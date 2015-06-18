<?php
include_once '../conf.php';
include_once '../magicquotesgpc.php';
global $con;
include_once('../imp_func_inc.php');
error_reporting(0);
session_start();
if(!islogin())
{
	header("Location:./?home");
}
if($_GET['do']=='request')
{
$ss_userid=$_SESSION['userid'];
$rec_userid = $_REQUEST['id'];
$rec_userid=$con->escape_string($rec_userid);
$ss_uid_ip=get_client_ip();

$checkfrnd=$con->query("SELECT req_sender,req_reciever,status FROM friend_system WHERE (req_sender='$ss_userid' OR req_reciever='$ss_userid') AND (req_sender='$rec_userid' OR req_reciever='$rec_userid')");

if($checkfrnd->num_rows > 0)
{
$checkrow=$checkfrnd->fetch_array();
if($checkrow['req_sender']=='$ss_userid' && $checkrow['status']=='0')
{
	// Request already sent
	$status='Error';
	$message='RAS';  //RAS = Request Already Sent
}
elseif($checkrow['req_sender']==$userid && $checkrow['status']==0)
{
	// Already Recieved request from that user
	$status='Error';
	$message='ARR';   //ARR = Already Recieved Request
}
else
{
	// Already Frnd with Him
	$status='Error';
	$message='AAF';
}
}
else
{
	// add to table
$addfrnd=$con->query("INSERT INTO friend_system(req_sender,req_reciever,sent_timestamp,sender_ip) VALUES ('$ss_userid','$rec_userid',now(),'$ss_uid_ip');");
if(!$addfrnd)
{
	$status='Error';
	$message='TE';    //TE = Technical Error
}
else
{
	$status='Success';
	$message='FRS';     //FRS = Friend Request Sent
}
}


$data = array(
        'status' => $status,
        'message' => $message
    );
    echo json_encode($data);
}

elseif($_GET['do']=='confirm')
{
	$ss_userid=$_SESSION['userid'];
	$rec_userid = $_REQUEST['id'];
	$rec_userid=$con->escape_string($rec_userid);
	$ss_uid_ip=get_client_ip();
	$checkfrnd=$con->query("SELECT req_sender,req_reciever,status FROM friend_system WHERE req_sender='$rec_userid' AND req_reciever='$ss_userid' AND status=0;");
	if($checkfrnd->num_rows > 0)
	{
		$checkfrnd=$con->query("UPDATE friend_system SET status=1,accept_time=now() WHERE req_sender='$rec_userid' AND req_reciever='$ss_userid' AND status=0 LIMIT 1;");
		$adfrndcount=$con->query("UPDATE user_options SET frnd_count=frnd_count+1 WHERE userid='$rec_userid' OR userid='$ss_userid' LIMIT 2;");
		$status='Success';
		$message='FRA';             // Friend Request Accepted
	}
	else
	{
		$status='Error';
		$message='TE';
	}
	$data = array(
        'status' => $status,
        'message' => $message
    );
    echo json_encode($data);
}

