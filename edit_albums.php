<?php include "inc/incfiles/header.inc.php"; ?>
<?php
// Check logged in or not system //

if (isset($_GET['uid']))
{
$uid = mysql_real_escape_string($_GET['uid']);
}
else
{

echo "
<h2>Photos in this Album:</h2><hr />
There is no photos in this Album
";
die();
}


///////////////////
$get_albums = mysql_query("SELECT * FROM albums WHERE id='$uid' && removed='no'");
$numrows = mysql_num_rows($get_albums);
while($row = mysql_fetch_assoc($get_albums)) {
$id = $row['id'];
$album_title = $row['album_title'];
$album_description = $row['album_description'];
$username = $row['created_by'];
$date = $row['date'];
$url = $row['cover_page'];
}
///////////////////
if ($user == $username)
{
}
else
{
die ("You must be logged in to view this page!");
}

// End check logged in or not system //
?>
<?php
// Upload image system //
if (isset($_FILES['profilepic'])) {
if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 1048576)) {
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

$album_title_new = @$_POST['album_title'];
$album_description_new = @$_POST['album_description'];
$date_new = date("y-m-d");

$profile_pic_query = mysql_query("UPDATE albums SET cover_page='http://www.ata-baba.kz/userdata/user_photos/$rand_dir_name/$profile_pic_name', album_title='$album_title_new', album_description='$album_description_new', date='$date_new' WHERE id='$uid'");
header("Location: albums/view_photo/$uid");
}
}
else
{
echo "Invalid File! Your img must be no larger than 1 MB and it must be either a .jpg, .jpeg, .png, or .gif!";
}
}
// End upload image system //
?>
<h2>EDIT YOUR ALBUM:</h2><br />
<hr />
<br />
<p>EDIT YOUR ALBUM DETAILS:</p><br />
<form action="" method="POST" enctype="multipart/form-data">
<input type="text" name="album_title" value="<?php echo $album_title ?>"><br />
<textarea name="album_description" id="aboutyou" cols="56" rows="8"><?php echo $album_description ?></textarea><br />

<div id='file_browse_wrapper'>
		<input type='file' name="profilepic" id='file_browse' />
	    </div>
<input type="submit" name="uploadpic" value="Upload"/>
</form>
<hr />
<?php
if (isset($_POST['uploadphoto'])) {
if (((@$_FILES["photo_choose"]["type"]=="image/jpeg") || (@$_FILES["photo_choose"]["type"]=="image/png") || (@$_FILES["photo_choose"]["type"]=="image/gif"))&&(@$_FILES["photo_choose"]["size"] < 1048576))
{
$chars_photo = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$rand_dir_name_photo = substr(str_shuffle($chars_photo), 0, 15);
mkdir("userdata/user_photos/$rand_dir_name_photo");
if (file_exists("userdata/user_photos/$rand_dir_name_photo/".@$_FILES["photo_choose"]["name"]))
{
echo @$_FILES["photo_choose"]["name"]." Already exists";
}
else
{
move_uploaded_file(@$_FILES["photo_choose"]["tmp_name"],"userdata/user_photos/$rand_dir_name_photo/".$_FILES["photo_choose"]["name"]);
$profile_pic_name_photo = @$_FILES["photo_choose"]["name"];

$date = date("y-m-d");
$description_photo = @$_POST['description_photo'];

$profile_pic_query_photo = mysql_query("INSERT INTO photos VALUES ('','$uid','$user','$date','$description_photo','http://www.ata-baba.kz/userdata/user_photos/$rand_dir_name_photo/$profile_pic_name_photo','no')");
header("Location: upload_photo.php");
}
}
else
{
echo "Invalid File! Youvvr img must be no larger than 1 MB and it must be either a .jpg, .jpeg, .png, or .gif!";
}
}

?>
<p>UPLOAD YOUR PHOTOS:</p><br />
<form action="" method="POST" enctype="multipart/form-data">
<h1>Select your photo:</h1><br />
<input type="file" name="photo_choose" /><br />
<h1>Photo description:</h1><br />
<textarea name="description_photo" id="aboutyou" cols="56" rows="8"></textarea><br />
<input type="submit" name="uploadphoto" value="Upload"/>
</form>
<br />