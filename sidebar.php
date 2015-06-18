<?php
if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: /');}
?>
<nav class="left-sidebar sidebar side-bar">
<div class="left-sidebar-container">
<?php
if(isset($_GET['setupaccount']))
{
if($_GET['setupaccount']!=2 || $_GET['setupaccount']==1)
{
?>
<div class="left-sidebar-header-container"><h2>Step 1 out of 2</h2></div>
<div class="left-sidebar-img-container"><img src="img/aside-profpic-tip.png" alt="Profile Picture Tip" width="200" /></div>
<div class="left-sidebar-detailtxt-container"><p style="line-height: 3rem !important;font-weight:bold">"A original Display picture is necessary to connect with your friends, so upload genuine DP"</p></div>

<?php
}
else if($_GET['setupaccount']==2)
{
?>
<div class="left-sidebar-header-container"><h2>Step 2 out of 2</h2></div>
<div class="left-sidebar-img-container"><img src="img/aside-profdetail-tip.png" alt="Profile Picture Tip" width="200" style="margin-top:30px" /></div>
<div class="left-sidebar-detailtxt-container"><p style="line-height: 3rem !important;font-weight:bold">"For best experience, please fill all the fields, this will make your profile page more beautiful & standard"</p></div>
<?php
}}
else if(isset($_GET['profile']))
{
	$getuser=$con->escape_string($_GET["profile"]);
	$getuser=preg_replace('#[^a-z0-9.@]#i','',$getuser);
	// Display things and tools for user profile
	$requestuser=$con->query("SELECT P.username,P.userid,P.full_name,P.nickname,P.date_of_birth,P.quotes,P.country,P.gender,P.religion,O.profile_pic_url,O.cover_pic_url FROM user_profile P,user_options O WHERE P.username = '$getuser' AND O.userid=P.userid LIMIT 1;");
	if($requestuser->num_rows > 0)
	{
		$row = $requestuser->fetch_array();
		$Puserid = htmlentities($row["userid"], ENT_QUOTES);
		$Pfullname = htmlentities($row["full_name"], ENT_QUOTES);
		$Pnickname = htmlentities($row["nickname"], ENT_QUOTES);
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
		
		if($Pnickname=='' || empty($Pnickname))
		$Pnickname='<span style="font-size:2rem">No Nickname</span>';
	}
	switch($Pgender)
	{
		case 'M':
		$Pgender = 'Male';
		break;
		case 'F':
		$Pgender = 'Female';
		break;
		default:
		$Pgender = 'Others';
		break;
	}
?>
<div class="left-sidebar-header-container" style="margin-top:40px">
<img class="shadow rounded" src="thumb.php?src=<?=$Oprofpicurl?>" width="300" style="height:240px">
<div class=""><h2 class="profsbfullname profsbfname shadow bg-dark padding10"><?=$Pfullname?></h2>
<h2 class="subheader profsbfname shadow bg-darkBrown padding5">(<?=$Pnickname?>)</h2>
</div>
<br />
<div class="btn-container" id="sbarbtncontainer">
<?php

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
</div>
</div>
<?php
}

# Display the Default General SideBar for Everything Else
else
{
$ss_userid=$_SESSION['userid'];
$ss_getfullname=$con->query("SELECT full_name FROM user_profile WHERE userid=$ss_userid LIMIT 1;");
$ss_getfullnamerow = $ss_getfullname->fetch_array();
$ss_fullname = htmlentities($ss_getfullnamerow["full_name"], ENT_QUOTES);

	echo<<<html
<nav class="vertical-menu compact defsidemenu">
    <ul>
        <li class="title capitalize grid">
		<div class="feedhead span10 row">
		<div class="feedheadprofpic span1">
<img class="shadow" src="user/$ss_username/profilethumb.jpeg" width="50" height="50"/>
</div>
<div class="feedheadprofdetail span3">
<div>
<h5 class="fg-darkBlue nomargin">$ss_fullname</h5>
<a href="./?start" class="fg-gray nomargin" style="margin-top: 10px !important;">Start Screen</a>
</div>
</div>
</div>
		
		</li>
		<li class="menu_divider"></li>
        <li><a href="./?home"><span class="icon-newspaper icon-defsidemenu fg-darkCyan">&nbsp</span>News Feed</a></li>
        <li><a href="./?profile=$ss_username"><span class="icon-user-2 icon-defsidemenu fg-darkCyan">&nbsp</span>Profile</a></li>
		<li><a href="#"><span class="icon-comments-4 icon-defsidemenu fg-darkCyan">&nbsp</span>Messages</a></li>
		<li><a href="#"><span class="icon-pictures icon-defsidemenu fg-darkCyan">&nbsp</span>Photos</a></li>
		<li><a href="#"><span class="icon-calendar icon-defsidemenu fg-darkCyan">&nbsp</span>Events</a></li>
		<li><a href="#"><span class="icon-tree-view icon-defsidemenu fg-darkCyan">&nbsp</span>Friends</a></li>
		<li><a href="#"><i class="fa fa-users fg-darkCyan">&nbsp</i>Groups</a></li>
		<li><a href="#"><span class="icon-at icon-defsidemenu fg-darkCyan">&nbsp</span>Email</a></li>
		<li><a href="#"><span class="icon-cart icon-defsidemenu fg-darkCyan">&nbsp</span>Shops</a></li>
		
    </ul>
	<li class="menu_divider"></li>
	<ul>
        <li class="title capitalize"><h5>Classified</h5></li>
		</ul>
	
</nav>
html;
}
?>
</div>
</nav>