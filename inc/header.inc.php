<?php
 include("./inc/connect.inc.php");	
 session_start();
 if(!isset($_SESSION["user_login"])) {
	$user = ""; 
 }
 else {
	 $user = $_SESSION["user_login"];
 }
 $get_unread_query = mysqli_query($con,"SELECT opened FROM pvt_messages WHERE user_to='$user' && opened='no'");
$get_unread = mysqli_fetch_assoc($get_unread_query);
$unread_numrows = mysqli_num_rows($get_unread_query);
$unread_numrows = "(".$unread_numrows.")";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my-chat</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="icon" href="tl.png" />
<script src="js/main.js" type="text/javascript"></script>
</head>
<body>
<div class="headerMenu">
     <div id="wrapper">
      <div class="logo">
        <img src="img/find_friends_logo.png" />
      </div>
      <div id="menu">
      <?php 
	  if(!$user) {
		  echo '<a href="index.php">Home</a>';
	  }
	  else {
		  echo '<a href="'.$user.'">Profile</a>';
		  echo '<a href="home.php" >Home</a>';	
		  echo '<a href="account_settings.php" >Account Settings</a>';
		  echo '<a href="friendsuggestions.php" >Friend Suggestions</a>';
		  echo '<a href="friend_requests.php" >Friend Requests</a>';
		  echo '<a href="my_messages.php" >Inbox '  . $unread_numrows . '</a>';
		  echo '<a href="my_pokes.php" >Pokes</a>';
          echo '<a href="logout.php" >Logout</a>';
	  }
	  ?>
</div>
</div>
</div>
</body>
</html>