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
// get post number
$p = $_GET["p"];

// connect to the server
$connection = mysql_connect("localhost","team8readwrite","5zYuteam8");

// select a database
mysql_select_db("1101sp09team8", $connection);

//define queries
$post = sprintf("SELECT post_date, post_title, post_author, comment_count, comment_parent, display_name, comment_date, comment_author, post_content, comment_content, display_name, wp_posts.ID, wp_users.ID comment_post_ID FROM wp_posts, wp_comments, wp_users WHERE wp_users.ID = post_author AND post_type = 'post' AND wp_posts.ID LIKE '%s' AND comment_post_ID LIKE '%s'", $p, $p);
$orig_post = sprintf("SELECT post_date, post_title, post_author, comment_count, comment_parent, display_name, comment_date, comment_author, post_content, comment_content, display_name, wp_posts.ID, wp_users.ID comment_post_ID FROM wp_posts, wp_comments, wp_users WHERE wp_users.ID = post_author AND post_type = 'post' AND wp_posts.ID LIKE '%s'", $p);
$comment = sprintf("SELECT comment_parent, comment_date, comment_author, comment_content, comment_post_ID FROM wp_comments WHERE comment_post_ID LIKE '%s' AND comment_parent LIKE '%s'", $p, $u); ?>


<?php include("linkbar.html"); ?>

<div class="posts"><?php $result = mysql_query($orig_post) or die(mysql_error());

	$row = mysql_fetch_array($result);
	$name = $row['display_name'];
	$post_date = $row['post_date'];
	$post_title = $row['post_title'];
	$post_author = $row['post_author'];
	$thread = $row['wp_users.ID'];
	$post_content = $row['post_content'];
	echo "<div class='post'> <h3>$post_date - $post_title - <a id='user' href='./user.php?p=$post_author'>$name</a></h3><br /><br />";
	echo "$post_content";
	echo "<br /><br /><a class='postcomment' href='./postcomment.php?p=$p'>Post Comment</a>";
	echo "<br /></div>";
	$result = mysql_query($post) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	print_comments($lineage, $row['comment_ID'], $row['comment_parent'], $row['comment_date'], $row['comment_author'], $row['comment_content'],0);
	
function print_comments($lineage, $comment_ID, $comment_parent, $comment_date, $comment_author, $comment_content, $indent){
		global $indent, $lineage;
	if($comment_parent==0){
		$indent=0;
		$u=75-$indent*10;
		print "<div class='comment' style=\"width: $u%\">";
		echo $comment_date. " - ". $comment_author. "<br />";
		echo $comment_content;
		echo "<br /><br />";
		print "</div>\n";
		$lineage=$comment_ID;
		$indent++;
		
		}else{
	
	if($comment_parent==$lineage){
			
			$lineage=$comment_ID;
			print_comments($lineage, $comment_ID, $comment_parent, $comment_date, $comment_author, $comment_content, $indent);
			$indent++;

		
		} else {
			$u=75-$indent*10;
			print "<div class='comment' style=\"width: $u%\">";
			echo $comment_date. " - ". $comment_author. "<br />";
			echo $comment_content;
			echo "<br /><br />";
			print "</div>\n";
			$lineage=$comment_parent;

		}}
}
			
?>

<?php mysql_close($connection); ?>
</div>
</body>
</html>
