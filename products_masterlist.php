<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products Masterlist</title>
<style>
body {
	margin: 0;
	padding: 0;
	background-color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
table {
	width: 98%;
	border-collapse: collapse;
	margin: 10px auto;
	border: 1px solid #ccc;
}
th, td {
	border: 1px solid #FFFFFF;
	padding: 8px;
}
th {
	background-color: #E0E8F1;
	font-weight: bold;
	border: 1px solid #ccc;
}
td {
	border: 1px solid #ccc;
}
tr:nth-child(even) {
	background-color: #F4F4F4;
}
tr:nth-child(odd) {
	background-color: #DDE0EE;
}
</style>
</head>
<body>
<?php 
@session_start();
include("webconnect.php");

$sql1 = "SELECT * FROM products ORDER BY productname ASC, productbrand ASC LIMIT 500";
$result = mysqli_query($conn, $sql1);
if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

if(isset($_POST['btnSearch2'])) {
  $criteria2 = $_POST['criteria'];
  $variable2 = $_POST['textsearch2'];
  if($variable2 == "") {
    $sql25 = "SELECT * FROM products ORDER BY productname ASC";
    $result = mysqli_query($conn, $sql25);
    if (!$result) die("Query failed: " . mysqli_error($conn));
  } else {
    $variable2 = mysqli_real_escape_string($conn, $variable2);
    $sql27 = "SELECT * FROM products WHERE $criteria2 LIKE '%$variable2%' ORDER BY productname ASC";
    $result = mysqli_query($conn, $sql27);
    if (!$result) die("Query failed: " . mysqli_error($conn));
  }
}

if(isset($_POST['btnSearch22'])) {
  $sql28 = "SELECT * FROM products ORDER BY productname ASC, productbrand ASC";
  $result = mysqli_query($conn, $sql28);
  if (!$result) die("Query failed: " . mysqli_error($conn));
}
?>

<?php include("mainmenu.php"); ?>

<div style="text-align: center; margin: 20px;">
  <form method="post">
    Search by: 
    <select name="criteria">
      <option selected>Select</option>
      <option value="productnumber">Product Number</option>
      <option value="productname">Product Name</option>
      <option value="productbrand">Product Brand</option>
    </select>
    <input name="textsearch2" type="text" size="28">
    <input name="btnSearch2" type="submit" value="Go">
    <input name="btnSearch22" type="submit" value="View All">
  </form>
  <h2>Products Masterlist</h2>
</div>

<table>
  <tr>
    <th>Product Num</th>
    <th>Quantity</th>
    <th>Product Name</th>
    <th>Product Brand</th>
    <th>Product Price</th>
    <th colspan="2">Photo</th>
    <th>Product Status</th>
    <th>Action</th>
  </tr>
  <?php while($row4 = mysqli_fetch_assoc($result)): ?>
  <tr>
    <td><?php echo htmlspecialchars($row4['productnumber']); ?></td>
    <td style="text-align:center;"><?php echo $row4['quantity']; ?></td>
    <td><?php echo htmlspecialchars($row4['productname']); ?></td>
    <td><?php echo htmlspecialchars($row4['productbrand']); ?></td>
    <td>PHP <?php echo number_format($row4['price'], 2); ?></td>
    <td colspan="2"><?php echo htmlspecialchars($row4['photo']); ?></td>
    <td><?php echo htmlspecialchars($row4['productstatus']); ?></td>
    <td style="text-align:center;">
      <a href="updateproducts.php?id=<?php echo urlencode($row4['productnumber']); ?>" title="Edit Price/Stock">
        <img src="buttons/pclip2.jpg" alt="Edit" width="27" height="22">
      </a>
    </td>
  </tr>
  <?php endwhile; ?>
  <?php if (mysqli_num_rows($result) == 0): ?>
  <tr><td colspan="9" style="text-align:center;">No products found.</td></tr>
  <?php endif; ?>
</table>

<div style="text-align: center; margin: 20px;">
  <a href="index.php">Home</a>
</div>
</body>
</html>
