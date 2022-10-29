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
    ?>
</head>
<body>
    <navbar-head></navbar-head>    
    <section class="hero set-bg" id="hero"></section>
    <section class="products-container" id="products">   
        <?php
            include("../src/db_connect.php");    

            $sql = "SELECT * FROM `products`";
            $result = $conn->query($sql);
            $conn->close();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {                
                    $products .= "<product-card product_name='" . $row["title"] . "' product_price='" . $row["price"] . "' product_image='" . $row["image"] . "' /></product-card>";                
                }
            } else {
                $products = "0 results";
            }                        

            echo $products;
        ?>
    </section>                        
    <footer-foot></footer-foot>
</body>
</html>