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

$feed_id=$_POST['id'];
$feed_id=$con->escape_string($feed_id);
$action=$_GET['action'];

if($action=='checkfornewfeeds')
{
# echo $feed_id;
$ss_userid=$_SESSION['userid'];

$sql="SELECT T.status_id,T.status_txt,T.hits,T.comments,T.userid_fk,T.owner,T.frnd_tag,T.pic_ids,T.mood,T.at_location,T.post_time,T.update_time,T.hit_allowed,T.comment_allowed,T.visibility,T.sharedlink_url,T.sharedlink_title,T.sharedlink_desc,T.sharedlink_img,T.hashtags,U.userid,U.username,U.full_name,U.banned FROM status_update T,user_profile U,friend_system S WHERE U.userid=T.userid_fk AND (CASE WHEN S.req_sender='$ss_userid' THEN req_reciever=U.userid WHEN req_reciever='$ss_userid' THEN req_sender=U.userid END AND T.update_time >= S.accept_time) AND S.status>0 AND CASE WHEN T.userid_fk='$ss_userid' THEN T.visibility<=2 WHEN T.userid_fk!='$ss_userid' THEN T.visibility<2 END AND T.status_id>$feed_id ORDER BY T.post_time DESC LIMIT 1";
$result=$con->query($sql);
if($result->num_rows <= 0)
{
}
else
{
	$row = $result->fetch_array();
		$feed_index = 0;
		$Uuserid = htmlentities(htmlspecialchars($row["userid"], ENT_QUOTES));
		$Ufname = htmlentities(htmlspecialchars($row["full_name"], ENT_QUOTES));
		$Uusername = htmlentities(htmlspecialchars($row["username"], ENT_QUOTES));
		$Uisban = htmlentities(htmlspecialchars($row["banned"], ENT_QUOTES));
		
		$Tstatusid = htmlentities(htmlspecialchars($row["status_id"], ENT_QUOTES));
		$Tstatus_txt = htmlentities(htmlspecialchars($row["status_txt"], ENT_QUOTES));
		$Tstatus_txt_wrap =nl2br($Tstatus_txt);
		$Thits = htmlentities(htmlspecialchars($row["hits"], ENT_QUOTES));
		$Tcomments = htmlentities(htmlspecialchars($row["comments"], ENT_QUOTES));
		$Tuserid = htmlentities(htmlspecialchars($row["userid_fk"], ENT_QUOTES));
		$Towner = htmlentities(htmlspecialchars($row["owner"], ENT_QUOTES));
		$Tfrnd_tag = htmlentities(htmlspecialchars($row["frnd_tag"], ENT_QUOTES));
		$Tpic_ids = htmlentities(htmlspecialchars($row["pic_ids"], ENT_QUOTES));
		$Tmood = htmlentities(htmlspecialchars($row["mood"], ENT_QUOTES));
		$Tat_location = htmlentities(htmlspecialchars($row["at_location"], ENT_QUOTES));
		$Tpost_time = htmlentities(htmlspecialchars($row["post_time"], ENT_QUOTES));
		$Tupdate_time = htmlentities(htmlspecialchars($row["update_time"], ENT_QUOTES));
		$Thit_allowed = htmlentities(htmlspecialchars($row["hit_allowed"], ENT_QUOTES));
		$Tcomment_allowed = htmlentities(htmlspecialchars($row["comment_allowed"], ENT_QUOTES));
		$Tvisibility = htmlentities(htmlspecialchars($row["visibility"], ENT_QUOTES));
		$Tsharedlink_url = htmlentities(htmlspecialchars($row["sharedlink_url"], ENT_QUOTES));
		$Tsharedlink_title = htmlentities(htmlspecialchars($row["sharedlink_title"], ENT_QUOTES));
		$Tsharedlink_desc = htmlentities(htmlspecialchars($row["sharedlink_desc"], ENT_QUOTES));
		$Tsharedlink_img = htmlentities(htmlspecialchars($row["sharedlink_img"], ENT_QUOTES));
		$Thashtags = htmlentities(htmlspecialchars($row["hashtags"], ENT_QUOTES));
		// if no image in shared link then display default link img
		if(empty($Tsharedlink_img) || $Tsharedlink_img==NULL || $Tsharedlink_img=='')
		{
			$Tsharedlink_img='data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==';
		}
		
		// replace all url in status to html links
		$Tstatus_txt_wrap= preg_replace('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', '<a href="$1" target="blank">$1</a>', $Tstatus_txt_wrap);
		
//because you want the url to be an external link the href needs to start with 'http://'
//simply replace any occurance of 'href="www.' into 'href="http://www."
		$Tstatus_txt_wrap = str_replace("href=\"www.","href=\"http://www.",$Tstatus_txt_wrap);
		$Tstatus_txt_wrap = convert_hashtag_to_link(html_entity_decode($Tstatus_txt_wrap, ENT_QUOTES));
		
		// do if this is only text post
		if((empty($Tpic_ids) || $Tpic_ids==NULL || $Tpic_ids=='') && ($Tstatus_txt!=NULL || !empty($Tstatus_txt) || $Tstatus_txt!=''))
		{
			// Display on Txt Post here
?>
<!-- New Feed Starts Only-Text-->
<div class="newsfeed span10 grid" data-feed-id="<?=$feed_index?>" id="<?=$Tstatusid?>">

<div class="feedhead span10 row">
<!-- Feed Header part -->
<div class="feedheadprofpic span1">
<img src="user/<?=$Uusername?>/profilethumb.jpeg" width="50" height="50"/>
</div>
<div class="feedheadprofdetail span3">
<div>
<a href="./?profile=<?=$Uusername?>">
<strong class="fg-darkBlue"><?=$Ufname?></strong>
</a>
</div>
<div class="feedposttime"><?=timeago($Tpost_time)?></div>
</div>
<div class="feedheadpostdetails span2 right">
<p class="small"><small>Detail options of post</small>
</p>
</div>
</div>


<div class="feedbody row">


<div class="usercontent nomargin">
<p><?=$Tstatus_txt_wrap?></p>
</div>

<?php
// To include only if a shared link is present in post
if((!empty($Tsharedlink_url) || $Tsharedlink_url!=NULL || $Tsharedlink_url!='') && ($Tsharedlink_title!=NULL || !empty($Tsharedlink_title) || $Tsharedlink_title!=''))
{
echo '<div class="linkcontain row"><div class="image_thumb span2"><img src="'.$Tsharedlink_img.'" width="120" height="100"></div>
<div class="sharedlink_content span7"><h4><a href="'.$Tsharedlink_url.'" target="_blank">'.$Tsharedlink_title.'</a></h4><p style="font-size:10pt">'.$Tsharedlink_desc.'</p>
</div>
</div>';
}
?>

</div>

<div class="feedtail">
<!-- Feed tail part -->
<div class="grid nomargin">
<div class="row nomargin feedactionbox">
<span class=""><a>Hit</a></span><span class="on-right dotseparator">∙</span>
<span class=""><a>Comment</a></span>
</div>
</div>
</div>
<li class="menu_divider commentseparator"></li>
<div class="feedcomments">
<div class="grid nomargin">

<div class="row nomargin commentmain">
<div class="commentuserpic">
<img src="img/defpropiclite.png" width="35" height="35"/>
</div>
<div class="commentcontainer">
<div class="commenttxtcont">
<span class="fg-darkBlue commentername">Vivek Kumar </span><span class="commenttxt">This is test CommentIf the weapon is your love, I got my hands up. If you're gonna take me down, I surrender. This is only for me and photo in private So none will be able to view it!!!!!</span>
<div class="commenttimeaction"><span class="commenttime">17 Aug 2014 23:30</span><span class="on-right dotseparator">∙</span><span class="commentactionbox">
<span class=""><a>Hit</a></span><span class="on-right dotseparator">∙</span>

</span>
</div>
</div>
</div>
</div>
<!-- A single Comment Ends ie a Row -->

<div class="row nomargin youdocomment">
<div class="commentuserpic">
<img src="user/<?=$_SESSION['username']?>/profilethumb.jpeg" width="35" height="35"/>
</div>
<div class="input-control text size9">
    <input type="text" value="" placeholder="Write a comment..."/>
</div>
</div>

</div>
</div>

</div> <!--News Feed Ends Only-Text-->
<?php

		}  //if condition ends for only text post
		
		// For Image only post do this
	else if((!empty($Tpic_ids) || $Tpic_ids!=NULL || $Tpic_ids!='') && ($Tstatus_txt==NULL || empty($Tstatus_txt) || $Tstatus_txt==''))
	{
		$Tpic_idss = array();
		$Tpic_idss = explode(',',$Tpic_ids);
		?>
<!-- New Feed Starts Only-Photo-->
<div class="newsfeed span10 grid" data-feed-id="<?=$feed_index?>" id="<?=$Tstatusid?>">

<div class="feedhead span10 row">
<!-- Feed Header part -->
<div class="feedheadprofpic span1">
<img src="user/<?=$Uusername?>/profilethumb.jpeg" width="50" height="50"/>
</div>
<div class="feedheadprofdetail span3">
<div>
<a href="./?profile=<?=$Uusername?>">
<strong class="fg-darkBlue"><?=$Ufname?></strong>
</a>
</div>
<div class="feedposttime"><?=timeago($Tpost_time)?></div>
</div>
<div class="feedheadpostdetails span2 right">
<p class="small"><small>Detail options of post</small></p>
</div>
</div>

<div class="feedbody row">

<div class="usercontentpic onlypicfeed">


<div class="carousell" style="height:550px;overflow-y:auto;padding:20px">
<?php
foreach($Tpic_idss as $pictureid)
{
	 $picres=$con->query("SELECT pic_id,postedby,pic_url FROM status_pic WHERE pic_id='$pictureid' AND postedby='$Uuserid' LIMIT 1;");
	 $picrow = $picres->fetch_array();
	 $picurl = htmlentities(htmlspecialchars($picrow["pic_url"], ENT_QUOTES));
?>
    <div class="images" style="padding:10px;height:550px;">
       <img src="thumb.php?src=<?=$picurl?>&x=50" class="shadow">
    </div>
<?php
}
?>
</div>

</div>
<?php
// To include only if a shared link is present in post
if((!empty($Tsharedlink_url) || $Tsharedlink_url!=NULL || $Tsharedlink_url!='') && ($Tsharedlink_title!=NULL || !empty($Tsharedlink_title) || $Tsharedlink_title!=''))
{
echo '<div class="linkcontain row"><div class="image_thumb span2"><img src="'.$Tsharedlink_img.'" width="120" height="100"></div>
<div class="sharedlink_content span7"><h4><a href="'.$Tsharedlink_url.'" target="_blank">'.$Tsharedlink_title.'</a></h4><p style="font-size:10pt">'.$Tsharedlink_desc.'</p>
</div>
</div>';
}
?>
</div>

<div class="feedtail">
<!-- Feed tail part -->

<div class="grid nomargin">
<div class="row nomargin feedactionbox">
<span class=""><a>Hit</a></span><span class="on-right dotseparator">∙</span>
<span class=""><a>Comment</a></span>
</div>
</div>
</div>
<li class="menu_divider commentseparator"></li>
<div class="feedcomments">
<div class="grid nomargin">

<div class="row nomargin commentmain">
<div class="commentuserpic">
<img src="img/defpropiclite.png" width="35" height="35"/>
</div>
<div class="commentcontainer">
<div class="commenttxtcont">
<span class="fg-darkBlue commentername">Vivek Kumar </span><span class="commenttxt">This is test CommentIf the weapon is your love, I got my hands up. If you're gonna take me down, I surrender. This is only for me and photo in private So none will be able to view it!!!!!</span>
<div class="commenttimeaction"><span class="commenttime">17 Aug 2014 23:30</span><span class="on-right dotseparator">∙</span><span class="commentactionbox">
<span class=""><a>Hit</a></span><span class="on-right dotseparator">∙</span>

</span>
</div>
</div>
</div>
</div>
<!-- A single Comment Ends ie a Row -->

<div class="row nomargin youdocomment">
<div class="commentuserpic">
<img src="user/<?=$_SESSION['username']?>/profilethumb.jpeg" width="35" height="35"/>
</div>
<div class="input-control text size9">
    <input type="text" value="" placeholder="Write a comment..."/>
</div>
</div>

</div>
</div>

</div> <!--News Feed Ends Only-Photo-->
<?php
	} // if ends for only image post
	
	//if both text and photo post then do 
	else if((!empty($Tpic_ids) || $Tpic_ids!=NULL || $Tpic_ids!='') && ($Tstatus_txt!=NULL || !empty($Tstatus_txt) || $Tstatus_txt!=''))
	{
?>
<!-- New Feed Starts Text+Photo-->
<div class="newsfeed span10 grid" data-feed-id="<?=$feed_index?>" id="<?=$Tstatusid?>">

<div class="feedhead span10 row">
<!-- Feed Header part -->
<div class="feedheadprofpic span1">
<img src="user/<?=$Uusername?>/profilethumb.jpeg" width="50" height="50"/>
</div>
<div class="feedheadprofdetail span3">
<div>
<a href="./?profile=<?=$Uusername?>">
<strong class="fg-darkBlue"><?=$Ufname?></strong>
</a>
</div>
<div class="feedposttime"><?=timeago($Tpost_time)?></div>
</div>
<div class="feedheadpostdetails span2 right">
<p class="small"><small>Detail options of post</small></p>
</div>
</div>


<div class="feedbody row">

<!-- Only if photo in post-->
<div class="usercontentpic span5">


<div class="carousell" style="height:300px;overflow-y:auto;">
<?php
$Tpic_idss = array();
$Tpic_idss = explode(',',$Tpic_ids);
foreach($Tpic_idss as $pictureid)
{
	 $picres=$con->query("SELECT pic_id,postedby,pic_url FROM status_pic WHERE pic_id='$pictureid' AND postedby='$Uuserid' LIMIT 1;");
	 $picrow = $picres->fetch_array();
	 $picurl = htmlentities(htmlspecialchars($picrow["pic_url"], ENT_QUOTES));
?>
    <div class="slide" style="height:300px;padding:10px">
       <img src="thumb.php?src=<?=$picurl?>" class="shadow">
    </div>
<?php
}
#if(sizeof($Tpic_idss) > 1)
#{
#  echo '
#    <a class="controls left"><i class="icon-arrow-left-2"></i></a>
#    <a class="controls right"><i class="icon-arrow-right-2"></i></a>';
#}
?>
</div>
</div>


<div class="usercontent span5 nomargin">
<p><?=$Tstatus_txt_wrap?></p>
</div>

</div>

<?php
// To include only if a shared link is present in post
if((!empty($Tsharedlink_url) || $Tsharedlink_url!=NULL || $Tsharedlink_url!='') && ($Tsharedlink_title!=NULL || !empty($Tsharedlink_title) || $Tsharedlink_title!=''))
{
echo '<div class="linkcontain row"><div class="image_thumb span2"><img src="'.$Tsharedlink_img.'" width="120" height="100"></div>
<div class="sharedlink_content span7"><h4><a href="'.$Tsharedlink_url.'" target="_blank">'.$Tsharedlink_title.'</a></h4><p style="font-size:10pt">'.$Tsharedlink_desc.'</p>
</div>
</div>';
}
?>

<div class="feedtail">
<!-- Feed tail part -->
<div class="grid nomargin">
<div class="row nomargin feedactionbox">
<span class=""><a>Hit</a></span><span class="on-right dotseparator">∙</span>
<span class=""><a>Comment</a></span>
</div>
</div>
</div>
<li class="menu_divider commentseparator"></li>
<div class="feedcomments">
<div class="grid nomargin">

<div class="row nomargin commentmain">
<div class="commentuserpic">
<img src="img/defpropiclite.png" width="35" height="35"/>
</div>
<div class="commentcontainer">
<div class="commenttxtcont">
<span class="fg-darkBlue commentername">Vivek Kumar </span><span class="commenttxt">This is test CommentIf the weapon is your love, I got my hands up. If you're gonna take me down, I surrender. This is only for me and photo in private So none will be able to view it!!!!!</span>
<div class="commenttimeaction"><span class="commenttime">17 Aug 2014 23:30</span><span class="on-right dotseparator">∙</span><span class="commentactionbox">
<span class=""><a>Hit</a></span><span class="on-right dotseparator">∙</span>

</span>
</div>
</div>
</div>
</div>
<!-- A single Comment Ends ie a Row -->

<div class="row nomargin youdocomment">
<div class="commentuserpic">
<img src="user/<?=$_SESSION['username']?>/profilethumb.jpeg" width="35" height="35"/>
</div>
<div class="input-control text size9">
<input type="text" value="" placeholder="Write a comment..."/>
</div>
</div>

</div>
</div>

</div> <!--News Feed Ends Text+Photo -->

<?php
} // both text and photo ends

}

}
?>