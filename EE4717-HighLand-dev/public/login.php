<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighLand - Sign In</title>
    <link rel="icon" href="assets/HighLand.png">    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js/components.js"></script>   
    <?php
        session_start();
    
        function handleSignIn(){
            include("../src/db_connect.php");
    
            if (isset($_POST['email']) && isset($_POST['password']))
            {
                $email = $_POST['email'];
                $password = $_POST['password'];
                
                $password = md5($password);                    
                $query = "SELECT * from `credentials` WHERE `email`='$email' AND `password`='$password'";
                
                $result = $conn->query($query);
                if ($result->num_rows >0 )
                {                         
                    $row = $result->fetch_assoc();
                    $uid = $row['user_id'];
                    
                    $query = "SELECT * from `users` WHERE `user_id`='$uid'";
                    $result = $conn->query($query);
                    $row = $result->fetch_assoc();
                                        
                    $_SESSION['user_id'] = $uid;
                    $_SESSION['email'] = $email;

                    $_SESSION['name'] = $row['name'];
                    $_SESSION['phone'] = $row['phone'];
                    $_SESSION['address'] = $row['address'];

                    unset($_SESSION['login_error']);
                }    
                else{                    
                    $_SESSION['login_error'] = "Invalid email or password";
                    unset($_SESSION['user_id']);       
                }    
            }        

            $conn->close();
                        
        }

        function handleSignUp(){
            include("../src/db_connect.php");
            
            if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address'])){

                $email = $_POST['email'];
                $query = "SELECT * from `credentials` WHERE `email`='$email'";
                $result = $conn->query($query);

                if($result->num_rows > 0){
                    $_SESSION['signup_error'] = "Email already exists";
                    unset($_SESSION['user_id']);
                    return;
                }

                $password = $_POST['password'];
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];

                $password = md5($password);

                $query = "INSERT INTO `users` (`name`, `email`, `phone`, `address`) VALUES ('$name', '$email', '$phone', '$address')";
                $result = $conn->query($query);
                $uid = $conn->insert_id;

                $query = "INSERT INTO `credentials` (`user_id`, `email`, `password`) VALUES ('$uid', '$email', '$password')";
                $result = $conn->query($query);

                $_SESSION['user_id'] = $uid;
                $_SESSION['email'] = $email;

                $_SESSION['name'] = $name;
                $_SESSION['phone'] = $phone;
                $_SESSION['address'] = $address;

                unset($_SESSION['signup_error']);
                
                // echo a script tag to store the user_id in the session storage
                
                header("Location: login.php");

            }else{
                $_SESSION['signup_error'] = "Please fill all the fields";
                unset($_SESSION['user_id']);
            }

        }
        
        if (isset($_POST['signin'])){
            handleSignIn();
        } elseif (isset($_POST['signup'])){
            handleSignUp();
        }

        if(isset($_SESSION['user_id'])){
            echo '<script>sessionStorage.setItem("user_id", "'.$_SESSION['user_id'].'");</script>';            
        }else{
            echo "<script>sessionStorage.removeItem('user_id');</script>";
        }
        
    ?>

    <script>                
        handleLogout = () => {      
            sessionStorage.removeItem("user_id");      
            $.ajax({
                url: "./logout.php",
                success: function(data){
                    window.location.href = "./index.php";
                }
            });
        }
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
    <div class="auth__container">        
        <?php
            if (isset($_SESSION['user_id']))
            {
                echo '<div class="user__profile"><h1> You are logged in as: '. $_SESSION['name'] . '</h1>';
                echo '<button onclick="handleLogout()">Log out</button></div>';
            }
            else
            {         
                echo '
                <div class="container" id="container">
                    <div class="form-container sign-up-container">
                        <form method="post" action="./login.php">
                            <h1 class="headings-1">Create Account</h1>                
                            <input required type="text" name="name" placeholder="Name" />
                            <input required type="email" name="email" placeholder="Email" />
                            <input type="text" name="phone" placeholder="Phone number" />
                            <input type="text" name="address" placeholder="Address" />
                            <input required type="password" name="password" placeholder="Password" />
                            <input type="hidden" name="signup" value=""/>
                            <button>Sign Up</button>
                            ';
                if(isset($_SESSION["signup_error"])){
                    echo '<p style="padding-top:0.5rem; color:red">'.$_SESSION["signup_error"] .' </p>';
                }                
                echo '
                        </form>
                    </div>
                    <div class="form-container sign-in-container">
                        <form method="post" action="./login.php">
                            <h1 class="headings-1">Sign in</h1>
                            <input required type="email" name="email" placeholder="Email" />
                            <input required type="password" name="password" placeholder="Password" />                
                            <input type="hidden" name="signin" value=""/>
                            <button>Sign In</button>';
                if(isset($_SESSION["login_error"])){
                    echo '<p style="padding-top:0.5rem; color:red">'.$_SESSION["login_error"] .' </p>';
                }                                      
                echo '
                        </form>
                    </div>
                    <div class="overlay-container">
                        <div class="overlay">
                            <div class="overlay-panel overlay-left">
                                <h1 class="headings-1">Welcome Back!</h1>
                                <p class="info-text">To continue shopping with us please login to your account</p>
                                <button class="ghost" id="signIn">Sign In</button>
                            </div>                    
                            <div class="overlay-panel overlay-right">
                                <h1 class="headings-1">Hello there!</h1>
                                <p class="info-text">Create your personal account and start shopping with us</p>
                                <button class="ghost" id="signUp">Sign Up</button>
                            </div>
                        </div>
                    </div>
                </div>       
                ';                         
            }
        ?>        
    </div>
    <footer-foot></footer-foot>
    <script src="./js/login.js"></script>
    <script src="./js/notif.js"></script>
</body>
</html>