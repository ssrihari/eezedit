<?php 
 $fold = $_POST['folder'];
 $target = "./docs/"."$fold/"; 
 $target = $target . basename( $_FILES['uploaded']['name']) ; 
 $ok=1; 
 if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) 
 {
 echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded to". $target;
 echo "<br /><a href=\"./index.php\">Back</a>";
 } 
 else {
 echo "Sorry, there was a problem uploading your file.";
 }
 ?>
