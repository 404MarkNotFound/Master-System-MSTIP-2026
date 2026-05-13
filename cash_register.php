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

$current_emp = isset($_SESSION['login_emp_num']) ? $_SESSION['login_emp_num'] : '6'; 
$datep = date('Y-m-d');
$subtotals = 0;
$payment = 0;
$change = 0;

// 1. ADD TO CART LOGIC
if(isset($_POST['btnSearch2'])) {
    $qty_in = intval($_POST['criteria']);
    $prod_id = mysqli_real_escape_string($conn, $_POST['textsearch2']);

    if($prod_id != "" && $qty_in > 0) {
        $get_prod = mysqli_query($conn, "SELECT * FROM products WHERE productnumber='$prod_id'");
        $p = mysqli_fetch_assoc($get_prod);
        
        if($p) {
            $db_stock = intval($p['quantity']); 
            if($db_stock >= $qty_in) {
                $pName = $p['productname'];
                $price = $p['price'];
                $sub = $qty_in * $price;
                mysqli_query($conn, "INSERT INTO cart (quantity, productnumber, productname, price, subtotal, sales_date) 
                                    VALUES ('$qty_in', '$prod_id', '$pName', '$price', '$sub', '$datep')");
            } else {
                echo "<script>alert('Error: Out of Stock!');</script>";
            }
        }
    }
}

// 2. PAYMENT LOGIC
if(isset($_POST['btnPayment'])) {
    $payment = floatval($_POST['payment']);
    $check_cart = mysqli_query($conn, "SELECT SUM(subtotal) as total FROM cart");
    $c_row = mysqli_fetch_assoc($check_cart);
    $total_due = $c_row['total'] * 1.12;

    if($payment >= $total_due && $total_due > 0) {
        $change = $payment - $total_due;
        $inv_no = 'INV-' . time();
        $get_cart = mysqli_query($conn, "SELECT * FROM cart");
        
        while($rc = mysqli_fetch_assoc($get_cart)){
            $pnum = $rc['productnumber'];
            $qnt = $rc['quantity'];
            mysqli_query($conn, "UPDATE products SET quantity = quantity - $qnt WHERE productnumber = '$pnum'");
            mysqli_query($conn, "INSERT INTO sales (sales_invoice, sales_date, productname, quantity, price, subtotal, emp_num) 
                                VALUES ('$inv_no', NOW(), '{$rc['productname']}', '$qnt', '{$rc['price']}', '{$rc['subtotal']}', '$current_emp')");
        }
        mysqli_query($conn, "DELETE FROM cart");
        echo "<script>alert('Transaction Successful!'); window.location='cash_register.php';</script>";
    }
}

// PAGPILI NG DISPLAY: Products ang database source
$product_db = mysqli_query($conn, "SELECT * FROM products ORDER BY id ASC");
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
  while($prod = mysqli_fetch_assoc($product_db)) { 
      $pnum = $prod['productnumber'];
      
      // Dito natin hahanapin kung ang product na ito ay kasalukuyang binibili (nasa cart)
      $cart_check = mysqli_query($conn, "SELECT quantity FROM cart WHERE productnumber='$pnum'");
      if(mysqli_num_rows($cart_check) > 0) {
          $cart_row = mysqli_fetch_assoc($cart_check);
          $order_qty = $cart_row['quantity'];
          
          // Eto yung calculation code na hardcoded para sa subtotal
          $item_subtotal = $order_qty * $prod['price']; 
          $subtotals += $item_subtotal;
  ?>
  <tr>
    <td colspan="2" class="style138"><?php echo $order_qty; ?> X <?php echo $prod['productname']; ?> @ <?php echo number_format($prod['price'], 2); ?></td>
    <td align="right" class="style138" style="color: blue;">P <?php echo number_format($item_subtotal, 2); ?></td>
  </tr> 
  <?php 
      } // Dito mag-e-end ang IF para yung may order lang ang lumitaw gaya ng sa image_2d7c30.png
  } 
  ?>

  <tr>
    <td align="left" colspan="2" height="40">
        <form method="POST">
          <span class="style138">Amt. Paid:</span>
          <input type="text" name="payment" size="12" placeholder="Enter amount">
          <input type="submit" name="btnPayment" value="Pay" />
        </form>
    </td> 
    <td align="right">
        <?php $v_amt = $subtotals * 0.12; $g_amt = $subtotals + $v_amt; ?>
        <span class="style138"><strong>Total: P <?php echo number_format($subtotals, 2); ?></strong></span><br>
        <span class="style138">VAT (12%): P <?php echo number_format($v_amt, 2); ?></span><br>
        <span class="style141">Amount Due: P <?php echo number_format($g_amt, 2); ?></span><br>
        <span class="style138">Amt. Paid: P <?php echo number_format($payment, 2); ?></span><br>
        <span class="style136">Change: P <?php echo number_format($change, 2); ?></span>
    </td>
  </tr>
</table>
</center>
</body>
</html>