<?php
include_once('../imp_func_inc.php');
error_reporting(0);
session_start();
$ss_username=$_SESSION['username'];
$ss_id=$_SESSION['userid'];
define ("MAX_SIZE","10000");
$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") 
{
	$uploaddir = '../../user/'.$ss_username.'/'; //Image upload directory
	$randa=uniqid();
	foreach ($_FILES['headerpost_images']['name'] as $name => $value)
	{
		$filename = stripslashes($_FILES['headerpost_images']['name'][$name]);
		$size=filesize($_FILES['headerpost_images']['tmp_name'][$name]);
		//Convert extension into a lower case format
		$ext = getExtension($filename);
		$ext = strtolower($ext);
		//File extension check
		if(in_array($ext,$valid_formats))
		{
			//File size check
			if ($size < (MAX_SIZE*1024))
				{ 
					$rand=rand(10000000000,9999999999);
					$image_name=time().'_'.$rand.$randa.'_'.$ss_id.'.'.$ext; 
					$newname=$uploaddir.$image_name; 
					if (move_uploaded_file($_FILES['headerpost_images']['tmp_name'][$name], $newname)) 
						{ 
							echo "<div id='hpi_".$randa."' class='uiImageContainer' style=''><img src='thmbsizer.php?src=user/".$ss_username."/".$image_name."&size=100x100' class='imgList left'><input type='hidden' name='headerpost_images[]' value='".$image_name."' /><button id='hpi_".$randa."' class='btn mini headerpost_images_remover' title='Remove'>&times;</button></div>"; 
							$randa++;
						}
						else 
						{ 
						//	echo '<span class="imgList">Error in Code</span>'; 
							echo 'Error in Code'; 
						} 
						
				}
			else 
				{ 
				//	echo '<span class="imgList">You have exceeded the size limit!</span>'; 
					echo 'You have exceeded the size limit!'; 
				} 
	   } 
		else 
			{ 
			//	echo '<span class="imgList">Unknown extension!</span>'; 
			echo 'Unknown extension! Maybe not an image file'; 
			} 
	} //foreach end
}
?>