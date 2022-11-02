
function updateCartCount() {

    let cartCount = 0;
    if (sessionStorage.getItem('cart')) {
        var cart = JSON.parse(sessionStorage.getItem('cart'));

        cart.forEach(item => {
            cartCount += item.qty;
        });

    }
    document.querySelector('.number').textContent = cartCount;
}

updateCartCount();