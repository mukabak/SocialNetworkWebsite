<?php include "inc/incfiles/header.inc.php"; ?>
<h2>Create Your Like Button</h2><hr />
<br />
<form action="create_like_button.php" method="POST">
<input type="text" name="like_button_url" placeholder="Enter the URL ..." size="50">
<input type="submit" name="create" value="Create" />
</form>
<?php
if (isset($_POST['like_button_url'])) {
$like_button_url = strip_tags(@$_POST['like_button_url']);
$username = $user;
$date = date("Y-m-d");
$uid = rand(1847652057243457, 9999999999999999);
$uid = md5($uid);

$like_button_url2 = strstr($like_button_url, 'http://');


$b_check = mysql_query("SELECT page_url FROM like_buttons WHERE page_url='$like_button_url'");
$numrows_check = mysql_num_rows($b_check);
if ($numrows_check >= 1) {
echo "already exis";
}
else
{
if ($like_button_url2) {
$create_button = mysql_query("INSERT INTO like_buttons VALUES ('','$username','$like_button_url','$date','$uid')");
$insert_like = mysql_query("INSERT INTO likes VALUES ('','$user','-1','$uid')");
echo "
<div style='width: 400px; height: 250px; border: 1px solid;'>
&ltiframe src='http://ata-baba.kz/like_but_frame.php?uid=$uid' style='border: 0px; height: 35px; width: 120px'&gt
&lt/iframe&gt
</div>
";
}
else
{
$like_button_url = "http://" . $like_button_url;
$create_button = mysql_query("INSERT INTO like_buttons VALUES ('','$username','$like_button_url','$date','$uid')");
$insert_like = mysql_query("INSERT INTO likes VALUES ('','$user','-1','$uid')");
echo "
<div style='width: 400px; height: 250px; border: 1px solid;'>
&ltiframe src='http://ata-baba.kz/like_but_frame.php?uid=$uid' style='border: 0px; height: 35px; width: 120px'&gt
&lt/iframe&gt
</div>
";
}
}
}
?>