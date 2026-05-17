
CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `productnumber` varchar(50) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productbrand` varchar(50) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(4) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `emp_num` varchar(12) NOT NULL,
  `sales_date` date NOT NULL,
  `sales_invoice` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cart` (`id`, `productnumber`, `productname`, `productbrand`, `price`, `quantity`, `subtotal`, `emp_num`, `sales_date`, `sales_invoice`) VALUES
(16, '12390', 'Sanmarino', '', 35.00, 1, 35.00, '', '2026-04-22', ''),
(17, '12390', 'Sanmarino', '', 35.00, 15, 525.00, '', '2026-04-22', '');


CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `productnumber` varchar(50) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productbrand` varchar(50) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(4) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `emp_num` varchar(12) NOT NULL,
  `sales_date` date NOT NULL,
  `sales_invoice` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `sales` (`id`, `productnumber`, `productname`, `productbrand`, `price`, `quantity`, `subtotal`, `emp_num`, `sales_date`, `sales_invoice`) VALUES
(1, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(7, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(8, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(9, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(10, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(11, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(12, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(13, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(14, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768599'),
(15, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768599'),
(16, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768599'),
(17, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768600'),
(18, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768600'),
(19, '', 'Sanmarino', '', 35.00, 100, 3500.00, '6', '2026-04-22', 'INV-17768600');


