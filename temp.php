<?php
$to = "root@localhost.com";
$subject = "Hi";
$body="HELLO WORLD If all is on then its on inbox.";
if(!mail($subject,$body,$to))
{
	echo("Success!");
}
else
{
	echo ("Error");
}
?>