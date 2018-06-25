<?php
include ("inc/scripts/mysql_connect.inc.php");
session_start();
if (isset($_SESSION["user_login"])) {
$user = $_SESSION["user_login"];
}
else
{
$user = "";
}

$post = @$_POST['post'];
if ($post != "") {
$date_added = date("y-m-d");
$added_by = $user;
$user_posted_to = $username;

$sqlCommand = "INSERT INTO posts (id,body,date_added,added_by,user_posted_to) VALUES ('','$post','$date_added','$added_by','$user_posted_to')";
$query = mysql_query($sqlCommand) or die (mysql_error());
}
?>