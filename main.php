<?php
ob_start();
include_once('php_include/conf.php');
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once('php_include/is_mobile.php');
include_once('php_include/magicquotesgpc.php');
include_once('php_include/generate_option.php');
require_once('php_include/check_login.php');
include_once('php_include/imp_func_inc.php');
global $con;
//Login Form Direct request
$login_error_msg=NULL;
if(isset($_GET['action']) && $_GET['action']=='login' && $_POST['login-btn'])
{
	if(empty($_POST['username']) || empty($_POST['password']))
	{
	$login_error_msg= "<small class='login_response_error'>Username/Password combination can't be left empty</small>";
	}
	else
	{
	$login_username=$con->escape_string($_POST["username"]);
	$login_username=preg_replace('#[^a-z0-9.@]#i','',$login_username);
	$login_password=$con->escape_string($_POST["password"]);
	$login_password = hash("sha256",DB_SALT . $login_password);
	$loginsql="SELECT userid,username,email,gender FROM user_profile WHERE (username='$login_username' OR email='$login_username') AND password='$login_password' LIMIT 1";
	$loginquery=$con->query($loginsql);
	if($loginquery->num_rows <=0)
	{
		$login_error_msg = "<small class='login_response_error'>Username or Password doesnot match. Try again!</small>";
	}
	else
	{
	$loginrow=$loginquery->fetch_array();
	$loggedin_username = htmlentities($loginrow["username"], ENT_QUOTES);
	$loggedin_email = htmlentities($loginrow["email"], ENT_QUOTES);
	$loggedin_gender = htmlentities($loginrow["gender"], ENT_QUOTES);
	$loggedin_id = htmlentities($loginrow["userid"], ENT_QUOTES);
	//Set Session
	$_SESSION=array();
	$_SESSION['username']=$loggedin_username;
	$_SESSION['userid']=$loggedin_id;
	$_SESSION['email']=$loggedin_email;
	$_SESSION['gender']=$loggedin_gender;
	$loggedin_user_ip=get_client_ip();
	$res=$con->query("UPDATE user_options SET last_login_ip='$loggedin_user_ip',last_login_time=now() WHERE userid='$loggedin_id' LIMIT 1;");
	if(isset($_POST['rememberme']) && $_POST['rememberme']=='yes')
	{
//		setcookie("loginkey",$loggedin_id,time()+3600);
		//setcookie('loginkey',$loggedin_id,strtotime('+30 days'),'/','localhost',false,true);
	}
	header('Location:./index.php');
	}
	}
}
//SignUp form ajax request
if(isset($_GET['action']) && $_GET['action']=='signup')
{
	$signup_username=$con->escape_string($_POST["signup_username"]);
	$signup_username_isvalid=$signup_username;
	$signup_username_isvalid=rtrim($signup_username_isvalid,' ');
	$signup_username=preg_replace('#[^a-z0-9_\.]#i','',$signup_username);
	$signup_email=$con->escape_string($_POST["signup_email"]);
	$signup_firstname=$con->escape_string($_POST["signup_firstname"]);
	$signup_lastname=$con->escape_string($_POST["signup_lastname"]);
	$signup_password=$con->escape_string($_POST["signup_password"]);
	$signup_orig_password=$signup_password;
	$signup_password = hash("sha256",DB_SALT . $signup_password);
	$signup_dob_day=$con->escape_string($_POST["signup_dob_day"]);
	$signup_dob_month=$con->escape_string($_POST["signup_dob_month"]);
	$signup_dob_year=$con->escape_string($_POST["signup_dob_year"]);
	$signup_gender=$con->escape_string($_POST["signup_gender"]);
	$signup_dob=$signup_dob_month.'/'.$signup_dob_day.'/'.$signup_dob_year;
	$signup_dob=strtotime($signup_dob);
	$signup_dob=date('Y-m-d',$signup_dob);
	$signup_fullname=$signup_firstname.' '.$signup_lastname;
	//validation starts
	
	if(empty($signup_username_isvalid))
	{
	$status = 'error';
    $message = 'Please enter your desired username';
	}
	else if(preg_match('#[^a-z0-9_\.]#i',$signup_username_isvalid))
	{
	$status = 'error';
    $message = 'Please enter valid username. Allowed only alphanumeric, underscore and period.';
	}
	else if(strlen($signup_username) > 20)
	{
	$status = 'error';
	$message = 'Username cannot exceed 20 caracters';
	}
	else if(empty($signup_email))
	{
	$status = 'error';
    $message = 'Please enter your email address';
	}
	else if(empty($signup_firstname))
	{
	$status = 'error';
    $message = 'Please enter your firstname';
	}
	else if(empty($signup_lastname))
	{
	$status = 'error';
    $message = 'Please enter your lastname';
	}
	else if(empty($signup_password))
	{
	$status = 'error';
    $message = 'Please enter a password';
	}
	else if(strlen($signup_orig_password) < 8)
	{
	$status = 'error';
    $message = 'Enter atleast 8 characters Password';
	}
	else if(empty($signup_dob_day) || empty($signup_dob_month) || empty($signup_dob_year))
	{
	$status = 'error';
    $message = 'Fill date of birth completely';
	}
	else if(!is_numeric($signup_dob_day) || !is_numeric($signup_dob_month) || !is_numeric($signup_dob_year))
	{
	$status = 'error';
    $message = 'Date of Birth not Valid';
	}
	else if($signup_dob_day>31 || $signup_dob_month>12 || ($signup_dob_year<1900 || $signup_dob_year>2014))
	{
	$status = 'error';
    $message = 'Warning! Date of Birth fields modified!';
	}
	else if(!filter_var($signup_email, FILTER_VALIDATE_EMAIL))
	{ 
	//validate email address - check if is a valid email address
    $status = 'error';
    $message = 'Please enter a valid email address!';
	}
	else if(empty($signup_gender))
	{
	$status = 'error';
    $message = 'Please specify your Gender';
	}
	else if(!in_array($signup_gender,array('F','M')))
	{
	$status = 'error';
    $message = 'Gender not Valid';
	}
	else
	{
		$query=$con->query("SELECT username,email FROM user_profile WHERE email='$signup_email' OR username='$signup_username' LIMIT 1;");
		if($query->num_rows <=0)
		{
			$sql = "INSERT INTO `user_profile` (`username`, `password`, `firstname`, `lastname`,`full_name`, `email`, `date_of_birth`, `gender`) VALUES('$signup_username','$signup_password','$signup_firstname','$signup_lastname','$signup_fullname','$signup_email','$signup_dob','$signup_gender');";
		if($con->query($sql))
		{
			$status = 'success';
            $message = 'Registration success!';
			$user_id=$con->insert_id;
			$user_ip=get_client_ip();
			$random=rand(100000,999999);
			$activation_link = hash("sha256",DB_SALT . $signup_username.$random.time());
			$sql2 = "INSERT INTO `user_options` (`userid`,`register_time_ip`,`date_of_register`,`activation_link`) VALUES ('$user_id','$user_ip',now(),'$activation_link');";
			$con->query($sql2);
			$sqlf="INSERT INTO `friend_system` (`req_sender`, `req_reciever`, `status`, `sender_ip`,`accept_time`) VALUES ('$user_id','$user_id',2, '$user_ip',now());";
			$con->query($sqlf);
			if(!file_exists("user/$signup_username"))
			{
				mkdir("user/$signup_username",0755);
			}
			$_SESSION['username']=$signup_username;
			$_SESSION['userid']=$user_id;
			$_SESSION['email']=$signup_email;
			$_SESSION['gender']=$signup_gender;
//			setcookie('loginkey',$user_id,strtotime('+30 days'),'/','localhost',false,true);
//			setcookie("loginkey",$loggedin_id,time()+3600);
		}
		else
		{
			$status = 'error';
            $message = 'Unknown Technical Error!';
		}	
		}
		else
		{
		$row = $query->fetch_array();
		if($row["username"]==$signup_username)
		{
			$status = 'error';
    		$message = 'Username already registered';
		}
		else
		{
			$status = 'error';
    		$message = 'Email is already registered';
		}
		}
	}
	
	//return json response 
    $data = array(
        'status' => $status,
        'message' => $message
    );
    echo json_encode($data);
	exit();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="metro/css/metro-bootstrap.css" />
        <link rel="stylesheet" href="metro/css/iconFont.min.css" />
        <link rel='stylesheet' href='ico/font/typicons.min.css' />
        <link rel="stylesheet" href="inc/css/main.css" />
       <!-- <link href='http://fonts.googleapis.com/css?family=Joti+One' rel='stylesheet' type='text/css'> -->
        <script src="metro/js/jquery/jquery.min.js"></script>
        <script src="metro/js/jquery/jquery.widget.min.js"></script>
        <script src="metro/js/metro/metro.min.js"></script>
        <script src="inc/js/main.js"></script>
    </head>
<body class="metro">
<div class="container">

<div id="header">
<div id="header_left">

</div>
<div id="header_right" class="text-center">

</div>
</div>

<div class="ribbon" id="strip">
<div id="strip_left" class="span5 text-right">
<div id="header_txt" class="">Socinest</div>
</div>
</div>

<div class="contain">
<div class="span5" id="left_homepage">
<!--<img src="img/slogan.png" width="300" height="300" />  -->
<h2>Donot have an account? </h2>
<button class="btn-login signupstartbtn" id="signup_bring_btn">Create a New</button>
<button class="btn-login signupstartbtn hidden" id="login_bring_btn">Login Now</button>
<div class="border-bottom margin20"></div>
<h1 class="slogan">Connect across <br>your imaginations</h1>
<img class="rounded" src="data:image/jpg;base64,<?php echo base64_img('img/joinus.jpg') ?>" width="300px">    
</div>

<div class="span7" id="right_homepage">
<div id="login_container">

<!-- Login Form -->
<form id="login" action="?action=login" method="post">
<h2 class="text-center">Log In</h2>
<label for="username">Username or Email</label>
<div class="input-control text">
    <input type="text" value="" placeholder="Username" id="username" name="username"/>
    <button class="btn-clear"></button>
</div>
 
<label for="password">Password</label>
<div class="input-control password">
    <input type="password" value="" placeholder="Password" id="password" name="password"/>
</div>

<div id="lower">
<div class="input-control checkbox">
    <label>
        <input type="checkbox" name="rememberme" value="yes" />
        <span class="check"></span>
        Remember Me
    </label>
</div>

<input type="submit" value="Log In" class="btn-login" id="login_button" name="login-btn">
<div class="input-control span3">
 <a href="#" id="forgot_passwd"><small>Forgot password?</small></a>
 </div>
 <div class="input-control text-center login_error_container">
<?php echo $login_error_msg; ?>
 </div>
</div><!--/ lower-->
</form>

<!-- Sign Up Form -->
<form class="hidden" id="signup" action="main.php?action=signup" method="POST"><h2 class="text-center">Create a Socinest Account</h2><label for="signup_username">Desired Username</label><div class="input-control text"><input type="text" value="" placeholder="Desired Username" id="signup_username" name="signup_username" maxlength="20"/><button class="btn-clear"></button></div> <label for="signup_email">Email Address</label><div class="input-control text"><input type="email" value="" placeholder="Your Email Address" id="signup_email" name="signup_email"/><button class="btn-clear"></button></div><label for="signup_firstname">First Name</label><div class="input-control text"><input type="text" value="" placeholder="First Name" id="signup_firstname" name="signup_firstname"/><button class="btn-clear"></button></div><label for="signup_lastname">Last Name</label><div class="input-control text"><input type="text" value="" placeholder="Last Name" id="signup_lastname" name="signup_lastname"/><button class="btn-clear"></button></div><label for="signup_password">New Password</label><div class="input-control password"><input type="password" value="" placeholder="New Password" id="signup_password" name="signup_password"/><button class="btn-reveal"></button></div><label for="signup_dob_day">Date of Birth</label><br /> <div class="input-control select inline"><select id="signup_dob_day" name="signup_dob_day" class="signup_dob"><option value="">Day</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select></div><div class="input-control select inline"><select name="signup_dob_month" class="signup_dob" id="signup_dob_month"><option value="">Month</option><option value="1">January</option><option value="2">February</option><option value="3">March</option> <option value="4">April</option> <option value="5">May</option> <option value="6">June</option> <option value="7">July</option> <option value="8">August</option> <option value="9">September</option> <option value="10">October</option> <option value="11">November</option><option value="12">December</option> </select></div><div class="input-control select inline">   <select id="signup_dob_year" name="signup_dob_year" class="signup_dob"><option value="">Year</option>
    <?=generate_options(date('Y'),1900)?></select></div><label for="signup_gender">Gender</label><br />    <div class="input-control select">    <select name="signup_gender" class="" id="signup_gender">        <option value="">Select Gender</option>        <option value="F">Female</option>        <option value="M">Male</option>    </select>	</div><div id="lower"><div class="signup_agreement"><small class="text-muted">By clicking Create Now you agree our <a href="./?terms"> Terms &amp; Conditions</a> and that you have read and accepted our <a href="./?data">Data</a> and <a href="./?cookie">Cookie</a> policy.</small></div><div class="signup_btn_area">
<input type="submit" value="Create Now" class="btn-login signupstartbtn" id="signup_btn" name="signup-btn">
<div class="signup_response" id="signup_response"></div>
</div>
</div><!--/ lower-->
</form>
</div><!-- Login Container ends -->
</div><!-- Homepage Left Ends -->


<!-- Footer Starts -->
<div class="main_footer" id="start_page_footer">

<div class="span3 footer_column">
<h4 class="main-textcolor">About Us</h4>
<a>About</a><br />
<a>Team</a><br />
<a>Showcase</a><br />
</div>
<div class="span3 footer_column">
<h4 class="main-textcolor">Legal</h4>
<a>Privacy</a><br />
<a>Terms</a><br />
<a>Cookies</a><br />
</div>
<div class="span3 footer_column">
<h4 class="main-textcolor">Help</h4>
<a>Get Started</a><br />
<a>Help Center</a><br />
<a>FAQs</a><br />
</div>
<div class="span3 footer_column">
<h4 class="main-textcolor">Contact</h4>
<a>Contact us</a><br />
<a>Customer Service</a><br />
<a>Feedback</a><br />
</div>
<div class="copyright main-textcolor">
SociNest &copy; 2014 </div>
</div>
</div>
<!-- Footer Ends -->

</div><!-- Contain Ends -->
</div><!-- Container Ends -->
</body>
</html>
