<?php 
 /*
 Way of using
 
 Just use this format to include a image to be made thumbnail
 <img src="thumb.php?source=http://www.site.com/image.jpg alt="image thumb"/>
 
 */
 // The file you are resizing
 $file =$_GET['src'];
 
 //This will set our output to 30% of the original size 
 $size = 0.30; 
 
 // This sets it to a .jpg, but you can change this to png or gif 
 header('Content-type:image/jpeg');
 
 // Setting the resize parameters
 list($width, $height) = getimagesize($file); 
 $filesize=filesize($file);
 if($filesize>=50000)
 {
 $modwidth = $width * $size; 
 $modheight = $height * $size; 
 }
 elseif($filesize<50000 && $filesize>10000)
 {
	 $size=0.50;
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