<?php
if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: /');}
?>
<div class="mainbodycontainer span11">
<div class="feedscontainer span10">
<?php
$getuser=$con->escape_string($_GET["profile"]);
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
		$Pdobday=date('l',$Pdob);
		$Pdobmonth = date('F',$Pdob);
		$Pdobdate = date('jS',$Pdob);
		$Pdobyear = date('Y',$Pdob);
		$Pageinyear = date('Y') - $Pdobyear;
		if($Preligion=NULL || empty($Preligion) || $Preligion=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Preligion="<span class='text-bgrey'>Specify your Religion</span>";
		else
		$Preligion="<span class='text-bgrey'>No Religion Set</span>";
		}
		else $Preligion=htmlentities($row["religion"], ENT_QUOTES);
		if($Pnickname=NULL || empty($Pnickname) || $Pnickname=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Pnickname="<span class='text-bgrey'>Your maiden name, alternate spellings</span>";
		else
		$Pnickname="<span class='text-bgrey'>No Nickname</span>";
		}
		else $Pnickname =htmlentities($row["nickname"], ENT_QUOTES);
		if($Plookingfor=NULL || empty($Plookingfor) || $Plookingfor=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Plookingfor="<span class='text-bgrey'>Whom you looking for?</span>";
		else
		$Plookingfor="<span class='text-bgrey'>Nothing set</span>";
		}
		else $Plookingfor =htmlentities($row["looking_for"], ENT_QUOTES);
		if($Prelationship=NULL || empty($Prelationship) || $Prelationship=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Prelationship="<span class='text-bgrey'>In a Relationship?</span>";
		else
		$Prelationship="<span class='text-bgrey'>Not Set</span>";
		}
		else $Prelationship =htmlentities($row["relationship_status"], ENT_QUOTES);
		if($Pmaritalstatus=NULL || empty($Pmaritalstatus) || $Pmaritalstatus=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Pmaritalstatus="<span class='text-bgrey'>Specify your Marital Status</span>";
		else
		$Pmaritalstatus="<span class='text-bgrey'>Not Set</span>";
		}
		else $Pmaritalstatus=htmlentities($row["marital_status"], ENT_QUOTES);
		if($Preligiousview=NULL || empty($Preligiousview) || $Preligiousview=='')
		{
		if($Puserid==$_SESSION['userid'])
		$Preligiousview="<span class='text-bgrey'>Say somthing about Religion</span>";
		else
		$Preligiousview="<span class='text-bgrey'>No views</span>";
		}
		else $Preligiousview=htmlentities($row["religious_views"], ENT_QUOTES);
		if($Plivewith=NULL || empty($Plivewith) || $Plivewith=='')
		$Plivewith="<span class='text-bgrey'>Somebody</span>";
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


