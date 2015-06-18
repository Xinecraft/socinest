<?php
function getExtension($str)
{
$i = strrpos($str,".");
if (!$i) { return ""; }
$l = strlen($str) - $i;
$ext = substr($str,$i+1,$l);
return $ext;
}

function data_uri($file, $mime) {
  $contents=file_get_contents($file);
  $base64=base64_encode($contents);
 echo "data:$mime;base64,$base64";
}
//This simple and easy function will take a number and add "th, st, nd, rd, th" after it. Very useful!
function ordinal($cdnl){ 
    $test_c = abs($cdnl) % 10; 
    $ext = ((abs($cdnl) %100 < 21 && abs($cdnl) %100 > 4) ? 'th' 
            : (($test_c < 4) ? ($test_c < 3) ? ($test_c < 2) ? ($test_c < 1) 
            ? 'th' : 'st' : 'nd' : 'rd' : 'th')); 
    return $cdnl.$ext; 
}  

//Detect Location By IP
function detect_city($ip) {

        $default = 'UNKNOWN';

        if (!is_string($ip) || strlen($ip) < 1 || $ip == '127.0.0.1' || $ip == 'localhost')
            $ip = '8.8.8.8';

        $curlopt_useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)';

        $url = 'http://ipinfodb.com/ip_locator.php?ip=' . urlencode($ip);
        $ch = curl_init();

        $curl_opt = array(
            CURLOPT_FOLLOWLOCATION  => 1,
            CURLOPT_HEADER      => 0,
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_USERAGENT   => $curlopt_useragent,
            CURLOPT_URL       => $url,
            CURLOPT_TIMEOUT         => 1,
            CURLOPT_REFERER         => 'http://' . $_SERVER['HTTP_HOST'],
        );

        curl_setopt_array($ch, $curl_opt);

        $content = curl_exec($ch);

        if (!is_null($curl_info)) {
            $curl_info = curl_getinfo($ch);
        }

        curl_close($ch);

        if ( preg_match('{<li>City : ([^<]*)</li>}i', $content, $regs) )  {
            $city = $regs[1];
        }
        if ( preg_match('{<li>State/Province : ([^<]*)</li>}i', $content, $regs) )  {
            $state = $regs[1];
        }

        if( $city!='' && $state!='' ){
          $location = $city . ', ' . $state;
          return $location;
        }else{
          return $default;
        }

}

// usage example :::  <img class="rounded" src="data:image/jpg;base64,<?php echo base64_img('img/joinus.jpg') ? >"   /> 
function base64_img($img_src)
{
	$img_binary=fread(fopen($img_src,"r"),filesize($img_src));
	$img_str=base64_encode($img_binary);
	return $img_str;
}

//check login or not function
function islogin()
{
	session_start();
	if(isset($_SESSION['userid']) && isset($_SESSION['username']) && isset($_SESSION['email']) && isset($_SESSION['gender']))
{
	return true;
}
	else
	return false;
}

// to find time ago things
function timeago( $date )
{
    if( empty( $date ) )
    {
        return "No date provided";
    }

    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

    $lengths = array("60","60","24","7","4.35","12","10");

    $now = time();

    $unix_date = strtotime( $date );

    // check validity of date

    if( empty( $unix_date ) )
    {
        return "Bad date";
    }

    // is it future date or past date

    if( $now > $unix_date )
    {
        $difference = $now - $unix_date;
        $tense = "ago";
    }
    else
    {
        $difference = $unix_date - $now;
        $tense = "from now";
    }
	

    for( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ )
    {
        $difference /= $lengths[$j];
    }

    $difference = floor( $difference );
	
	if($difference<=59 && $periods[$j]=='second')
	{
		return "Just Now";
	}
	
    if( $difference != 1 )
    {
        $periods[$j].= "s";
    }
	
    return "$difference $periods[$j] {$tense}";
} //Time Ago Ends

function convert_hashtag_to_link($message)
{
	$parsedMessage = preg_replace('/(^|[^a-z0-9_&])#([a-z0-9_]+)/i','$1<a href="./?hashtag=$2">#$2</a>', $message);
	return $parsedMessage;
}
?>
