<?php
  session_start();
  
  // store to test if they *were* logged in
  $old_user = $_SESSION['valid_user'];  
  unset($_SESSION['valid_user']);
  session_destroy();
?>
<html>
  <head>
        <link rel="icon" href="assets/HighLand.png">
  </head>
<body>
<h1>Log out</h1>
<?php 
  if (!empty($old_user))
  {
    header("Location: ./login.php");
    die();
  }
  header("Location: ./index.php");
  die();
?> 
<script src="./js/notif.js"></script>
</body>
</html>