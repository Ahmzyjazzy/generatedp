<?php


$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ($contentType === "application/json") {
  //Receive the RAW post data.
  $content = trim(file_get_contents("php://input"));

   echo $content;

  $decoded = json_decode($content, true);

  //If json_decode failed, the JSON is invalid.

  // echo json_encode($decoded);
  echo $decoded->username;

}
	// $inp = file_get_contents('php//input');

	// $val = json_decode(inp);

	// echo json_encode($val->username);


	// $arr = $_POST['body'];

	// echo json_decode($_POST[]);


	// $postedData = json_decode($arr);
	// // $username = $postedData[0]=>username;

	// if(isset($_POST["json"])){
	// 	echo json_encode("{msg:'ahmed'}");
	// }else{
	// 	echo json_encode("{msg:'error'}");
	// }
	
?>