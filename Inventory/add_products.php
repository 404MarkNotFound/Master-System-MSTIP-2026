<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Products Details</title>
<style>
.container {max-width: 600px; margin: 50px auto; padding: 20px;}
form {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
label {display: block; margin-top: 10px; font-weight: bold;}
input[type=text], input[type=number], input[type=file], select {
  width: 100%;
  padding: 12px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}
input[type=submit]:hover {background-color: #45a049;}
</style>
</head>
<body>
<?php
include("webconnect.php");

$message = '';

if(isset($_POST['Submit'])) {
  $productnumber = mysqli_real_escape_string($conn, $_POST['productnumber']);
  $productname = mysqli_real_escape_string($conn, $_POST['productname']);
  $productbrand = mysqli_real_escape_string($conn, $_POST['productbrand']);
 $price = floatval($_POST['price'] ?? 0);
  $quantity = intval($_POST['quantity']);
  $productstatus = mysqli_real_escape_string($conn, $_POST['productstatus']);

  // Check if exists
  $sql2 = "SELECT * FROM products WHERE productnumber = '$productnumber'";
  $result = mysqli_query($conn, $sql2);
  $count = mysqli_num_rows($result);

  if($count == 0) {
$photo = '';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
  $target_dir = "uploads/products/";
  if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
  }
  $photo_name = basename($_FILES["photo"]["name"]);
  $target_file = $target_dir . uniqid() . '_' . $photo_name;
  if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $photo = $target_file;
  }
}
$sql = "INSERT INTO products (productnumber, productname, productbrand, price, quantity, productstatus, photo) VALUES('$productnumber','$productname','$productbrand','$price','$quantity','$productstatus','$photo')";
if(mysqli_query($conn, $sql)) {
echo "<script>alert('Product added successfully! ID: " . mysqli_insert_id($conn) . "'); window.location='products_masterlist_fixed.php';</script>";



    } else {
$message = "Insert Error: " . mysqli_error($conn);
    }
  } else {
    $message = "Product '$productnumber' already exists!";
    echo "<script>alert('$message'); </script>";
  }
}
?>

<?php include("mainmenu.php"); ?>

<div class="container">
  <?php if($message): ?>
  <div style="padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 20px;">
    <?php echo $message; ?>
  </div>
  <?php endif; ?>
  
  <h2>Add Product Details</h2>
  <form name="myform" method="POST" enctype="multipart/form-data">
    <label for="productnumber">Product Number</label>
    <input type="text" id="productnumber" name="productnumber" required>

    <label for="productname">Product Name</label>
    <input type="text" id="productname" name="productname" required>

    <label for="productbrand">Product Brand</label>
    <input type="text" id="productbrand" name="productbrand" required>

    <label for="price">Product Price</label>
    <input type="number" step="0.01" id="price" name="price" required>

    <label for="quantity">Quantity</label>
    <input type="number" id="quantity" name="quantity" required>

<label for="productstatus">Product Status</label>
    <select name="productstatus" required>
      <option value="Active">Active</option>
      <option value="Inactive">Inactive</option>
      <option value="Out of Stock">Out of Stock</option>
    </select>

    <label for="photo">Product Photo</label>
    <input type="file" id="photo" name="photo" accept="image/*">

    <input type="submit" name="Submit" value="Add Product">
  </form>
  
  <div style="text-align: center; margin-top: 20px;">
    <a href="products_masterlist_fixed.php">View Products</a> | <a href="index.php">Home</a>
  </div>

</div>

</body>
</html>

