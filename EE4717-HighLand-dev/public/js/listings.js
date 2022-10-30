function handleSearchChange(e){
    console.log(e.value);

    var products = document.querySelectorAll('.product__card');

    products.forEach(function(product){
        var name = product.querySelector('.name').innerText;
        
        if(name.toLowerCase().indexOf(e.value.toLowerCase()) > -1){
            product.style.display = '';
        }else{
            product.style.display = 'none';
        }
    });    
}

function showAllProducts(){

    var products = document.querySelectorAll('.product__card');

    products.forEach(function(product){
        product.style.display = '';
    });

}

function handlePriceFilter(e){

    
    if(e.getAttribute('high') == "inf"){
        showAllProducts();
        return
    }
    
    var high = parseFloat(e.getAttribute('high'));
    var low = parseFloat(e.getAttribute('low'));
        
    var products = document.querySelectorAll('.product__card');
    
    products.forEach(function(product){
        
        var price = product.querySelector('.price').innerText;        
        price = price.replace('S$', '');
        
        if(price >= low && price <= high){
            product.style.display = '';

        }else{
            product.style.display = 'none';
        }
    });

}

function handleRatingFilter(e){

    if(e.getAttribute('rating') == "inf"){
        showAllProducts();
        return
    }
        
    var rating = parseFloat(e.getAttribute('rating'));
    
    var products = document.querySelectorAll('.product__card');
    
    products.forEach(function(product){
        
        var stars = product.querySelector('.rating').getAttribute('rating');
        stars = parseInt(stars);

        console.log(stars, rating);
        
        if(stars <= rating){
            product.style.display = '';
        }else{
            product.style.display = 'none';
        }
    });
}