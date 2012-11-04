<html>
	<head>
		<link rel="stylesheet" href="style.css" />
		<script type="text/javascript" src="./all.js"></script>
		<script type="text/javascript" src="./shortcut.js"></script>
		
		<?
		$statusMessage="Ready to edit";

		#initialize directoryName and fileName
		$curDirName = $_POST['dirName'];
		$curFileName = $_POST['fileName'];
		if (!isset($curFileName))
			$curFileName = "text.txt";
		if (!isset($curDirName))
			$curDirName = "default";

		#for file delete
		if(isset($_POST['deleteFile']))
			if($curFileName!="text.txt"||$curDirName!="default")
			{
				if(unlink("./docs/".$curDirName."/".$curFileName))
				{
					$curFileName = "text.txt";
					$curDirName = "default";
					$statusMessage = "File deleted";
				}
				else 
					echo "can't delete file";
			}
		
		#for folder delete
		if(isset($_POST['deleteFolder']))
		{
			$dir="./docs/".$curDirName;
			$objects = scandir($dir); 
		     foreach ($objects as $object) { 
		       if ($object != "." && $object != "..") { 
		         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
		       } 
		     } 
		     reset($objects); 
		     rmdir($dir);
		     $statusMessage = "Folder deleted";
			$curFileName = "text.txt";
			$curDirName = "default";
		}
		
		#for file rename
		if(isset($_POST['newFilename']))
		{						
			$oldfile="./docs/" . $curDirName . "/" . $curFileName;
			$newfile="./docs/".$curDirName."/".$_POST['newFilename'];
			rename("$oldfile","$newfile");
			$curFileName=$_POST['newFilename'];
			$statusMessage = "File renamed";	
		}	
		
		#for folder rename
		if(isset($_POST['newFoldername']))
		{						
			$oldfolder="./docs/" . $curDirName;
			$newfolder="./docs/".$_POST['newFoldername'];
			rename("$oldfolder","$newfolder");
			$curDirName=$_POST['newFoldername'];	
			$statusMessage = "Folder renamed";
		}	
					
		#for new folder
		if(isset($_POST['newDir']))
		{	if(!mkdir("./docs/".$_POST['newDir'],0744))
				echo "cant create dir";
			else
				$statusMessage = "New folder created";
		}
		
		#for new file
		if(isset($_POST['newFil']))
			if(fopen("./docs/".$curDirName."/".$_POST['newFil'],'w'))
			{	
				$curFileName=$_POST['newFil'];	
				$statusMessage = "New file created";
			}
			else
				echo $curFileName."not created";
		
		#initialize file path				
		$curFilePath = "./docs/" . $curDirName . "/" . $curFileName;				
		
		#initialize contents and save
		if (isset($_POST['content'])) {
			$content = $_POST['content'];
			trim($content);
			stripslashes($content);
			$fh = fopen($curFilePath, 'w') or die("can't open file " . $curFilePath);
			fwrite($fh, $content);
			fclose($fh);
			$statusMessage="File saved";
		}
		
		#initialize the content to display
		$fh2 = fopen($curFilePath, 'r') or die("can't open file " . $curFilePath);
		$content = fread($fh2, filesize($curFilePath)+1);
		fclose($fh2);
		

		
		?>
		<script type="text/javascript">
			
			function saveFile(){
var fil= "<?= $curFileName?>";
var dir = "<?= $curDirName?>";
addToForm("fileName", fil);
addToForm("dirName", dir);
document.getElementById('textareaForm').submit();
}

function reloadFile(dir,fil){
if(dir==undefined)
dir= "<?= $curDirName?>";
if(fil==undefined)
fil= "<?= $curFileName?>";
	addToForm("fileName", fil);
	addToForm("dirName", dir);
	document.getElementById('textareaForm').removeChild(document.getElementById('ta'));
	document.getElementById('textareaForm').submit();
	}

