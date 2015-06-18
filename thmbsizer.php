<?
 // The file you are resizing
if($_GET['src'] && $_GET['size'] && $_GET)
{
 $file =$_GET['src'];
 $getsize=$_GET['size'];
 list($x,$y)=explode('x',$getsize);
 //This will set our output to 20% of the original size
 // This sets it to a .jpg, but you can change this to png or gif 
 header('Content-type:image/jpeg');
 
 // Setting the resize parameters
 list($width, $height) = getimagesize($file); 
 $filesize=filesize($file);
 	 $modheight = $x;
//	 $modwidth = $width/($height/$modheight); 
	 $modwidth = $y;
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
 imagejpeg($tn,NULL,80);
 imagedestroy($tn);
}
 

elseif($_GET['source'])
 {
 $file =$_GET['source'];
 
 //This will set our output to 45% of the original size 
 $size = 0.45; 
 
 // This sets it to a .jpg, but you can change this to png or gif 
 header('Content-type:image/jpeg');
 
 // Setting the resize parameters
 list($width, $height) = getimagesize($file); 
 $filesize=filesize($file);
 if($filesize>=60000)
 {
 $modwidth = $width * $size; 
 $modheight = $height * $size; 
 }
 elseif($filesize<60000 && $filesize>20000)
 {
	 $size=0.70;
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
 imagejpeg($tn,NULL,80); 
 imagedestroy($tn);
}
else
{
	header("location:./?home");
}
?>