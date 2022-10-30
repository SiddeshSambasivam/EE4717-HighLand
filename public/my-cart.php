<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighLand - My Cart</title>
    <link rel="icon" href="assets/HighLand.png">    
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
            cell = row.insertCell(4);
            cell.innerHTML = '<b>Remove</b>';

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
                // insert a input with minimum value 1 with the current quantity
                cell.innerHTML = `
                    <div class="quantity-block">
                        <button class="quantity-arrow-minus qty__btn"> - </button>                        
                        <input class="quantity-num qty__input" data-index="${i}" type="number" min="1" value="${item.qty}" onchange="updateQuantity(' + i + ', this.value)">
                        <button class="quantity-arrow-plus qty__btn"> + </button>
                    </div>
                    `;                
                cell = row.insertCell(3);
                cell.innerHTML = precise(item.price * item.qty);
                cell = row.insertCell(4);
                cell.innerHTML = `<button data-index="${i}" class="remove__btn" onclick="removeItem(' + i + ')">Remove</button>`;                
                cell.style.width = '200px';                
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
    <div id="cart" class="cart__container">
        <h2>My Cart</h2>
    </div>
    <footer-foot></footer-foot> 
    <script>
        $(function() {

            (function quantityProducts() {
                
                var quantityArrowMinus = document.querySelectorAll('.quantity-arrow-minus');
                var quantityArrowPlus = document.querySelectorAll('.quantity-arrow-plus');
                var quantityNum = document.querySelectorAll('.quantity-num');

                for (var i = 0; i < quantityArrowMinus.length; i++) {
                    quantityArrowMinus[i].addEventListener('click', quantityMinus);
                    quantityArrowPlus[i].addEventListener('click', quantityPlus);
                }
                
                function updateTotal(index) {
                    var tbody = document.getElementById('cartTableBody');
                    var row = tbody.rows[index];

                    var price = parseFloat(row.cells[1].innerHTML);
                    var qty = parseInt(row.cells[2].querySelector('.quantity-num').value);
                                        
                    row.cells[3].innerHTML = precise(price * qty);

                    updateCartTotal();
                    
                }
                
                function updateCartTotal() {

                    var tbody = document.getElementById('cartTableBody');

                    var total = 0;
                    for (var i = 0; i < tbody.rows.length - 1; i++) {
                        var row = tbody.rows[i];
                        total += parseFloat(row.cells[3].innerHTML);
                    }

                    var totalRow = tbody.rows[tbody.rows.length - 1];
                    totalRow.cells[3].innerHTML = precise(total, 3);
                    
                }

                function quantityMinus() {
                    var input = this.parentNode.querySelector('.quantity-num');
                    var value = parseInt(input.value);
                    if (value > 1) {
                        value = value - 1;
                    } else {
                        value = 1;
                    }
                    input.value = value;
                    
                    var index = input.getAttribute('data-index');
                    var cartItems = JSON.parse(sessionStorage.getItem('cart'));                        
                    var item = cartItems[index];
                    item.qty = value;

                    cartItems[index] = item;                        
                    sessionStorage.setItem('cart', JSON.stringify(cartItems));       
                    
                    updateTotal(index);            
                }

                function quantityPlus() {
                    var input = this.parentNode.querySelector('.quantity-num');
                    var value = parseInt(input.value);
                    if (value < 100) {
                        value = value + 1;                        
                        
                    } else {
                        value = 100;
                    }
                    input.value = value;

                    var index = input.getAttribute('data-index');
                    var cartItems = JSON.parse(sessionStorage.getItem('cart'));                        
                    var item = cartItems[index];
                    item.qty = value;

                    cartItems[index] = item;                        
                    sessionStorage.setItem('cart', JSON.stringify(cartItems));

                    updateTotal(index);
                }
                
                var removeBtns = document.querySelectorAll('.remove__btn');
                for (var i = 0; i < removeBtns.length; i++) {
                    removeBtns[i].addEventListener('click', removeItem);
                }

                function removeItem() {

                    var cartItems = JSON.parse(sessionStorage.getItem('cart'));                    
                    var index = this.getAttribute('data-index');
                    cartItems.splice(index, 1);

                    sessionStorage.setItem('cart', JSON.stringify(cartItems));
                    window.location.href = 'my-cart.php';
                }                

            })();

        });
    </script>   
    <script src="./js/notif.js"></script>
</body>
</html>