<html>
	<head>
		<link rel="stylesheet" href="style.css" /> 
		<script type="text/javascript">
		function validate()
		{
			if(!folder.value) alert("enter folder name");
		}
		</script>
	</head>
	<body>
		 <form id="upload-form" enctype="multipart/form-data" action="upload.php" method="POST">
	 	 <label>Choose a file to upload:</label> <input  style="float:right" name="uploaded" type="file" /><br />
	 	 <label>Choose the folder:</label><input id="folder" style="float:right" name="folder" type="text"/><br />
		 <button onclick="validate()">Upload</button>
		 </form> 				
	</body>
</html>
