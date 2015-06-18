<?php
if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: /');}

$getuser=$con->escape_string($_GET["user"]);
$getuser=preg_replace('#[^a-z0-9.@]#i','',$getuser);
$checkuser=$con->query("SELECT userid FROM user_profile WHERE username LIKE '$getuser' LIMIT 1;");
if($checkuser->num_rows > 0)
{
	$requestuser=$con->query("SELECT P.username,P.userid,P.full_name,P.date_of_birth,P.marital_status,P.religious_views,P.quotes,P.country,P.gender,P.religion,P.nickname,P.looking_for,P.relationship_status,O.profile_pic_url,P.live_in,P.live_with,P.secondary_school,P.college,P.achievement,P.fav_person,P.fav_celebrity,P.intrests,O.cover_pic_url,O.frnd_count FROM user_profile P,user_options O WHERE P.username = '$getuser' AND O.userid=P.userid LIMIT 1;");
	$row = $requestuser->fetch_array();
		$Puserid = htmlentities($row["userid"], ENT_QUOTES);
		$Pfullname = htmlentities($row["full_name"], ENT_QUOTES);
		$Pdob = htmlentities($row["date_of_birth"], ENT_QUOTES);
		$Pquotes = htmlentities($row["quotes"], ENT_QUOTES);
		$Pcountry = htmlentities($row["country"], ENT_QUOTES);
		$Pgender = htmlentities($row["gender"], ENT_QUOTES);
		$Preligion = htmlentities($row["religion"], ENT_QUOTES);
		$Pnickname =htmlentities($row["nickname"], ENT_QUOTES);
		$Plookingfor =htmlentities($row["looking_for"], ENT_QUOTES);
		$Prelationship =htmlentities($row["relationship_status"], ENT_QUOTES);
		$Ocoverpicurl = htmlentities($row["cover_pic_url"], ENT_QUOTES);
		$Oprofpicurl = htmlentities($row["profile_pic_url"], ENT_QUOTES);
		$Plivein =htmlentities($row["live_in"], ENT_QUOTES);
		$Plivewith =htmlentities($row["live_with"], ENT_QUOTES);
		$Psecschool =htmlentities($row["secondary_school"], ENT_QUOTES);
		$Pcollege =htmlentities($row["college"], ENT_QUOTES);
		$Pachiv =htmlentities($row["achievement"], ENT_QUOTES);
		$Pfav_person =htmlentities($row["fav_person"], ENT_QUOTES);
		$Pfav_celeb =htmlentities($row["fav_celebrity"], ENT_QUOTES);
		$Pintrests =htmlentities($row["intrests"], ENT_QUOTES);
		$Pmaritalstatus =htmlentities($row["marital_status"], ENT_QUOTES);
		$Preligiousview =htmlentities($row["religious_views"], ENT_QUOTES);
		$Ofrndcount = htmlentities($row["frnd_count"], ENT_QUOTES);
		if(empty($Pcollege) || $Pcollege=='' || $Pcollege==NULL) $goes_to=$Psecschool;
		else $goes_to=$Pcollege;
		if(empty($Pachiv) || $Pachiv=='' || $Pachiv==NULL) $achievement='No Acheivement Set';
		else $achievement=$Pachiv;
		if(empty($Pfav_person) || $Pfav_person=='' || $Pfav_person==NULL)
		{
			if($Puserid==$_SESSION['userid'])
			$adores='No Adore<h5 class="fg-lightTeal">Set it Now</h5>';
			else
			$adores='No Adore Set';
		}
		else $adores=$Pfav_person;
		if(empty($Pfav_celeb) || $Pfav_celeb=='' || $Pfav_celeb==NULL)
		{
			if($Puserid==$_SESSION['userid'])
			$fav_celeb='No Fav Celebrity<h5 class="fg-lightTeal">Set it Now</h5>';
			else
			$fav_celeb='No Fav Celebrity Set';
		}
		else $fav_celeb=$Pfav_celeb;
		if(empty($Pintrests) || $Pintrests=='' || $Pintrests==NULL)
		{
			if($Puserid==$_SESSION['userid'])
			 $intrests='No Intrests<h5 class="fg-lightTeal">Set it Now</h5>';
			 else
			 $intrests='No Intrests';
		}
		else $intrests=$Pintrests;
		
		$Pdob = strtotime($Pdob);
		$Pdob2 = date('d-M-Y',$Pdob);
		$Pdateofbirthwithnoyear=date('jS F');
		$Pdobday=date('l',$Pdob);
		$Pdobmonth = date('F',$Pdob);
		$Pdobdate = date('jS',$Pdob);
		$Pdobyear = date('Y',$Pdob);
		$Pageinyear = date('Y') - $Pdobyear;
		if($Preligion=NULL || empty($Preligion) || $Preligion=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Preligion="<span class='fg-green'>Specify your Religion</span>";
		else
		$Preligion="<span class='fg-green'>No Religion Set</span>";
		}
		else $Preligion=htmlentities($row["religion"], ENT_QUOTES);
		if($Pnickname=NULL || empty($Pnickname) || $Pnickname=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Pnickname="<span class='fg-green'>Your maiden name, alternate spellings</span>";
		else
		$Pnickname="<span class='fg-green'>No Nickname</span>";
		}
		else $Pnickname =htmlentities($row["nickname"], ENT_QUOTES);
		if($Plookingfor=NULL || empty($Plookingfor) || $Plookingfor=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Plookingfor="<span class='fg-green'>Whom you looking for?</span>";
		else
		$Plookingfor="<span class='fg-green'>Nothing set</span>";
		}
		else $Plookingfor =htmlentities($row["looking_for"], ENT_QUOTES);
		if($Prelationship=NULL || empty($Prelationship) || $Prelationship=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Prelationship="<span class='fg-green'>In a Relationship?</span>";
		else
		$Prelationship="<span class='fg-green'>Not Set</span>";
		}
		else $Prelationship =htmlentities($row["relationship_status"], ENT_QUOTES);
		if($Pmaritalstatus=NULL || empty($Pmaritalstatus) || $Pmaritalstatus=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Pmaritalstatus="<span class='fg-green'>Specify your Marital Status</span>";
		else
		$Pmaritalstatus="<span class='fg-green'>Not Set</span>";
		}
		else $Pmaritalstatus=htmlentities($row["marital_status"], ENT_QUOTES);
		if($Preligiousview=NULL || empty($Preligiousview) || $Preligiousview=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Preligiousview="<span class='fg-green'>Say somthing about Religion</span>";
		else
		$Preligiousview="<span class='fg-green'>No views</span>";
		}
		else $Preligiousview=htmlentities($row["religious_views"], ENT_QUOTES);
		if($Plivewith=NULL || empty($Plivewith) || $Plivewith=='')
		$Plivewith="<span class='fg-green'>Somebody</span>";
		else $Plivewith=htmlentities($row["live_with"], ENT_QUOTES);
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

$getfrnds=$con->query("SELECT F.status, U.userid,profile_pic_url
FROM user_options U, friend_system F
WHERE
CASE
WHEN F.req_sender = '$Puserid'
THEN F.req_reciever = U.userid
WHEN F.req_reciever= '$Puserid'
THEN F.req_sender= U.userid
END
AND 
F.status='1';");

$frndcount=$getfrnds->num_rows;
if($frndcount<=0)
{
	if($Puserid==$_SESSION['userid'])
	$frndcountselfdisplay="You have no Friend. Make friends :)";
	else
	$frndcountselfdisplay="$Pfullname has no Friend.";
}
elseif($frndcount==1)
{
	if($Puserid==$_SESSION['userid'])
	$frndcountselfdisplay="You have one Friend. Make more friends :)";
	else
	$frndcountselfdisplay="$Pfullname has only one Friend";
}
else
{
	if($Puserid==$_SESSION['userid'])
	$frndcountselfdisplay="You have $frndcount Friends";
	else
	$frndcountselfdisplay="$Pfullname has $frndcount Friends";
}

}
?>
<div class="mainbodycontainer span11">

<div class="userprofilegrid span10 grid">
<div class="userprofilerow span5 row left">
<h3 class="subheader span5 text-center">Personal Info</h3>

<div class="uprp panel span5">
    <div class="uprph panel-header bg-darkBlue fg-white">
        About
    </div>
    <div class="uprpc panel-content bg-white row">
       <div class="padding5"> 
       <div class="row nomargin">
       <div class="uprpic"><i class="fa fa-briefcase fg-gray"></i></div>
       <div class="span4">Developer at SWAT4 Officials</div>
       </div>
       <li class="menu_divider uprpcmd"></li>
       <div class="row nomargin">
       <div class="uprpic"><i class="fa fa-graduation-cap fg-gray"></i></div>
       <div class="span4">Persuing BTech from Arya College of Engineering and Research Center</div>
       </div>
       <li class="menu_divider uprpcmd"></li>
       <div class="row nomargin">
       <div class="uprpic"><i class=" icon-home fg-gray"></i></div>
       <div class="span4">Lives in Jaipur,India</div>
       </div>
       <li class="menu_divider uprpcmd"></li>
       <div class="row nomargin">
       <div class="uprpic"><i class="icon-location fg-gray"></i></div>
       <div class="span4">From in Ranchi,Jharkhand</div>
       </div>
    </div>
</div>
</div>



<div class="uprp panel span5">
    <div class="uprph panel-header bg-darkGreen fg-white">
        General Information
    </div>
    <div class="uprpc panel-content bg-white row">
    <dl class="horizontal tertiary-text fg-gray ppbintl">
  						<dt><strong>Gender</strong></dt>
					    <dd><?=$Pgender?></dd>
						</dl>
                        <dl class="horizontal tertiary-text fg-gray ppbintl">
  						<dt><strong>Dirth Date</strong></dt>
					    <dd><?=$Pdateofbirthwithnoyear?></dd>
						</dl>
                       <dl class="horizontal tertiary-text fg-gray ppbintl">
  						<dt><strong>Relationship</strong></dt>
					    <dd><?=$Prelationship?></dd>
						</dl>
                        <dl class="horizontal tertiary-text fg-gray ppbintl">
  						<dt><strong>Nickname</strong></dt>
					    <dd><?=$Pnickname?></dd>
						</dl>
                        <dl class="horizontal tertiary-text fg-gray ppbintl">
  						<dt><strong>Religion</strong></dt>
					    <dd><?=$Preligion?></dd>
						</dl>
                        <dl class="horizontal tertiary-text fg-gray ppbintl">
  						<dt><strong>looking for</strong></dt>
					    <dd><?=$Plookingfor?></dd>
						</dl>
                       
    </div>
</div>





<div class="uprp panel span5">
    <div class="panel-header">
        ...
    </div>
    <div class="panel-content">
        ...
    </div>
</div>


</div> <!-- ROW ENDS -->


<div class="span5 row right">
<h3 class="subheader text-center span5">Professional Info</h3>
<div class="panel span5">
    <div class="panel-header">
        ...
    </div>
    <div class="panel-content">
        ...
    </div>
</div>
<div class="panel span5">
    <div class="panel-header">
        ...
    </div>
    <div class="panel-content">
        ...
    </div>
</div>

</div>


</div>
</div>