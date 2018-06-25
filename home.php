<?php include "inc/incfiles/header.inc.php"; ?>
<?php
// Check logged in or not system //
if (!isset($_SESSION["user_login"]))
{
echo "<meta http-equiv=\"refresh\"content=\"0; url=index.php\">";
}
else
{
// End check logged in or not system //
?>
<div class="newsFeed">
<h2>Your Newsfeed:</h2>
</div>
<br /><br />

<?php
$getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to='$user' ORDER BY id DESC LIMIT 10") or die(mysql_error());
while ($row = mysql_fetch_assoc($getposts))
{
$id = $row['id'];
$body = $row['body'];
$date_added = $row['date_added'];
$added_by = $row['added_by'];
$user_posted_to = $row['user_posted_to'];

$get_user_info = mysql_query("SELECT * FROM users WHERE username='$added_by'");
$get_info = mysql_fetch_assoc($get_user_info);
$profilepic_info = $get_info['profile_pic'];

if ($profilepic_info == "") {
$profile_pic_post_img = "img/default_pic.jpg";
}
else
{
$profile_pic_post_img = "userdata/profile_pics/".$profilepic_info;
}
?>
<script language="javascript">
function toggle<?php echo $id; ?>() {
var ele =document.getElementById("toggleComment<?php echo $id; ?>");
var text =document.getElementById("displayComment<?php echo $id; ?>");
if (ele.style.display == "block") {
ele.style.display = "none";
}
else
{
ele.style.display = "block";
}
}
</script>
<?php
echo "
<br />
<div class='newsFeedPost'>
<div class='newfeedPostOptions'>
<a href='javascript:;' onClick='javascript:toggle$id()'>Show Comments</a>
</div>
<div style='float: left;'>
<img src='$profile_pic_post_img' height='50' width='40'>
</div>
<div class='posted_by'>
Posted by:
<a href='$added_by'>$added_by</a> on $date_added</div>
<br /><br />
<div  style='max-width: 600px;'>
$body<br /><br />
</div>
<div id='toggleComment$id' style='display: none;'>
<br />
<iframe src='./comment_frame.php?id=$id' frameborder='0' style='max-height: 150px; width: 100%; min-height: 10px;'></iframe>
</div>
<p />
</div>
";
}
}
?>