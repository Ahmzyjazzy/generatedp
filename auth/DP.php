<?php

/*

int imagecopy ( resource dest_image, resource source_image, int dest_x, int dest_y, 
int source_x, int source_y, int source_width, int source_height)

int imagecopymerge ( resource dest_image, resource source_image, int dest_x, int dest_y, 
int source_x, int source_y, int source_width, int source_height, int merge_percentage)

1. The destination image you're copying to

2. The source image you're copying from

3. The X co-ordinate you want to copy to

4. The Y co-ordinate you want to copy to

5. The X co-ordinate you want to copy from

6. The y co-ordinate you want to copy from

7. The width in pixels of the source image you want to copy

8. The height in pixels of the source image you want to copy

Parameters three and four allow you to position the source image where you want it on the destination image, 
and parameters five, six, seven, and eight allow you to define the rectangular area of the source image that 
you want to copy. Most of the time you will want to leave parameters five and six at 0 
(copy from the top-left hand corner of the image), and parameters seven and eight at the width of the source image
 (the bottom-right corner of it) so that it copies the entire source image.

The way these functions differ is in the last parameter: imagecopy() always overwrites all the pixels in the 
destination with those of the source, whereas imagecopymerge() merges the destination pixels with the source 
pixels by the amount specified in the extra parameter: 0 means "keep the source picture fully", 100 means 
"overwrite with the source picture fully", and 50 means "mix the source and destination pixel colours equally". 
The imagecopy() function is therefore equivalent to calling imagecopymerge() and passing in 100 as the last parameter.

*/

class DISPLAY_PICTURE {
 
   protected $db;

   private static $sy;

   function __construct()
    {
        
    }
 
   function __destruct()
    {
        
    }

	public function mergeImage($txt, $fr_img, $av_img, $merge_right, $merge_bottom, $destination_path){

		/*
		$frame - frame image path
		$avatar - avatar image path
		$merge_right - margin from right of image
		$merge_bottom - margin from left of image
		*/

		// Load the avatar and the frame to apply the watermark to
		$frame = imagecreatefromjpeg($fr_img);
		$avatar = imagecreatefromjpeg($av_img);

		$sx = imagesx($avatar);
		$sy = imagesy($avatar);

		// Merge the stamp onto our photo with an opacity of 50%
		imagecopymerge($frame, $avatar, imagesx($frame) - $sx - $merge_right, imagesy($frame) - $sy - $merge_bottom, 0, 0, imagesx($avatar), imagesy($avatar), 100);

		$final_image = $this->addtext($txt, $frame, $av_img, 250, 140);

		$this->saveFile($final_image, $destination_path, "a.jpg");

	}

	public function createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir)
	{
		/*
		$image_name - Name of the image which is uploaded
		$new_width - Width of the resized photo (maximum)
		$new_height - Height of the resized photo (maximum)
		$uploadDir - Directory of the original image
		$moveToDir - Directory to save the resized image
		*/

	    $path = $uploadDir . $image_name;
	    $mime = getimagesize($path);

	    if($mime['mime']=='image/png') { 
	        $src_img = imagecreatefrompng($path);
	    }
	    if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
	        $src_img = imagecreatefromjpeg($path);
	    }   

	    $old_x          =   imageSX($src_img);
	    $old_y          =   imageSY($src_img);

	    if($old_x > $old_y) 
	    {
	        $thumb_w    =   $new_width;
	        $thumb_h    =   $old_y*($new_height/$old_x);
	    }

	    if($old_x < $old_y) 
	    {
	        $thumb_w    =   $old_x*($new_width/$old_y);
	        $thumb_h    =   $new_height;
	    }

	    if($old_x == $old_y) 
	    {
	        $thumb_w    =   $new_width;
	        $thumb_h    =   $new_height;
	    }

	    $dst_img = ImageCreateTrueColor($thumb_w,$thumb_h);
	    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 

	    // New save location
	    $new_thumb_loc = $moveToDir . $image_name;

	    if($mime['mime']=='image/png') {
	        $result = imagepng($dst_img,$new_thumb_loc,8);
	    }
	    if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
	        $result = imagejpeg($dst_img,$new_thumb_loc,80);
	    }

	    imagedestroy($dst_img); 
	    imagedestroy($src_img);

	    return $result;
	}

	private function addtext($txt, $frame, $av_img, $merge_right, $merge_bottom)
	{

		/* 

		#imagettftext-params below
		( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )

		image : An image resource, returned by one of the image creation functions, such as imagecreatetruecolor().

		size: The font size in points.

		angle : The angle in degrees, with 0 degrees being left-to-right reading text. Higher values represent a counter-clockwise rotation. For example, a value of 90 would result in bottom-to-top reading text.

		x :The coordinates given by x and y will define the basepoint of the first character (roughly the lower-left corner of the character). This is different from the imagestring(), where x and y define the upper-left corner of the first character. For example, "top left" is 0, 0.

		y : The y-ordinate. This sets the position of the fonts baseline, not the very bottom of the character.

		color : The color index. Using the negative of a color index has the effect of turning off antialiasing. See imagecolorallocate().

		fontfile : The path to the TrueType font you wish to use.

		*/

		// First we create our stamp image manually from GD
		$stamp = imagecreatetruecolor(100, 70);
		// imagefilledrectangle($stamp, 0, 0, 99, 69, 0x0000FF);
		// imagefilledrectangle($stamp, 9, 9, 90, 60, 0xFFFFFF);
		imagestring($stamp, 5, 20, 20, $txt, 0x0000FF);

		// Set the margins for the stamp and get the height/width of the stamp image
		$marge_right = $merge_right;
		$marge_bottom = $merge_bottom;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);

		// Merge the stamp onto our photo with an opacity of 50%
		imagecopymerge($frame, $stamp, imagesx($frame) - $sx - $merge_right, imagesy($frame) - $sy - $merge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 100);

		return $frame;
	}

	private function saveFile($final_image, $destination_path, $new_file_name){
		// Save the image to file and free memory
		imagepng($final_image, $destination_path.$new_file_name);
		imagedestroy($final_image);
	}



}


$txt = "Ahmed Olanrewaju";
$uploadImage = "1536424536034.jpg";

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


//call 
$dp = new DISPLAY_PICTURE();

//create thumnail
$dp->createThumbnail($uploadImage, $img_width, $img_height, $uploadDir, $moveToDir);

//merge picture
$dp->mergeImage($txt, $frameImg, $moveToDir.$uploadImage, $margin_right, $margin_bottom, $final_destination);


?>


