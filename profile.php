<?php include "inc/incfiles/header.inc.php"; ?>
<?php
// Show profile information system //
if (isset($_GET['u']))
{
$username = mysql_real_escape_string($_GET['u']);
if (ctype_alnum($username))
{
$check = mysql_query("SELECT username, first_name, bio FROM users WHERE username='$username' AND closed='no'");
if(mysql_num_rows($check)===1)
{
$get = mysql_fetch_assoc($check);
$username = $get['username'];
$firstname = $get['first_name'];
$bio = $get['bio'];
}
else
{
echo "<meta http-equiv=\"refresh\"content=\"0; url=index.php\">";
exit();
}
}
}
// End show profile information system //
?>
<?php
// Post system //
$post = @$_POST['post'];
if ($post != "")
{
$date_added = date("y-m-d");
$added_by = $user;
$user_posted_to = $username;
$sqlCommand = "INSERT INTO posts (id,body,date_added,added_by,user_posted_to) VALUES ('','$post','$date_added','$added_by','$user_posted_to')";
$query = mysql_query($sqlCommand) or die (mysql_error());
}
$check_pic=mysql_query("SELECT profile_pic FROM users WHERE username='$username'");
$get_pic_row = mysql_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['profile_pic'];
if ($profile_pic_db == "") {
$profile_pic = "img/default_pic.jpg";
}
else
{
$profile_pic = "userdata/profile_pics/".$profile_pic_db;
}
?>
<div class="postForm">
<form action="<?php echo $username; ?>" method="POST">
<textarea id="post" name="post" rows="5" cols="135"></textarea>
<input href="javascript:" type="submit" name="send" value="Post" style="background-color:#DCE5EE; float:right; border: 1px solid #666; color:#666; height:73px; width:65px;"/>
</form>
</div>
<div class="profilePosts">
<?php
$getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC LIMIT 10") or die(mysql_error());
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

echo "
                                            <div style='float: left;'>
                                            <img src='$profile_pic_post_img' height='50' width='40' border='1px; solid;'>
                                            </div>
                    <div class='posted_by'>
                    Posted by:
                                            <a href='$added_by'>$added_by</a> on $date_added</div>
                                            <br /><br />
                                            <div  style='max-width: 600px;'>
                                            $body<br /><br />
                                            </div>
                                            <hr /><br />
                    ";
}
// End post system //
?>
<?php
if (isset($_POST['sendmsg']))
{
header("location: send_msg.php?u=$username");
}



// Friend requests system //
$errorMsg = "";
if (isset($_POST['addfriend']))
{
$friend_request = $_POST['addfriend'];
$user_to = $user;
$user_from = $username;
if ($user_to == $username)
{
$errorMsg = "you can't send a friend request to yourself!<br />";
}
else
{
$create_request = mysql_query("INSERT INTO friend_requests VALUES ('','$user_to','$user_from')");
$errorMsg = "Your friend request has been sent!";
}
}
else
{
}
?>
</div>
<img src="<?php echo $profile_pic; ?>" height="250" width="200" border="1px; solid;" alt="<?php echo $username ?>'s profile" title="<?php echo $username ?>'s profile"/>
<br />
<form action="<?php $username; ?>" method="POST">
<?php
$friendArray = "";
$countFriends = "";
$friendArray12 = "";
$adAsFriend = "";
$selectFriendsQuery = mysql_query("SELECT friend_array FROM users WHERE username='$username'");
$friendRow = mysql_fetch_assoc($selectFriendsQuery);
$friendArray = $friendRow['friend_array'];
if ($friendArray !="")
{
$friendArray = explode(",",$friendArray);
$countFriends = count($friendArray);
$friendArray12 = array_slice($friendArray, 0, 12);
$i = 0;
if (@in_array($user,$friendArray))
{
$addAsFriend = '<input type="submit" name="removefriend" value="UnFriend">';
}
else
{
$addAsFriend = '<input type="submit" name="addfriend" value="Add friend">';
}
echo $addAsFriend;
}
else
{
echo '<input type="submit" name="addfriend" value="Add friend">';
}
// sdfsdf //
if (@$_POST['removefriend'])
{
$add_friend_check = mysql_query("SELECT friend_array from users WHERE username='$user'");
$get_friend_row = mysql_fetch_assoc($add_friend_check);
$friend_array = $get_friend_row['friend_array'];
$friend_array_explode = explode(",",$friend_array);
$friend_array_count = count(friend_array_explode);

$add_friend_check_username = mysql_query("SELECT friend_array from users WHERE username='$username'");
$get_friend_row_username = mysql_fetch_assoc($add_friend_check_username);
$friend_array_username = $get_friend_row['friend_array'];
$friend_array_explode_username = explode(",",$friend_array_username);
$friend_array_count_username = count($friend_array_explode_username);

$usernameComma = ",".$username;
$usernameComma2 = $username.",";

$userComma = ",".$user;
$userComma2 = $user.",";

if (strstr($friend_array,$usernameComma))
{
$friend1 = str_replace("$usernameComma","",$friend_array);
}
else
if (strstr($friend_array,$usernameComma2))
{
$friend1 = str_replace("$usernameComma2","",$friend_array);
}
else
if (strstr($friend_array,$username))
{
$friend1 = str_replace("$username","",$friend_array);
}
if (strstr($friend_array,$userComma))
{
$friend2 = str_replace("$userComma","",$friend_array);
}
else
if (strstr($friend_array,$userComma2))
{
$friend2 = str_replace("$userComma2","",$friend_array);
}
else
if (strstr($friend_array,$user))
{
$friend2 = str_replace("$user","",$friend_array);
}

$friend2 = "";

$removeFriendQuery = mysql_query("UPDATE users SET friend_array='$friend1' WHERE username='$user'");
$removeFriendQuery_username = mysql_query("UPDATE users SET friend_array='$friend2' WHERE username='$username'");
echo "Friend Removed...";
header("Location: $username");
}
// End request friends system //

