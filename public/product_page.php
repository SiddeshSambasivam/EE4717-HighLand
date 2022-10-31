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

    <div class="flex__container_product_page">        
            <?php 
                echo '<img class="product__page_img" src="'.$row['image'].'" alt="product image" />';
            ?>
            <h2>
                <?php 
                    echo $row['title'];
                ?>
            </h2>
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
            <p>
                <?php 
                    echo $row['description'];
                ?>
            </p>
            <h2>
                S$
                <?php 
                    echo $row['price'];
                ?>
            </h2>
            <?php
             
                
                // $colors = explode(",", $row['size']);
                // $sizes = explode(",", $row['color']);
                $sizes = preg_split ("/\,/", $row['size']); 
                $colors = preg_split ("/\,/", $row['color']); 

                echo "<div style='width:40%; display:flex; flex-direction:row ;justify-content:space-around; padding: 1rem 0rem;'>Choose the color";
                // foreach($sizes as $size){
                //     echo '<input type="radio" id="size-product" name="size-product" value="'.$size.'">Black</input>';
                // }
                for ($i = 0; $i < count($sizes); $i++) {
                    //$string .= '<div style="margin-top:50px"><a href="'.$_SERVER['PHP_SELF'].'?sizing='.$available_size[$i].'>US <br>'.$available_size[$i].'</a></div>';
                    echo '<input type="radio" required checked="checked" id="size-product" name="size-product" class="btn__product">'.$sizes[$i].'</input>';

                }
                echo "</div>";
                echo "<div style='width:40%; display:flex; flex-direction:row ;justify-content:space-around; padding: 1rem 0rem;'>Choose the size";
                // foreach($colors as $color){
                    
                //     echo '<input type="radio" id="color-product" name="color-product" class="btn__product">'.$color.'</input>';
                // }
                for ($i = 0; $i < count($colors); $i++) {
                    //$string .= '<div style="margin-top:50px"><a href="'.$_SERVER['PHP_SELF'].'?sizing='.$available_size[$i].'>US <br>'.$available_size[$i].'</a></div>';
                    echo '<input type="radio" required checked="checked" id="color-product" name="color-product" class="btn__product">'.ucfirst($colors[$i]).'</input>';

                }
                
                echo "</div>";

                echo '<a class="product__page_btn" style="margin-top:30px; margin-bottom: 50px;" onclick="handleAddCart(\''.$row["title"].'\','.$row['price'].',1,\''.$row["product_id"].'\'); callSnacker()">
                <span class="material-symbols-outlined">add</span>
                Add To Cart
                </a>';




            ?>
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