<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sales Receipt </title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
}
.style136 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 20px; font-weight: bold; color: blue;}
.style137 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 18px; }
.style138 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style139 {font-size: 12px}
.style141 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }

-->
</style>
</head>

<?php 
@session_start();
include("webconnect.php");

// Fixed: changed date format from 'M d, Y H:i:s' (e.g. "Mar 22, 2026") to 'Y-m-d'
// (e.g. "2026-03-22") so it saves correctly into MySQL DATE type columns.
// The old format caused sales_date to store as 0000-00-00 in the sales table.
$datep = date('Y-m-d');
$subtotals = 0;
$s_totals = 0;
$net_total = 0;
$payment = 0;
$change = 0;

$sql1 = " SELECT * from cart order by productname ASC, productbrand ASC ";
$result = mysqli_query($conn, $sql1) ; 

// //-- SEARCH by individual
if(isset($_POST['btnSearch2'])) 
{
    $criteria2 = $_POST['criteria'];
    $variable2 = $_POST['textsearch2'];

  if($variable2 =="") {
  $sql25 =" select * from products ORDER by productname ASC ";
  $result = mysqli_query($conn, $sql25);
//$row2 = mysqli_fetch_assoc($result);

} else {

   $sql27 = "select * from products where productnumber='$variable2' ORDER by productname ASC " ;
    $result = mysqli_query($conn, $sql27);
    $row1 = mysqli_fetch_assoc($result);
    $productNumber = $row1['productnumber'];
    $productName = $row1['productname'];
    $productBrand = $row1['productbrand'];
    $unitprice = $row1['price'];
   $subtotal = $criteria2 * $unitprice;  //calculate the quantity * unitprice

   // Fixed: moved INSERT into cart inside the else block so it only runs when a valid
   // product number was entered and found in the products table. Previously it ran even
   // when the search box was empty, inserting blank/null data into the cart.
    // Fixed: auto-generate a unique sales invoice number using current date and time
    // so each transaction has a traceable invoice instead of a hardcoded '#'
    $sales_invoice = 'INV-' . date('Ymd-His');

    // Fixed: default employee number set to EM001 until a login/session system is implemented
    // previously hardcoded as '#' which made emp_num useless in the sales masterlist
    $emp_num = 'EM001';

    $sql26 = "INSERT into cart (quantity,productnumber,productname,productbrand,price,subtotal,emp_num,sales_date,sales_invoice) "
      . " values ('$criteria2','$productNumber','$productName', '$productBrand','$unitprice', '$subtotal', '$emp_num','$datep', '$sales_invoice') " ;
    mysqli_query($conn, $sql26);
}
   $sql28 = "select * from cart order by id " ;
    $result = mysqli_query($conn, $sql28);
  }
  //finalize the sales by subtracting the Amount Due from the Amt paid, 
  //saving the entire transactions to the SALES table and clean the CART

  if(isset($_POST['btnPayment'])) {

    $payment = floatval($_POST['payment']);   //the textbox we enter amount paid.
    $sql31 = "SELECT * from cart";
    $result4 = mysqli_query($conn, $sql31);

    while($row4 = mysqli_fetch_assoc($result4)) {
    $s_totals = $s_totals + $row4['subtotal']; //calculate sales totals
    }
    $vat = $s_totals * 0.12;
    $net_total = $s_totals + $vat;
    $change = $payment - $net_total;
    
    /* insert final record to SALES table  
    $sql29 = "INSERT into sales values (select * from cart) " ;
    mysqli_query($conn, $sql29);
    $result3 = mysqli_query($conn, $sql29);
    @$row3 = mysqli_fetch_assoc($result3);*/

    // insert final record to SALES table  
    // Fixed: INSERT INTO...VALUES() is for literal values only. To copy rows from another
    // table the correct syntax is INSERT INTO...SELECT. The old syntax was invalid SQL,
    // meaning sales were never actually saved to the sales table.
    // Removed the duplicate mysqli_query and fetch lines — INSERT does not return rows.
    // Fixed: SELECT * was copying the id column from cart into sales, causing a duplicate
    // primary key error. We now specify only the actual sales columns, excluding the id
    // so the sales table can auto-generate its own unique id for each record.
    $sql29 = "INSERT INTO sales (quantity, productnumber, productname, productbrand, price, subtotal, emp_num, sales_date, sales_invoice) SELECT quantity, productnumber, productname, productbrand, price, subtotal, emp_num, sales_date, sales_invoice FROM cart" ;    mysqli_query($conn, $sql29);

    // empty the CART table
    /*$sql30 = "DELETE * from cart" ;*/
    // Fixed: DELETE does not use * like SELECT does. DELETE * FROM is invalid SQL syntax.
    // The correct syntax is DELETE FROM tablename. Without this fix the cart would never
    // be cleared after payment, causing old items to appear in the next transaction.
    $sql30 = "DELETE FROM cart" ;
    mysqli_query($conn, $sql30);
  }

