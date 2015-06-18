<?php
if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: /');}
//makes this file include-only by checking if the requested file is the same as this file
if(isset($_SESSION['userid']) && isset($_SESSION['username']) && isset($_SESSION['email']) && isset($_SESSION['gender']))
{
	$ss_username=$_SESSION['username'];
	$ss_id=$_SESSION['userid'];
	$ss_email=$_SESSION['email'];
	$ss_gender=$_SESSION['gender'];
	$ss_user_ip=get_client_ip();
	//redirect loop problem
	if($_SERVER['PHP_SELF']!='/s/index.php')
	header('Location:./index.php');
}
/*
else if(isset($_COOKIE['loginkey']))
{
	global $con;
	$ss_id=$con->escape_string($_COOKIE['loginkey']);
	$sql="SELECT userid,username,email,gender FROM user_profile WHERE userid='$ss_id' LIMIT 1";
	$query=$con->query($sql);
	$row=$query->fetch_array();
	$ss_username = htmlentities($row["username"], ENT_QUOTES);
	$ss_email = htmlentities($row["email"], ENT_QUOTES);
	$ss_gender = htmlentities($row["gender"], ENT_QUOTES);
	//set session
	$_SESSION['username']=$ss_username;
	$_SESSION['userid']=$ss_id;
	$_SESSION['email']=$ss_email;
	$_SESSION['gender']=$ss_gender;
	$ss_user_ip=get_client_ip();
	$res=$con->query("UPDATE user_options SET last_login_ip='$ss_user_ip',last_login_time=now() WHERE userid='$ss_id' LIMIT 1;");
}
*/
else
{
	//redirect loop problem
	if($_SERVER['PHP_SELF']!='/s/main.php')
	header('Location:./main.php');
}