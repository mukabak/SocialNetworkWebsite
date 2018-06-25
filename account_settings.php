<?php include "inc/incfiles/header.inc.php"; ?>
<?php
// Check logged in or not system //
if ($user)
{
}
else
{
die ("You must be logged in to view this page!");
}
// End check logged in or not system //
?>
<?php
// Show information system //
$Checkinfo = mysql_query("SELECT * FROM users WHERE username='$user'");
while ($row = mysql_fetch_assoc($Checkinfo))
{
$db_fname = $row['first_name'];
$db_lname = $row['last_name'];
$db_bio = $row['bio'];
}
// End show information system //
// Change password system //
$senddata = @$_POST['senddata'];
$old_password = @$_POST['oldpassword'];
$new_password = @$_POST['newpassword'];
$new_password2 = @$_POST['newpassword2'];
if ($senddata)
{
$password_query = mysql_query("SELECT * FROM users WHERE username='$user'");
while ($row = mysql_fetch_assoc($password_query))
{
$db_password = $row['password'];
$old_password_md5 = md5($old_password);
if ($old_password_md5 == $db_password)
{
if ($new_password == $new_password2)
{
if (strlen($new_password)>32||strlen($new_password)<5)
{
echo "Your new password must be 5-32 characters long!";
}
else
{
$new_password_md5 = md5($new_password);
$password_update_query = mysql_query("UPDATE users SET password='$new_password_md5' WHERE username='$user'");
echo "Success! Your password updated!";
}
}
else
{
echo "Paswords does't match!";
}
}
else
{
echo "The old password is incorrect!";
}
}
}
else
{
echo "";
}
// End change password system //
// Udpade information system //
$sendinfo = @$_POST['sendinfo'];
$new_fname = @$_POST['fname'];
$new_lname = @$_POST['lname'];
$new_bio = @$_POST['aboutyou'];
if ($sendinfo)
{
$password_update_query = mysql_query("UPDATE users SET first_name='$new_fname', last_name='$new_lname', bio='$new_bio' WHERE username='$user'");
echo "Success! Your profile updated!";
$password_query = mysql_query("SELECT * FROM users WHERE username='$user'");
while ($row = mysql_fetch_assoc($password_query))
{
$db_password = $row['password'];
$db_fname = $row['first_name'];
$db_lname = $row['last_name'];
$db_bio = $row['bio'];
}
}
// End update information system //
// Upload image system //
$check_pic=mysql_query("SELECT profile_pic FROM users WHERE username='$user'");
$get_pic_row = mysql_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['profile_pic'];
if ($profile_pic_db == "")
{
$profile_pic = "img/default_pic.jpg";
}
else
{
$profile_pic = "userdata/profile_pics/".$profile_pic_db;
}
if (isset($_FILES['profilepic']))
{
if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 1048576))
{
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$rand_dir_name = substr(str_shuffle($chars), 0, 15);
mkdir("userdata/profile_pics/$rand_dir_name");
if (file_exists("userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"]))
{
echo @$_FILES["profilepic"]["name"]." Already exists";
}
else
{
move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"userdata/profile_pics/$rand_dir_name/".$_FILES["profilepic"]["name"]);
$profile_pic_name = @$_FILES["profilepic"]["name"];
$profile_pic_query = mysql_query("UPDATE users SET profile_pic='$rand_dir_name/$profile_pic_name' WHERE username='$user'");
header("Location: account_settings.php");
}
}
else
{
echo "Invalid File! Your img must be no larger than 1 MB and it must be either a .jpg, .jpeg, .png, or .gif!";
}
}
// End upload image system //
?>
<h2>Edit your Account Settings below</h2><br />
<hr />
<br />
<p>UPLOAD YOUR PROFILE PHOTO:</p><br />
<form action="" method="POST" enctype="multipart/form-data">
<img src="<?php echo $profile_pic; ?>" width="200" height="250"/>
<input type="file" name="profilepic" /><br />
<input type="submit" name="uploadpic" value="Upload"/>
</form>
<hr />
<br />
<form action="account_settings.php" method="post">
<p>CHANGE YOUR PASSWORD:</p><br />
<h1>Your old password:<br /></h1><input type="password" name="oldpassword" id="oldpassword"><br />
<h1>Your new password:<br /></h1><input type="password" name="newpassword" id="newpassword"><br />
<h1>Repeat password:<br /></h1><input type="password" name="newpassword2" id="newpassword2"><br />
<input type="submit" name="senddata" id="senddata" value="Change" ><br />
<hr />
<br />
<p>UPDATE YOUR PROFILE INFO:</p><br />
<input type="text" name="fname" id="fname" value="<?php echo $db_fname ?>"><br />
<input type="text" name="lname" id="lname" value="<?php echo $db_lname ?>"><br />
<textarea name="aboutyou" id="aboutyou" cols="56" rows="8"><?php echo $db_bio ?></textarea><br />
<input type="submit" name="sendinfo" id="sendinfo" value="Update" ><br />
<hr />
<br />
</form>
<form action="close_account.php" method="post">
<p>CLOSE ACCOUNT:</p><br />
<input type="submit" name="closeaccount" id="closeaccount" value="Close My Account" ><br />
<hr />
</form>
<br />
<br />