elseif($_GET['do']=='reject')
{
	$ss_userid=$_SESSION['userid'];
	$rec_userid = $_REQUEST['id'];
	$rec_userid=$con->escape_string($rec_userid);
	$checkfrnd=$con->query("SELECT req_sender,req_reciever,status FROM friend_system WHERE req_sender='$rec_userid' AND req_reciever='$ss_userid' AND status=0;");
	if($checkfrnd->num_rows > 0)
	{
		$checkfrnd=$con->query("DELETE FROM friend_system WHERE req_sender='$rec_userid' AND req_reciever='$ss_userid' AND status=0 LIMIT 1;");
		$status='Success';
		$message='FRR';             // Friend Request Rejected
	}
	else
	{
		$status='Error';
		$message='TE';
	}
	$data = array(
        'status' => $status,
        'message' => $message
    );
    echo json_encode($data);
}
elseif($_GET['do']=='unfriend')
{
	$ss_userid=$_SESSION['userid'];
	$rec_userid = $_REQUEST['id'];
	$rec_userid=$con->escape_string($rec_userid);
	if($ss_userid == $rec_userid) return false;
	
	$checkfrnd=$con->query("SELECT req_sender,req_reciever,status FROM friend_system WHERE CASE WHEN req_sender='$ss_userid' THEN req_reciever='$rec_userid' WHEN req_reciever='$ss_userid' THEN req_sender='$rec_userid' END AND status > 0;");
	if($checkfrnd->num_rows > 0)
	{
		$unfriend = $con->query("DELETE FROM friend_system WHERE (req_sender='$rec_userid' OR req_reciever='$rec_userid') AND (req_sender='$ss_userid' OR req_reciever='$ss_userid') AND status > 0 LIMIT 1;");
		if($unfriend)
		{
			$adfrndcount=$con->query("UPDATE user_options SET frnd_count=frnd_count-1 WHERE userid='$rec_userid' OR userid='$ss_userid' LIMIT 2;");
			$status='Success';
			$message='UFS';     // Unfriend Successfully
		}
		else
		{
			$status='Error';
			$message='TE'; 
		}
	}
	else
	{
		$status='Error';
		$message='NAF';         // Not a Friend
	}
	
	$data = array(
        'status' => $status,
        'message' => $message
    );
    echo json_encode($data);
}
elseif($_GET['do']=='canfrsrequest')
{
	$ss_userid=$_SESSION['userid'];
	$rec_userid = $_REQUEST['id'];
	$rec_userid=$con->escape_string($rec_userid);
	if($ss_userid == $rec_userid) return false;
	
	$checkfrnd=$con->query("SELECT req_sender,req_reciever,status FROM friend_system WHERE req_sender='$ss_userid' AND req_reciever='$rec_userid' AND status = 0;");
	if($checkfrnd->num_rows > 0)
	{
		$cancelfreq=$con->query("DELETE FROM friend_system WHERE req_sender='$ss_userid' AND req_reciever='$rec_userid' AND status = 0 LIMIT 1;");
		if($cancelfreq)
		{
			$status='Success';
			$message='CFRS';  // Cancel Friend Request Successful
		}
		else
		{
			$status='Error';
			$message='TE'; 
		}
	}
	else
	{
		$status='Error';
		$message='NSR';      // Not Sent Any Request to Cancel
	}
	$data = array(
        'status' => $status,
        'message' => $message
    );
    echo json_encode($data);
}
elseif($_GET['do']=='blockuser')
{
	$ss_userid=$_SESSION['userid'];
	$rec_userid = $_REQUEST['id'];
	$rec_userid=$con->escape_string($rec_userid);
	$ss_uid_ip=get_client_ip();
	if($ss_userid == $rec_userid) return false;


// Blocking System Here
	$checkblock=$con->query("SELECT blocker,blockee FROM block_system WHERE CASE WHEN blocker='$ss_userid' THEN blockee='$rec_userid' WHEN blockee='$ss_userid' THEN blocker='$rec_userid' END LIMIT 2;");
	if($checkblock->num_rows <= 0)
	{
		// Handle Blocking Here if No Block Present
		$doblock = $con->query("INSERT INTO block_system(blocker,blockee,blocker_ip) VALUES('$ss_userid','$rec_userid','$ss_uid_ip');");
		$status='Success';
		$message='BUS';   // Blcoking User Successful
	}
	else if($checkblock->num_rows == 1)
	{
		// Handle a Single Way Block Here
		$blockrow=$checkblock->fetch_array();
		if($blockrow['blocker']==$ss_userid)
		{
			// The user has already blocked that person
		}
		else
		{
			//Can Insert a block becoz the blockee has blocked this user
			$doblock = $con->query("INSERT INTO block_system(blocker,blockee,blocker_ip) VALUES('$ss_userid','$rec_userid','$ss_uid_ip');");
			$status='Success';
			$message='BUS';
		}
	}
	else if($checkblock->num_rows == 2)
	{
		// Handle a Dual Way Block Here
		// Both the User and the blockee has blocked this user
	}

// If Block Successful then Remove from Friend List if Present
if($status=='Success')
{
		$checkfrnd=$con->query("SELECT req_sender,req_reciever,status FROM friend_system WHERE CASE WHEN req_sender='$ss_userid' THEN req_reciever='$rec_userid' WHEN req_reciever='$ss_userid' THEN req_sender='$rec_userid' END;");
	if($checkfrnd->num_rows > 0)
	{
		$checkfrndrow=$checkfrnd->fetch_array();
		$statusisone = $checkfrndrow['status'];
		$unfriend = $con->query("DELETE FROM friend_system WHERE (req_sender='$rec_userid' OR req_reciever='$rec_userid') AND (req_sender='$ss_userid' OR req_reciever='$ss_userid') LIMIT 1;");
		if($unfriend && $statusisone==1)
		{
			$adfrndcount=$con->query("UPDATE user_options SET frnd_count=frnd_count-1 WHERE userid='$rec_userid' OR userid='$ss_userid' LIMIT 2;");
		}
	}
}
	$data = array(
        'status' => $status,
        'message' => $message
    );
    echo json_encode($data);
}

// Unblock System
elseif($_GET['do']=='unblockuser')
{
	$ss_userid=$_SESSION['userid'];
	$rec_userid = $_REQUEST['id'];
	$rec_userid=$con->escape_string($rec_userid);
	$ss_uid_ip=get_client_ip();
	if($ss_userid == $rec_userid) return false;

// UnBlocking System Here
	$checkblock=$con->query("SELECT blocker,blockee FROM block_system WHERE blocker='$ss_userid' AND blockee='$rec_userid';");
	if($checkblock->num_rows <= 0)
	{
		// Handle Blocking Here if No Block Present
		
		$status='Error';
		$message='NBF';   // No Block Found
	}
	else
	{
	$unblock=$con->query("DELETE FROM block_system  WHERE blocker='$ss_userid' AND blockee='$rec_userid' LIMIT 1;");
	$status='Success';
	$message='UBUS';   //Un Blocking User Successful 	
	}
	$data = array(
        'status' => $status,
        'message' => $message
    );
    echo json_encode($data);
}