<?php
function simple_lookup($lquery, $lname, $lrow){
$result = mysql_query($lquery) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
	echo "$lname"; echo ": "; echo $row[$lrow]; echo "<br />";}
}
?>
