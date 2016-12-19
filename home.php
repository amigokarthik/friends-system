<?php include("./inc/header.inc.php"); ?>
<?php 
if (!isset($_SESSION["user_login"])) {
    echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/begin/home.php\">";
}
else
{
$check_pic = mysqli_query($con,"SELECT profile_pic FROM users WHERE username='$user'");
$get_pic_row = mysqli_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['profile_pic']; 
if($profile_pic_db == "") {
$profile_pic = "img/default_pic.jpg";
}
else {
	$profile_pic = "userdata/profile_pics/".$profile_pic_db;
}
?>
<div class="fro1">
<img src="<?php echo $profile_pic; ?>" height="100" width="100" alt="<?php echo $user ; ?>'s Profile" title="<?php echo $user ; ?>'s Profile" />
<div style="font-size:26px; font-family:'Times New Roman', Times, serif; color:#903; font-style:italic; font:bolder;">
<?php
$about_query = mysqli_query($con,"SELECT bio,username,last_name,age FROM users WHERE username='$user'");
$get_result = mysqli_fetch_assoc($about_query);
$about_the_user = $get_result['bio'];
$fout_the_user = $get_result['username'];
$lout_the_user = $get_result['last_name'];
$zout_the_user = $get_result['age'];
echo $fout_the_user;
?>
</div>
<h2>Public Posts</h2>	
</div>
<?php 
$getposts = mysqli_query($con,"SELECT * FROM posts ORDER BY id DESC LIMIT 10") or die(mysql_error());
while($row = mysqli_fetch_assoc($getposts)) {
	$id = $row['id'];
	$body = $row['body'];
	$date_added = $row['date_added'];
	$added_by = $row['added_by'];
	$user_posted_to = $row['user_posted_to'];

$get_user_info = mysqli_query($con,"SELECT * FROM users WHERE username='$added_by'");
$get_info = mysqli_fetch_assoc($get_user_info);
$get_user_info = mysqli_query($con,"SELECT * FROM users WHERE username='$added_by'");
                                                $get_info = mysqli_fetch_assoc($get_user_info);
                                                $profilepic_info = $get_info['profile_pic'];
                                                if ($profilepic_info == "") {
                                                 $profilepic_info = "./img/default_pic.jpg";
                                                }
                                                else
                                                {
                                                 $profilepic_info = "./userdata/profile_pics/".$profilepic_info;
                                                }  
if($added_by != $user_posted_to)
{												                                           
echo "  
<div class='newsFeedPost'>
<div style='float: left;'>
<img src='$profilepic_info' height='60'>&nbsp;&nbsp;
<br/>
</div> 
$added_by posted on $user_posted_to's timeline  
<div class='dfgh'>
<p />$body<br />
</div>
<p />
 - $date_added - 
</div>
<p />
";
}
else
{
echo "  
<div class='newsFeedPost'>
<div style='float: left;'>
<img src='$profilepic_info' height='60'>&nbsp;&nbsp;
<br/>
</div> 
$added_by posted on his own timeline 
<div class='dfgh'>
<p />$body<br />
</div>
<p />
 - $date_added - 
</div>
<p />
";	
}
}
}
?>
<embed src="a.mp3" autostart="true" loop="true"
width="2" height="0">
</embed>