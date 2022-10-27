<?php  //cart.php
include "dbconnect.php";
session_start();
// var_dump($_SESSION);
if (!isset($_SESSION['cart'])){
	$_SESSION['cart'] = array();
}



?>

<html>
<link href="css-stylesheet.css" rel="stylesheet">
<div id=wrapper>
<header>
	<a href="index.php">
    <img src="logo.gif" alt= "HighLand" class="center" height="300" width="300">
	</a>
</header>
<body>
<?php
if (isset($_GET['checkedout']))
{
	if (count($_SESSION['cart'])>1) 
	{
	echo "<h2 class='center' style='text-align:center'>Thank You for shopping with us!<br><br> Your items will arrive shortly!<br> Order Summary</h2>";
	}

	else{
	echo "<h2 class='center' style='text-align:center'>Your cart is empty!<br><br></h2>";
	}

}
?>
<table border="0" style="margin: 0px auto;">
	<thead>
	<tr>
		<th>Item Name</th>
		<th >Price</th>
	</tr>
	</thead>
	<tbody>
<?php
$total = 0;

for ($i=0; $i < count($_SESSION['cart']); $i++){
	echo "<tr style='text-align: center; '>";
	echo "<td style='text-align: center; '>" .$_SESSION['cart'][$i]. "</td>";
	echo "<td align='right' style='text-align: center; '>$";
	echo $_SESSION['price'][$i]. "</td>";
	echo "</tr >";
	$total = $total + $_SESSION['price'][$i];
}
?>
	</tbody>
	<tfoot>
	<tr>
		<th align='left'>Total:</th><br>
		<th align='left'>$<?php echo number_format($total, 2); ?>
		</th>
	</tr>
	</tfoot>
</table>
<p class='center' style='text-align: center; '><a href="index.php">Continue Shopping</a></p>

<?php
if (!isset($_SESSION['valid_user']))
{

	echo "<p><a href='". $_SERVER['PHP_SELF']."?empty=1' class='center' style='text-align: center;'>Checkout as guest</a></p>";
	echo "<p><a href='registration.php' class='center' style='text-align: center;'>Become a member now!</a></p>";


}
if (isset($_SESSION['valid_user']))
{
	if(!isset($_GET['checkedout'])){

	
	echo "<p><a href='". $_SERVER['PHP_SELF']."?checkedout=1&empty=1' class='center' style='text-align: center;'>Checkout now!</a></p>";

	}
}

if (isset($_GET['empty'])) {
	unset($_SESSION['cart']);
	unset($_SESSION['price']);
	// header('location: ' . $_SERVER['PHP_SELF']);
	// exit();
}

?>
<footer>
	<h1>About Us</h1>
	<a href="mailto:zaccheus@leong.com">zaccheus@leong.com</a>
</footer>
</body>
</html>