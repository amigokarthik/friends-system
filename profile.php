<?php include("./inc/header.inc.php"); ?>
<?php
if(isset($_GET['u'])) {
	$username = mysqli_real_escape_string($con,$_GET['u']);
	if(ctype_alnum($username)) {
		$check = mysqli_query($con,"SELECT username,first_name FROM users WHERE username='$username'");
		if(mysqli_num_rows($check)==1) {
			$get = mysqli_fetch_assoc($check);
			$username = $get['username'];
			$firstname = $get['first_name'];
			}
		else {
			echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/begin/index.php\">"; 
			exit();
		}
	}
} 

$post = @$_POST['post'];
if($post != "") {
	$date_added = date("Y-m-d");
	$added_by = $user;
	$user_posted_to = $username;
	$sqlCommand = "INSERT INTO posts VALUES('','$post','$date_added','$added_by','$user_posted_to')" ;
	$query = mysqli_query($con,$sqlCommand) or die(mysqli_error());
}
else {
	echo " ";
}


$check_pic = mysqli_query($con,"SELECT timelinepic,profile_pic FROM users WHERE username='$username'");
$get_pic_row = mysqli_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['profile_pic'];
$t_pic_db = $get_pic_row['timelinepic']; 
if($t_pic_db == "") {
$timelinepic = "img/default_pic.jpg";
}
else {
	$timelinepic = "userdata/profile_pics1/".$t_pic_db;
}
if($profile_pic_db == "") {
$profile_pic = "img/default_pic.jpg";
}
else {
	$profile_pic = "userdata/profile_pics/".$profile_pic_db;
}
?>
<div style="margin-left:15%;margin-right:15%; margin-top:20px;">
<img src="<?php echo $timelinepic; ?>" height="350" width="800" alt="<?php echo $username; ?>'s Profile" title="<?php echo $username; ?>'s Timeline" />
</div>
<div class="postForm">
<form action = "<?php echo $username; ?>" method="post">
<p>Post Your Status</p>
<br/>
<textarea id="post" name="post" rows="4" cols="80"></textarea>
<input type="submit" name="send" value="Post" style="background-color: #DCE5EE; float: right; border: 1px solid #666; color:#666;height:55px; width: 50px;" />
</form>
</div>
<div class="profilePosts">
<?php 
$getposts = mysqli_query($con,"SELECT * FROM posts WHERE added_by = '$user' ORDER BY id DESC LIMIT 10") or die(mysql_error());
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
												                                           

echo "  
<div style='float: left;'>
<img src='$profilepic_info' height='65'>&nbsp;&nbsp;
</div>     
Posted by:                                            
<a href='$added_by'>$added_by</a>- $date_added -&nbsp;&nbsp;
<div  style='max-width: 600px;'>
$body<br /><br/><br/><br/><br/>
</div>
<hr />";
}

if (isset($_POST['sendmsg'])) {
 header("Location: send_msg.php?u=$username");
}

