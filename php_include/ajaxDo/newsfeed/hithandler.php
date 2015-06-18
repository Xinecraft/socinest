<?php
include_once '../../conf.php';
include_once '../../magicquotesgpc.php';
global $con;
include_once('../../imp_func_inc.php');
error_reporting(0);
session_start();
if(!islogin())
{
	header("Location:./?home");
}

$ss_userid=$_SESSION['userid'];
$rec_statusid = $_REQUEST['id'];
$rec_statusid=$con->escape_string($rec_statusid);


$status='Success';
$message='ARR';   //ARR = Already Recieved Request

$data = array(
        'status' => $status,
        'message' => $message
    );
    echo json_encode($data);
?>