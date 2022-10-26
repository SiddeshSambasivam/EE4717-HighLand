<?php //registration.php
include "dbconnect.php";
session_start();

if (isset($_POST['userid']) && isset($_POST['password']))
{
  // if the user has just tried to log in
  $userid = $_POST['userid'];
  $password = $_POST['password'];
/*
  $db_conn = new mysqli('localhost', 'webauth', 'webauth', 'auth');

  if (mysqli_connect_errno()) {
   echo 'Connection to database failed:'.mysqli_connect_error();
   exit();
  }
*/
$password = md5($password);
  $query = 'select * from users '
           ."where username='$userid' "
           ." and password='$password'";
// echo "<br>" .$query. "<br>";
  $result = $dbcnx->query($query);
  if ($result->num_rows >0 )
  {
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $userid;    
  }
  $dbcnx->close();
}
?>
<html>
<link href="css-stylesheet.css" rel="stylesheet">
<div id=wrapper>
<header>
	<a href="index.html">
    <img src="logo.gif" alt= "HighLand" class="center" height="300" width="300">
	</a>
</header>
<title>Signup Page</title>
<body>
<div id='loginbox' class="center" style="background-color:#5e5d5d;padding-top:50px; padding-bottom:50px; text-align:center;">
  <h1 class="center">Account Page</h1>
  <?php
    if (isset($_SESSION['valid_user']))
    {
      echo 'You are now registered! <br />';
      echo '<a href="authmain.php">Click here to login!</a><br />';
    }



    else
    {

      // Provide form to log in

      echo '<div align="center"><form method="POST" action="register.php">';
      echo '<table>';
      echo '<tr><td>Username:</td>';
      echo '<td><input type="text" name="username" required></td></tr>';
      echo '<tr><td>Password:</td>';
      echo '<td><input type="password" name="password" required></td></tr>';
	  echo '<tr><td>Repeat Password:</td>';
	echo '<td><input type="password" name="password2" required></td></tr>';
      echo '<tr><td colspan="2" align="center">';
      echo '<input type="submit" value="Register"></td></tr>';
      echo '</table></form></div>';
    }
  ?>
  <br/>

</div>

<footer>
	<h1>About Us</h1>
	<a href="mailto:zaccheus@leong.com">zaccheus@leong.com</a>
</footer>
</div>
</body>
</html>

