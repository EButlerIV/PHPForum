<?php
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
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>Comments</title>
<link rel="stylesheet" type="text/css" href="forum.css" />
</head>
<body>
<?php
if ($display_form) {
	print "<div id='info'><h3>You are not authorized to post.<h3><br/>\n";
	print "<p>Please go back to the main page.<br/>\n";	
	print "</p></div>";

}else{
$name = $_POST["name"];
$post_subject = $_POST["post_subject"];
$post_content = $_POST["post_content"];
$submit = $_POST["submit"];
$namelookup = sprintf("SELECT user_login, ID FROM wp_users WHERE user_login LIKE '%s'", $name);

// connect to the server
$connection = mysql_connect("localhost","team8readwrite","5zYuteam8");

// select a database
mysql_select_db("1101sp09team8", $connection);


function showerror()
{
        die("Error ". mysql_errno(). " : " .mysql_error());
}

function display_form($style1 = "", $style2 = "", $style3 = "", $name_value="", $postsubject_value = "", $postbody_value = "") {
	print "<div id='info'>
		<h3>New Post:</h3>
		<form  method=\"post\"
                action=\"post.php\">

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
			<input type=\"submit\" name = \"submit\" value=\"submit\" />
			</td>
			</tr>
			</table>
		</form>
	</div>";

}



$style1 = "";
$style2 = "";
$style3 = "";
$error_style = "style = \"color: red\"";
$message = "";
$name_value = "";
$postsubject_value = "";
$postbody_value = "";
$errors = false;
$comment_count=0;
$post_type = 'post';
$post_status = 'publish';

//Username no more than 10 characters long, only letters, digits, and underscores
$usernametest = "^[a-zA-Z0-9_]{1,10}$";

//Subject with length limitation, more characters
$postsubjecttest = "^[a-z0-9_.:;<> \"]{1,50}$";

//Post body length limitation, no form tag or more than three anchor tags
$postbodytest = "^[a-zA-Z0-9_.:;<>]{1,10000}";
$postbodytest2 = "[<a>]{0,3}";
$postbodytest3 = "[^<form>]]";

if (!isset($submit)) {
  display_form(); // display the form
}
else {
	// start validation
	if(!eregi($usernametest, $name) || !$result = mysql_query($namelookup)){
		$style1 = $error_style;
		$message = $message."The name is invalid.<br/>";
		$errors = true;
	} else {
		$name_value = "value = \"$name\"";
		$row = mysql_fetch_array($result);
		$userid = $row['ID'];	
	}
	if(!eregi($postsubjecttest, $post_subject)){
		$style2 = $error_style;
		$message = $message."The post subject is invalid.<br/>";
		$errors = true;
	} else {
		$postsubject_value = "value = \"$post_subject\"";	
	}
if(!eregi($postbodytest1, $post_body) && !eregi($postbodytest2, $post_body) && !eregi($postbodytest3, $post_body)){
		$style3 = $error_style;
		$message = $message."The post body is invalid.<br/>";
		$errors = true;
	} else {
		$postbody_value = "value = \"$post_body\"";	
	}

      	if (!$errors) {
		$password = "5zYuteam8";
		if (! ($connection = @mysql_connect("localhost","team8readwrite",$password)))
		die ("connection to the database failed");
		if (!@mysql_select_db("1101sp09team8", $connection)) showerror();
		$insert_q1 = "INSERT INTO wp_posts (post_title, post_author, post_date, post_content, post_type, post_status, comment_count) VALUES ('$post_subject', '$userid', NOW(), '$post_content', '$post_type', '$post_status', '$comment_count');";
		if (! (@mysql_query($insert_q1, $connection))) {
		showerror();
		}



		print "Thank you, $name, for submitting your information!<br/>\n";
	} else {
		// priniting the form
	  display_form($style1, $style2, $style3, $name_value, $postsubject_value, $postbody_value, $alertname, $alertsubject, $alertbody);
	  // printing the error message
	  print "<p $error_style>$message You need to resubmit the form</p>";
	}
}}
?>
</body>
</html>
