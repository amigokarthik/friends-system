<?php include("./inc/header.inc.php"); ?>
<?php
$passkey=$_GET["passkey"];
$sql1="SELECT * FROM c_users WHERE confirmcode = '$passkey'";
$result1=mysqli_query($con,$sql1);
if($result1){
$count=mysqli_num_rows($result1);
if($count==1){
$rows=mysqli_fetch_array($result1);
$un=$rows['username'];
$fn=$rows['first_name'];
$ln=$rows['last_name'];
$em=$rows['email'];
$pswd=$rows['password'];
$a=$rows['age'];
$ai=$rows['area of interest'];
$d=date("Y-m-d");
$query = mysqli_query($con,"INSERT INTO users VALUES ('','','$un','$fn','$ln ','$em','$pswd','$d','0','','','','$a','$ai')");
die("<h2>Activate your account using link sent to email address you specified<br>Click on Home to login</h2>");
}
}
?>