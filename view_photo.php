<?php include "inc/incfiles/header.inc.php"; ?>

<!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php
if (isset($_GET['uid']))
{
$uid = mysql_real_escape_string($_GET['uid']);
}
else
{
die();
}
?>

<?php
$get_albums = mysql_query("SELECT * FROM albums WHERE id=$uid");
$numrows = mysql_num_rows($get_albums);
while($rowalbum = mysql_fetch_assoc($get_albums))
{
$album_title = $rowalbum['album_title'];
$album_description = $rowalbum['album_description'];
$username = $rowalbum['created_by'];
$date = $rowalbum['date'];
$url = $rowalbum['cover_page'];
}
?>

<h2><?php echo $album_title; ?></h2>
<hr />

<?php
if ($user == $username)
{
echo "<a href='http://ata-baba.kz/edit_albums.php?uid=$uid'><div style='float: right; display: inline;'>Edit Album</div></a>";
}
?>

<br />
<div class='view_albums'>

<?php
$get_photo = mysql_query("SELECT * FROM photos WHERE uid='$uid' && removed='no'");
$numrows = mysql_num_rows($get_photo);
while($row = mysql_fetch_assoc($get_photo)) {
$id_photo = $row['id'];
$date_photo = $row['date_posted'];
$description_photo = $row['description'];
$url_photo = $row['image_url'];
echo "
<a class='thumbnail' href='javascript:'><img class='thumbnail' src='$url_photo' /><span class='thumbnail'><img src='$url_photo' /><br /></span></a>
";
}
?>
</div>