<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sales Receipt</title>
<style type="text/css">
  .style138 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;}
  .style141 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px;}
  .style136 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; color: blue; font-size: 18px;}
</style>
</head>

<?php 
@session_start();
include("webconnect.php");
date_default_timezone_set('Asia/Manila');

// 1. KUNIN ANG SESSION NG EMPLOYEE NUMBER
// Kung ayaw pa rin magbago mula sa '6', i-check ang iyong Login Page logic.
$current_emp = isset($_SESSION['login_emp_num']) ? $_SESSION['login_emp_num'] : '6'; 

// TEST LINE: Burahin ang "//" sa ibaba para i-force ang ID at i-test kung magbabago sa Sales Masterlist
// $current_emp = '2021-009'; 

$datep = date('Y-m-d');
$subtotals = 0;
$payment = 0;
$change = 0;

// ADD TO CART LOGIC
if(isset($_POST['btnSearch2'])) {
    $qty_in = $_POST['criteria'];
    $prod_id = $_POST['textsearch2'];

    if($prod_id != "") {
        $get_prod = mysqli_query($conn, "SELECT * FROM products WHERE productnumber='$prod_id'");
        $p = mysqli_fetch_assoc($get_prod);
        
        if($p) {
            $pName = $p['productname'];
            $price = $p['price'];
            $sub = $qty_in * $price;
            mysqli_query($conn, "INSERT INTO cart (quantity, productnumber, productname, price, subtotal, sales_date) 
                                VALUES ('$qty_in', '$prod_id', '$pName', '$price', '$sub', '$datep')");
        }
    }
}

// 2. PAYMENT LOGIC
if(isset($_POST['btnPayment'])) {
    $payment = floatval($_POST['payment']);
    
    $check_cart = mysqli_query($conn, "SELECT SUM(subtotal) as total FROM cart");
    $c_row = mysqli_fetch_assoc($check_cart);
    $net_sales = $c_row['total'];
    $vat = $net_sales * 0.12;
    $grand_total = $net_sales + $vat;
    
    if($payment >= $grand_total && $grand_total > 0) {
        $change = $payment - $grand_total;
        $inv_no = 'INV-' . time();

        $get_all_cart = mysqli_query($conn, "SELECT * FROM cart");
        while($row = mysqli_fetch_assoc($get_all_cart)) {
            $name = $row['productname'];
            $q = $row['quantity'];
            $pr = $row['price'];
            $st = $row['subtotal'];
            
            // DITO IPAPASOK ANG DYNAMIC EMP_NUM
            mysqli_query($conn, "INSERT INTO sales (sales_inv, sales_date, product_name, quantity, unit_price, sub_total, emp_num) 
                                VALUES ('$inv_no', NOW(), '$name', '$q', '$pr', '$st', '$current_emp')");
        }
        
        mysqli_query($conn, "DELETE FROM cart"); 

        // POP-UP ALERT PAGKATAPOS NG TRANSACTION
        echo "<script>alert('Transaction Successful! \\nChange: P " . number_format($change, 2) . "');</script>";
        
    } elseif ($grand_total > 0) {
        echo "<script>alert('Insufficient Amount! Please pay the correct total.');</script>";
    }
}

$cart_display = mysqli_query($conn, "SELECT * FROM cart ORDER BY id ASC");
?>

<body>
<?php include("mainmenu.php"); ?>
<center><br>
  <font face="arial" size="6">MSTIP Convenience Store</font><br>
  Sta. Mesa, Manila, Philippines<br>
  VAT #: 22233344<br>
  <?php echo date('M d, Y'); ?>
<br><br>
  <table width="98%" border="1" cellpadding="2" cellspacing="0" bordercolor="green">
  <tr>
    <td width="70%" height="33" colspan="2">
    <form method="post">
      <span class="style138">Qty:</span>
      <input type="text" name="criteria" size="2" value="1">
      <input name="textsearch2" type="text" size="15" placeholder="Enter Product No." autofocus/>
      <input name="btnSearch2" type="submit" value="Go" />
    </form> </td>
    <td width="30%" align="center" class="style138">Sales Inv.</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#E0E8F1" class="style141">Items</td>
    <td align="center" bgcolor="#E0E8F1" class="style141">Item Totals</td>
  </tr>

 <?php 
  while($item = mysqli_fetch_assoc($cart_display)) {
    $subtotals += $item['subtotal'];
 ?>
  <tr>
    <td colspan="2" class="style138">
        <?php echo $item['quantity']; ?> X <?php echo $item['productname']; ?> @ <?php echo number_format($item['price'], 2); ?>
    </td>
    <td align="right" class="style138" style="color: blue;">
        P <?php echo number_format($item['subtotal'], 2); ?>
    </td>
  </tr> 
 <?php } ?>

  <tr>
    <td align="left" colspan="2" height="40">
        <form method="POST">
          <span class="style138">Amt. Paid:</span>
          <input type="text" name="payment" size="12" placeholder="Enter amount">
          <input type="submit" name="btnPayment" value="Pay" />
        </form>
    </td> 
    <td align="right">
        <?php 
            $v_amt = $subtotals * 0.12;
            $g_amt = $subtotals + $v_amt;
        ?>
        <span class="style138"><strong>Total: P <?php echo number_format($subtotals, 2); ?></strong></span><br>
        <span class="style138">VAT (12%): P <?php echo number_format($v_amt, 2); ?></span><br>
        <span class="style141">Amount Due: P <?php echo number_format($g_amt, 2); ?></span><br>
        <span class="style138">Amt. Paid: P <?php echo number_format($payment, 2); ?></span><br>
        <span class="style136">Change: P <?php echo number_format($change, 2); ?></span>
    </td>
  </tr>
</table>
</center>
<br />
<center><span class="style138"><a href="index.php">MSTIP</a>-Home </span></center>
</body>
</html>