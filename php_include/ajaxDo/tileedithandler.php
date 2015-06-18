<?php
include_once '../conf.php';
include_once '../magicquotesgpc.php';
global $con;
include_once('../imp_func_inc.php');
error_reporting(0);
session_start();
$ss_userid= $_SESSION['userid'];
if(!islogin())
{
	header("Location:./?home");
}

if($_GET['view']=='goto')
{
	$getgoestodata = $con->query("SELECT secondary_school,college FROM user_profile WHERE userid='$ss_userid' LIMIT 1");
	$getgoestodatarow = $getgoestodata->fetch_array();
	$secschool =htmlentities($getgoestodatarow["secondary_school"], ENT_QUOTES);
	$college =htmlentities($getgoestodatarow["college"], ENT_QUOTES);
	if(empty($college) || $college=='' || $college==NULL) $goes_to=$secschool;
	else $goes_to=$college;
	echo html_entity_decode($goes_to);
}
elseif($_GET['edit']=='goto' && !empty($_GET['text']))
{
	$text=$con->escape_string($_GET['text']);
	$text = trim($text);
	
	$getgoestodata = $con->query("SELECT secondary_school,college FROM user_profile WHERE userid='$ss_userid' LIMIT 1");
	$getgoestodatarow = $getgoestodata->fetch_array();
	$secschool =htmlentities(htmlspecialchars($getgoestodatarow["secondary_school"], ENT_QUOTES));
	$college =htmlentities(htmlspecialchars($getgoestodatarow["college"], ENT_QUOTES));
	if(empty($college) || $college=='' || $college==NULL) $updateto=1;
	else $updateto=0;
	
	if($updateto==1)
	{
		$editgoto= $con->query("UPDATE user_profile SET secondary_school='$text' WHERE userid='$ss_userid' LIMIT 1");
		echo $text;
	}
	else
	{
		$editgoto= $con->query("UPDATE user_profile SET college='$text' WHERE userid='$ss_userid' LIMIT 1");
		echo $text;
	}
}
// For Achievement Tile
elseif($_GET['view']=='achmnt')
{
	$getdata = $con->query("SELECT achievement FROM user_profile WHERE userid='$ss_userid' LIMIT 1");
	$getrow = $getdata->fetch_array();
	$data =htmlentities($getrow["achievement"], ENT_QUOTES);
	if(empty($data) || $data=='' || $data==NULL) $data='No Acheivement Set';
	else $data=$data;
	echo html_entity_decode($data);
}
elseif($_GET['edit']=='achmnt' && !empty($_GET['text']))
{
	$text=$con->escape_string($_GET['text']);
	$text = trim($text);
	$edit= $con->query("UPDATE user_profile SET achievement='$text' WHERE userid='$ss_userid' LIMIT 1");
	echo $text;
}

// For Looking for Tile
elseif($_GET['view']=='lookfor')
{
	$getdata = $con->query("SELECT looking_for FROM user_profile WHERE userid='$ss_userid' LIMIT 1");
	$getrow = $getdata->fetch_array();
	$data =htmlentities($getrow["looking_for"], ENT_QUOTES);
	if(empty($data) || $data=='' || $data==NULL) $data="Whom you looking for?";
	else $data=$data;
	echo html_entity_decode($data);
}
elseif($_GET['edit']=='lookfor' && !empty($_GET['text']))
{
	$text=$con->escape_string($_GET['text']);
	$text = trim($text);
	$edit= $con->query("UPDATE user_profile SET looking_for='$text' WHERE userid='$ss_userid' LIMIT 1");
	echo $text;
}