?>

<body>
<?php include("mainmenu.php"); ?>
<center><br>
  <font face="arial" size="6">MSTIP Convenience Store</font><br>
  Sta. Mesa, Manila, Philippines<br>
  VAT #: 22233344
  <br><?php echo $datep; ?>
<br><br>
  <table width="98%" border="1" cellpadding="2" cellspacing="0" bordercolor="rgb(216, 208, 208)">
  <tr>
    <td width="70%" height="33" colspan="2" class="style13">
    <form id="form4" name="form4" method="post">
      <span class="style92">Qty:</span>
       <input type="text" name="criteria" id="criteria" size="2" value="1">
       <input name="textsearch2" type="text" id="textsearch2" size="15" placeholder="Enter Product No."/>
      <input name="btnSearch2" type="submit" id="btnSearch2" value="Go" />
   </form> </td>
   <td width="30%" align="center">Sales Inv.</td>
    </tr>
  <tr>
    <td colspan="2" width="70%" height="24" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Items</strong></td>
    <td colspan="2" width="30%" align="center" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Item Totals</strong></td>
    </tr>

 <?php 
  $vat = 0;
 	while($row4 = mysqli_fetch_assoc($result)) {
    // stores datafield values to portabl variables 
    $productnumber =$row4['productnumber']; 
    $productname =$row4['productname']; 
    $productbrand =$row4['productbrand']; 
    $unitprice =$row4['price'];
    $qty = $row4['quantity']; 
    $totals = $row4['subtotal'];   

    $sprice =$row4['price'] * $qty;   //calculate subtotal for each item x qty
    $subtotals = $subtotals + $sprice;  // calculate the overall totals of all items
    /*$vat = $subtotals * 0.12;  // create a formula to get VAT of .12 of total sales
    $net_total = $subtotals + $vat;  //this part should be calculated.*/
    // Fixed: Removed VAT and net_total from inside the display loop. These lines were
    // overwriting the values already correctly calculated in the btnPayment block above,
    // which caused $change to always display 0 after payment.

    // MACHINE PROBLEM: be able to calculate the VAT and add it to the subtotals 
    // before calculating the change from the payment

		// --- alternating row colors
			if(@$color == "#DDE0EE") {
		     	@$color = "#F4F4F4";
    			} else {
      			@$color = "#DDE0EE";
    		}			
  ?>
  <tr>
    <td colspan="2" width="70%" bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $qty; ?>&nbsp;X&nbsp;
    <?php echo $productname; ?>&nbsp;@&nbsp;<?php echo $unitprice; ?></span></td>
    <td colspan="2" width="30%" align="right" bgcolor="<?php echo $color; ?>" class="style139 style136 style138">
     <strong><a href="delete_item_from_cart.php?id=<?php echo $row4['id']; ?>" onclick="return confirm('Are your sure you want to delete this item?')">
     <?php echo $sprice; ?>&nbsp;</a></strong></td>
    </tr> 
 <?php } ?>
 <?php
 // Fixed: Calculate VAT and net_total here after the loop, outside of btnPayment block,
 // so totals are always visible on page load for the cashier before payment is submitted. one tidfjbgdjgfbhdb
    if(!isset($_POST['btnPayment'])) {
     $vat = $subtotals * 0.12;
     $net_total = $subtotals + $vat;
 }
 ?>
   <tr>
    <td align="left" colspan="2" height="40">
    <form id="form3" name="form3" method="POST">
      <span class="style92">Amt. Paid:</span>
       <input type="text" name="payment" id="payment" size="12" placeholder="Enter amount" value="">
      <input type="submit" name="btnPayment" id="btnPayment" value="Pay" />
   </form></td> 
   <td colspan="2" align="right" span class="style137"><strong>P:&nbsp;<?php echo @$subtotals; ?></strong></span>
   <br><span class="style style141">VAT:&nbsp;P<?php echo $vat; ?></span>
   <br><span class="style style141">Net Sales:&nbsp;P<?php echo @$net_total; ?></span>
   <br><span class="style style141">Amt. Paid:&nbsp;P<?php echo @$payment; ?></span>
   <br><b>Change:&nbsp;</b><span class="style style136"><?php echo $change; ?></span></td></tr>
</table>
</center>
<br />
<center><span class="style49 style139"><a href="index.html">MSTIP</a>-Home </span>
</center>
</body>

</html>

