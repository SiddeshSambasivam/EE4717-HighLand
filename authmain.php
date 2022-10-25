<?php //authmain.php
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
<link href="horizontal-menu.css" rel="stylesheet">
<div id=wrapper>
<header>
	<a href="index.html">
    <img src="logo.gif" alt= "HighLand" class="center" height="300" width="300">
	</a>
</header>
<body>
<div id='loginbox' class="center" style="background-color:#5e5d5d;padding-top:50px; padding-bottom:50px; text-align:center;">
  <h1 class="center">Account Page</h1>
  <?php
    if (isset($_SESSION['valid_user']))
    {
      echo 'You are logged in as: '.$_SESSION['valid_user'].' <br />';
      echo '<a href="logout.php">Log out</a><br />';
      echo '<a href="index.html" class="center">Back to shopping</a>';
    }
    else
    {
      if (isset($userid))
      {
        // if they've tried and failed to log in
        echo '<p class="center">Incorrect Username or Password.<br /></p>';
      }
      else 
      {
        // they have not tried to log in yet or have logged out
        echo '<p class="center">You are not logged in.<br /></p>';
      }

      // Provide form to log in
      echo '<div align="center"><form method="post" action="authmain.php">';
      echo '<table>';
      echo '<tr><td>Username:</td>';
      echo '<td><input type="text" name="userid"></td></tr>';
      echo '<tr><td>Password:</td>';
      echo '<td><input type="password" name="password"></td></tr>';
      echo '<tr><td colspan="2" align="center">';
      echo '<input type="submit" value="Log in"></td></tr>';
      echo '</table></form></div>';

      echo '<a href ="registration.php" class="center">Dont have an account? Sign Up Now!</a>';
    }
  ?>
  <br />
  

  
</div>

<footer>
	<h1>About Us</h1>
	<a href="mailto:zaccheus@leong.com">zaccheus@leong.com</a>
</footer>
</div>
</body>
</html>
