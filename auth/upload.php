<?php

include_once("DP.php");

$DP = new DISPLAY_PICTURE();

$uploadDir = "../uploads/";
$thumbnailDir = "../uploads/thumbnail/";

$destination_folder_for_dp = "../uploads/dp/";
$frameImg = "../src/img/frame.jpeg";

// image dimension variable
$img_width = 170;
$img_height = 126;

// image position right:bottom
$margin_right = 143;
$margin_bottom = 148;

if(isset($_FILES["avatar"]["type"])) {

    $validextensions = array("jpeg", "jpg", "png");
    $temporary = explode(".", $_FILES["avatar"]["name"]);
    $file_extension = end($temporary);        

    $time = $_POST['timestamp'];
    $txt = $_POST['fullname'];
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
            
            if(move_uploaded_file($sourcePath,$targetPath) /*Save Uploaded file*/ ){

              //create dp instance 
              $dp = new DISPLAY_PICTURE($newfilename);

              //create thumnail
              if($dp->createThumbnail($newfilename, $img_width, $img_height, $uploadDir, $thumbnailDir)){

                //merge picture
                if($dp->mergeImage($txt, $frameImg, $thumbnailDir.$newfilename, $margin_right, $margin_bottom, $destination_folder_for_dp)){
                  
                  //send merge picture to browser
                  echo "Dp created successfully";

                }else{
                  echo "Image processing failed, please try again.";
                }

              }else{
                echo "Image processing failed, please try again.";
              }              
                
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