<? php
	$post_date = $row['post_date'];
	$post_title = $row['post_title'];
	$user_login = $row['user_login'];
	$comment_count = $row['comment_count'];
	$ID = $row['ID'];
	$post_content = wordwrap($row['post_content'], 120, "<br>");
	
	echo "<div class='post'> <h5>$post_date</h5> - <h3>$post_title</h3> - <h4>$user_login</h4><br /><br />";
	echo "<p>$post_content</p>";
	echo "<br /><br />";
	echo "<a align="right" href="./posts.php?p=$ID">Comments ($comment_count)</a></div><br /><br />";
?>