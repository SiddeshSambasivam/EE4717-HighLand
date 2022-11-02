
function handleAddCart(product, price, qty, id, size, color){

    console.log(product, price, qty, id, size, color);
    
    let cart = JSON.parse(sessionStorage.getItem('cart'));
    if(cart == null){
        cart = [];
    }

    let productInCart = cart.find(item => item.product == product);    
    let index = cart.indexOf(productInCart);


    if(productInCart == null){
        cart.push({ 
            id: id,           
            product: product,
            price: price,
            qty: qty,
            size: size,
            color:color
        });
    }
    else{
        productInCart.qty += qty;
        cart[index] = productInCart;
    }

    sessionStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();

}