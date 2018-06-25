<?php include ("inc/scripts/mysql_connect.inc.php"); ?>
<?php 
// Check logged in or not system //
session_start();
if (isset($_SESSION["user_login"]))
{
$user = $_SESSION["user_login"];
}
else
{
$user = "";
}
// End check logged in or not system //
$get_unread_query = mysql_query("SELECT opened FROM pvt_messages WHERE user_to='$user' && opened='no'");
$get_unread = mysql_fetch_assoc($get_unread_query);
$unread_numrows = mysql_num_rows($get_unread_query);
?>
<html>
<head>
<link href="http://ata-baba.kz/css/main.css" rel="stylesheet" type="text/css">
<title>FindFriends</title>
</head>
<body>
<div class="headerMenu">
	<div id="wrapper">
	<table class="headerTable">
	<tr>
	<td width="400px" valign="top" id="headerTable">
		<div class="logo">
			<img src = "http://ata-baba.kz/img/find_friends_logo.png">
		</div>
		<div class="search_box">
		     <form method="GET" action="search.php" id="search">
	      	     <input name="q" type="text" size="60" placeholder="Search..."/>
		     </form>
		</div>
		
		</td>
		<td width="600px" valign="top" id="headerTable" align="right">
<?php
// Menu system //
if (isset($_SESSION["user_login"]))
{
echo '
<div id="menu">
<a href="http://ata-baba.kz/'.$user.'">Profile</a>
<a href="http://ata-baba.kz/my_messages.php">Messages ('. $unread_numrows . ')</a>
<a href="http://ata-baba.kz/albums/'.$user.'">Photos</a>
<a href="http://ata-baba.kz/my_musics.php">Musics</a>
<a href="http://ata-baba.kz/my_pokes.php">Pokes</a>
<a href="http://ata-baba.kz/account_settings.php">Account Settings</a>
<a href="http://ata-baba.kz/logout.php">Logout</a>
</div>
';
}
else
{
echo '
<div id="menu">
<a href="http://ata-baba.kz/index.php">Sign Up</a>
<a href="http://ata-baba.kz/index.php">Login</a>
</div>
';
}
// End menu system //
?>
</td>
	</tr>
	</table>
	</div>
	<div id="border">
</div>
	</div>
<br /><br /><br /><br />
<div id="wrapper2">
