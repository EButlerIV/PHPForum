
<?php
// -------------- define functions -----------------
function isvalid($user, $password) {
	// check if the user's password is valid
	// at this point all non-empty passwords are valid
	if ($password != "") return true;
	return false;	
}

function print_login_form() {
	$form_string = "
	<form method=\"post\" 
	action=\"login.php\">
	<table border=\"0\">
	<tr>

	<td>Enter your user name:</td>
	<td>
	<input type = \"text\" name = \"user\" />
	</td>
	</tr>

	<tr>
	<td>Enter your password:</td>
	<td>
	<input type = \"password\" name = \"password\" />
	</td>

	</tr>
	<tr>
	<td>
	<input type=\"submit\" name = \"submit\" value=\"submit\" />
	</td>
	</tr>

	</table>
	</form>
	";
	print $form_string;
}
// ---------------- end of functions -----------------

// since sessions are handled with cookies, we must start
// a session before any HTML tags
session_start();
$display_form = true;
if (!isset($_SESSION['user'])) {
	// check if the user is responding to login form
	$user = $_POST['user'];
	$password = $_POST['password'];	
	if (isset($user)) {
		if (isvalid($user, $password)) {
			// the user logged in - no need to display form
			$_SESSION['user'] = $user;
			$display_form = false; 
		}
	}
} else {
	// returning user - no need to display the form
	$display_form = false;	
}
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
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>
Authenticating user. Please wait.
</title>
<link rel="stylesheet" type="text/css" href="forum.css" />
</head>
<body>
<?php
if ($display_form) {
	print_login_form();	
} else {
	print "<div class='newpost'><h3>Welcome, ".$_SESSION['user']."!<h3><br/>\n";
	print "<p>Please wait to be directed back to the main page<br/>\n";	
	print "</p></div>";
}
?>

</body>
</html>