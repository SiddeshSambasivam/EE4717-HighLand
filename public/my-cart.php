<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighLand - Clothing</title>
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js/components.js"></script>
    <?php
        session_start();
    ?>
    <script>
        function precise(x) {
            return x.toPrecision(4);
        }
        function loadCart() {
            console.log('DOM loaded with JavaScript');
                
            var cartItems = JSON.parse(sessionStorage.getItem('cart'));
            if (cartItems == null || cartItems.length == 0) {
                document.getElementById('cart').innerHTML = '<div align="center" style="padding-top:10rem"><span class="material-symbols-outlined cart__info_sbl">report</span></div><h2 align="center" style="padding-top:1rem">Cart is empty!</h2><p align="center" style="padding-top:0.5rem;font-size:1.2rem;">Please add products to cart to checkout.</p><a align="center" class="cart__invalid_info" href="./index.php">🛒 Return to shopping</a>';                
                return;
            }

            var cart = document.getElementById('cart');
            var total = 0;
            
            var table = document.createElement('table');
            table.setAttribute('id', 'cartTable');
            table.setAttribute('class', 'cartTable');
            var header = table.createTHead();
            var row = header.insertRow(0);
            var cell = row.insertCell(0);
            cell.innerHTML = '<b>Product</b>';
            cell = row.insertCell(1);
            cell.innerHTML = '<b>Price</b>';
            cell = row.insertCell(2);
            cell.innerHTML = '<b>Quantity</b>';
            cell = row.insertCell(3);
            cell.innerHTML = '<b>Total</b>';
            // cell = row.insertCell(4);
            // cell.innerHTML = '<b>Remove</b>';

            var tbody = document.createElement('tbody');
            tbody.setAttribute('id', 'cartTableBody');
            table.appendChild(tbody);

            for (var i = 0; i < cartItems.length; i++) {
                var item = cartItems[i];
                var row = tbody.insertRow(i);
                var cell = row.insertCell(0);
                cell.innerHTML = item.product;
                cell = row.insertCell(1);
                cell.innerHTML = precise(item.price);
                cell = row.insertCell(2);
                cell.innerHTML = item.qty;
                cell = row.insertCell(3);
                cell.innerHTML = precise(item.price * item.qty);
                // cell = row.insertCell(4);
                // cell.innerHTML = '<button onclick="removeItem(' + i + ')">Remove</button>';
                total += item.price * item.qty;
            }

            cart.appendChild(table);

            var totalRow = tbody.insertRow(cartItems.length);
            var cell = totalRow.insertCell(0);
            cell.innerHTML = '<b>Total</b>';
            cell = totalRow.insertCell(1);
            cell.innerHTML = '';
            cell = totalRow.insertCell(2);
            cell.innerHTML = '';
            cell = totalRow.insertCell(3);
            cell.innerHTML = precise(total);

            var checkout = document.createElement('button');
            checkout.setAttribute('id', 'checkout');
            checkout.setAttribute('class', 'checkout__btn');
            checkout.innerHTML = 'Checkout';
            checkout.addEventListener('click', function() {
                window.location.href = 'checkout.php';
            });

            cart.appendChild(checkout);                
        
        }

        window.addEventListener('DOMContentLoaded', loadCart);

    </script>
</head>
<body>
    <!-- <navbar-head></navbar-head> -->
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
    <div id="cart" class="cart__container">
        <h2>My Cart</h2>
    </div>
    <footer-foot></footer-foot>    
</body>
</html>