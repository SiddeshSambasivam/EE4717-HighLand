<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighLand - Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
    <script src="./js/components.js"></script>
    <?php
        include("../src/products.php");
        
        session_start();

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
    <section class="hero set-bg" id="hero">
        <div class="hero__label">Winter collection</div>
        <h1 class="hero__title">Winter-Collections 2022</h1>
        <p class="hero__info">The latest designs from a wide variety of brands for all your fashion cravings. Checkout the new winter collection 2022.</p>

        <a href="./clothing.php" class="hero__cta">
            shop now
            <span class="material-symbols-outlined cta__move">
                arrow_forward_ios
            </span>
        </a>
    </section>
    <h2 class="top_products__section_header">Top Rated Products</h2>
    <section class="products-container" id="products">   
        <?php
            include("../src/db_connect.php");    

            $sql = "SELECT * FROM `products` WHERE `rating` > 4 LIMIT 8";
            $result = $conn->query($sql);
            $conn->close();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {                                    
                    $products .= '
                        <div class="product__card">
                            <img class="product__card_img" src="'.$row['image'].'" alt="product image">
                            <div class="product__info">
                                <a class="add_cart__btn" onclick="handleAddCart(\''.$row["title"].'\','.$row['price'].',1); callSnacker()">
                                    <span class="material-symbols-outlined">add</span>
                                    Add To Cart
                                </a>
                                <h4>'.$row['title'].'</h4>                                    
                                <div class="rating">';

                    for($i = 0; $i < 5; $i++){
                        if($i < $row['rating']){
                            $products .= '<span class="fa fa-star checked"></span>';
                        }else{
                            $products .= '<span class="fa fa-star"></span>';
                        }
                    }
                    
                    $products .= '                    
                                </div>
                                <h3>$'.$row['price'].'</h3>
                            </div>
                        </div>';
                }
            } else {
                $products = "0 results";
            }                        

            echo $products;
        ?>
    </section>                        
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