if($_GET['profile']==$_SESSION['username'])
	{
		// Code for userprofile for Owner screen
?>
<div class="tile-group six no-margin no-padding">

           <div class="tile-group two no-margin no-padding">
           <!--Dynamic Photos Loader Tile -->
            <a class="tile double bg-violet live profphototile" data-click="transform" data-role="live-tile" data-effect="slideUp">
<?php
$countimages=$con->query("SELECT pic_id FROM status_pic WHERE postedby LIKE '$Puserid';");
$no_of_img=$countimages->num_rows;
$request4image=$con->query("SELECT pic_url FROM status_pic WHERE postedby LIKE '$Puserid' ORDER BY time DESC LIMIT 4;");
if($request4image->num_rows <= 0)
{
	echo '<div class="tile-content"><img src="img/2.jpg"></div>';
}
else
{
	while($req4imgrow = $request4image->fetch_array())
	{
		$req4picurl = htmlentities($req4imgrow["pic_url"], ENT_QUOTES);
		echo "<div class='tile-content'><img class='r4iic' src='thumb.php?src=$req4picurl&x=20' width='100%' height='100%'></div>";
	}
}
?>
             <div class="tile-status bg-black">
                    <div class="label">Photos</div>
                    <span class="badge bg-darkRed "><?=$no_of_img?></span>
                </div>
            </a>
            
            <a class="tile double half bg-violet" data-click="transform">
                <div class="tile-content">
                
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Gender </p>
                        <h3 class="fg-white nomargin"><?=$Pgender?></h3>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h3 class="no-margin fg-white"><span class="fa fa-<?=strtolower($Pgender)?>"></span></h3></div>
                </div>
            </a> <!-- end tile -->
            </div>
            <!-- end tile -->



<div class="tile-group two no-margin no-padding">
<a class="tile double half bg-cyan" id="gototile">
                <div class="tile-content">
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Goes to
                        <i class="editbtndoh fa fa-edit padding1 right"></i>
                        </p>
                        <h4 class="fg-white nomargin gototiledata"><?=$goes_to?></h4>
                        <input class="text-center gototileeditbox hidden" name="gototileeditbox" value="" />
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><i class="fa fa-university"></i></h4></div>
                </div>
            </a> <!-- end tile -->
            
<a class="tile double half bg-emerald">
                <div class="tile-content">
                
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Recent Status
                        </p>
                        <h4 class="fg-white nomargin">This status Sucks</h4>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><i class="fa fa-ils"></i></h4></div>
                </div>
            </a> <!-- end tile -->
            <a class="tile double half bg-darkBlue" id="achmntile">
                <div class="tile-content">
                
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Achievement
                        <i class="editbtndoh fa fa-edit padding1 right"></i>
                        </p>
                        <h4 class="fg-white nomargin achmntiledata"><?=$achievement?></h4>
                        <input class="text-center achmntileeditbox hidden" name="achmntileeditbox" value="" maxlength="25"/>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><span class="fa fa-trophy"></span></h4></div>
                </div>
            </a> <!-- end tile -->
            
<div class="tile half bg-orange">
    <div class="tile-content icon">
     <i class="icon-cart-2"></i>
 </div>
</div>


<div class="tile half bg-green">
    <div class="tile-content icon">
        <i class="icon-cart-2"></i>
    </div>
</div>

<div class="tile half bg-teal" title="Show Cover Picture">
    <div class="tile-content icon">
        <i class="icon-pictures"></i>
    </div>
</div>

<a class="tile half bg-darkPink" title="View Full Profile" href="./?user=<?=$getuser?>">
    <div class="tile-content icon">
        <i class="icon-user-2"></i>
    </div>
</a>

</div>





            <a class="tile double bg-darkIndigo live" data-click="transform" data-role="live-tile" data-effect="slideUp">
                <div class="tile-content">
                
                    <div class="text-center padding10 ntp">
                        <h4 class="fg-white">Adores</h4>
                        <h2 class="fg-white"><?=$adores?></h2>
                        
                    </div>
                </div>
                  <div class="tile-content">
                    <div class="text-center padding10 ntp">
                         <h4 class="fg-white">Fav Celebrity</h4>
                        <h2 class="fg-white"><?=$fav_celeb?></h2>
                        
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h3 class="no-margin fg-white"><span class="fa fa-meh-o"></span></h3></div>
                </div>
            </a> <!-- end tile -->

            <div class="tile double bg-darker" data-click="transform">
                 <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white">Intrests</h2>
                    <h3 class="fg-white"><?=$intrests?> </h3>
                    </div>
                </div>
            </div> <!-- end tile -->

            <!-- small tiles
            <a href="#" class="tile half bg-darkRed" data-click="transform">
                <div class="tile-content icon">
                    <span class="icon-camera"></span>
                </div>
            </a>

            <a href="#" class="tile half bg-darkOrange" data-click="transform">
                <div class="tile-content icon">
                    <span class="icon-headphones"></span>
                </div>
            </a>

            <a href="#" class="tile half bg-green" data-click="transform">
                <div class="tile-content icon">
                    <span class="icon-steering-wheel"></span>
                </div>
            </a>

            <a href="#" class="tile half bg-darkPink" data-click="transform">
                <div class="tile-content icon">
                    <span class="icon-pictures"></span>
                </div>
            </a>
            <!-- end small tiles -->
<div class="tile-group two no-margin no-padding">
<div class="tile double half bg-darkRed live" data-click="transform" data-role="live-tile" data-effect="slideUp">
                 <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white">Lives in <strong><?=$Plivein?></strong></h2>
                    </div>
                    <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><span class="fa fa-map-marker"></span></h4></div>
                </div>
                </div>
                <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white">with <b><?=$Plivewith?></b></h2>
                    </div>
                </div>
            </div> <!-- end tile -->
            <div class="tile double half bg-darkOrange live" data-click="transform" data-role="live-tile" data-effect="slideUp">
            	 <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white">Birthday</h2>
                    </div>
                </div>
                 <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white"><?=$Pdobdate.' '.$Pdobmonth?></h2>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><span class="fa fa-birthday-cake"></span></h4></div>
                </div>
            </div> <!-- end tile -->
            </div>
            
     <div class="tile triple bg-darkGreen live" data-click="transform" data-role="live-tile" data-effect="slideUp">
    <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white">Friends</h2>
                    <h4 class="fg-white"><?=$frndcountselfdisplay?></h4>
                    </div>
                </div>
                <div class="tile-content image-set bg-black">
                
<?php
if($getfrnds->num_rows > 0)
{
$i=1;
while($getfrndprofpicrow=$getfrnds->fetch_array())
{
 if($i==6) break;
 echo "<img src='thumb.php?src=".$getfrndprofpicrow['profile_pic_url']."&x=10'>";
 $i++;
}
}
else
{
	echo "<h2 class='fg-white text-center'>No friends </h2>";
}
?>
    </div>
                <div class="brand">
                    <div class="label"><h2 class="no-margin fg-white"><span class="fa fa-users"></span></h2></div>
                    <div class="badge bg-green"><?=$frndcount?></div>
                </div>
            </div>
            
 <a href="#" class="tile bg-dark" data-click="transform">
                <div class="tile-content text-center">
                	<h1 class="fg-white nomargin">+1</h1>
                    <h2 class="fg-white nomargin">People</h2>
                    <p class="fg-white margin5">in Common</p>
                </div>
            </a>
            
<a class="tile double half bg-darkBlue" id="lookfortile">
                <div class="tile-content">
                
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Looking for
                        <i class="editbtndoh fa fa-edit padding1 right"></i>
                        </p>
                        <h4 class="fg-white nomargin lookfortiledata"><?=$Plookingfor?></h4>
                        <input class="text-center lookfortileeditbox hidden" name="lookfortileeditbox" value="" maxlength="25"/>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><span class="fa fa-paw"></span></h4></div>
                </div>
            </a> <!-- end tile -->
            
<a class="tile double half bg-magenta live" data-click="transform" data-role="live-tile" data-effect="slideUp">
                <div class="tile-content">
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Relationship Status</p>
                        <h4 class="fg-white nomargin"><?=$Prelationship?></h4>
                    </div>
                </div>
                 <div class="tile-content">
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Marital Status</p>
                        <h4 class="fg-white nomargin"><?=$Pmaritalstatus?></h4>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><span class="fa fa-heart-o"></span></h4></div>
                </div>
            </a> <!-- end tile -->
            
<a class="tile double half bg-darkIndigo live" data-click="transform" data-role="live-tile" data-effect="slideUp">
                <div class="tile-content">
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Religion</p>
                        <h4 class="fg-white nomargin"><?=$Preligion?></h4>
                    </div>
                </div>
                <div class="tile-content">
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Religious View</p>
                        <p class="fg-white nomargin"><?=$Preligiousview?></p>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><span class="fa fa-moon-o"></span></h4></div>
                </div>
            </a> <!-- end tile -->
 
            
            
        </div> <!-- End group -->

<?php
	}
