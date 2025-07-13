CREATE TABLE `rewards_pending` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `char_name` VARCHAR(50) NOT NULL,
  `item_id` INT NOT NULL,
  `amount` INT NOT NULL,
  `enchant` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);
