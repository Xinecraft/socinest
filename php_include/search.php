<?php
if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: /');}
?>
<div class="mainbodycontainer span11">
<div class="feedscontainer span10">


<?php
$q=$_GET['q'];
if($q=='' || $q==NULL || empty($q))
header('Location: /');

$q=$con->escape_string($_GET["q"]);
$ss_userid=$_SESSION['userid'];
$search=$con->query("SELECT * FROM user_profile WHERE username LIKE '%$q%' OR full_name LIKE '%$q%' OR email LIKE '$q';");
if($search->num_rows > 0)
{
	echo "<div class='searchbox span10 grid'><h5>Found $search->num_rows people searching '{$q}'</h5>";
	while($row = $search->fetch_array())
	{
		
		$userid = htmlentities($row["userid"], ENT_QUOTES);
		$fname = htmlentities($row["full_name"], ENT_QUOTES);
		$username = htmlentities($row["username"], ENT_QUOTES);
		$livein = htmlentities($row["live_in"], ENT_QUOTES);
		$school = htmlentities($row["secondary_school"], ENT_QUOTES);
?>
<li class="menu_divider"></li>
<div class="searchboxc span10 row" id="<?=$userid?>">
<div class="span1 profpic">
<img src="user/<?=$username?>/profilethumb.jpeg" width="50" height="50"/>
</div>

<div class="searchuserdetail span5">
<h5><a href="?profile=<?=$username?>"><?=$fname?></a></h5>
<p class="text-Grey"><?=$school?></p>
<p class="text-Grey"><?=$livein?></p>
</div>

<div class="searchuseroptions span4" id="suo<?=$userid?>">
<?php
if($_SESSION['username']==$username)
{
	echo '<a class="main-btn" href="?profile='.$username.'"><i class="icon-user on-left"></i>View my Profile</a>
	<a class="cancel-btn" href="./?home"><i class="icon-home on-left"></i>Back Home</a>
	';
}
else
{
$checkfrnd=$con->query("SELECT req_sender,req_reciever,status FROM friend_system WHERE (req_sender='$ss_userid' OR req_reciever='$ss_userid') AND (req_sender='$userid' OR req_reciever='$userid')");
if($checkfrnd->num_rows > 0)
{
$checkrow=$checkfrnd->fetch_array();
	if($checkrow['req_sender']==$ss_userid && $checkrow['status']==0)
	{
	// Request already sent
	echo "<a class='main-btn addfrnd$userid green-main-btn frndreqsentbtn' id='$userid'><i class='icon-checkmark on-left'></i>Friend Request Sent</a>
<a href='./?sendmessage={$username}' class='whi-btn'><i class='icon-comments-5 on-left'></i>Send Message</a>
";
	}
	elseif($checkrow['req_sender']==$userid && $checkrow['status']==0)
	{
	// Already Recieved request from that user
		echo "<a class='addfrnd$userid main-btn confrndbtn' id='$userid'><i class='icon-reply on-left'></i>Confirm Friend</a>
		<a class='red-main-btn addfrnd$userid rejfrndbtn' id='$userid'><i class=' icon-cancel on-left'></i>Reject</a>
<a href='./?sendmessage={$username}' class='whi-btn'><i class='icon-comments-5 on-left'></i>Send Message</a>
";
	}
	else
	{
		echo "<a class='main-btn addfrnd$userid frndbtn' id='$userid'><i class='icon-user-2 on-left'></i>Friends</a>
<a href='./?sendmessage={$username}' class='whi-btn'><i class='icon-comments-5 on-left'></i>Send Message</a>
";
	}
}
else
{

// Check If User is Blocked by the Owner?

$checkblock=$con->query("SELECT blocker,blockee FROM block_system WHERE CASE WHEN blocker='$ss_userid' THEN blockee='$userid' WHEN blockee='$ss_userid' THEN blocker='$userid' END LIMIT 2;");
if($checkblock->num_rows <= 0)
{
echo "<a class='main-btn addfrndbtn addfrnd$userid' id='$userid'><i class='icon-plus on-left'></i>Add as Friend</a>
<a href='./?sendmessage={$username}' class='whi-btn main-btn'><i class='icon-comments-5 on-left'></i>Send Message</a>
";
}
elseif($checkblock->num_rows == 1)
{
	// Check if User has blocked him or is being blocked?
	$blockrow=$checkblock->fetch_array();
		if($blockrow['blocker']==$ss_userid)
		{
			// The user has already blocked that person
			echo "<a class='red-main-btn unblockuserbtn addfrnd$userid' id='$userid'><i class='icon-blocked on-left'></i>Unblock User</a>";
		}
		else
		{
			echo "<a class='main-btn requestublockbtn addfrnd$userid' id='$userid'><i class='fa fa-send on-left'></i>Request for Unblock</a>";
			//User is being blocked by him
		}
}
elseif($checkblock->num_rows == 2)
{
	echo "<a class='red-main-btn unblockuserbtn addfrnd$userid' id='$userid'><i class='icon-blocked on-left'></i>Unblock User</a>";
}
}

}
?>
</div>
</div>

<?php
	}
	echo '</div>';
}
#Display if nothing found
else
{
	echo "<div class='searchbox span10 grid'><h5>No Result for '{$q}'</h5><h6>Try searching something else.</h6>
	</div>";
}
?>
</div>
</div>