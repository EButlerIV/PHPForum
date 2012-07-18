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
<title>User Information</title>
<link rel="stylesheet" type="text/css" href="forum.css" />
</head>
<body>
<?php
// get user ID
$p = $_GET["p"];

// connect to the server
$connection = mysql_connect("localhost","team8readwrite","5zYuteam8");

// select a database
mysql_select_db("1101sp09team8", $connection);
//define queries
$name = sprintf("SELECT user_login FROM wp_users WHERE ID = '%s'", $p);
$email = sprintf("SELECT user_email FROM wp_users WHERE ID = '%s'", $p);
$user_url = sprintf("SELECT user_url FROM wp_users WHERE ID = '%s'", $p);
$posts = sprintf("SELECT * FROM wp_posts WHERE post_author = '%s' AND post_type = 'post'", $p);
$comments = sprintf("SELECT * FROM wp_comments WHERE user_id = '%s'", $p);
?> 
<?php include("linkbar.html"); ?>
<?php include("simple_lookup.php"); ?>



<div id="info"><h1>User Information:</h1>
	<p>
	<?php simple_lookup($name, "Name", user_login); ?>
	<?php simple_lookup($email, "E-mail", user_email); ?>
	<?php simple_lookup($user_url, "Site URL", user_url); ?>
	</p>
</div>

<div class="posts"><h1>User's Posts</h1><?php $result = mysql_query($posts) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
$post_date = $row['post_date'];
	$post_title = $row['post_title'];
	$post_author = $row['post_author'];
	$comment_count = $row['comment_count'];
	$name = $row['display_name'];
	$thread = $row['postid'];
	$post_content = $row['post_content'];

	echo "<div class='post'> <h3>$post_date - <a id='pcommlink1' href='./comments.php?p=$thread'>$post_title</a> - <a id='user' href='./user.php?p=$post_author'>$name</a></h3><br /><br />";
	echo "$post_content";
	echo "<br /><br />";
	echo "<div class='commentalign'><p><a href='./comments.php?p=$thread'>Comments ($comment_count)</a> | <a href='./postcomment.php?p=$thread'>Post Comment</a></p></div></div>";
	}?>
	
</div>

<div class="posts"><h1>User's Comments</h1><?php $result = mysql_query($comments) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
	echo "<div class='comment'><br />". $row['comment_date']. " - ". $row['comment_author']. "<br />";
	echo $row['comment_content'];
	echo "<br /></div>";}?>
	
</div>

<?php mysql_close($connection); ?>
</body>
</html>
