<?php  //cart.php
include "dbconnect.php";
session_start();
// var_dump($_SESSION); 
$id = session_id();
if (!isset($_SESSION['cart'])){
	$_SESSION['cart'] = array();
}

if (isset($_GET['buy'])) {
	$_SESSION['cart'][] = $_GET['buy'];
    $_SESSION['price'][] = $_GET['price'];
	header('location: ' . $_SERVER['PHP_SELF']. '?' . SID);
	exit();
}
$query = 'select * from items';
// echo "<br>" .$query. "<br>";
$result = $dbcnx->query($query);
$num_results = $result->num_rows;

$query = 'SELECT ID, Price, ItemName FROM items';
$result = $dbcnx->query($query);





// $items = array(
// 	'top1',
// 	'top2',
// 	'top3',
// 	'top4');
// $prices = array(24.95, 1000, 19.99, 34.95);

?>
<!DOCTYPE html>
<html lang='en'>
<html>

<head>

<title>HighLand</title>
<style>

</style>
<link href="css-stylesheet.css" rel="stylesheet">
</head>


<div id=wrapper>

<header>
	<a href="index.php">
    <img src="logo.gif" alt= "HighLand" class="center" height="300" width="300">
	</a>
</header>
<body>
	<div>
	<nav>
		<ul id="mainMenu">
			<div class="nav"><a href="services.html">Men</a></div>
			<div><a href="services.html">Women</a></div>

            <div class="last"><a href="cart.php">My Cart :<br>  <?php echo count($_SESSION['cart']);?> Items in cart</a></div>
			<div class="break"></div>

			<div class="nav"><a href="support.html">Tops</a></div>
			<div class="nav"><a href="blog.html">Bottoms</a></div>
			<div class="nav"><a href="about.html">Shoes</a></div>
			<div class="nav"><a href="contact.html">Accessories</a></div>
            <?php
            if (isset($_SESSION['valid_user'])) {
			echo "<div class='last'><a href='authmain.php'>Account <br> Welcome ". $_SESSION['valid_user']."</a></div>";
            }

            else{

                echo"<div class='last'><a href='authmain.php'>Account </a></div>";
            }
            ?>
		</ul>
	</nav>
	</div>
    <br>
	<div class = 'flex-container'>


    <!-- <table border="1">
        <thead>
        <tr>
            <th>Item Description</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
    <?php
    
    // for ($i=0; $i<$num_results; $i++){
    //     $items = $result->fetch_assoc();
    //     echo "<tr>";
    //     echo "<td>" .$items['ID']. "</td>";
    //     echo "<td>$" .number_format($items['Price'], 2). "</td>";
    //     echo "<td>" .$items['ItemName']. "</td>";
    //     echo "<td><a href='" .$_SERVER['PHP_SELF']. '?buy=' .$i. "'>Buy</a></td>";
    //     echo "</tr>";
    // }
    ?>
        </tbody>
    </table> -->
<?php



    for ($i=0; $i<$num_results; $i++){
        $items = $result->fetch_assoc();
		echo "<div>";
		echo "<div id = 'item' ><img class='item' src='images/".$items['ItemName'].".jpg' alt='shoe1' height='400px' width='400px'></div>";
		echo "<div class=''text'><h2 style='text-align: center;'>".$items['ItemName']."</h2><div class='break'></div><h2 style='text-align: center;'>$ ".number_format($items['Price'], 2)."</h2></div>";
		echo "<h3 style='text-align: center;'><a href='" .$_SERVER['PHP_SELF']. '?buy=' .$items['ItemName'].'&price='.$items['Price']."'>Add to cart</a></h3 >";
        echo "</div>";

    }

 ?>





	</div>
<footer>
	<h1>About Us</h1>
	<a href="mailto:zaccheus@leong.com">zaccheus@leong.com</a>
</footer>
</body>



</div>
</body>
</html>
