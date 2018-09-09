<?php

include_once("EVENT_DP.php");

$year = date("Y");

$uploadDir = "../uploads/".$year."/";
$thumbnailDir = "../uploads/".$year."/thumbnail/";

$destination_folder_for_dp = "../uploads/".$year."/dp/";
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

    $name = preg_replace('/\s+/', '_', $txt);
    $newfilename = $name.$time .".".$file_extension;

    if(strlen($txt) > 0)
    {
    
      if ((($_FILES["avatar"]["type"] == "image/png") || ($_FILES["avatar"]["type"] == "image/jpg") || ($_FILES["avatar"]["type"] == "image/jpeg")) && ($_FILES["avatar"]["size"] <= 2000000) && in_array($file_extension, $validextensions)) 
      {

          if ($_FILES["avatar"]["error"] > 0)
          {
            $message = "Return Code: " . $_FILES["avatar"]["error"] . "<br/><br/>";
            $response = array('status' => 'error', 'msg' => $message);
            echo json_encode($response);

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
                $dp = new EVENT_DP($newfilename);

                //create thumnail
                if($dp->createThumbnail($newfilename, $img_width, $img_height, $uploadDir, $thumbnailDir)){

                  //merge picture
                  if($dp->mergeImage($txt, $frameImg, $thumbnailDir.$newfilename, $margin_right, $margin_bottom, $destination_folder_for_dp)){
                    
                    //send merge picture to browser
                    $message = 
                    '<section class="dp-container">
                        <a href="?home" class="arrow-back "><i class="ti-arrow-left"></i></a>
                        <div>
                            <img id="dp_result" src="uploads/2018/dp/'.$newfilename.'">                
                            <a class="button" class="kb-button download-dp" href="uploads/2018/dp/'.$newfilename.'" download="'.$name.'"_kwarabuild'.$year.'">Download Image</a>      
                        </div>
                    <sectoin>';

                    $response = array('status' => 'ok', 'msg' => $message);
                    echo json_encode($response);

                  }else{
                    $message = "Image processing failed, please try again.";
                    $response = array('status' => 'error', 'msg' => $message);
                    echo json_encode($response);
                  }

                }else{
                  $message = "Image processing failed, please try again.";
                  $response = array('status' => 'error', 'msg' => $message);
                  echo json_encode($response);
                }              
                  
              }else{
                $message = "Image processing failed, please try again.";
                $response = array('status' => 'error', 'msg' => $message);
                echo json_encode($response);
              }
                              
            }
          }
      }
      else
      {
        $message = "Invalid file Size or Type ".$_FILES["avatar"]["type"]." ".$_FILES["avatar"]["size"];
        $response = array('status' => 'error', 'msg' => $message);
        echo json_encode($response);
      }

    }else{
      $message = "Name is required";
      $response = array('msg' => 'error', 'msg' => $message);
      echo json_encode($response);
    }

}else{
  $message = "No file selected";
  $response = array('status' => 'error', 'msg' => $message);
  echo json_encode($response);
}



?>