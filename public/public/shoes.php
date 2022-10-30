<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighLand - Shoes</title>
    <link rel="icon" href="assets/HighLand.png">    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="./js/components.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <?php        
        include("../src/db_connect.php");    
        
        session_start();

        $sql = "SELECT COUNT(*) FROM products WHERE `category` = 'shoes'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $num_products = $row['COUNT(*)'];            
        $conn->close();
        
        $results_per_page = 9;
        $number_of_results = $num_products;

        $number_of_pages = ceil($number_of_results/$results_per_page);

        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }

        $this_page_first_result = ($page-1)*$results_per_page;


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
    <div class="main-container">
        <div class="query__panel">
                        
            <h2>Shoes</h2>

            <input type="text" id="search" onchange="handleSearchChange(this)"  placeholder="Search for products" />

            <!-- toggle drop down -->            
            <h3>Filter by price</h3>
            <button onclick="handlePriceFilter(this)" low="0" high="50">S$0.00-S$50.00</button>
            <button onclick="handlePriceFilter(this)" low="50" high="100">S$50.00-S$100.00</button>
            <button onclick="handlePriceFilter(this)" low="100" high="200">S$100.00-S$200.00</button>
            <button onclick="handlePriceFilter(this)" low="200" high="250">S$200.00-S$250.00</button>
            <button onclick="handlePriceFilter(this)" low="0" high="inf">Remove filter</button>

            <h3>Filter by rating</h3>
            <button onclick="handleRatingFilter(this)" rating="1">1 Star</button>
            <button onclick="handleRatingFilter(this)" rating="2">2 Stars</button>
            <button onclick="handleRatingFilter(this)" rating="3">3 Stars</button>
            <button onclick="handleRatingFilter(this)" rating="4">4 Stars</button>
            <button onclick="handleRatingFilter(this)" rating="5">5 Stars</button>
            <button onclick="handleRatingFilter(this)" rating="inf">Remove filter</button>
        </div>
        <div class="products">
            <div class="listings__info_pag">
                <?php
                    echo "Showing ".($this_page_first_result + 1)." to ".($this_page_first_result + $results_per_page)." of ".$number_of_results." results";
                ?>                
            </div>
            <div class="listings-container" id="products-list">                            
                <?php

                    include("../src/db_connect.php");    
                    $sql = "SELECT * FROM `products` WHERE `category` = 'shoes' LIMIT ".$this_page_first_result.",".$results_per_page;
                    $result = $conn->query($sql);
                    $conn->close();
                    $products='';
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
                                        <h4 class="name">'.$row['title'].'</h4>                                    
                                        <div class="rating" rating='.$row["rating"].'>';

                            for($i = 0; $i < 5; $i++){
                                if($i < $row['rating']){
                                    $products .= '<span class="fa fa-star checked"></span>';
                                }else{
                                    $products .= '<span class="fa fa-star"></span>';
                                }
                            }
                            
                            $products .= '                    
                                        </div>
                                        <h3 class="price">S$'.$row['price'].'</h3>
                                    </div>
                                </div>';
                        }
                    } else {
                        $products = "0 results";
                    }                        

                    echo $products;
                ?>
            </div>        
            <?php                

                if($number_of_pages>1){                                        
                    echo '<div class="pagination__container">';
                    for($page = 1; $page <= $number_of_pages; $page++){
                        echo '<a class="pagination__link" href="clothing.php?page='.$page.'">'.$page.'</a>';
                    }
                    echo '</div>';
                }
            ?>                                        
        </div>
    </div>
    <footer-foot></footer-foot>
    <div id="snackbar">
        <span class="material-symbols-outlined">
            info
        </span>
        Added to cart
    </div>
    <script src="./js/listings.js"></script>
    <script src="./js/cart.js"></script>
    <script src="./js/snackbar.js"></script>    
</body>
</html>