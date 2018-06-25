<?php
echo "&ltPLAYLIST&gt";

mysql_connect("localhost","ataba_user12345","ataba_user12345...") or die(mysql_error());
mysql_select_db("atababak_root");

$get_musics = mysql_query("SELECT * FROM musics WHERE song_username='oraz'");
$numrows = mysql_num_rows($get_musics);
while($row = mysql_fetch_assoc($get_musics))
{
$song_title = $row['song_title'];
$song_url = $row['song_url'];
$song_username = $row['song_username'];

echo "
<br />
&ltSONG&gt<br />
&ltTITLE&gt
$song_title
&lt/TITLE&gt<br />
&ltURL&gt
$song_url
&lt/URL&gt<br />
&ltSONGLENGTH&gt
100
&lt/SONGLENGTH&gt<br />
&ltDOWNLOAD&gt
&lt/DOWNLOAD&gt<br />
&lt/SONG&gt<br /><br />
";
}
echo "&lt/PLAYLIST&gt";
?>
