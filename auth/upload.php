<?php

include_once("DP.php");

$DP = new DISPLAY_PICTURE();

$txt = "Ahmed Olanrewaju Olayinka jhhfdjjhdf";

$uploadDir = "../uploads/";
$moveToDir = "../uploads/thumbnail/";

$final_destination = "../uploads/dp/";
$frameImg = "../src/img/frame.jpeg";

// image dimension variable
$img_width = 170;
$img_height = 126;

// image position
$margin_right = 143;
$margin_bottom = 148;

if(isset($_FILES["avatar"]["type"])) {

    $validextensions = array("jpeg", "jpg", "png");
    $temporary = explode(".", $_FILES["avatar"]["name"]);
    $file_extension = end($temporary);        

    $time = $_POST['timestamp'];
    $username = $_POST['username'];
    $newfilename = $time .".".$file_extension;
    
    if ((($_FILES["avatar"]["type"] == "image/png") || ($_FILES["avatar"]["type"] == "image/jpg") || ($_FILES["avatar"]["type"] == "image/jpeg")) && ($_FILES["avatar"]["size"] <= 2000000) && in_array($file_extension, $validextensions)) {
        if ($_FILES["avatar"]["error"] > 0)
        {
          echo "Return Code: " . $_FILES["avatar"]["error"] . "<br/><br/>";
        }
        else
        {
          if (file_exists($uploadDir.$newfilename)) {
            $sourcePath = $_FILES["avatar"]["tmp_name"]; // Storing source path of the file in a variable
            $targetPath = $uploadDir.$newfilename; // Target path where file is to be stored
            move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
          }
          else
          {
            $sourcePath = $_FILES["avatar"]["tmp_name"]; // Storing source path of the file in a variable
            $targetPath = $uploadDir.$newfilename; // Target path where file is to be stored
            
            if(move_uploaded_file($sourcePath,$targetPath) /*Moving Uploaded file*/ ){

              //create dp instance 
              $dp = new DISPLAY_PICTURE($newfilename);

              //create thumnail
              $dp->createThumbnail($newfilename, $img_width, $img_height, $uploadDir, $moveToDir);

              //merge picture
              $dp->mergeImage($txt, $frameImg, $moveToDir.$newfilename, $margin_right, $margin_bottom, $final_destination);
                
            }else{
              echo "Image processing failed, please try again.";
            }
                            
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

?>