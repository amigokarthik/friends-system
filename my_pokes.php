<?php include("./inc/header.inc.php"); ?>
<?php 
$check_for_pokes = mysqli_query($con,"SELECT * FROM pokes WHERE user_to='$user'");
$poke = mysqli_fetch_assoc($check_for_pokes);
$poke_num = mysqli_num_rows($check_for_pokes);
 $user_to = $poke['user_to'];
 $user_from = $poke['user_from'];

 if (@$_POST['poke_' . $user_from . '']) {
   $delete_poke = mysqli_query($con,"DELETE FROM pokes WHERE user_from='$user_from' && user_to='$user_to'");
    $create_new_poke = mysqli_query($con,"INSERT INTO pokes VALUES ('','$user','$user_from')");
    header("Location: my_pokes.php");
 echo "You just Poked $user_from";
}
if ($poke_num == 0) {
 echo "You have no pokes yet.";
}
else
{
 echo "
 <form action='my_pokes.php' method='POST'>
 You have been poked by $user_from&nbsp;
 <input type='submit' name='poke_$user_from' value=\"Poke Back\">
 </form>
 "."<br>";
} 
?>