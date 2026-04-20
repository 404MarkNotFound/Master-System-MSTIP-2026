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
.error { color: red; }
</style>
</head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("webconnect.php");

// Explicit connection check to prevent null $conn
if (!isset($conn) || $conn === null || !$conn) {
    die("Fatal Error: Database connection failed. Please check webconnect.php and MySQL server. Error: " . mysqli_connect_error());
}

$message = '';

if(isset($_POST['Submit']) && $conn) {
  // Input validation and sanitization with connection check
  $productnumber = trim($_POST['productnumber'] ?? '');
  $productname = trim($_POST['productname'] ?? '');
  $productbrand = trim($_POST['productbrand'] ?? '');
  $price = floatval($_POST['price'] ?? 0);
  $quantity = intval($_POST['quantity'] ?? 0);

  if (empty($productnumber) || empty($productname) || empty($productbrand) || $price <= 0 || $quantity < 0) {
    $message = "All fields are required and valid.";
  } else {
    // Use prepared statement to avoid escape_string issues and injection
    $check_stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE productnumber = ?");
    $check_stmt->bind_param("s", $productnumber);
    $check_stmt->execute();
    $count = $check_stmt->get_result()->fetch_row()[0];
    $check_stmt->close();

    if($count == 0) {
      $photo = '';
      if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/products/";
        if (!file_exists($target_dir)) {
          mkdir($target_dir, 0777, true);
        }
        $photo_name = basename($_FILES["photo"]["name"]);
        $photo_ext = strtolower(pathinfo($photo_name, PATHINFO_EXTENSION));
        if (in_array($photo_ext, ['jpg','jpeg','png','gif'])) {
          $target_file = $target_dir . uniqid() . '_' . $productnumber . '.' . $photo_ext;
          if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo = $target_file;
          } else {
            $message = "File upload failed.";
          }
        } else {
          $message = "Invalid file type. Only JPG, PNG, GIF allowed.";
        }
      }

      if (empty($message)) {
        $insert_stmt = $conn->prepare("INSERT INTO products (productnumber, productname, productbrand, price, quantity, photo) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("sssdis", $productnumber, $productname, $productbrand, $price, $quantity, $photo);
        if($insert_stmt->execute()) {
echo "<script>alert('Product added successfully! ID: " . $insert_stmt->insert_id . "'); window.location='inventory.php';</script>";
          exit;
        } else {
          $message = "Insert Error: " . $conn->error;
        }
        $insert_stmt->close();
      }
    } else {
      $message = "Product number '$productnumber' already exists!";
    }
  }
}
?>

<?php include("mainmenu.php"); ?>

<div class="container">
  <?php if($message): ?>
  <div class="error" style="padding: 10px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 20px;">
    <?php echo htmlspecialchars($message); ?>
  </div>
  <?php endif; ?>
  
  <h2>Add Product Details</h2>
  <form name="myform" method="POST" enctype="multipart/form-data">
    <label for="productnumber">Product Number *</label>
    <input type="text" id="productnumber" name="productnumber" value="<?php echo htmlspecialchars($_POST['productnumber'] ?? ''); ?>" required>

    <label for="productname">Product Name *</label>
    <input type="text" id="productname" name="productname" value="<?php echo htmlspecialchars($_POST['productname'] ?? ''); ?>" required>

    <label for="productbrand">Product Brand *</label>
    <input type="text" id="productbrand" name="productbrand" value="<?php echo htmlspecialchars($_POST['productbrand'] ?? ''); ?>" required>

    <label for="price">Product Price *</label>
    <input type="number" step="0.01" min="0" id="price" name="price" value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>" required>

    <label for="quantity">Quantity *</label>
    <input type="number" min="0" id="quantity" name="quantity" value="<?php echo htmlspecialchars($_POST['quantity'] ?? ''); ?>" required>

    <label for="photo">Product Photo (optional)</label>
    <input type="file" id="photo" name="photo" accept="image/*">

    <input type="submit" name="Submit" value="Add Product">
  </form>
  
  <div style="text-align: center; margin-top: 20px;">
    <a href="inventory.php">View Products</a> | <a href="index.php">Home</a>
  </div>
</div>

</body>
</html>
