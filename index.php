<?php
ob_start();
require_once('php_include/conf.php');
ini_set('display_errors',0);
error_reporting(E_ALL);
include_once('php_include/is_mobile.php');
include_once('php_include/magicquotesgpc.php');
include_once('php_include/generate_option.php');
include_once('php_include/thumbnailfunction.php');
require_once('php_include/check_login.php');
include_once('php_include/imp_func_inc.php');
global $con;

?>
<!DOCTYPE html>
<html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<!--<php
//load time calculator
$starttime = microtime(); $startarray = explode(" ", $starttime); $starttime = $startarray[1] + $startarray[0];
?> -->
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="metro/css/metro-bootstrap.css" />
        <link rel="stylesheet" href="metro/css/iconFont.min.css" />
        <link rel="stylesheet" href="inc/css/jquery-ui.css" />
        <link rel='stylesheet' href='ico/font/typicons.min.css' />
        <link rel="stylesheet" href="inc/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="inc/css/main.css" />
       <!-- <link href='http://fonts.googleapis.com/css?family=Joti+One' rel='stylesheet' type='text/css'> -->
        
</head>
<body class="metro">
<div class="container">
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->
<?php
include_once('header.php');
include_once('sidebar.php');
//incude body here;
?>
<div class="bodycontainer">
<?php
if(isset($_GET["setupaccount"])) include_once("php_include/setupaccount.php");
else if(isset($_GET["logout"]))  include_once("php_include/logout.php");
else if(isset($_GET["profile"])) include_once("php_include/profile.php");
else if(isset($_GET["q"])) include_once("php_include/search.php");
else if(isset($_GET["user"])) include_once("php_include/user.php");
else include_once("php_include/home.php");
?>
</div>
<?php
include_once('footer.php');
?>
</div>
<?php
//load time calculator
//$endtime = microtime();
//$endarray = explode(" ", $endtime); 
//$endtime = $endarray[1] + $endarray[0];
//$totaltime = $endtime - $starttime;
//$totaltime = round($totaltime,10); 
//echo "Seconds To Load: "; printf ("%fn", $totaltime);
?>
        <script src="metro/js/jquery/jquery.min.js"></script>
        <script src="metro/js/jquery/jquery.widget.min.js"></script>
        <script src="inc/js/jquery-ui.js"></script>
        <script src="metro/js/metro/metro.min.js"></script>
        <script src="inc/js/jquery.wallform.js"></script>
        <script src="inc/js/main.js"></script>
</body>
</html>