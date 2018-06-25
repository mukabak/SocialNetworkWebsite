<?php include "inc/incfiles/header.inc.php"; ?>
<?php
if (isset($_GET['u']))
{
$username = mysql_real_escape_string($_GET['u']);
if (ctype_alnum($username))
{
$check = mysql_query("SELECT username, first_name, bio FROM users WHERE username='$username'");
if(mysql_num_rows($check)===1)
{
$get = mysql_fetch_assoc($check);
$username = $get['username'];
$firstname = $get['first_name'];
$bio = $get['bio'];


if ($username != $user) {
if (isset($_POST['submit'])) {
$msg_title = strip_tags(@$_POST['msg_title']);
$msg_body = strip_tags(@$_POST['msg_body']);
$date = date("Y-m-d");
$opened = "no";
$deleted = "no";

if ($msg_title == "") {
echo "Please give your message a title.";
}
else
if ($msg_body == "") {
echo "Please write a message.";
}
else
{
$send_msg = mysql_query("INSERT INTO pvt_messages VALUES ('','$user','$username','$msg_title','$msg_body','$date','$opened','$deleted')");
echo "Your message has been sent!" ;
}
}
echo "
<form action='send_msg.php?u=$username' method='POST'>
<h2>Compose a Message: ($username)</h2>
<input type='text' name='msg_title' size='30' placeholder='Enter the messages title here...'><p />
<textarea cols='50' rows='12' name='msg_body' placeholder='Enter the message you wish to send...'></textarea>
<input type='submit' name='submit' value='Send message'>
</form>
";
}
else
{
header("location: $user");
}
}
}
}
?>