<?php include "inc/incfiles/header.inc.php"; ?>
<script src="sample/min.js" type="text/javascript"></script>
<script src="sample/custom.js" type="text/javascript"></script>
<div>
<div>
<script type="text/javascript" src="sample/swfobject.js"></script>
<div id="dewplayer_content_js">
<object data="dewplayer.swf" width="0" height="0" name="dewplayer" id="dewplayerjs" type="application/x-shockwave-flash" style="visibility:hidden;">
<param name="movie" value="dewplayer.swf" />
<param name="flashvars" value="mp3=test.mp3|test.mp3|test.mp3&javascript=on" />
<param name="wmode" value="transparent" />
</object>
</div>
<p>
<br />
<br />
<?php
$get_photo = mysql_query("SELECT * FROM musics WHERE song_username='oraz'");
$numrows = mysql_num_rows($get_photo);
while($row = mysql_fetch_assoc($get_photo))
{
$song_id = $row['song_id'];
$song_title = $row['song_title'];
$song_username = $row['song_username'];
$song_url = $row['song_url'];
echo "
<image src='sample/play.PNG' onclick=\"set('$song_url');\" id='testbuttonplay$song_id' style='width:20px; height:20px;'/><image src='sample/pause.PNG' onclick=\"pause();\" id='testbuttonpause$song_id' style='width:20px; height:20px; margin-left:-20px; visibility:hidden'/>  added by: $song_username  Title: $song_title<br />
";
?>
<script type="text/javascript">
			$("document").ready(function(){
			
			$("#testbuttonplay<?php echo $song_id; ?>").click(function(){
			$("#testbuttonplay<?php echo $song_id; ?>").css("visibility","hidden");
			$("#testbuttonpause<?php echo $song_id; ?>").css("visibility","visible");
			});
			
			});
			
			$("document").ready(function(){
			
			$("#testbuttonpause<?php echo $song_id; ?>").click(function(){
			$("#testbuttonpause<?php echo $song_id; ?>").css("visibility","hidden");
			$("#testbuttonplay<?php echo $song_id; ?>").css("visibility","visible");
			});
			
			});
			</script>
<?php
}
?>

<input type="button" id="testbutton1" onclick="play();" value="Play" />
<input type="button" id="testbutton2" onclick="stop();" value="Stop" style="visibility:hidden; margin-left:-30;" />
<input type="button" onclick="pause();" value="Pause" />
<input type="button" onclick="next();" value="Next" />
<input type="button" onclick="prev();" value="Prev" />
<input type="button" onclick="go(2);" value="Go(2)" />
<input type="button" onclick="set('test.mp3');" value="Set mp3" />
<input type="button" onclick="set('test.mp3');" value="Set another mp3" />
<input type="button" onclick="setpos(10000);" value="Set position 10 sec" />
<input type="button" onclick="getpos();" value="Get position" />
<input type="button" onclick="volume(50);" value="Set volume 50%" />
<br />
</p>
			
			
			
			<script type="text/javascript">
			
			
			
			
			var dewp = document.getElementById("dewplayerjs");
			function play() {
			  if(dewp!=null) dewp.dewplay();
			}
						function stop() {
			  if(dewp!=null) dewp.dewstop();
			}
			function pause() {
			  if(dewp!=null) dewp.dewpause();
			}
			function next() {
			  if(dewp!=null) dewp.dewnext();
			}
			function prev() {
			  if(dewp!=null) dewp.dewprev();
			}
			var dewp = document.getElementById("dewplayerjs");
			function set(file) {
			  if(dewp!=null) dewp.dewset(file);
			  
			  
<?php
$get_photo = mysql_query("SELECT * FROM musics WHERE song_username='oraz'");
$numrows = mysql_num_rows($get_photo);
while($row = mysql_fetch_assoc($get_photo))
{
$song_id = $row['song_id'];
?>
$("#testbuttonpause<?php echo $song_id; ?>").css("visibility","hidden");
$("#testbuttonplay<?php echo $song_id; ?>").css("visibility","visible");
<?php
}


?>
			  
			  
			}
			function go(index) {
			  if(dewp!=null) dewp.dewgo(index);
			}
			function setpos(ms) {
			  if(dewp!=null) dewp.dewsetpos(ms);
			}
			function getpos() {
			  if(dewp!=null) alert(dewp.dewgetpos());
			}
			function volume(val) {
			  if(dewp!=null) alert(dewp.dewvolume(val));
			}
			</script>
		</div>
	</div>