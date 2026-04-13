-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2026 at 10:14 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enterprise_architecture`
--hjvbvbdjv

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `productnumber`, `productname`, `productbrand`, `price`, `quantity`, `subtotal`, `emp_num`, `sales_date`, `sales_invoice`) VALUES
(1, '12321', 'CDO Conrned Beef', 'CDO', '40.00', 1, '40.00', '', '0000-00-00', ''),
(7, '12321', 'CDO Conrned Beef', 'CDO', '40.00', 1, '40.00', '', '0000-00-00', ''),
(8, '12321', 'CDO Conrned Beef', 'CDO', '40.00', 1, '40.00', '', '0000-00-00', ''),
(9, '12321', 'CDO Conrned Beef', 'CDO', '40.00', 1, '40.00', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(5) NOT NULL,
  `emp_num` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `fname` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `mname` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `lname` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `address` text COLLATE latin1_general_ci NOT NULL,
  `gender` varchar(9) COLLATE latin1_general_ci NOT NULL,
  `employment_status` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `position` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `sss` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `philhealth` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `tin` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `pagibig` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `taxcategory` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `salary` float NOT NULL,
  `rateperday` float NOT NULL,
  `photo` varchar(120) COLLATE latin1_general_ci NOT NULL,
  `cnum` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `department` varchar(70) COLLATE latin1_general_ci NOT NULL,
  `civil_status` varchar(30) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_num`, `fname`, `mname`, `lname`, `address`, `gender`, `employment_status`, `position`, `sss`, `philhealth`, `tin`, `pagibig`, `taxcategory`, `salary`, `rateperday`, `photo`, `cnum`, `email`, `department`, `civil_status`) VALUES
