<?php 
session_start();
$user = $_SESSION['user'];
session_destroy(); 
?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- 
Handling login via sessions in PHP
Author: Elena Machkasova 
Last modified: 4/17/08 
--> 

<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="REFRESH" content="3; ./posts.php">
<title>
Handling user logout.
</title>
<link rel="stylesheet" type="text/css" href="forum.css" />
</head>
<body>
<p>

<?php
	print "<div class='newpost'><h3>Goodbye, ".$_SESSION['user']."!<h3><br/>\n";
	print "<p>Please wait to be directed back to the main page<br/>\n";	
	print "</p></div>";
?>
</p>
</body>
</html>
