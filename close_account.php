<?php include "inc/incfiles/header.inc.php"; ?>
<?php
if ($user) {
if (isset($_POST['no'])) {
header ("Location: account_settings.php");
}
if (isset($_POST['yes'])) {
$close_account = mysql_query("UPDATE users SET closed='yes' WHERE username='$user'");
echo "Your account has been closed!";
session_destroy();
die();
}
}
else
{
die ("You must be logged in to view this page!");
}
?>


<br />
<center>
<form action="close_account.php" method="POST">
Are you sure you want to close your account?<br>
<input type="submit" name="no" value="No, take me back!">
<input type="submit" name="yes" value="Yes, I'm sure.">
</form>
</center>