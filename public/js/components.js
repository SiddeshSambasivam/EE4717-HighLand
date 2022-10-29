
class Navbar extends HTMLElement {
    connectedCallback() {
        this.innerHTML = `
            <header class="header">
                <div class="header__top">
                    <div class="header__top_left_info">
                        <p>
                            Free shippings on all orders, 30 days return and refund policy.
                        </p>
                    </div>
                    <div class="header__top_right_cta">
                        <a href="./login.php">Sign up</a>
                        <a href="#">faqs</a>
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
        `
    }
}

class Footer extends HTMLElement {
    connectedCallback() {
        this.innerHTML = `
            <footer>
                <div class="footer">            

                    <div class="footer__row">
                        <ul>
                            <li><a href="#">Contact us</a></li>                    
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>                
                        </ul>
                    </div>

                    <div class="footer__row">
                        HighLand © 2022 - All rights reserved 
                    </div>
                </div>
            </footer>           
        `
    }
}

class ProductCard extends HTMLElement {

    connectedCallback() {

        const product_name = this.getAttribute('product_name');
        const product_price = this.getAttribute('product_price');
        const product_image = this.getAttribute('product_image');

        this.innerHTML = `
            <div class="product__card">
                <img class="product__card_img" src="${product_image}" alt="product image">
                <div class="product__info">
                    <h4>${product_name}</h4>                
                    <div class="rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <h3>$${product_price}</h3>
                </div>
            </div>            
        `
    }
}

customElements.define("footer-foot", Footer);
customElements.define("product-card", ProductCard);
customElements.define("navbar-head", Navbar);