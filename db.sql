DROP DATABASE IF EXISTS ccbst;

CREATE DATABASE ccbst;
USE ccbst;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10, 2),
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
	id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (order_id) REFERENCES orders(id)
    
);

INSERT INTO ccbst.products (name, price, description, image) VALUES
('Product A', 10.00, 'Description for Product A.', 'uploads/a.jpeg'),
('Product B', 15.50, 'Description for Product B.', 'uploads/b.jpeg'),
('Product C', 20.99, 'Description for Product C.', 'uploads/c.jpeg'),
('Product D', 25.00, 'Description for Product D.', 'uploads/d.jpeg'),
('Product E', 30.00, 'Description for Product E.', 'uploads/e.jpeg');

-- INSERT INTO ccbst.users (name, email, password) VALUES
-- ('admin', 'admin@admin.com', 'admin');