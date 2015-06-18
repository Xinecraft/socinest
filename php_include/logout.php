<?php
//temp purpose
session_start();
if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: /');}
//makes this file include-only by checking if the requested file is the same as this file
//if(isset($_SESSION['userid']) || isset($_SESSION['username']) || isset($_SESSION['email']) || isset($_SESSION['gender']) || isset($_COOKIE['loginkey']))
if(isset($_SESSION['userid']) || isset($_SESSION['username']) || isset($_SESSION['email']) || isset($_SESSION['gender']))
{
	$_SESSION=array();
	session_destroy();
//	setcookie('loginkey',$user_id,strtotime('-30 days'),'/','localhost',false,true);
	header('Location:../main.php');
	//success logout
}
// if(isset($_SESSION['userid']) || isset($_SESSION['username']) || isset($_SESSION['email']) || isset($_SESSION['gender']) || isset($_COOKIE['loginkey']))
if(isset($_SESSION['userid']) || isset($_SESSION['username']) || isset($_SESSION['email']) || isset($_SESSION['gender']))
{
	//handle logout fail system
	header('Location:./logout_error.php');
}
else
{
	//success logout and now header to main page
	header('Location:./main.php');
}
?>