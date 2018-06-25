<?php include "inc/incfiles/header.inc.php"; ?>
<?php
// Check logged in or not system //
if (!isset($_SESSION["user_login"]))
{
echo "";
}
else
{
echo "<meta http-equiv=\"refresh\"content=\"0; url=home.php\">";
}
// End check logged in or not system //
?>
<?php
// Registration system //
$reg = @$_POST['reg'];
$fn = "";
$ln = "";
$un = "";
$em = "";
$pswd = "";
$pswd2 = "";
$d = "";
$u_check = "";
$rm="";
$fn = strip_tags(@$_POST['fname']);
$ln = strip_tags(@$_POST['lname']);
$un = strip_tags(@$_POST['username']);
$em = strip_tags(@$_POST['email']);
$pswd = strip_tags(@$_POST['password']);
$pswd2 = strip_tags(@$_POST['password2']);
$d = date("Y-m-d");
if ($reg)
{
$u_check = mysql_query("SELECT username FROM users WHERE username='$un'");
$check = mysql_num_rows($u_check);
$e_check = mysql_query("SELECT email FROM users WHERE email='$em'");
$email_check = mysql_num_rows($e_check);
if ($check == 0)
{
if ($email_check == 0)
{
if ($fn&&$ln&&$un&&$em&&$pswd&&$pswd2)
{
if ($pswd==$pswd2)
{
if (strlen($un)>32||strlen($fn)>32||strlen($ln)>32)
{
$rm = "The maximum limit is 32 characters!";
}
else
{
if (strlen($pswd)>32||strlen($pswd)<5)
{
$rm = "Your password must be 5-32 characters long!";
}
else
{
$pswd = md5($pswd);
$pswd2 = md5($pswd2);
$query = mysql_query("INSERT INTO users VALUES ('','$un','$fn','$ln','$em','$pswd','$d','0','None','','','no')");
die("<h2>Welcome to InstaWord!</h2>Login to your account to get started ...");
}
}
}
else {
$rm = "Your passwords don't match!";
}
}
else
{
$rm = "Please fill in all of the fields";
}
}
else
{
$rm = "This E-mail already taken!";
}
}
else
{
$rm = "This Username address already taken!";
}
}
// End registration system //
?>
<?php
// Login system //
if (isset($_POST["user_login"]) && isset($_POST["password_login"]))
{
$user_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["user_login"]);
$password_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password_login"]);
$md5password_login = md5($password_login);
$sql = mysql_query("SELECT id FROM users WHERE username='$user_login' AND password='$md5password_login' AND closed='no' LIMIT 1");
$userCount = mysql_num_rows($sql);
if ($userCount == 1)
{
while($row = mysql_fetch_array($sql))
{
$id = $row["id"];
}
$_SESSION["id"] = $id;
$_SESSION["user_login"] = $user_login;
$_SESSION["password_login"] = $password_login;
exit("<meta http-equiv=\"refresh\"content=\"0\">");
}
else
{
echo "That information inccorrect, try again!";
exit();
}
}
// End login system //
?>
<table class="homepageTable">
       <tr>
           <td width="60%" valign="top">
		   <h2>Already a Member? Login below...</h2>
           <form action="index.php" method="post" name="form1" id="form1">
		   <input type="text" size="32" name="user_login" id="loginbox" placeholder="Username" /><br />
		   <input type="password" size="32" name="password_login" id="loginbox" placeholder="Password" /><br />
		   <input type="submit" name="button" id="button" value="Login to your account">
           </form>
           </td>
           <td width="40%" valign="top">
           <h2>Sign up below...</h2>
           <form action="#" method="post">
           <input type="text" size="25" name="fname" placeholder="First Name" value="<?php echo $fn; ?>">
           <input type="text" size="25" name="lname" placeholder="Last Name" value="<?php echo $ln; ?>">
           <input type="text" size="25" name="username" placeholder="Username" value="<?php echo $un; ?>">
           <input type="email" size="25" name="email" placeholder="Email Address" value="<?php echo $em; ?>">
           <input type="password" size="25" name="password" placeholder="Password">
           <input type="password" size="25" name="password2" placeholder="Repeat Password"><br />
           <input type="submit" name="reg" value="Sign Up!">
		   <input type="multiple" name="regmessage" id="regmessage" readonly="true" value="<?php echo $rm; ?>">
           </form>
           </td>
       </tr>
</table>
</div>
</body>
</html>