else
	{
		// Code for userprofile for Visitor Screen
?>


<div class="tile-group six no-margin no-padding">

           <div class="tile-group two no-margin no-padding">
           <!--Dynamic Photos Loader Tile -->
            <a class="tile double bg-violet live profphototile" data-click="transform" data-role="live-tile" data-effect="slideUp">
<?php
$countimages=$con->query("SELECT pic_id FROM status_pic WHERE postedby LIKE '$Puserid';");
$no_of_img=$countimages->num_rows;
$request4image=$con->query("SELECT pic_url FROM status_pic WHERE postedby LIKE '$Puserid' ORDER BY time DESC LIMIT 4;");
if($request4image->num_rows <= 0)
{
	echo '<div class="tile-content"><img src="img/2.jpg"></div>';
}
else
{
	while($req4imgrow = $request4image->fetch_array())
	{
		$req4picurl = htmlentities($req4imgrow["pic_url"], ENT_QUOTES);
		echo "<div class='tile-content'><img class='r4iic' src='thumb.php?src=$req4picurl&x=20' width='100%' height='100%'></div>";
	}
}
?>
             <div class="tile-status bg-black">
                    <div class="label">Photos</div>
                    <span class="badge bg-darkRed "><?=$no_of_img?></span>
                </div>
            </a>
            
            <a class="tile double half bg-violet" data-click="transform">
                <div class="tile-content">
                
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Gender </p>
                        <h3 class="fg-white nomargin"><?=$Pgender?></h3>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h3 class="no-margin fg-white"><span class="fa fa-<?=strtolower($Pgender)?>"></span></h3></div>
                </div>
            </a> <!-- end tile -->
            </div>
            <!-- end tile -->



<div class="tile-group two no-margin no-padding">
<a class="tile double half bg-cyan" data-click="transform">
                <div class="tile-content">
                
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Goes to</p>
                        <h4 class="fg-white nomargin"><?=$goes_to?></h4>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h3 class="no-margin fg-white"><i class="fa fa-university"></i></h3></div>
                </div>
            </a> <!-- end tile -->
            
<a class="tile double half bg-emerald" data-click="transform">
                <div class="tile-content">
                
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Recent Status</p>
                        <h4 class="fg-white nomargin">This status Sucks</h4>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h3 class="no-margin fg-white"><i class="fa fa-ils"></i></h3></div>
                </div>
            </a> <!-- end tile -->
            <a class="tile double half bg-darkBlue" data-click="transform">
                <div class="tile-content">
                
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Achievement</p>
                        <h4 class="fg-white nomargin"><?=$achievement?></h4>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h3 class="no-margin fg-white"><span class="fa fa-trophy"></span></h3></div>
                </div>
            </a> <!-- end tile -->
</div>




            <a class="tile double bg-darkIndigo live" data-click="transform" data-role="live-tile" data-effect="slideUp">
                <div class="tile-content">
                
                    <div class="text-center padding10 ntp">
                        <h4 class="fg-white">Adores</h4>
                        <h2 class="fg-white"><?=$adores?></h2>
                        
                    </div>
                </div>
                  <div class="tile-content">
                    <div class="text-center padding10 ntp">
                         <h4 class="fg-white">Fav Celebrity</h4>
                        <h2 class="fg-white"><?=$fav_celeb?></h2>
                        
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h3 class="no-margin fg-white"><span class="fa fa-meh-o"></span></h3></div>
                </div>
            </a> <!-- end tile -->

            <div class="tile double bg-darker" data-click="transform">
                 <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white">Intrests</h2>
                    <h3 class="fg-white"><?=$intrests?> </h3>
                    </div>
                </div>
            </div> <!-- end tile -->

            <!-- small tiles
            <a href="#" class="tile half bg-darkRed" data-click="transform">
                <div class="tile-content icon">
                    <span class="icon-camera"></span>
                </div>
            </a>

            <a href="#" class="tile half bg-darkOrange" data-click="transform">
                <div class="tile-content icon">
                    <span class="icon-headphones"></span>
                </div>
            </a>

            <a href="#" class="tile half bg-green" data-click="transform">
                <div class="tile-content icon">
                    <span class="icon-steering-wheel"></span>
                </div>
            </a>

            <a href="#" class="tile half bg-darkPink" data-click="transform">
                <div class="tile-content icon">
                    <span class="icon-pictures"></span>
                </div>
            </a>
            <!-- end small tiles -->
<div class="tile-group two no-margin no-padding">
<div class="tile double half bg-darkRed live" data-click="transform" data-role="live-tile" data-effect="slideUp">
                 <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white">Lives in <strong><?=$Plivein?></strong></h2>
                    </div>
                    <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><span class="fa fa-map-marker"></span></h4></div>
                </div>
                </div>
                <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white">with <b><?=$Plivewith?></b></h2>
                    </div>
                </div>
            </div> <!-- end tile -->
            <div class="tile double half bg-darkOrange live" data-click="transform" data-role="live-tile" data-effect="slideUp">
            	 <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white">Birthday</h2>
                    </div>
                </div>
                 <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white"><?=$Pdobdate.' '.$Pdobmonth?></h2>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><span class="fa fa-birthday-cake"></span></h4></div>
                </div>
            </div> <!-- end tile -->
            </div>
            
     <div class="tile triple bg-darkGreen live" data-click="transform" data-role="live-tile" data-effect="slideUp">
    <div class="tile-content">
                 <div class="text-center padding10 ntp">
                    <h2 class="fg-white">Friends</h2>
                    <h4 class="fg-white"><?=$frndcountselfdisplay?></h4>
                    </div>
                </div>
                <div class="tile-content image-set bg-black">
                
<?php
if($getfrnds->num_rows > 0)
{
$i=1;
while($getfrndprofpicrow=$getfrnds->fetch_array())
{
 if($i==6) break;
 echo "<img src='thumb.php?src=".$getfrndprofpicrow['profile_pic_url']."&x=10'>";
 $i++;
}
}
else
{
	echo "<h2 class='fg-white text-center'>No friends </h2>";
}
?>
    </div>
                <div class="brand">
                    <div class="label"><h2 class="no-margin fg-white"><span class="fa fa-users"></span></h2></div>
                    <div class="badge bg-green"><?=$frndcount?></div>
                </div>
            </div>
            
 <a href="#" class="tile bg-dark" data-click="transform">
                <div class="tile-content text-center">
                	<h1 class="fg-white nomargin">+1</h1>
                    <h2 class="fg-white nomargin">People</h2>
                    <p class="fg-white margin5">in Common</p>
                </div>
            </a>
            
<a class="tile double half bg-darkBlue" data-click="transform">
                <div class="tile-content">
                
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Looking for</p>
                        <h4 class="fg-white nomargin"><?=$Plookingfor?></h4>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><span class="fa fa-paw"></span></h4></div>
                </div>
            </a> <!-- end tile -->
            
<a class="tile double half bg-magenta live" data-click="transform" data-role="live-tile" data-effect="slideUp">
                <div class="tile-content">
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Relationship Status</p>
                        <h4 class="fg-white nomargin"><?=$Prelationship?></h4>
                    </div>
                </div>
                 <div class="tile-content">
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Marital Status</p>
                        <h4 class="fg-white nomargin"><?=$Pmaritalstatus?></h4>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><span class="fa fa-heart-o"></span></h4></div>
                </div>
            </a> <!-- end tile -->
            
<a class="tile double half bg-darkIndigo live" data-click="transform" data-role="live-tile" data-effect="slideUp">
                <div class="tile-content">
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Religion</p>
                        <h4 class="fg-white nomargin"><?=$Preligion?></h4>
                    </div>
                </div>
                <div class="tile-content">
                    <div class="text-right padding10 ntp text-center">
                        <p class="fg-white">Religious View</p>
                        <p class="fg-white nomargin"><?=$Preligiousview?></p>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h4 class="no-margin fg-white"><span class="fa fa-moon-o"></span></h4></div>
                </div>
            </a> <!-- end tile -->
 
            
            
        </div> <!-- End group -->

<?php
	}
}
else
{
	// Code if username is not found.
	header('Location:./?home');
}
?>
</div>
</div>
