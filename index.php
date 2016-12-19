<html>
<head>
<link rel="icon" href="tl.png" />
</head>
<body>
<?php include("./inc/header.inc.php"); ?>
<?php
$reg = @$_POST['reg'];
$fn="";
$ln="";
$un="";
$ai="";
$em="";
$em2="";
$pswd="";
$pswd2="";
$d="";
$a="";
$u_check="";
$fn=strip_tags(@$_POST['fname']);
$ln=strip_tags(@$_POST['lname']);
$un=strip_tags(@$_POST['username']);
$ai=strip_tags(@$_POST['aoi']);
$em=strip_tags(@$_POST['email']);
$a=strip_tags(@$_POST['age']);
$em2=strip_tags(@$_POST['email2']);
$pswd=strip_tags(@$_POST['password']);
$confirm_code=md5(uniqid(rand()));
$pswd2=strip_tags(@$_POST['password2']);
$d=date("Y-m-d");
if($reg) {
	if($em==$em2) {
		$u_check=mysqli_query($con,"SELECT username FROM users WHERE username = '$un'");
		$check = mysqli_num_rows($u_check);
		$e_check=mysqli_query($con,"SELECT email FROM users WHERE email = '$em'");
		$email_check = mysqli_num_rows($e_check);
		if($check==0) {
			if($email_check==0) {
			if($fn&&$ln&&$un&&$em&&$em2&&$pswd&&$pswd2) {
				if($pswd==$pswd2) {
					if(strlen($un)>25||strlen($fn)>25||strlen($ln)>25) {
						echo "The maximum limit for username/firstname/lastname is 25 characters!";
					}
					else 
					{
						if(strlen($pswd)>30||strlen($pswd)<5) {
							echo "your password must be between 5 and 30 characters!";
						}
						else {
							$pswd = md5($pswd);
							$pswd2 = md5($pswd2);
							$query = mysqli_query($con,"INSERT INTO c_users VALUES ('$confirm_code','','$un','$fn','$ln ','$em','$pswd','$d','$a','$ai')");
							$subject="Confirmation link from MyGenesis";
							$header="from:MyGenesis<admin@mygenesis.tk>";
							$message ="Click on this link to activate your account \r\n";
							$message.="http://www.mygenesis.tk/social/confirmation.php?passkey=$confirm_code";
							$sentmail = mail($em,$subject,$message,$header);
							if($sentmail){
							die("<h2>Activate your account using link sent to email address you specified</h2>");
							}
							else {
									echo "Cannot send Confirmation link to your e-mail address";
								}
							
							}
							}
							}
							else {
								echo "your passwords dont match!";
							}
			}
			else {
								echo "please fill in all of the fields";
							}
			}
			else { 
				echo "Sorry! but it looks like someone has already used that email!";
			}
	}
			else {
								echo "username already taken!";
							}
			}
			else {
								echo "your emails dont match!";
							}
			}
		
if(isset($_POST["user_login"])&& isset($_POST["password_login"])) {
	$user_login = preg_replace('#[^A-Za-z0-9]#i','',$_POST["user_login"]);
	$password_login = preg_replace('#[^A-Za-z0-9]#i','',$_POST["password_login"]);	
	$password_login_md5 = md5($password_login);	
$sql = mysqli_query($con,"SELECT id FROM users WHERE username='$user_login' AND password='$password_login_md5' LIMIT 1");
    
	$userCount = mysqli_num_rows($sql);
	if($userCount == 1) {
		while ($row = mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
			$id = $row["id"];
		}
		$_SESSION["user_login"] = $user_login;
		header("location:home.php");
		exit();
	}
	else {
		echo 'The information is incorrect,try again';
		exit();
	}
}
?>
<?php
if(!$user) {	
?>
<div style="width:800px; margin: 0px auto 0px auto;">
<table>
<tr>
<td width="60%" valign="top">
 <h2>Already a member? Sign in below!</h2>
 <form action="index.php" method="post">
 <input type="text" name="user_login" size="25" placeholder="Username" /><br/><br/>
 <input type="password" name="password_login" size="25" placeholder="Password" /><br/><br/>
 <input type="submit" name="login" value="Login"/>
 </form>
 <br/>
 <br/>
 <img src="us.jpg"/><br/><br/>
 <h2>Welcome to my-chat</h2>
 </td>
 <td width="40%" valign="top">
 <h2>Sign Up Below ...</h2>
 <form action="index.php" method="post">
 <input type="text" name="fname" size="25" placeholder="First Name" /><br/><br/>
 <input type="text" name="lname" size="25" placeholder="Last Name" /><br/><br/>
 <input type="text" name="username" size="25" placeholder="Username" /><br/><br/>
  <input type="text" name="aoi" size="25" placeholder="Area Of Interest" /><br/><br/>
 <input type="text" name="email" size="25" placeholder="Email Address"/><br/><br/>
 <input type="text" name="email2" size="25" placeholder="Re-Enter Email Address"/><br/><br/>
 <input type="text" name="age" size="25" placeholder="Age" /><br/><br/>
 <input type="password" name="password" size="25" placeholder="Password" /><br/><br/>
 <input type="password" name="password2" size="25" placeholder="Re-Enter Password" /><br/><br/>
 <input type="submit" name="reg" value="Sign Up!"/>
 </form>
 </td>
 </tr>
 </table>
 </div>
 <?php include("./inc/footer.inc.php"); ?>
 <br/>
 <h1 style="font-size:24px;"><marquee behavior="alternate" width="100%">Design:Karthik Anantharaju</marquee></h1>
</body>
</html>
<?php
}
else {
	header("location: home.php");
}
?>