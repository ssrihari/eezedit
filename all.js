function toggleWrap()
{
	ta.wrap= (ta.wrap=="off")?"on":"off";
}

function hideDocTree()
{
	documentTree.style.display='none';
	mainToolbar.style.display='none';
	fToolbar.style.width = ta.style.width = '98%';
	fToolbar.style.left = ta.style.left = '1%';
	widthAdjust.style.left = '0%';
	
	showEr.style.display='block';
	hideEr.style.display='none';
}

function showDocTree()
{
	documentTree.style.display='block';
	mainToolbar.style.display='block';
	fToolbar.style.width = ta.style.width = '79%';
	fToolbar.style.left = ta.style.left = '20%';
	widthAdjust.style.left = '19%';
	
	showEr.style.display='none';
	hideEr.style.display='block';
}

function incWidth()
{
	var amt=10;
	documentTree.style.width= documentTree.offsetWidth+amt;
	mainToolbar.style.width= mainToolbar.offsetWidth+amt;
	fToolbar.style.width= fToolbar.offsetWidth-amt;
	fToolbar.style.left= fToolbar.offsetLeft+amt;
	ta.style.width= ta.offsetWidth-amt;
	ta.style.left= ta.offsetLeft+amt;
	widthAdjust.style.left= widthAdjust.offsetLeft+amt;
	
}

function decWidth()
{
	var amt=10;
	documentTree.style.width= documentTree.offsetWidth-amt;
	mainToolbar.style.width= mainToolbar.offsetWidth-amt;
	fToolbar.style.width= fToolbar.offsetWidth+amt;
	fToolbar.style.left= fToolbar.offsetLeft-amt;
	ta.style.width= ta.offsetWidth+amt;
	ta.style.left= ta.offsetLeft-amt;
	widthAdjust.style.left= widthAdjust.offsetLeft-amt;
}

function addToForm(nam, val)
{
		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", nam);
		hiddenField.setAttribute("value", val);
		document.getElementById('textareaForm').appendChild(hiddenField);
}


function loadFile() {
	post_to_url("", inputFileName.value);
}

function addFolder()
{
	var dirname=prompt("Enter new Folder name");
	if(!dirname) return;
	addToForm("newDir",dirname);
	document.getElementById('textareaForm').removeChild(ta);
	document.getElementById('textareaForm').submit();
}
function addFile()
{
	var filname="";
	var dirname=prompt("Enter the folder name for the new file");
	if(dirname=="Logs")
	{ 
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!

		var yyyy = today.getFullYear();
		if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
//		var today = 
		filname=dd+'.'+mm+'.'+yyyy;
	}
	filname=prompt("Enter new file name",filname);
	addToForm("dirName",dirname);	
	addToForm("newFil",filname);
	document.getElementById('textareaForm').removeChild(ta);
	document.getElementById('textareaForm').submit();	
}
function renameFile()
{
	var newFilename=prompt("Enter new name for the file");
	if(!newFilename) return;
	addToForm("newFilename",newFilename);		
	reloadFile();
}

function deleteFile()
{
	if(confirm("Delete this file?"))
	{
		addToForm("deleteFile","yes");	
		reloadFile();
	}	
}

function renameFolder()
{
	var newFoldername=prompt("Enter new name for the folder");
	if(!newFoldername) return;
	addToForm("newFoldername",newFoldername);		
	reloadFile();
}

function deleteFolder()
{
	if(confirm("Delete this folder and all contents?"))
	{
		addToForm("deleteFolder","yes");	
		reloadFile();
	}	
}

function markChanged()
{
	document.getElementById("changedFlag").style.display="inline";
}