$errormsg = "";
if(isset($_POST['addfriend'])) {
$friend_request = $_POST['addfriend'];
$user_to = $user;
$user_from = $username;
if($user_to == $username) {
$errormsg = "You cant send friend request to yourself!<br/>";
}
else {
$create_request = mysqli_query($con,"INSERT INTO friend_requests VALUES ('','$user_to','$user_from')");
$errormsg = "You frined request has been sent<br/>";
}
}
else {

}
?>
</div>
<div class="pro1">
<img src="<?php echo $profile_pic; ?>" height="200" width="200" alt="<?php echo $username; ?>'s Profile" title="<?php echo $username; ?>'s Profile" />
<br />
<form action="<?php echo $username; ?>" method="post">
<?php
$friendsArray = "";
$countFriends = "";
$friendsArray12 = "";
$addAsFriend = "";
$selectFriendsQuery = mysqli_query($con,"SELECT friend_array FROM users WHERE username='$username'");
$friendRow = mysqli_fetch_assoc($selectFriendsQuery);
$friendArray = $friendRow['friend_array'];
if ($friendArray != "") {
   $friendArray = explode(",",$friendArray);
   $countFriends = count($friendArray);
   $friendArray12 = array_slice($friendArray, 0, 12);
   

$i = 0;
if (in_array($username,$friendArray)) {
 
}
else {
	if($user != $username && $username!="")
	{
$addAsFriend = '<input type="submit" name="addfriend" value="Add Friend">';}
}
if (in_array($user,$friendArray)) {
	if($user != $username && $username != "")
	{
 $addAsFriend = '<input type="submit" name="removefriend" value="UnFriend">';}
}
else
{
 
}
echo $addAsFriend;
}
else {
$addAsFriend = '<input type="submit" name="addfriend" value="Add Friend">';
echo $addAsFriend; 
}
if(@$_POST['removefriend']) {
$add_friend_check = mysqli_query($con,"SELECT friend_array FROM users WHERE username='$user'");
$get_friend_row = mysqli_fetch_assoc($add_friend_check);
$friend_array = $get_friend_row['friend_array'];
$friend_array_explode = explode(",",$friend_array);
$friend_array_count = count($friend_array_explode);

$add_friend_check_username = mysqli_query($con,"SELECT friend_array FROM users WHERE username='$user'");
$get_friend_row_username = mysqli_fetch_assoc($add_friend_check_username);
$friend_array_username = $get_friend_row_username['friend_array'];
$friend_array_explode_username = explode(",",$friend_array_username);
$friend_array_count_username = count($friend_array_explode_username);

  $usernameComma = ",".$username;
  $usernameComma2 = $username.",";
  
  $userComma = ",".$user;
  $userComma2 = $user.",";
if (strstr($friend_array,$usernameComma)) {
   $friend1 = str_replace("$usernameComma","",$friend_array);
  }
  else
  if (strstr($friend_array,$usernameComma2)) {
   $friend1 = str_replace("$usernameComma2","",$friend_array);
  }
  else
  if (strstr($friend_array,$username)) {
   $friend1 = str_replace("$username","",$friend_array);
  }
  //Remove logged in user from other persons array
  if (strstr($friend_array,$userComma)) {
   $friend2 = str_replace("$userComma","",$friend_array);
  }
  else
  if (strstr($friend_array,$userComma2)) {
   $friend2 = str_replace("$userComma2","",$friend_array);
  }
  else
  if (strstr($friend_array,$user)) {
   $friend2 = str_replace("$user","",$friend_array);
  }

  $friend2 = "";

  $removeFriendQuery = mysqli_query($con,"UPDATE users SET friend_array='$friend1' WHERE username='$user'");
  $removeFriendQuery_username = mysqli_query($con,"UPDATE users SET friend_array='$friend2' WHERE username='$username'");
  echo "Friend Removed ...";
  header("Location: $username");
}
if (@$_POST['poke']) {
	$check_if_poked = mysqli_query($con,"SELECT * FROM pokes WHERE user_to='$username' && user_from='$user'");
  $num_poke_found = mysqli_num_rows($check_if_poked);
  if ($num_poke_found == 1) {
   echo "You must wait to be poked back.";
  }
  else
  if ($username == $user) {
   echo "You cannot Poke yourself.";
  }
  else
  {
 $poke_user = mysqli_query($con,"INSERT INTO pokes VALUES ('','$user','$username')");
 echo "$username has been poked.";
  }
}
?>
<?php echo $errormsg; ?>
<br/>
<input type="submit" name="poke" value="Poke"/>
<input type="submit" name="sendmsg" value="Send Message"/>
</form> 
<h2><?php echo $username; ?>'s Profile</h2>
<div style="font-size:12px; font-family:'Times New Roman', Times, serif; color:#903";>
<?php
$about_query = mysqli_query($con,"SELECT bio,first_name,last_name,age FROM users WHERE username='$username'");
$get_result = mysqli_fetch_assoc($about_query);
$about_the_user = $get_result['bio'];
$fout_the_user = $get_result['first_name'];
$lout_the_user = $get_result['last_name'];
$zout_the_user = $get_result['age'];
echo "ABOUT:"." ".$about_the_user."<br/>"."<br/>";
echo "FIRST NAME:"." ".$fout_the_user."<br/>"."<br/>";
echo"LAST NAME:"." ".$lout_the_user."<br/>"."<br/>";
echo"AGE:"." ".$zout_the_user."<br/>"."<br/>";
?>
</div>
</div>
<div class="right">
<h2><?php echo $username; ?>'s Friends</h2>	
<?php
if($countFriends != 0) {
 foreach ($friendArray12 as $key => $value) {
 $i++;
 $getFriendQuery = mysqli_query($con,"SELECT * FROM users WHERE username='$value' LIMIT 1");
 $getFriendRow = mysqli_fetch_assoc($getFriendQuery);
 $friendUsername = $getFriendRow['username'];
 $friendProfilePic = $getFriendRow['profile_pic'];
 if ($friendProfilePic == "") {
  echo "<a href='$friendUsername'><img src='img/default_pic.jpg' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" height='50' width='40'></a><br/><br/>";
 }
else {
echo "<a href='$friendUsername'><img src='userdata/profile_pics/$friendProfilePic' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" height='50' width='40'></a><br/><br/>";
}
}
}
else {
echo $username."has no friends yet.";
}
?>
</div>