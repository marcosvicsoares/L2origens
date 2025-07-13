CREATE TABLE items_delayed (
    id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT NOT NULL,
    item_id INT NOT NULL,
    count BIGINT NOT NULL DEFAULT 1,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
