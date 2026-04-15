--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `emp_num` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `fname` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `mname` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `lname` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `address` text COLLATE latin1_general_ci NOT NULL,
  `hire_date` date NOT NULL,
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

INSERT INTO `employees` (`id`, `emp_num`, `fname`, `mname`, `lname`, `address`, `hire_date`, `gender`, `employment_status`, `position`, `sss`, `philhealth`, `tin`, `pagibig`, `taxcategory`, `salary`, `rateperday`, `photo`, `cnum`, `email`, `department`, `civil_status`) VALUES
(1, '2021-001', 'ABEGAIL', 'S.', 'PASIA', 'Quezon City', '2021-01-10', 'Female', 'Regular', 'Cashier', 'SSS-1001', 'PH-1001', 'TIN-1001', 'PAG-1001', 'B', 25000, 1200, 'pasia.webp', '09170000001', 'abegail.pasia@pcaat.edu.ph', 'Cashier / Front End', 'Single'),
(2, '2021-002', 'AILA MARIE', 'G.', 'BATA-ANON', 'Manila', '2021-02-18', 'Female', 'Regular', 'Stock Clerk', 'SSS-1002', 'PH-1002', 'TIN-1002', 'PAG-1002', 'B', 25000, 1200, 'bata-anon.webp', '09170000002', 'ailamarie.bata-anon@pcaat.edu.ph', 'Grocery / Dry Goods', 'Single'),
(3, '2021-003', 'AILONA', 'L.', 'LIPIT', 'Pasig City', '2021-03-25', 'Female', 'Regular', 'Bakery Staff', 'SSS-1003', 'PH-1003', 'TIN-1003', 'PAG-1003', 'B', 25000, 1200, 'lipit.webp', '09170000003', 'ailona.lumberio-lipt@pcaat.edu.ph', 'Bakery Department', 'Single'),
(4, '2021-004', 'AIREEN', 'M.', 'EVANGELISTA', 'Quezon City', '2021-04-12', 'Female', 'Regular', 'Produce Clerk', 'SSS-1004', 'PH-1004', 'TIN-1004', 'PAG-1004', 'B', 25000, 1200, 'evangelista.webp', '09170000004', 'aireen.evangelista@pcaat.edu.ph', 'Produce Department', 'Married'),
(5, '2021-005', 'ALLYSZA', 'N.', 'DATU', 'Manila', '2021-05-07', 'Female', 'Regular', 'Store Manager', 'SSS-1005', 'PH-1005', 'TIN-1005', 'PAG-1005', 'B', 30000, 1500, '', '09170000005', 'allysza.datu@pcaat.edu.ph', 'Management', 'Single'),
(6, '2021-006', 'ARIES', '', 'SEGUI', 'Quezon City', '2021-06-01', 'Male', 'Contractual', 'Maintenance', 'SSS-1006', 'PH-1006', 'TIN-1006', 'PAG-1006', 'C', 18000, 800, '', '09170000006', 'aries.sigue@pcaat.edu.ph', 'Maintenance', 'Single'),
(7, '2021-007', 'CHIARA REINA', '', 'DATU', 'Manila', '2021-07-22', 'Female', 'Regular', 'Store Owner / Admin', 'SSS-1007', 'PH-1007', 'TIN-1007', 'PAG-1007', 'A', 80000, 4000, '', '09170000007', 'chiara.datu@pcaat.edu.ph', 'Management', 'Single'),
(8, '2021-008', 'DAVETTE JOHANA', '', 'GARCIA', 'Pasig City', '2021-08-15', 'Female', 'Contractual', 'Marketing Staff', 'SSS-1008', 'PH-1008', 'TIN-1008', 'PAG-1008', 'B', 22000, 1000, '', '09170000008', 'davette.garcia@pcaat.edu.ph', 'Marketing', 'Single'),
(9, '2021-009', 'EDUARD', '', 'JOSEPH', 'Quezon City', '2021-09-10', 'Male', 'Contractual', 'Maintenance Staff', 'SSS-1009', 'PH-1009', 'TIN-1009', 'PAG-1009', 'C', 18000, 800, '', '09170000009', 'eduard.joseph@pcaat.edu.ph', 'Maintenance', 'Single'),
(10, '2021-010', 'MA. FILIPINA', '', 'GARCIA', 'Manila', '2021-10-05', 'Female', 'Regular', 'Inventory Officer', 'SSS-1010', 'PH-1010', 'TIN-1010', 'PAG-1010', 'B', 28000, 1300, '', '09170000010', 'filipina.garcia@pcaat.edu.ph', 'Warehouse / Receiving', 'Married'),
(11, '2021-011', 'JOSE ARIEL', 'P.', 'CLEMENTE', 'Sta. Cruz, Manila', '2021-11-03', 'Male', 'Regular', 'IT Support', 'SSS-1011', 'PH-1011', 'TIN-1011', 'PAG-1011', 'B', 24000, 1200, 'clemente.webp', '09170000011', 'jose.clemente@pcaat.edu.ph', 'Warehouse / Receiving', 'Single'),
(12, '2021-012', 'MICHELLE MAE', '', 'FERNANDEZ', 'Quezon City', '2021-12-13', 'Female', 'Regular', 'Supervisor', 'SSS-1012', 'PH-1012', 'TIN-1012', 'PAG-1012', 'A', 45000, 2200, 'fernandez.webp', '09170000012', 'michelle.fernandez@pcaat.edu.ph', 'Management', 'Married'),
(13, '2021-013', 'PEARL ANGELETTE', '', 'MARIANO', 'Manila', '2021-12-21', 'Female', 'Regular', 'HR Staff', 'SSS-1013', 'PH-1013', 'TIN-1013', 'PAG-1013', 'A', 40000, 2000, 'pearlmariano.webp', '09170000013', 'pearl.mariano@pcaat.edu.ph', 'Cashier / Front End', 'Single'),
(14, '2021-014', 'RICKARDO', '', 'SANTIAGO', 'Pasig City', '2021-12-28', 'Male', 'Regular', 'Stock Clerk', 'SSS-1014', 'PH-1014', 'TIN-1014', 'PAG-1014', 'B', 20000, 900, '', '09170000014', 'rickardo.santiago@pcaat.edu.ph', 'Grocery / Dry Goods', 'Single'),
(15, '2021-015', 'SERVANDO', '', 'CRUZ', 'Quezon City', '2021-12-30', 'Male', 'Regular', 'Marketing Officer', 'SSS-1015', 'PH-1015', 'TIN-1015', 'PAG-1015', 'B', 23000, 1100, 'cruz.webp', '09170000015', 'servando.cruz@pcaat.edu.ph', 'Marketing', 'Married');
--
-- Indexes for table `employees`
--

ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `employees`
--

ALTER TABLE `employees`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
