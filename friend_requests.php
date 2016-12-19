<?php include("./inc/header.inc.php"); ?>
<?php 
$friendRequests = mysqli_query($con,"SELECT * FROM friend_requests WHERE user_to='$user'");
$numrows = mysqli_num_rows($friendRequests);
if ($numrows == 0) {
 echo "You have no friend Requests at this time.";
 $user_from = "";
}
else
{
 while ($get_row = mysqli_fetch_assoc($friendRequests)) {
  $id = $get_row['id']; 
  $user_to = $get_row['user_to'];
  $user_from = $get_row['user_from'];
  
  echo '<br/>'. '' . $user_from . ' wants to be friends'.'<br/><br/>'.'<br /><br/>';
?>
<?php 
$get_friend_check="";
$get_friend_row="";
$friend_array="";
if(isset($_POST['acceptrequest'.$user_from])) {
$get_friend_check = mysqli_query($con,"SELECT friend_array FROM users WHERE username='$user'");
$get_friend_row = mysqli_fetch_assoc($get_friend_check);
$friend_array = $get_friend_row['friend_array']; 
$frined_array_explode = explode(",",$friend_array);
$friendarray_count = count($frined_array_explode);
$add_friend_check_friend = mysqli_query($con,"SELECT friend_array FROM users WHERE username='$user_from'");
$get_friend_row_friend = mysqli_fetch_assoc($add_friend_check_friend);
$friend_array_friend = $get_friend_row_friend['friend_array']; 
$frined_array_explode_friend = explode(",",$friend_array_friend);
$friendarray_count_friend = count($frined_array_explode_friend);
 if ($friend_array == "") {
     $friendarray_count = count(NULL);
  }
  if ($friend_array_friend == "") {
     $friendarray_count_friend = count(NULL);
  }
  if ($friendarray_count == NULL) {
   $add_friend_query = mysqli_query($con,"UPDATE users SET friend_array=CONCAT(friend_array,'$user_from') WHERE username='$user'");
  }
  if ($friendarray_count_friend == NULL) {
   $add_friend_query = mysqli_query($con,"UPDATE users SET friend_array=CONCAT(friend_array,'$user_to') WHERE username='$user_from'");
  }
  if ($friendarray_count >= 1) {
   $add_friend_query = mysqli_query($con,"UPDATE users SET friend_array=CONCAT(friend_array,',$user_from') WHERE username='$user'");
  }
   if ($friendarray_count_friend >= 1) {
   $add_friend_query = mysqli_query($con,"UPDATE users SET friend_array=CONCAT(friend_array,',$user_to') WHERE username='$user_from'");
  }
  $delete_requests = mysqli_query($con,"DELETE FROM friend_requests WHERE user_to='$user_to'&&user_from='$user_from'");
  echo "You are now friends!";
  header("Location: friend_requests.php");
 }
 if(isset($_POST['ignorerequest'.$user_from])) {
 $delete_requests = mysqli_query($con,"DELETE FROM friend_requests WHERE user_to='$user_to'&&user_from='$user_from'");
  header("Location: friend_requests.php");
 }
?>
<form action="friend_requests.php" method="post">
<input type="submit" name="acceptrequest<?php echo $user_from ; ?>" value="Accept Request"/>
<input type="submit" name="ignorerequest<?php echo $user_from ; ?>" value="Ignore Request"/>
</form>
<?php 
 }
 }
?>