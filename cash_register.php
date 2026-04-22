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

// 1. SECURED ADD TO CART (PREVENTS NEGATIVE)
if(isset($_POST['btnSearch2'])) {
    $qty_in = intval($_POST['criteria']);
    $prod_id = mysqli_real_escape_string($conn, $_POST['textsearch2']);

    if($prod_id != "" && $qty_in > 0) {
        // A. Kunin ang actual stock sa products table
        $get_prod = mysqli_query($conn, "SELECT * FROM products WHERE productnumber='$prod_id'");
        $p = mysqli_fetch_assoc($get_prod);
        
        if($p) {
            $db_stock = intval($p['quantity']); // Mula sa database

            // B. Kunin kung ilan na ang nasa CART para sa product na ito
            $check_cart_qty = mysqli_query($conn, "SELECT SUM(quantity) as in_cart FROM cart WHERE productnumber='$prod_id'");
            $c_qty = mysqli_fetch_assoc($check_cart_qty);
            $current_in_cart = intval($c_qty['in_cart']);

            // C. TOTAL na magiging laman ng cart kung itutuloy ang add
            $total_requested = $current_in_cart + $qty_in;

            if($db_stock <= 0) {
                echo "<script>alert('Error: Item is Out of Stock!');</script>";
            } 
            elseif($total_requested > $db_stock) {
                // Ito ang pipigil para hindi maging negative
                $allowed = $db_stock - $current_in_cart;
                echo "<script>alert('Error: Cannot add more! Available stock is only $db_stock. You already have $current_in_cart in cart.');</script>";
            } 
            else {
                $pName = $p['productname'];
                $price = $p['price'];
                $sub = $qty_in * $price;
                mysqli_query($conn, "INSERT INTO cart (quantity, productnumber, productname, price, subtotal, sales_date) 
                                    VALUES ('$qty_in', '$prod_id', '$pName', '$price', '$sub', '$datep')");
            }
        } else {
            echo "<script>alert('Product Number not found!');</script>";
        }
    }
}


if(isset($_POST['btnPayment'])) {
    if(!isset($_POST['payment']) || $_POST['payment'] == ""){
        echo "<script>alert('Please enter payment amount.');</script>";
    } else {
        $payment = floatval($_POST['payment']);
        $check_cart = mysqli_query($conn, "SELECT SUM(subtotal) as total FROM cart");
        $c_row = mysqli_fetch_assoc($check_cart);
        $net_sales = $c_row['total'];
        $grand_total = $net_sales + ($net_sales * 0.12);
        
        if($payment >= $grand_total && $grand_total > 0) {
            $change = $payment - $grand_total;
            $inv_no = 'INV-' . time();

            $get_all_cart = mysqli_query($conn, "SELECT * FROM cart");
            while($row = mysqli_fetch_assoc($get_all_cart)) {
                $p_num = $row['productnumber'];
                $q_ordered = $row['quantity'];
                
                // DITO ANG ACTUAL DEDUCTION SA MASTERLIST
                mysqli_query($conn, "UPDATE products SET quantity = quantity - $q_ordered WHERE productnumber = '$p_num'");

                mysqli_query($conn, "INSERT INTO sales (sales_invoice, sales_date, productname, quantity, price, subtotal, emp_num) 
                                    VALUES ('$inv_no', NOW(), '{$row['productname']}', '$q_ordered', '{$row['price']}', '{$row['subtotal']}', '$current_emp')");
            }
            mysqli_query($conn, "DELETE FROM cart"); 
            echo "<script>alert('Transaction Successful!'); window.location='cash_register.php';</script>";
        } else {
            echo "<script>alert('Insufficient Amount!');</script>";
        }
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
 <?php while($item = mysqli_fetch_assoc($cart_display)) { $subtotals += $item['subtotal']; ?>
  <tr>
    <td colspan="2" class="style138"><?php echo $item['quantity']; ?> X <?php echo $item['productname']; ?> @ <?php echo number_format($item['price'], 2); ?></td>
    <td align="right" class="style138" style="color: blue;">P <?php echo number_format($item['subtotal'], 2); ?></td>
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
