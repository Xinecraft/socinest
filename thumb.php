<?php 

 // The file you are resizing
if($_GET['src'])
{
 $file =$_GET['src'];
 
 if(isset($_GET['x']))
 $size = $_GET['x'];
 else
 $size = 30; 
 
 $size /= 100;
 
 // This sets it to a .jpg, but you can change this to png or gif 
 header('Content-type:image/jpeg');
 
 // Setting the resize parameters
 list($width, $height) = getimagesize($file); 
 $filesize=filesize($file);
 if($filesize>=200000)
 {
 $modwidth = $width * $size; 
 $modheight = $height * $size; 
 }
 elseif($filesize<200000 && $filesize>100000)
 {
	 $size=$size+0.2;
	 $modwidth = $width * $size; 
 	 $modheight = $height * $size; 
 }
 else
 {
	 $modwidth = $width;
	 $modheight = $height;
 }
	 
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
 imagejpeg($tn,NULL,60); 
 imagedestroy($tn);
}
 
 ?> 