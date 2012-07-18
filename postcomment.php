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
<title>New Comment</title>
<link rel="stylesheet" type="text/css" href="forum.css" />
</head>
<body>
<?php

if ($display_form) {
	print "<div class='newpost'><h3>You are not authorized to post.<h3><br/>\n";
	print "<a href='./posts.php'>Please go back to the main page</a>";	
	print "</div>";

}
	else{
$name = $_SESSION['user'];
$comment_content = $_POST["comment_content"];
$commentid = $_GET['p'];
$submit = $_POST["submit"];
$comment_post_ID = $_post["comment_post_ID"];

$namelookup = sprintf("SELECT user_login, ID FROM wp_users WHERE user_login LIKE '%s'", $name);

// connect to the server
$connection = mysql_connect("localhost","team8readwrite","5zYuteam8");

// select a database
mysql_select_db("1101sp09team8", $connection);

$result= mysql_query($namelookup);
function showerror()
{
        die("Error ". mysql_errno(). " : " .mysql_error());
}

function display_form($style = "", $comment_value = "", $alert = "", $comment_post_ID) {
	global $commentid;
	print "<div id='info'>
		<h3>New Post:</h3>
		<form  method=\"post\" action=\"postcomment.php?p=$commentid\">
			<table style='border: none'>
			<tr>
			<td $style3>Post Body:</td>
			<td><textarea rows='5' cols='50' name='comment_content' $comment_value></textarea></td>
			<td> <input type='hidden' name='comment_post_ID' $commentid /></td>
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



$style = "";
$error_style = "style = \"color: red\"";
$comment_value = "";
$errors = false;


if (!isset($submit)) {
  display_form(); // display the form
}
else {
		$name_value = "value = \"$name\"";
		$row = mysql_fetch_array($result);
		$userid = $row['ID'];	
		$comment_approved = 1;
		$comment_value = "value = \"$comment_content\"";
		$comment_post_ID = $_GET["p"];	
	
	if (!$errors) {
		$comment_content = mysql_real_escape_string("$comment_content");
		$password = "5zYuteam8";
		if (! ($connection = @mysql_connect("localhost","team8readwrite",$password)))
		die ("connection to the database failed");
		if (!@mysql_select_db("1101sp09team8", $connection)) showerror();
		$insert_q1 = "INSERT INTO wp_comments (comment_post_ID, comment_author, comment_date, comment_content, comment_approved) VALUES ('$comment_post_ID', '$name', NOW(), '$comment_content', '$comment_approved');";
		$insert_q2 = "UPDATE wp_posts SET comment_count = comment_count + 1 WHERE ID like $comment_post_ID";
		if (! (@mysql_query($insert_q1, $connection)) || !(@mysql_query($insert_q2, $connection))) {
		showerror();
		}

		print "<div class='newpost'><h3>Thank you, $name, for submitting your information!</h3><br/>\n
			<a href='http://csci1101sp09.morris.umn.edu/~butlere/Final/comments.php?p=$comment_post_ID'>Click Here to Return</a> ";
	} else {
		// priniting the form
	  display_form($style, $comment_value, $alert, $comment_post_ID);
	}
}}
?>
</body>
</html>