// Poke system //
if (@$_POST['poke']) {
$check_if_poked = mysql_query("SELECT * FROM pokes WHERE user_to='$username' && user_from ='$user'");
$num_poke_found = mysql_num_rows($check_if_poked);
if ($num_poke_found == 1) {
echo "You must wait to be poked back!";
}
else
if ($username == $user) {
echo "You cannot poke yourself.";
}
else
{
$poke_user = mysql_query("INSERT INTO pokes VALUES ('','$user','$username')");
echo "$username has been poked!";
}
}
$check_like_button = mysql_query("SELECT * FROM like_buttons WHERE uid='$username'");
$check_like_numrows = mysql_num_rows($check_like_button);
if ($check_like_numrows >= 1) {
}
else
{
$date=date("Y-m-d");
$create_button = mysql_query("INSERT INTO like_buttons VALUES ('','$username','http://ata-baba.kz/$username','$date','$username')");
$insert_like = mysql_query("INSERT INTO likes VALUES ('','$username','-1','$username')");
}
?>
<?php echo $errorMsg; ?>
<input type="submit" name="poke" value ="Poke">
<input type="submit" name="sendmsg" value ="Send Msg">
</form>
<iframe src='http://ata-baba.kz/like_but_frame.php?uid=<?php echo $username; ?>' style='border: 0px; height: 35px; width: 120px;'> </iframe>
<div class="txtHeader"><?php echo $username; ?>'s profile</div>
<div class="profileLeftSideContent"><?php echo $bio ?></div>
<div class="txtHeader"><?php echo $username; ?>'s friends</div>
<div class="profileLeftSideContent">
<?php
if ($countFriends !=0)
{
foreach ($friendArray12 as $key => $value)
{
$i++;
$getFriendQuery = mysql_query("SELECT * FROM users WHERE username='$value' LIMIT 1");
$getFriendRow = mysql_fetch_assoc($getFriendQuery);
$friendUsername = $getFriendRow['username'];
$friendProfilePic = $getFriendRow['profile_pic'];

if ($friendProfilePic == "")
{
echo "<a href='$friendUsername'><img src='img/default_pic.jpg' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" height='50' width='40' style='padding=right: 6px;'></a>";
}
else
{
echo "<a href='$friendUsername'><img src='userdata/profile_pics/$friendProfilePic' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" height='50' width='40' style='padding=right: 6px;'></a>";
}
}
}
else
echo $username." has no friends.";
?>
</div>
<form action="albums/<?php echo $username; ?>" method="POST">
<div class="txtHeader"><?php echo $username; ?>'s albums</div>
<div class="profileLeftSideContent">
<input type="submit" name="view_albums" value ="View Albums">
</div>
</form>
</body>
</html>