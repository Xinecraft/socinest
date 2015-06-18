<?php
if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: /');}
error_reporting(E_ALL); ini_set('display_errors', 'On');
global $con;
$sacc_error_msg='';
$usern=$_SESSION['username'];
$ss_id=$_SESSION['userid'];
// Check if setup account already done and if done header back to home
$check_setup=$con->query("SELECT account_setup_complete FROM user_options WHERE userid='$ss_id' AND account_setup_complete=0");
if($check_setup->num_rows <=0)
{
	header("Location:./?home");
}
$valid_exts = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
$max_size = 5000 * 1024; // max file size
$path = 'user/'.$usern.'/'; // upload directory
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit1'])) {
  if( ! empty($_FILES['image']) ) {
    // get uploaded file extension
	$filename=$_FILES['image']['name'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    // looking for format and size validity
    if (in_array($ext, $valid_exts) AND $_FILES['image']['size'] < $max_size) {
      $path = $path . time().uniqid(). '.' .$ext;
	  $pathtosql=$path;
      // move uploaded file from temp to uploads directory
      if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
		$sql="UPDATE `user_options` SET `profile_pic_url` = '$pathtosql' WHERE `userid` = $ss_id LIMIT 1;";
		$con->query($sql);
		createThumb($path);
      }
    } else {
      echo 'Error';
    }
  } else {
   echo "";
  }
} else {
  echo 'Bad request!';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit2'])) 
{
if(empty($_POST['livein']))
	$sacc_error_msg= "<div class='text-center'><small class='signup_response_error' style='
    padding: 2px;text-allign:center;'>Please input your address where you live in.</small></div>";
else if(empty($_POST['secschool']))
	$sacc_error_msg= "<div class='text-center'><small class='signup_response_error' style='
    padding: 2px;text-allign:center;'>Please input your Secondary School.</small></div>";
else if(empty($_POST['mobile']))
	$sacc_error_msg= "<div class='text-center'><small class='signup_response_error' style='
    padding: 2px;text-allign:center;'>Please input your mobile or contact number.</small></div>";
else //Handle the form submit here
{
	$livein=$con->escape_string($_POST["livein"]);
	$secschool=$con->escape_string($_POST["secschool"]);
	$college=$con->escape_string($_POST["college"]);
	$workat=$con->escape_string($_POST["workat"]);
	$mobile=$con->escape_string($_POST["mobile"]);
	if(empty($workat)) $workat=NULL;
	if(empty($college)) $college=NULL;
	$sql="UPDATE `user_profile` SET `live_in`='$livein',`secondary_school`='$secschool',`college`='$college',`work_at`='$workat',`phone_number`='$mobile' WHERE userid=$ss_id LIMIT 1;";
	if($con->query($sql))
		{
			$status = 'success';
            $user_id=$con->insert_id;
			$con->query("UPDATE `user_options` SET `account_setup_complete` = 1 WHERE `userid` = $ss_id LIMIT 1;");
			header('Location:./index.php');
		}
}
}
?>
<div class="inputboxcontainer">
<?php
if($_GET['setupaccount']==1 || empty($_GET['setupaccount']))
{
?>
<div class="panel span8 sacc-inputbox">
    <div class="panel-header bg-darkBlue fg-white">
        <p id="inputbox-header-sacc">Add a profile picture</p>
    </div>
    
    <div class="panel-content span8" id="sacc-img-upload-cont">
    <div class="sacc-picture-cont span3">
    <img src="img/defpropic.png" alt="Default Profile Pic" class="sacc-profilepic-view" >
    </div>
    <div class="sacc-pic-form span4">
    <form method="post" action="?setupaccount=1" enctype="multipart/form-data" id="sacc-profpic-upload">
    <input id="sacc-uploadImage" type="file" accept="image/*" name="image" class="" ><br /><br />
    <input type="submit" id="sacc-inputimg-button" class="btn-login signupstartbtn" value="Click here to Upload" name="submit1">
    <button class="btn-login signupstartbtn" id="sacc-next-btn">Next</button>
    </form>
    </div>
    </div>
    </div>

<?php
}
if($_GET['setupaccount']==2)
{
?>
    <div class="panel span8 sacc-inputbox">
    <div class="panel-header bg-darkBlue fg-white">
        <p id="inputbox-header-sacc">Tell us about yourself</p>
    </div>
    
<form method="post" action="?setupaccount=2" id="sacc-profile-update">

<fieldset class="span7">
<?php echo $sacc_error_msg; ?>
<label for="livein">Live In:</label>
<input type="text" value="<?php if(isset($_POST['livein'])) echo $_POST['livein'];?>" placeholder="Live in" id="livein" name="livein"/>

<label for="secschool">Secondary School  :</label>
<input type="text" value="<?php if(isset($_POST['secschool'])) echo $_POST['secschool'];?>" placeholder="Secondary School" id="secschool" name="secschool"/>

<label for="college">College or University(if any) :</label>
<input type="text" value="<?php if(isset($_POST['college'])) echo $_POST['college'];?>" placeholder="College or University" id="college" name="college"/>

<label for="workat">Work at(if any)</label>
<input type="text" value="<?php if(isset($_POST['workat'])) echo $_POST['workat'];?>" placeholder="Work at (Organisation)" id="workat" name="workat"/>

<label for="mobile">Contact Number</label>
<input type="text" value="<?php if(isset($_POST['mobile'])) echo $_POST['mobile'];?>" placeholder="Contact Number (personal)" id="mobile" name="mobile"/>

 <input type="submit" id="sacc-update-btn" class="btn-login signupstartbtn" value="Update &amp; Finish" name="submit2">
 </fieldset>
    </form>
    </div>
<?php
}
?>
</div>