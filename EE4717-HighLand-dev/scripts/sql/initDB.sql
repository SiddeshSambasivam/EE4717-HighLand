CREATE DATABASE HighLand;

USE HighLand;

CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE credentials (
    user_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE products (
    product_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) NOT NULL,    
    image VARCHAR(255) NOT NULL,
    items_in_stock INT NOT NULL,
    category VARCHAR(255) NOT NULL,
    
    rating DECIMAL(2,1) NOT NULL,            
    color VARCHAR(255) NOT NULL,
    size VARCHAR(255) NOT NULL,

    -- For product tags such as "new", "sale", "best seller"
    tags VARCHAR(255) NOT NULL,

    PRIMARY KEY (product_id)
);

CREATE TABLE product_images (
    product_id INT NOT NULL,
    image_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    PRIMARY KEY (product_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

CREATE TABLE orders (
    order_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    order_date DATETIME NOT NULL,
    status ENUM('0', '1', '2') NOT NULL,
    address VARCHAR(255) NOT NULL,
    PRIMARY KEY (order_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- NOTE: `order_items` table act as a join-table between `orders` and `products` tables
CREATE TABLE order_items (
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);
