<?php function print_login_form() {
  $form_string = "
<form id=\"theform\" method=\"post\" 
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
?>

<div id="linkbar"><p><a href="./post.php">Post</a> | <a href="./posts.php">Posts</a> | <?phpif (!isset($_SESSION['user'])) {
	print_login_form();	
} else {
  	print "<p>";
	print "Welcome, ".$_SESSION['user']."!<br/>\n";	
	print "<a href=\"logout.php\">Logout</a><br/>\n";
	print "</p>";
}?>
</div>

