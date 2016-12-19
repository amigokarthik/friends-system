<?php include("./inc/header.inc.php"); 

if ($user) {

	

}

else {

	die("You must be logged in to view this page!");

}

?>

<?php

$senddata = @$_POST['senddata'] ;

$old_password =  strip_tags(@$_POST['oldpassword']);

$new_password =  strip_tags(@$_POST['newpassword']);

$repeat_password =  strip_tags(@$_POST['newpassword2']);

if($senddata) {

	$password_query = mysqli_query($con,"SELECT * FROM users WHERE username='$user'");

	while($row = mysqli_fetch_assoc($password_query)) {

		$db_password = $row['password'];

		$old_password_md5 = md5($old_password);

		if($old_password_md5 == $db_password) {

			if($new_password == $repeat_password) {

				if(strlen($new_password) == 0 ) {

					echo "Please enter something!";

				}

				if(strlen($new_password) <= 4 ) {

					echo "Your password must be more than 4 characters!";

				}

				else {

				 $new_password_md5 = md5($new_password);

				 $password_update_query = mysqli_query($con,"UPDATE users SET password='$new_password_md5' WHERE username='$user'");

				 echo "Success! Your password has been updated!"; 

				}

			}

			else {

				echo "Your two new passwords dont match!";

			}

		}

		else {

			echo "The old password is incorrect!";

		}

	}

}

else {

	echo "";

}

$updateinfo = @$_POST['updateinfo'] ;

$get_info = mysqli_query($con,"SELECT first_name,last_name,bio,age FROM users WHERE username='$user'");

$get_row = mysqli_fetch_assoc($get_info);

$db_firstname = $get_row['first_name'];

$db_lastname = $get_row['last_name'];

$db_bio = $get_row['bio'];

$db_age = $get_row['age'];

if($updateinfo) {

	$firstname = strip_tags(@$_POST['fname']) ;

	$lastname = strip_tags(@$_POST['lname']) ;

	$bio = @$_POST['bio'] ;

	$age = @$_POST['age'] ;

if(strlen($firstname) < 3) {

	echo "Your first name must be 3 more characters long!";

}

	else if(strlen($lastname) < 5) {

		echo "Your last name must be 5 more characters long!";

	}

	else {

		$info_submit_query = mysqli_query($con,"UPDATE users SET first_name = '$firstname',last_name = '$lastname',bio = '$bio',age = '$age' WHERE  username='$user'");

		echo "Profile Updated!";

		header("Location: $user") ;

	}

} 

else {

	

}

$check_pic = mysqli_query($con,"SELECT timelinepic,profile_pic FROM users WHERE username='$user'");

$get_pic_row = mysqli_fetch_assoc($check_pic);

$profile_pic_db = $get_pic_row['profile_pic'];

$t_pic_db = $get_pic_row['timelinepic']; 

if($t_pic_db == "") {

$t_pic = "img/default_pic.jpg";

}

else {

	$t_pic = "userdata/profile_pics1/".$t_pic_db;

}

if($profile_pic_db == "") {

$profile_pic = "img/default_pic.jpg";

}

else {

	$profile_pic = "userdata/profile_pics/".$profile_pic_db;

}

if(isset($_FILES['profilepic'])) {

if((@$_FILES["profilepic"]["type"] == "image/jpeg") || (@$_FILES["profilepic"]["type"] == "image/png") || (@$_FILES["profilepic"]["type"] == "image/gif") && (@$_FILES["profilepic"]["size"] < 1048576)) {

$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

$rand_dir_name = substr(str_shuffle($chars),0,15);

mkdir("userdata/profile_pics/$rand_dir_name");

if(file_exists("userdata/profile_pics/$rand_dir_name".@$_FILES["profilepic"]["name"])) {

echo @$_FILES["profilepic"]["name"]."Already exists";

}

else {

move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"userdata/profile_pics/$rand_dir_name/".$_FILES["profilepic"]["name"]);

//echo "Uploaded and stored in: userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"];

$profile_pic_name = @$_FILES["profilepic"]["name"];

$profile_pic_query = mysqli_query($con,"UPDATE users SET profile_pic='$rand_dir_name/$profile_pic_name' WHERE username='$user'");

header("Location: account_settings.php");

}

}

else {

 	echo "Invalid! Your file must not be larger than 1MB";	

}

}

if(isset($_FILES['tpic'])) {

if((@$_FILES["tpic"]["type"] == "image/jpeg") || (@$_FILES["tpic"]["type"] == "image/png") || (@$_FILES["tpic"]["type"] == "image/gif") && (@$_FILES["tpic"]["size"] < 1048576)) {

$chars1 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

$rand_dir_name1 = substr(str_shuffle($chars1),0,15);

mkdir("userdata/profile_pics1/$rand_dir_name1");

if(file_exists("userdata/profile_pics1/$rand_dir_name1".@$_FILES["tpic"]["name"])) {

echo @$_FILES["tpic"]["name"]."Already exists";

}

else {

move_uploaded_file(@$_FILES["tpic"]["tmp_name"],"userdata/profile_pics1/$rand_dir_name1/".$_FILES["tpic"]["name"]);

//echo "Uploaded and stored in: userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"];

$t_pic_name = @$_FILES["tpic"]["name"];

$t_query = mysqli_query($con,"UPDATE users SET timelinepic='$rand_dir_name1/$t_pic_name' WHERE username='$user'");

header("Location: account_settings.php");

}

}

else {

 	echo "Invalid! Your file must not be larger than 1MB";	

}

}

?>

<br/>

<p>Upload your Timeline photo:</p><br/><br/>

<form action="" method="post" enctype="multipart/form-data">

<img src="<?php echo $t_pic; ?>" width="70" />

&nbsp;<input type="file" name="tpic" /><br/><br/>

<input type="submit" name="uploadtpic" value="Upload your Timeline!"/><br/><br/>

</form>

</p>

<hr/>

<br/>

<br/>

<br/>

<p>Upload your profile photo:</p><br/><br/>

<form action="" method="post" enctype="multipart/form-data">

<img src="<?php echo $profile_pic; ?>" width="70" />

&nbsp;<input type="file" name="profilepic" /><br/><br/>

<input type="submit" name="uploadpic" value="Upload your pic!"/><br/><br/>

</form>

</p>

<hr/>

<br/>

<br/>

<form action="account_settings.php" method="post">

&nbsp;<p>Change Your Password</p><br/><br/>

Your Old Password: <input type="password" name="oldpassword" id="oldpassword" size="25"><br/><br/>

Your New Password: <input type="password" name="newpassword" id="newpassword" size="25"><br/><br/>

Repeat Password: <input type="password" name="newpassword2" id="newpassword2" size="25"><br/><br/>

<input type="submit" name="senddata" id="senddata" value="Update Password"/><br/><br/>

</form>

<hr/>

<br/>

<br/>

<form action="account_settings.php" method="post">

<p>Update Your Profile Info:</p><br/><br/>

First Name:  <input type="text" name="fname" id="fname" size="25" value="<?php echo $db_firstname; ?>"><br/><br/>

Last Name:  <input type="text" name="lname" id="lname" size="25" value="<?php echo $db_lastname; ?>"><br/><br/> 

About You: <textarea name="bio" id="bio" rows="7" cols="60"><?php echo $db_bio; ?></textarea><br/><br/>

Age: <input type="text" name="age" id="age" size="25" value="<?php echo $db_lastname; ?>"><br/><br/>

<input type="submit" name="updateinfo" id="updateinfo" value="Update Information"/>

</form>