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
<title>Posts</title>
<link rel="stylesheet" type="text/css" href="forum.css" />
</head>
<body>
<?php
// get post number
$p = $_GET["p"];

// connect to the server
$connection = mysql_connect("localhost","team8readwrite","5zYuteam8");

// select a database
mysql_select_db("1101sp09team8", $connection);

//define queries
$posts = "SELECT post_date, post_title, post_author, comment_count, display_name, wp_posts.ID AS postid, post_content FROM wp_posts, wp_users  WHERE post_status = 'publish' AND wp_posts.post_author=wp_users.ID ORDER BY post_date DESC";
?> 


<?php include("linkbar.html"); ?>


<div class="posts"><?php $result = mysql_query($posts) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
	$post_date = $row['post_date'];
	$post_title = $row['post_title'];
	$post_author = $row['post_author'];
	$comment_count = $row['comment_count'];
	$name = $row['display_name'];
	$thread = $row['postid'];
	$post_content = $row['post_content'];
	$i = ($i + 1);
	if ($i > $p && $i <= ($p + 5)){
	echo "<div class='post'> <h3>$post_date - <a href='./comments.php?p=$thread'>$post_title</a> - <a href='./user.php?p=$post_author'>$name</a></h3><br /><br />";
	echo "$post_content";
	echo "<br /><br />";
	echo "<div class='commentalign'><p><a href='./comments.php?p=$thread'>Comments ($comment_count)</a> | <a href='./postcomment.php?p=$thread'>Post Comment</a></p></div></div>";
}
	}?>

</div>

<?php include("footer.html"); ?>

<?php mysql_close($connection); ?>
</body>
</html>
