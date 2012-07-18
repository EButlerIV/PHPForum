	echo "<div class='post'> <h3>$post_date - <a id='pcommlink1' href='./comments.php?p=$thread'>$post_title</a> - <a id='user' href='./user.php?p=$post_author'>$name</a></h3><br /><br />";
	echo "$post_content";
	echo "<br /><br />";
	echo "<a align='right' href='./comments.php?p=$thread'>Comments ($comment_count)</a></div><br /><br />";