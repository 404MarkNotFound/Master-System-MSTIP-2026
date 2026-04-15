-- Inventory SQL Schema Dump
-- Table structure for table `products`
-- Run: mysql -u youruser -p yourdb < inventory.sql

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productnumber` varchar(50) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `productbrand` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `productstatus` enum('Active','Inactive','Out of Stock') NOT NULL DEFAULT 'Active',
  `photo` text DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL COMMENT 'Category/Description (legacy)',
  `qty` int(11) DEFAULT NULL COMMENT 'Legacy qty alias',
  PRIMARY KEY (`id`),
  UNIQUE KEY `productnumber` (`productnumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Products for Inventory Management';

-- Optional: Sample data
/*
INSERT INTO `products` (`productnumber`, `productname`, `productbrand`, `price`, `quantity`, `productstatus`, `photo`, `lastname`) VALUES
('P001', 'Laptop Dell', 'Dell', 999.99, 10, 'Active', 'uploads/products/p001.jpg', 'Electronics'),
('P002', 'Mouse Logitech', 'Logitech', 25.50, 50, 'Active', NULL, 'Accessories');
*/

