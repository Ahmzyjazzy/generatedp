<?php

include_once("DP.php");

$DP = new DISPLAY_PICTURE();

if(isset($_FILES["avatar"]["type"])) {

    $validextensions = array("jpeg", "jpg", "png");
    $temporary = explode(".", $_FILES["avatar"]["name"]);
    $file_extension = end($temporary);        
    $time = $_POST['timestamp'];
    $newfilename = $time .".".$file_extension;
    
    if ((($_FILES["avatar"]["type"] == "image/png") || ($_FILES["avatar"]["type"] == "image/jpg") || ($_FILES["avatar"]["type"] == "image/jpeg")) && ($_FILES["avatar"]["size"] <= 2000000) && in_array($file_extension, $validextensions)) {
        if ($_FILES["avatar"]["error"] > 0)
        {
          echo "Return Code: " . $_FILES["avatar"]["error"] . "<br/><br/>";
        }
        else
        {
          if (file_exists("../uploads/" . $newfilename)) {
            echo "Image exist.";
            $sourcePath = $_FILES["avatar"]["tmp_name"]; // Storing source path of the file in a variable
            $targetPath = "../uploads/".$newfilename; // Target path where file is to be stored
            move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
          }
          else
          {
            $sourcePath = $_FILES["avatar"]["tmp_name"]; // Storing source path of the file in a variable
            $targetPath = "../uploads/".$newfilename; // Target path where file is to be stored
            move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
            echo "Image successfully uploaded.";
            //to do here
                            
          }
        }
    }
    else
    {
      echo "Invalid file Size or Type ".$_FILES["avatar"]["type"]." ".$_FILES["avatar"]["size"];
    }
}else{
  echo "No file selected";
}
//echo $result;

?>