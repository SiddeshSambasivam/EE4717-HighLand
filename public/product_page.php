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

        $item_id = $_GET['id'];    
        $sql = "SELECT * FROM `products` WHERE `product_id` = '$item_id'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
        
        $conn->close();
       
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
                    <!-- <li><a href="./about.php">About</a></li> -->                    
                </ul>
            </nav>
            <div class="header__bottom_cta">                  
                <a href="./my-cart.php">
                    <span class="material-symbols-outlined" style="position:relative">
                        shopping_cart
                    </span>                     
                    <div class="number">0</div>       
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

    <div class="flex-container-product-page">
        <div style="margin-top:50px;">
            <?php 
                echo '<img class="product__card_img" src="'.$row['image'].'" alt="product image" />';
            ?>
            <h2>
                <?php 
                    echo $row['title'];
                ?>
            </h2>
            <p>
                <?php 
                    echo $row['description'];
                ?>
            </p>
            <p>
                <?php 
                    echo $row['price'];
                ?>
            </p>
            <?php
              echo '<a onclick="handleAddCart(\''.$row["title"].'\','.$row['price'].',1,\''.$row["product_id"].'\'); callSnacker()">
                <span class="material-symbols-outlined">add</span>
                Add To Cart
                </a>';

                // split string separated by comma                
                $colors = explode(",", $row['size']);
                $sizes = explode(",", $row['color']);
            ?>
            <ul id="size">                
                <?php
                    foreach($sizes as $size){
                        echo '<li>'.$size.'</li>';
                    }
                ?>
            </ul>
            <ul id="color">
                <?php
                    foreach($colors as $color){
                        echo '<li>'.$color.'</li>';
                    }
                ?>
            </ul>

            <div class="rating">
                <?php
                    $products = "";                    
                    for($i = 0; $i < 5; $i++){
                        if($i < floor($row['rating'])){
                            $products .= '<span class="fa fa-star checked"></span>';
                        }else{
                            $products .= '<span class="fa fa-star"></span>';
                        }
                    }   
                    echo $products;
                ?>                                                          
            </div>                                            
        </div>
    </div>


    <footer-foot></footer-foot>
    <div id="snackbar">
        <span class="material-symbols-outlined">
            info
        </span>
        Added to cart
    </div>
    <script src="./js/cart.js"></script>
    <script src="./js/snackbar.js"></script>
    <script src="./js/notif.js"></script>    
</body>
</html>