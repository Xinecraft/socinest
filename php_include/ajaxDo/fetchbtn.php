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

$ss_userid=$_SESSION['userid'];
$getuser = $_REQUEST['uid'];
$getuser=$con->escape_string($getuser);
	// Display things and tools for user profile
	$requestuser=$con->query("SELECT P.username,P.userid,P.full_name,P.date_of_birth,P.quotes,P.country,P.gender,P.religion,O.profile_pic_url,O.cover_pic_url FROM user_profile P,user_options O WHERE P.userid = '$getuser' AND O.userid=P.userid LIMIT 1;");
	if($requestuser->num_rows > 0)
	{
		$row = $requestuser->fetch_array();
		$Puserid = htmlentities($row["userid"], ENT_QUOTES);
		$Pfullname = htmlentities($row["full_name"], ENT_QUOTES);
		$Pdob = htmlentities($row["date_of_birth"], ENT_QUOTES);
		$Pdob = strtotime($Pdob);
		$Pdob = date('d-M-Y',$Pdob);
		$Pquotes = htmlentities($row["quotes"], ENT_QUOTES);
		$Pcountry = htmlentities($row["country"], ENT_QUOTES);
		$Pgender = htmlentities($row["gender"], ENT_QUOTES);
		$Preligion = htmlentities($row["religion"], ENT_QUOTES);
		$Ocoverpicurl = htmlentities($row["cover_pic_url"], ENT_QUOTES);
		$Oprofpicurl = htmlentities($row["profile_pic_url"], ENT_QUOTES);
		$ss_userid = $_SESSION['userid'];
	}
if($_GET['profile']==$_SESSION['username'])
{
echo '<a class="main-btn editprofilebtn large sbar-block-btn" href="./?editprofile"><i class="icon-pencil on-left"></i>Edit Profile</a>';
?>
<?php
}
else
{
$checkfrnd=$con->query("SELECT req_sender,req_reciever,status FROM friend_system WHERE (req_sender='$ss_userid' OR req_reciever='$ss_userid') AND (req_sender='$Puserid' OR req_reciever='$Puserid')");
if($checkfrnd->num_rows > 0)
{
$checkrow=$checkfrnd->fetch_array();
	if($checkrow['req_sender']==$ss_userid && $checkrow['status']==0)
	{
	// Request already sent
	echo "<a class='addfrnd$Puserid green-main-btn frndreqsentbtn sbar-block-btn' id='$Puserid'><i class='icon-checkmark on-left'></i>Friend Request Sent</a>   <div class='hidden frndreqsentbtncont'>
     <ul class='header_root'>
     <a class='cancelfrndrequestbtn'><li>Cancel Friend Request</li></a>
     </ul>
		</div>           
<a href='./?sendmessage={$getuser}' class='whi-btn main-btn sbar-block-btn'><i class='icon-comments-5 on-left'></i>Send Message</a>
<a class='red-main-btn blockhimbtn blockuser$Puserid sbar-block-btn' id='$Puserid'><i class='icon-blocked on-left'></i>Block User</a>
";
	}
	elseif($checkrow['req_sender']==$Puserid && $checkrow['status']==0)
	{
	// Already Recieved request from that user
		echo "<a class='addfrnd$Puserid main-btn confrndbtn sbar-block-btn' id='$Puserid'><i class='icon-reply on-left'></i>Confirm Friend</a>
		<a class='red-main-btn addfrnd$Puserid rejfrndbtn sbar-block-btn' id='$Puserid'><i class=' icon-cancel on-left'></i>Reject</a>
<a href='./?sendmessage={$getuser}' class='whi-btn main-btn sbar-block-btn'><i class='icon-comments-5 on-left'></i>Send Message</a>
<a class='red-main-btn blockhimbtn blockuser$Puserid sbar-block-btn' id='$Puserid'><i class='icon-blocked on-left'></i>Block User</a>
";
	}
	else
	{
		echo "<a class='main-btn addfrnd$Puserid frndbtn sbar-block-btn' id='$Puserid'><i class='icon-user-2 on-left'></i>Friend</a>
		<div class='frndbtncontnt hidden'>
     <ul class='header_root'>
     <a href='#'><li>Close Friends</li></a>
     <a href='#'><li>Acquaintances</li></a>
     <a href='#'><li>Add to Others</li></a>
     <li class='menu_divider'></li>
     <a class='unfriendbtn ptr' id='$Puserid'><li>UnFriend</li></a>
	 <a href='#' class='reportuser'><li>Report</li></a>
	 <a class='blockhimbtn' id='$Puserid'><li>Block</li></a>
     </ul>
		</div>
<a href='./?sendmessage={$getuser}' class='whi-btn main-btn sbar-block-btn'><i class='icon-comments-5 on-left'></i>Send Message</a>
";
	}
}
else
{

// Check If User is Blocked by the Owner?

$checkblock=$con->query("SELECT blocker,blockee FROM block_system WHERE CASE WHEN blocker='$ss_userid' THEN blockee='$Puserid' WHEN blockee='$ss_userid' THEN blocker='$Puserid' END LIMIT 2;");
if($checkblock->num_rows <= 0)
{
echo "<a class='main-btn addfrndbtn addfrnd$Puserid sbar-block-btn' id='$Puserid'><i class='icon-plus on-left'></i>Add as Friend</a>
<a href='./?sendmessage={$getuser}' class='whi-btn main-btn sbar-block-btn'><i class='icon-comments-5 on-left'></i>Send Message</a>
<a class='red-main-btn blockhimbtn blockuser$Puserid sbar-block-btn' id='$Puserid'><i class='icon-blocked on-left'></i>Block User</a>

";
}
elseif($checkblock->num_rows == 1)
{
	// Check if User has blocked him or is being blocked?
	$blockrow=$checkblock->fetch_array();
		if($blockrow['blocker']==$ss_userid)
		{
			// The user has already blocked that person
			echo "<a class='green-main-btn unblockuserbtn blockuser$Puserid sbar-block-btn' id='$Puserid'><i class='icon-blocked on-left'></i>Unblock User</a>";
		}
		else
		{
			echo "<a class='main-btn requestublockbtn blockuser$Puserid sbar-block-btn' id='$Puserid'><i class='fa fa-send on-left'></i>Request for Unblock</a>";
			//User is being blocked by him
		}
}
elseif($checkblock->num_rows == 2)
{
	echo "<a class='red-main-btn unblockuserbtn blockuser$Puserid sbar-block-btn' id='$Puserid'><i class='icon-blocked on-left'></i>Unblock User</a>";
}

}
}
?>