(116, '2021-098', 'ABEGAIL', 'S.', 'PASIA', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'pasia.webp', '', 'abegail.pasia@pcaat.edu.ph', 'FACULTY/TVL/PART-TIME', ''),
(118, '2021-003', 'AILA MARIE', 'G.', 'BATA-ANON', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'bata-anon.webp', '', 'ailamarie.bata-anon@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(119, '2021-089', 'AILONA', 'L.', 'LIPIT', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'lipit.webp', '', 'ailona.lumberio-lipt@pcaat.edu.ph', 'FACULTY/LANGUAGES AND LITERATURE', ''),
(120, '2021-035', 'AIREEN', 'M.', 'EVANGELISTA', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'evangelista.webp', '', 'aireen.evangelista@pcaat.edu.ph', 'FACULTY/BUSINESS AND SCIENCE', ''),
(122, '2021-001', 'ALLYSZA', 'N.', 'DATU', '', 'Female', '', 'Executive Assistant', '', '', '', '', '', 0, 0, '', '', 'allysza.datu@pcaat.edu.ph', 'Executive Assistant', ''),
(123, '2021-017', 'ALMHAR', 'D.', 'PANELO', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, 'panelo.webp', '', 'almhar.panelo@pcaat.edu.ph', 'FACULTY/TECHNICAL-VOCATIONAL-LIVELIHOOD', ''),
(127, '2021-001', 'ANGEL', 'L.', 'DATU', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, 'angeldatu.webp', '', 'angel.datu@pcaat.edu.ph', 'FACULTY/LANGUAGES AND LITERATURE', ''),
(128, '2021-013', 'ANGELICA', 'R.', 'ILAN', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'ilan.webp', '', 'angelica.ilan@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(131, '2021-038', 'ARIES', '', 'SEGUI', '', 'Male', '', 'Maintenance', '', '', '', '', '', 0, 0, '', '', 'aries.sigue@pcaat.edu.ph', 'Maintenance', ''),
(135, '2021-008', 'BERMIN', '', 'CAPELLAN', '', 'Female', '', 'Dept. Head B&S', '', '', '', '', '', 0, 0, 'capellan.webp', '', 'bermin.capellan@pcaat.edu.ph', 'Dept. Head, Business and Sciences', ''),
(138, '2021-045', 'CHERRY ROSE', '', 'TAGUIAM', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'taguiam.webp', '', 'cherryrose.taguiam@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(139, '2021-001', 'CHIARA REINA', '', 'DATU', '', 'Female', '', 'PRESIDENT', '', '', '', '', '', 0, 0, '', '', 'chiara.datu@pcaat.edu.ph', 'President', ''),
(140, '2021-015', 'CHRISTIAN', 'M.', 'ARELLANO', '', 'Male', '', 'OIC, PPF', '', '', '', '', '', 0, 0, 'arellano.png', '', 'christian.arellano@pcaat.edu.ph', 'OIC, PPF', ''),
(142, '2021-043', 'CLARISSA', 'S.', 'LICUAN', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'licuan.webp', '', 'clarissa.licuan@pcaat.edu.ph', 'FACULTY/LANGUAGES AND LITERATURE', ''),
(144, '2021-030', 'DANDY', 'MONTOYA', 'BONETE', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, 'bonete.webp', '', 'dandy.bonete@pcaat.edu.ph', 'FACULTY/BUSINESS AND SCIENCE', ''),
(147, '2021-033', 'DAVETTE JOHANA', '', 'GARCIA', '', 'Female', '', 'Marketing', '', '', '', '', '', 0, 0, '', '', 'davette.garcia@pcaat.edu.ph', 'Marketing', ''),
(153, '2021-036', 'EDUARD', '', 'JOSEPH', '', 'Male', '', 'Maintenance', '', '', '', '', '', 0, 0, '', '', 'eduard.joseph@pcaat.edu.ph', 'Maintenance', ''),
(160, '2021-033', 'MA. FILIPINA', '', 'GARCIA', '', 'Female', '', 'Business Development Officer', '', '', '', '', '', 0, 0, '', '', 'filipina.garcia@pcaat.edu.ph', 'Business Development Officer', ''),
(170, '2021-001', 'IDELFONSO', 'L.', 'DATU', '', 'Male', '', 'VP for Admin and Finance', '', '', '', '', '', 0, 0, 'ideldatu.webp', '', 'idel.datu@pcaat.edu.ph', 'Vice President for Administration and Finance', ''),
(171, '2021-012', 'IRIS', '', 'FRANI', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'frani.webp', '', 'iris.frani@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(180, '2021-096', 'JOSE ARIEL', 'P.', 'CLEMENTE', 'Sta. Cruz, Manila', 'Male', '', 'IT Staff', '', '', '', '', 'B', 24000, 0, 'clemente.webp', '', 'jose.clemente@pcaat.edu.ph', 'FACULTY/TECHNICAL-VOCATIONAL-LIVELIHOOD', ''),
(183, '2021-007', 'JUDY', 'G.', 'SIBAYAN', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'sibayan.webp', '', 'judy.sibayan@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(193, '2021-018', 'KYLA MARIE', '', 'PASTORAL', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'pastoral.webp', '', 'kyla.pastoral@pcaat.edu.ph', 'FACULTY/TECHNICAL-VOCATIONAL-LIVELIHOOD', ''),
(201, '2021-005', 'MAI NICOLE', 'R.', 'OLAGUER', '', 'Female', '', 'Asst. Principal', '', '', '', '', '', 0, 0, 'olaguer.webp', '', 'mai.olaguer@pcaat.edu.ph', 'ASSISTANT PRINCIPAL', ''),
(205, '2021-019', 'MARK', '', 'ELABA', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, '', '', 'mark.elaba@pcaat.edu.ph', 'FACULTY/TECHNICAL-VOCATIONAL-LIVELIHOOD', ''),
(215, '2021-009', 'MICHELLE MAE', '', 'FERNANDEZ', '', 'Female', '', 'IT Head', '', '', '', '', '', 0, 0, 'fernandez.webp', '', 'michelle.fernandez@pcaat.edu.ph', 'IT HEAD', ''),
(223, '2021-028', 'PEARL ANGELETTE', '', 'MARIANO', '', 'Female', '', 'HRD Head', '', '', '', '', '', 0, 0, 'pearlmariano.webp', '', 'pearl.mariano@pcaat.edu.ph', 'Head, HRD/ OIC, Marketing Director', ''),
(224, '2021-001', 'PERLITA', '', 'DATU', '', 'Female', '', 'Consultant', '', '', '', '', '', 0, 0, '', '', 'perlita.datu@pcaat.edu.ph', 'Internal and External Consultant', ''),
(226, '2021-027', 'PHOEBE', '', 'CLAROS', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'claros.webp', '', 'phoebe.claros@pcaat.edu.ph', 'FACULTY/LANGUAGES AND LITERATURE', ''),
(227, '2021-040', 'PRINCESS DIANE', '', 'DE GUIA', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'dequia.webp', '', 'princess.deguia@pcaat.edu.ph', 'FACULTY/TECHNICAL-VOCATIONAL-LIVELIHOOD', ''),
(229, '2021-029', 'PSALM', 'DANIEL', 'CAGUIA', '', 'Female', '', 'Registrar Staff', '', '', '', '', '', 0, 0, 'caguia.webp', '', 'psalm.caguia@pcaat.edu.ph', 'Registrar Staff', ''),
(230, '2021-024', 'REXEL IAN', '', 'REYES', '', 'Male', '', 'IT Staff', '', '', '', '', '', 0, 0, 'reyes.webp', '', 'rexel.reyes@pcaat.edu.ph', 'IT Staff', ''),
(236, '2021-026', 'RICKARDO', '', 'SANTIAGO', '', 'Male', '', 'Registrar Staff', '', '', '', '', '', 0, 0, '', '', 'rickardo.santiago@pcaat.edu.ph', 'Registrar Staff', ''),
(237, '2021-032', 'ROBERT JEROME', 'J.', 'DE VERA', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, 'devera.webp', '', 'robert.devera@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(238, '2021-011', 'ROCELINE', 'P.', 'SORIQUEZ', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'soriquez.webp', '', 'roceline.soriquez@pcaat.edu.ph', 'FACULTY/TECHNICAL-VOCATIONAL-LIVELIHOOD', ''),
(239, '2021-099', 'ROCHELLE ANN', '', 'PANA', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'pana.webp', '', 'rochell.pana@pcaat.edu.ph', 'FACULTY/BUSINESS AND SCIENCE', ''),
(245, '2021-033', 'ROWENA', '', 'GARCIA', '', 'Female', '', 'Registrar Staff', '', '', '', '', '', 0, 0, '', '', 'rowena.garcia@pcaat.edu.ph', 'Registrar Staff', ''),
(246, '2021-023', 'RUBEN', 'M.', 'DE LIMA', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, 'delima.webp', '', 'ruben.delima@pcaat.edu.ph', 'FACULTY/BUSINESS AND SCIENCE', ''),
(248, '2021-022', 'SERVANDO', '', 'CRUZ', '', 'Male', '', 'Marketing Officer', '', '', '', '', '', 0, 0, 'cruz.webp', '', 'servando.cruz@pcaat.edu.ph', 'Marketing Officer', ''),
(249, '2021-021', 'GLOLAND SHAI', '', 'DE LEON', '', 'Female', '', 'Registrar Staff', '', '', '', '', '', 0, 0, 'deleon.webp', '', 'shai.deleon@pcaat.edu.ph', 'Registrar Staff', ''),
(250, '2021-004', 'SHERINA', '', 'VILLANUEVA', '', 'Female', '', 'Department Head', '', '', '', '', '', 0, 0, 'villanueva.webp', '', 'sherina.villanueva@pcaat.edu.ph', 'Dep. Head, Language and Literature', ''),
(252, '2021-020', 'VANESSA MAE', 'A.', 'OJEDA', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'ojeda.webp', '', 'vanessamae.ojeda@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `productnumber` varchar(50) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productbrand` varchar(50) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(4) NOT NULL,
  `productstatus` varchar(20) NOT NULL,
  `photo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `productnumber`, `productname`, `productbrand`, `price`, `quantity`, `productstatus`, `photo`) VALUES
(1, '12321', 'CDO Conrned Beef', 'CDO', '40.00', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `productnumber`, `productname`, `productbrand`, `price`, `quantity`, `subtotal`, `emp_num`, `sales_date`, `sales_invoice`) VALUES
(1, '12321', 'CDO Conrned Beef', 'CDO', '40.00', 1, '40.00', '', '0000-00-00', ''),
(7, '12321', 'CDO Conrned Beef', 'CDO', '40.00', 1, '40.00', '', '0000-00-00', ''),
(8, '12321', 'CDO Conrned Beef', 'CDO', '40.00', 1, '40.00', '', '0000-00-00', ''),
(9, '12321', 'CDO Conrned Beef', 'CDO', '40.00', 1, '40.00', '', '0000-00-00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