function downloadFile()
{
var downFile= "<?echo $curFilePath?>";
 window.location="download.php?download_file="+downFile;
}

		</script>
	</head>
	<body>
		
		<div id="fToolbar" class="fileToolbar">
			<? echo " > " . $curDirName . " > " . $curFileName;?>  <label id="changedFlag" style="display:none">*</label>
			&nbsp; | &nbsp; <span class="clickable" onclick="saveFile()">Save file </span>
			&nbsp; | &nbsp; <span class="clickable" onclick="renameFile()">Rename file </span>
			&nbsp; | &nbsp; <span class="clickable" onclick="deleteFile()">Delete file </span>
			&nbsp; | &nbsp; <span class="clickable" onclick="renameFolder()">Rename folder </span>
			&nbsp; | &nbsp; <span class="clickable" onclick="deleteFolder()">Delete folder </span>
			&nbsp; | &nbsp; <span class="clickable" onclick="downloadFile()">Download file </span>
			&nbsp; | &nbsp; <span>Last: <? echo date("d-m-y h:i", filemtime($curFilePath))?> </span>

			<span id="statMessage" class="statusMsg" ><?= $statusMessage?> &nbsp;</span>
		</div>
		
		<div id="documentTree" class="docTree" style="color:white">
			<?php
			if ($handle = opendir('./docs')) {
				print("<ul id='dirTreeUl'>\n");
				$files = glob("./docs/*");
				usort($files, create_function('$b,$a', 'return filemtime($a) - filemtime($b);'));
				foreach ($files as $file) {
					$file=basename($file);
					if ($file != '.' && $file != '..') {
						print("<li id='folder'>\n");
						print("$file");

						print("<ul>\n");
						if ($handle2 = opendir('./docs/' . $file)) {
							$files2 = glob("./docs/".$file.'/*');
							usort($files2, create_function('$b,$a', 'return filemtime($a) - filemtime($b);'));
							foreach ($files2 as $textFile) {
								$textFile=basename($textFile);
								if ($textFile != '.' && $textFile != '..') {
									print("<li ");
									if (strcmp($textFile,$curFileName)==0)
										print("id='textCur' ");
									else
										print("id='text' ");
									print(">");
									print("$textFile");
									print("</li>");
								}
							}
						}
						print("</ul>");

						print("</li>");
					}
				}
				closedir($handle);
				print("</ul>");
			}
			?>
		</div>
		<div id="mainToolbar" class="toolbar" align="center">
				<img class="clickable" src="./img/add_file.png" onclick="addFile()"/>
				<img class="clickable" src="./img/add_folder.png" onclick="addFolder()" />
				<a href="./upload-form.php"><img class="clickable" src="./img/upload.png" onclick="" /></a>
			</div>

		<div id="widthAdjust" class="widthAdjust">
				<img class="clickable" src="./img/decWidth.png" onclick="decWidth()"/><br />
				<img class="clickable" src="./img/incWidth.png" onclick="incWidth()" /><br />
				<img id="hideEr" class="clickable" src="./img/hide.png" onclick="hideDocTree()"/>
				<img id="showEr" style="display:none" class="clickable" src="./img/show.png" onclick="showDocTree()"/>
		</div>
			
		<form id="textareaForm" method="post" action="">

			<textarea name="content" id="ta" wrap="on" valign="top"><?php echo trim($content);?></textarea>
		</form>
		<script>		
			document.getElementById("dirTreeUl").addEventListener("click", function(e) {				
				if(e.target && e.target.nodeName == "LI") {
					var el = e.target;
					if(el.id == "text" ) {
						var fil = el.textContent;
						var par = el.parentNode.parentNode;
						var dir = par.textContent.split("\n")[1];
						reloadFile(dir, fil);
					}
					else if(el.id == "folder" ) {
                                                var childN = el.firstChild.nextSibling;
						if(childN.style.display!="none")
							{
								childN.style.display="none";
								el.style.fontWeight="bold";
							}
						else
							{
								childN.style.display="block";
								el.style.fontWeight="normal";
							}
			
					}
					else return;
				}
			});
			shortcut.add("Ctrl+s",saveFile);
			shortcut.add("Alt+n",addFile);
			shortcut.add("Alt+w",toggleWrap);
		</script>
	</body>
</html>
