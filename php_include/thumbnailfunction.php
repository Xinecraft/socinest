<?php
if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: /');}
function createThumb($file)
{
 $usern=$_SESSION['username'];
 // This sets it to a .jpg, but you can change this to png or gif 
 header('Content-type:image/jpeg');
 
 // Setting the resize parameters
 list($width, $height) = getimagesize($file); 
 $filesize=filesize($file);
 	 $modwidth = 50;
	 $modheight = 50;	 
 // Creating the Canvas 
 $tn= imagecreatetruecolor($modwidth, $modheight);
 $type=getimagesize($file);
 switch($type['mime'])
 {
	 case 'image/jpeg':
	 $source = imagecreatefromjpeg($file);
	 break;
	 case 'image/png':
	 $source = imagecreatefrompng($file);
	 break;
	 case 'image/gif':
	 $source = imagecreatefromgif($file);
	 break;
	 case 'image/bmp':
	 $source = imagecreatefromwbmp($file);
	 break;
 
 }
 // Resizing our image to fit the canvas 
 imagecopyresized($tn, $source, 0, 0, 0, 0, $modwidth, $modheight, $width, $height); 
 
 // Outputs a jpg image, you could change this to gif or png if needed 
 imagejpeg($tn,'user/'.$usern.'/profilethumb.jpeg',75);
 imagedestroy($tn);
}
?>