CREATE TABLE vote_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account VARCHAR(45),
    ip_address VARCHAR(45),
    site VARCHAR(45),
    voted_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
