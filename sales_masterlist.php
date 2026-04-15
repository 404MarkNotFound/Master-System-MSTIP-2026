<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sales Masterlist</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
}
.style136 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style138 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; }
.style139 {font-size: 14px}
.style141 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
 
-->
</style>
</head>
 
<?php 
@session_start();
include("webconnect.php");
 
$datep=date('M d, Y H:i:s');
 
 
$sql1 = " SELECT * from sales order by sales_date DESC, emp_num ASC ";
$result = mysqli_query($conn, $sql1) ; 
 
// //-- SEARCH by individual
if(isset($_POST['btnSearch2'])) 
{
   $criteria2 = $_POST['criteria'];
   $variable2 = $_POST['textsearch2'];
 
  if($variable2 =="") {
  $sql25 =" select * from sales ORDER by sales_date DESC ";
  $result = mysqli_query($conn, $sql25);
//$row2 = mysqli_fetch_assoc($result);
 
} else {

  if($criteria2 == "Select" || $criteria2 == "") {
     $sql27 = "select * from sales ORDER by sales_date DESC";
  } else {
     $sql27 = "select * from sales where $criteria2 LIKE '%%$variable2%%' ORDER by sales_date DESC";
  }
  $result = mysqli_query($conn, $sql27);
}
}
 
// //- VIEW ALL
// //-- SEARCH by individual
if(isset($_POST['btnSearch22'])) 
{
 //if($criteria2 == "description") {
   $sql28 = "select * from sales ORDER by sales_date DESC " ;
   $result = mysqli_query($conn, $sql28);
 //$row2 = mysqli_fetch_assoc($result);
}
 
 
?>
 
<body>
<?php include("mainmenu.php"); ?>
<center>
 <h2>Sales Masterlist</h2>
  <table width="98%" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
  <tr>
    <!-- Fixed: added missing closing quote on colspan="4" — previously colspan="4 was
    swallowing the class attribute, breaking the table header layout -->
    <td height="33" colspan="4" class="style13"><form id="form4" name="form4" method="post">
      <span class="style92">Search by:</span>
      <select name="criteria" id="criteria">
        <!-- Fixed: closing tag was split across two lines as </option\n> which is invalid HTML -->
        <option selected="selected">Select</option>
        <option value="sales_invoice">Sales Invoice</option>
        <option value="productname">Product Name</option>
        <option value="emp_num">Employee Number</option>
      </select>
      <input name="textsearch2" type="text" id="textsearch2" size="28" />
      <input name="btnSearch2" type="submit" id="btnSearch2" value="  Go  " />
      <input name="btnSearch22" type="submit" id="btnSearch22" value="  View All  " />
    </form>      </td>
    <td colspan="8" class="style13"><span class="style141">&nbsp;&nbsp;<a href="#">Grid View</a> </span></td>
    </tr>
  <tr>
    <td width="10" height="24" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Sales Invoice</strong></td>
    <td width="8%" align="center" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Sales Date</strong></td>
    <td width="20%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Product Name</strong><strong> </strong></td>
    <td width="10%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Quantity</strong></td>
    <td width="11%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Unit Price</strong></td>
    <td width="9%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>&nbsp;Sub_Total</strong></td>
    <td width="8" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Emp. Number</strong></td>
    <td width="5%" align="center" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Action</strong></td>
    </tr>
 <?php 
 	while($row4 = mysqli_fetch_assoc($result)) {
	$empnumber = $row4['emp_num']; 
	
	 			// --- alternating row colors
			if(@$color == "#DDE0EE") {
		     	@$color = "#F4F4F4";
    			} else {
      			@$color = "#DDE0EE";
    		}			
 
 ?>
  <tr>
    <td height="26" bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['sales_invoice']; ?></span></td>
    <td height="26" align="center" bgcolor="<?php echo $color; ?>" class="style127 style136 style139" ><?php echo $row4['sales_date']; ?></td>
    <td bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['productname']; ?></span></td>
    <td bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['quantity']; ?></span></td>
    <td align="left" bgcolor="<?php echo $color; ?>" class="style127 style136 style139" >&nbsp;<?php echo $row4['price']; ?></td >
    <td  bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['subtotal']; ?></span></td>
    <td bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['emp_num']; ?></span></td>
    <td align="center" bgcolor="<?php echo $color; ?>" class="style127 style136 style139" ><a href="update_memo.php?id=<?php echo $row4['id']; ?>"><img src="buttons/pclip2.jpg" width="27" height="22" /></a></td>
    </tr>
 <?php } ?> 
</table>
</center>
<br />
<center><span class="style49 style136"><a href="index.html">MSTIP</a>-Home </span>
</center>
</body>
 
</html>