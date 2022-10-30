
function handleAddCart(product, price, qty){

    console.log(product, price, qty);
    
    let cart = JSON.parse(sessionStorage.getItem('cart'));
    if(cart == null){
        cart = [];
    }

    let productInCart = cart.find(item => item.product == product);    
    let index = cart.indexOf(productInCart);


    if(productInCart == null){
        cart.push({
            product: product,
            price: price,
            qty: qty
        });
    }
    else{
        productInCart.qty += qty;
        cart[index] = productInCart;
    }

    sessionStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();

}