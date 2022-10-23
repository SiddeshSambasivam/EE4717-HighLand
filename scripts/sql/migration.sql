USE HighLand;

INSERT INTO users (email, phone, name, address) VALUES
    ('siddesh.test@test.com', '1234567890', 'Siddesh', '123, Test Street, Test City, Test State, Test Country');

INSERT INTO credentials (user_id, email, password) VALUES
    (1, 'siddesh.test@test.com', 'test123');

INSERT INTO products (title, price, description, image, items_in_stock, rating, category, color, size, tags) VALUES
    ('Test Product 1', 100.00, 'This is a test product', '/assets/test_image.svg', 10, 4.5, 'test', 'test', 'test', 'test'),
    ('Test Product 2', 200.00, 'This is a test product', '/assets/test_image.svg', 20, 4.5, 'test', 'test', 'test', 'test'),
    ('Test Product 3', 300.00, 'This is a test product', '/assets/test_image.svg', 30, 4.5, 'test', 'test', 'test', 'test');

INSERT INTO product_images (product_id, image_id, image_url) VALUES
    (1, 1, '/assets/test_image.svg'),    
    (2, 1, '/assets/test_image.svg'),    
    (3, 1, '/assets/test_image.svg');    

INSERT INTO orders (user_id, total_price, order_date, status, address) VALUES
    (1, 100.00, '2022-10-23 00:00:00', '0', '123, Test Street, Test City, Test State, Test Country'),
    (1, 200.00, '2020-10-23 00:00:00', '1', '123, Test Street, Test City, Test State, Test Country'),
    (1, 300.00, '2022-10-23 00:00:00', '2', '123, Test Street, Test City, Test State, Test Country');

INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
    (1, 1, 1, 100.00),
    (2, 2, 2, 200.00),
    (3, 3, 3, 300.00);
