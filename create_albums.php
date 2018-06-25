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

if (isset($_POST['uploadpic'])) {
if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 1048576))
{
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$rand_dir_name = substr(str_shuffle($chars), 0, 15);
mkdir("userdata/user_photos/$rand_dir_name");
if (file_exists("userdata/user_photos/$rand_dir_name/".@$_FILES["profilepic"]["name"]))
{
echo @$_FILES["profilepic"]["name"]." Already exists";
}
else
{
move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"userdata/user_photos/$rand_dir_name/".$_FILES["profilepic"]["name"]);
$profile_pic_name = @$_FILES["profilepic"]["name"];
$img_id_before_md5 = "$rand_dir_name/$profile_pic_name";
$img_id = md5($img_id_before_md5);

$album_title = @$_POST['album_title'];
$album_description = @$_POST['album_description'];
$date = date("y-m-d");
$profile_pic_query = mysql_query("INSERT INTO albums VALUES ('','$album_title','$album_description','$user','$date','no','http://www.ata-baba.kz/userdata/user_photos/$rand_dir_name/$profile_pic_name')");
header("Location: albums/$user");
}
}
else
{
echo "Invalid File! Your img must be no larger than 1 MB and it must be either a .jpg, .jpeg, .png, or .gif!";
}
}
?>

<p>CREATE YOUR ALBUMS:</p><br />
<hr />
<form action="create_albums.php" method="POST" enctype="multipart/form-data">
<br />
<h1>Album's title:<h1/>
<input type="text" name="album_title"/><br />
<h1>Album's description:<h1/>
<textarea name="album_description" id="album_description" cols="56" rows="8"></textarea><br />
<h1>Album's cover page:<h1/>
<div id='file_browse_wrapper'>
		<input type='file' name="profilepic" id='file_browse' />
	    </div>
		<hr />
<input type="submit" name="uploadpic" value="Create"/><br />
</form>