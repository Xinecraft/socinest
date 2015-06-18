<?php
include_once '../conf.php';
include_once '../magicquotesgpc.php';
global $con;
include_once('../imp_func_inc.php');
error_reporting(0);
session_start();
if(islogin())
{
$ss_username=$_SESSION['username'];
$ss_id=$_SESSION['userid'];
$picurl='user/'.$ss_username.'/';
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") 
{
	if(!empty($_POST['pupdate']) || !empty($_POST['headerpost_images']))
	{
	$post_visibility=$con->escape_string($_POST["header-post-options-s"]);
	if($post_visibility !=0 && $post_visibility !=1 && $post_visibility !=2) $post_visibility=0;
	if(isset($_POST["comment_allowed"])) $post_comment_allowed=1;
	else $post_comment_allowed=0;
	if(isset($_POST["hit_allowed"])) $post_hit_allowed=1;
	else $post_hit_allowed=0;
	if(isset($_POST["sharedlink_img"])) $sharedlink_img=$_POST["sharedlink_img"];
	else $sharedlink_img=NULL;
	if(isset($_POST["sharedlink_url"])) $sharedlink_url=$_POST["sharedlink_url"];
	else $sharedlink_url=NULL;
	if(isset($_POST["sharedlink_title"])) $sharedlink_title=$_POST["sharedlink_title"];
	else $sharedlink_title=NULL;
	if(isset($_POST["sharedlink_desc"])) $sharedlink_desc=$_POST["sharedlink_desc"];
	else $sharedlink_desc=NULL;
	
	$post_text=$con->escape_string($_POST["pupdate"]);
	$hostip=get_client_ip();
	foreach($_POST['headerpost_images'] as $v)
	{
		$sql="INSERT INTO `status_pic`(`pic_url`,`posted_by`) VALUES('$v','$ss_id');";
		$sql = "INSERT INTO `status_pic` ( `pic_url`, `postedby`, `time`) VALUES ( '$picurl$v','$ss_id', CURRENT_TIMESTAMP);";
		$query1=$con->query($sql);
		$picid=$con->insert_id;
		$picid_list=$picid.','.$picid_list;
		$picid_list=rtrim($picid_list,',');
	}
	$sql = "INSERT INTO `status_update` ( `status_txt`, `host_ip`, `userid_fk`, `owner`, `pic_ids`, `mood`, `at_location`, `post_time`, `update_time`, `hit_allowed`, `comment_allowed`, `visibility`, `sharedlink_url`, `sharedlink_title`, `sharedlink_desc`, `sharedlink_img`, `hashtags`) VALUES ( '$post_text','$hostip','$ss_id','$ss_id','$picid_list', NULL,NULL, now(),now(),'$post_hit_allowed','$post_comment_allowed','$post_visibility','$sharedlink_url','$sharedlink_title', '$sharedlink_desc','$sharedlink_img',NULL);";
	$query2=$con->query($sql);
	$status='success';
	$message='Status Update Successful';
	
}
else
{
	$status='error';
	$message='Please enter some Status or attach image.';
}
}
$data = array(
        'status' => $status,
        'message' => $message
    );
    echo json_encode($data);
}
?>