<?php include("./inc/header.inc.php"); 
if ($user) {
	
}
else {
	die("You must be logged in to view this page!");
}
?>
<?php
$get_info = mysqli_query($con,"SELECT username FROM users");
while($row = mysqli_fetch_array($get_info)){
    $db_firstname = $row['username'];
	if($db_firstname!=$user)
	echo "&nbsp;&nbsp;"."<a href='$db_firstname'>$db_firstname</a>"."<br/>"."<br/>" ;
}
?>