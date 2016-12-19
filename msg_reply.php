<?php include("./inc/header.inc.php"); ?>
<?php
if (isset($_GET['u'])) {
	$username = mysqli_real_escape_string($con,$_GET['u']);
	if (ctype_alnum($username)) {
 	//check user exists
	$check = mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
	if (mysqli_num_rows($check)===1) {
	$get = mysqli_fetch_assoc($check);
	$username = $get['username'];
	
	//Check user isn't sending themself a private message
	if ($username != $user) {
          if (isset($_POST['submit'])) {
            $msg_title = strip_tags(@$_POST['msg_title']);
            $msg_body = strip_tags(@$_POST['msg_body']);
            $date = date("Y-m-d");
            $opened = "no";
            $deleted = "no";
            
            if ($msg_title == "Enter the message title here ...") {
             echo "Please give your message a title.";
            }
            else
            if (strlen($msg_title) < 3) {
             echo "Your message title cannot be less than 3 characters in length!";
            }
            else
            if ($msg_body == "Enter the message you wish to send ...") {
             echo "Please write a message.";
            }
            else
            if (strlen($msg_body) < 3) {
             echo "Your message cannot be less than 3 characters in length!";
            }
            else
            {

            $send_msg = mysqli_query($con,"INSERT INTO pvt_messages VALUES ('','$user','$username','$msg_title','$msg_body','$date','$opened','$deleted')");
		   header("Location: my_messages.php");
            }
          }
        echo "
        
        <form action='my_messages.php' method='POST'>
        <h2>Compose a Message: ($username)</h2>
        <input type='text' name='msg_title' size='30' onClick=\"value=''\" value='Enter the message title here ...'><p />
        <textarea cols='50' rows='12' name='msg_body'>Enter the message you wish to send ...</textarea><p />
        <input type='submit' name='submit' value='Send Message'>
        </form>

        ";
        }
        else
        {
         header("Location: $user");
        }
	}
	}
}
?>