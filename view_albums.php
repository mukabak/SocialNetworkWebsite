<?php include "inc/incfiles/header.inc.php"; ?>

<?php
if (isset($_GET['u']))
{
$username = mysql_real_escape_string($_GET['u']);
if (ctype_alnum($username))
{
$check = mysql_query("SELECT username FROM users WHERE username='$username' AND closed='no'");
if(mysql_num_rows($check)===1)
{
$get = mysql_fetch_assoc($check);
$username = $get['username'];
}
else
{
echo "<meta http-equiv=\"refresh\"content=\"0; url=http://www.ata-baba.kz/index.php\">";
exit();
}
}
}
?>

<div class="view_albums">
<h2>PHOTO GALLERY</h2>
<p />
<hr />
<br />
<p>ALBUMS:</p>
<p />

<?php
$get_albums = mysql_query("SELECT * FROM albums WHERE created_by='$username' && removed='no'");
$numrows = mysql_num_rows($get_albums);
while($row = mysql_fetch_assoc($get_albums))
{
$id = $row['id'];
$album_title = $row['album_title'];
$created_by = $row['created_by'];
$date = $row['date'];
$url = $row['cover_page'];
$uid = $id;
echo "
<a href='view_photo/$uid'>
<img src='$url' id='album' title='$album_title'></a>
";
}
?>

<?php
if ($numrows == 0)
{
echo '<p>You have not any albums yet! You can create it now ...</p>';
}
?>

<p />
<hr />

<?php
if (isset($_POST['uploadpic']))
{
if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 2097152))
{
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$rand_dir_name = substr(str_shuffle($chars), 0, 15);
mkdir("userdata/user_album_coverpage/$rand_dir_name");
move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"userdata/user_album_coverpage/$rand_dir_name/".$_FILES["profilepic"]["name"]);
$profile_pic_name = @$_FILES["profilepic"]["name"];
$album_title_upload = @$_POST['album_title'];
$date_upload = date("y-m-d");
$profile_pic_query = mysql_query("INSERT INTO albums VALUES ('','$album_title_upload','$user','$date_upload','no','http://www.ata-baba.kz/userdata/user_album_coverpage/$rand_dir_name/$profile_pic_name')");
header("Location: $user");
}
else
{
echo "Invalid File! Your img must be no larger than 2 MB and it must be either a .jpg, .jpeg, .png, or .gif!";
}
}

if ($user == $username) {
echo "
<br />
<p>CREATE YOUR OWN ALBUMS:</p>
<br />
<form action='' method='POST' enctype='multipart/form-data'>
<h1>Title:<br /><h1/>
<input type='text' name='album_title'/>
<br />
<br />
<h1>Cover page:<br /><h1/>
<div id='file_browse_wrapper'>
<input type='file' name='profilepic' id='file_browse' />
</div>
<br />
<input type='submit' name='uploadpic' value='Create'/><br />
</form>
<p />
<hr />
";
}
?>
</div>