<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighLand - Home</title>
    <link rel="icon" href="assets/HighLand.png">    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
    <script src="./js/components.js"></script>
    <?php        
        
        session_start();
        include("../src/db_connect.php");    
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = array();
        }

        if(isset($_GET['buy'])){
                        
            $product = $_GET['buy'];
            $price = $_GET['price'];

            $quantity = 1;            
            $exists = false;     
            $index = 0;       

            foreach($_SESSION['cart'] as $item){
                if($product == $item['product']){
                    $quantity = $item['quantity'] + 1;     
                    $_SESSION['cart'][$index]['quantity'] = $quantity;
                    $exists = true;
                    break;
                }
                $index++;
            }

            if(!$exists){
                $item = array(
                    'product' => $product,
                    'price' => $price,
                    'quantity' => $quantity
    
                );    
                array_push($_SESSION['cart'], $item);
            }

            echo "<script>console.log('Added to cart!');</script>";            
        }

    ?>


</head>


<div id=wrapper>
<body>
<header class="header">
        <div class="header__top">
            <div class="header__top_left_info">
                <p>
                    Free shippings on all orders, 30 days return and refund policy.
                </p>
            </div>            
            <div class="header__top_right_cta">
                <?php 
                    if(isset($_SESSION['user_id'])){
                        echo "<span>Welcome ".$_SESSION['name']."!</span>";
                        echo "<a href='logout.php'>Logout</a>";
                    }else{
                        echo '<a href="./login.php">Sign up</a>
                             <a href="#">faqs</a>';
                    }
                ?>
            </div>
        </div>
        <div class="header__bottom">
            <div class="header__bottom_logo">
                <a href="./index.php">HighLand</a>
            </div>
            <nav>
                <ul>
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./clothing.php">Clothing</a></li>
                    <li><a href="./shoes.php">Shoes</a></li>
                    <li><a href="./accessories.php">Accessories</a></li>
                    <li><a href="./about.php">About</a></li>                    
                </ul>
            </nav>
            <div class="header__bottom_cta">                  
                <a href="./my-cart.php">
                    <span class="material-symbols-outlined">
                        shopping_cart
                    </span>                            
                </a>                
                <a href="#">
                    <span class="material-symbols-outlined">
                        search
                    </span>                                                                            
                </a>   
                <a href="./login.php">
                    <span class="material-symbols-outlined">
                        account_circle
                    </span>                            
                </a>
            </div>
        </div>
    </header>
<?php

    $item_title = $_GET['item'];
    $item_title = str_replace('%20', ' ', $item_title);
    $sql = "SELECT * FROM `products` WHERE `title` = '$item_title'";
    $result = $conn->query($sql);
    
    $conn->close();
    
    while($row = $result->fetch_assoc()) { 

	$string = '<div class = "flex-container-product-page">
		<div style = "margin-top: 50px">
			<img class="product__card_img" src="'.$row['image'].'" alt="product image" >
            <br>
            <h2 style = "text-align: center;margin-top: 30px; margin-bottom :20px">'.$row['title'].'</h2>';
		
            for($i = 0; $i < 5; $i++){
                if($i < $row['rating']){
                    $string .= '<span class="fa fa-star checked" style = "text-align: center"></span>';
                }else{
                    $string .= '<span class="fa fa-star" style = "text-align: center"></span>';
                }
            }
        $string .='</div>

		<div> 
			<div id="item_desc">
				<h2>'.$row['description'].'</h2>
                <br>    
				<h2>Price S$'.$row['price'].'</h2>

				<ul id="size">';
                // for (size in $row['size']->fetch_assoc()){
					

				// $products .= echo '<div><a href="services.html">US <br> 7</a></div>';
                // }
	$string .='<div><a href="#">US <br> 8</a></div>
					<div><a href="#">US <br> 9</a></div>
		
					<div><a href="#">US 10</a></div>
					<div><a href="#">US 11</a></div>
					<div><a href="#">US 12</a></div>
					<div><a href="#">US 13</a></div>
				</ul>

			</div>
		</div>

		







    
	</div>
    
    ';
    }
    echo $string;
    ?>
    <footer-foot></footer-foot>
    <div id="snackbar">
        <span class="material-symbols-outlined">
            info
        </span>
        Added to cart
    </div>
    <script src="./js/cart.js"></script>
    <script src="./js/snackbar.js"></script>
</body>
</html>
