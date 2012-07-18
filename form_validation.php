<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Displaying error messages for forms
Author: Elena Machkasova
Last Modifed: 4/17/2008
-->
<?php
$name = $_POST["name"];
$email = $_POST["email"];
$submit = $_POST["submit"]; // to check if the user got here through a form

function display_form($style1 = "", $style2 = "", $style3 = "", $name_value="", $postsubject_value = "", $postbody_value = "") {
	print "<div id='info'>
		<h3>New Post:</h3>
		<form method='post' 
			action='form_validation.php'>
			<table style='border: none'>
			<tr>
			<td $style1>
			Username:
			</td>
			<td>
			<input type='text' name='name' $name_value style='width: 30' />
			</td>
			</tr>
			<tr>
			<td $style2>
			Post Subject:
			</td>
			<td>
			<input type='text' name='post_subject' $postsubject_value style='width: 30' />
			</td>
			</tr>
			<tr>
			<td $style3>Post Body:</td>
			<td><textarea rows='5' cols='50' name='post_content' $postbody_value>
			</textarea>
			</td>
			</tr>
			<tr>
			<td>
			<input type='submit' value='submit' />
			</td>
			</tr>
			</table>
		</form>
	</div>";

}?>
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>
Displaying errors
</title>
</head>
<body>
<?php

$style1 = "";
$style2 = "";
$error_style = "style = \"color: red\"";
$message = "";
$name_value = "";
$email_value = "";
$errors = false;

if (!isset($submit)) {
  display_form(); // display the form
}
else {
	// start validation
        // usually some sort of regular expression: 
        // if (!eregi("^[a-z ]+$", $name))
        // For simplicity we only check for empty values
       if (strcmp($name, "") == 0) {
		$style1 = $error_style;
		$message = $message."The name is empty<br/>";
		$errors = true;
	} else {
		$name_value = "value = \"$name\"";	
	}
       // Also usually regular expression:
       // if (!eregi("^([a-z0-9]+)@([a-z._]+)$", $email))
       // For simplicity just checking for an empty field 
	if (strcmp($email, "") == 0) {
		$style2 = $error_style;
		$message = $message."The e-mail is empty <br/>";
		$errors = true;
	} else {
		$email_value = "value = \"$email\"";	
	}
	if (!$errors) {
		print "Thank you, $name, for submitting your information!<br/>\n";
	} else {
		// priniting the form
	  display_form($style1, $style2, $name_value, $email_value);
	  // printing the error message
	  print "<p $error_style>$message You need to resubmit the form</p>";
	}
}
?>
</body>
</html>
