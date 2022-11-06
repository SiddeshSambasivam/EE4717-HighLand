<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighLand - Checkout</title>
    <link rel="icon" href="assets/HighLand.png">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/style.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js/components.js"></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script>

    <script>

        function sendEmail(message) {                    
            Email.send({
                Host : "smtp.elasticemail.com",
                Username : "plutocrat45@gmail.com",
                Password : "14306467AA813E1D15DB524226715344A441",                
                To : 'plutocrat45@gmail.com',
                From : "plutocrat45@gmail.com",
                Subject : "Order Summary from HighLand",
                Body : message                
            }).then(


                //decrease stock by 1 in database


                //update transaction table


                message => {                    
                    sessionStorage.removeItem("cart");
                    window.location.href = "thank-you.php";
                });
        }  
    </script>

    <?php
        session_start();
        include("../src/db_connect.php");
        
    ?>

    <script> 
        if (sessionStorage.getItem("user_id") == null) {
            window.location.href = "login.php";
        }    

        if (sessionStorage.getItem("cart") == null) {
            window.location.href = "index.php";
        }

        function order(){

            var user_id = sessionStorage.getItem("user_id");
            
            var cart = JSON.parse(sessionStorage.getItem("cart"));
            var total_price = 0;

            for(var i = 0; i < cart.length; i++){
                total_price += cart[i].price * cart[i].qty;
            }

            var status = "0";                              
            var address = document.getElementById("address").value;

            console.log(user_id, total_price, status, address);
            

            jQuery.ajax({
                url: "handleOrder.php",
                data: {
                    user_id: user_id,
                    total_price: precise(total_price),
                    address: address,
                    status: status,                    
                    data:cart,
                },
                method: 'POST',
                success: function(data){
                    // console.log(data);

                    var message = "Thank you for your order! Your order number is " + data + ".";
                    console.log(message);
                    // send email to plutocrat45@gmail.com                    
                    // sendEmail(message);   
               
                }
            });


            // uncomment these lines to remove cart without sending email
            sessionStorage.removeItem("cart");
            window.location.href = "thank-you.php";
        }

        function precise(x) {
            return x.toPrecision(4);
        }

        function createSummary(){
            console.log('DOM loaded with JavaScript');     
            function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
}    
            
            // get cart items from session storage
            var cartItems = JSON.parse(sessionStorage.getItem('cart'));

            // create summary table
            var cart = document.getElementById('summary');
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
            cell.innerHTML = '<b>Color</b>';
            cell = row.insertCell(4);
            cell.innerHTML = '<b>Size</b>';
            cell = row.insertCell(5);
            cell.innerHTML = '<b>Total</b>';
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
                cell.innerHTML = capitalizeFirstLetter(item.color);
                cell = row.insertCell(4);                
                cell.innerHTML = item.size;
                cell = row.insertCell(5);
                cell.innerHTML = precise(item.price * item.qty);
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
            cell.innerHTML = '';  
            cell = totalRow.insertCell(4);
            cell.innerHTML = '';        
            cell = totalRow.insertCell(5);        
            cell.innerHTML = precise(total);
            
        };

        window.addEventListener("DOMContentLoaded", createSummary);
    </script>
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
    <div class="checkout__container">
        <!-- <h2>Thank you for shopping with us!</h2> -->

        <div class="checkout__container__left">
            <h2>Shipping Address</h2>
            <div>

                <div class="checkout__container__left__form">
                    <div class="checkout__container__left__form__input">
                        <label for="name">Name</label>
                        <?php
                            echo '<input type="text" required name="name" id="name" value="'.$_SESSION['name'].'">';
                        ?>                        
                    </div>
                    <div class="checkout__container__left__form__input">
                        <label for="email">Email</label>
                        <?php
                            echo '<input type="email" required name="email" id="email" value="'.$_SESSION['email'].'">';
                        ?>                        
                    </div>
                    <div class="checkout__container__left__form__input">
                        <label for="address">Address</label>
                        <?php
                            echo '<textarea type="text" required name="address" id="address">'.$_SESSION['address'].'</textarea>';
                        ?>
                        <!-- <input type="text" name="address" id="address" required> -->
                    </div>
                    <div class="checkout__container__left__form__input">
                        <label for="phone">Phone</label>
                        <?php
                            echo '<input type="text" required name="phone" id="phone" value="'.$_SESSION['phone'].'">';
                        ?>                        
                    </div>
                </div>
                
                
                <div class="checkout__container__left__form__input">
                    <button type ="submit" form="orderForm" onclick="order()" value="Order" name="submit">Order</button>
                </div>
            </div>
        </div>
    
        <!-- <div class="checkout__container__right"> -->
        <div class="checkout__container__right">
            <h2>Order Summary</h2>
            <div id="summary">            
            </div>

        </div>
        
    </div>
    
    <footer-foot></footer-foot>    
    <script src="./js/notif.js"></script>
    <script>
    </script>
</body>
</html>
