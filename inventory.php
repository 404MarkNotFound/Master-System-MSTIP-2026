<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Management - MSTIP</title>
  <link rel="stylesheet" href="loginstyle.css">

  <style>
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }

    .action-form { margin: 2px; display: inline; }
    .edit-input { width: 60px; }

    button { padding: 4px 8px; cursor: pointer; border: none; }

    .delete-btn { background: #ff4444; color: white; }
    .update-btn { background: #4CAF50; color: white; }

    .stock-out {
      color: #ff4444;
      font-weight: bold;
      background: #ffe6e6;
      padding: 2px 6px;
      border-radius: 4px;
    }

    .stock-low {
      color: #ff8800;
      font-weight: bold;
      background: #fff3e6;
      padding: 2px 6px;
      border-radius: 4px;
    }
  </style>
</head>

<body>

<?php include("mainmenu.php"); ?>

<div class="container">
  <div class="wrapper">
    <div class="title"><span>Inventory Management</span></div>

<?php
include("webconnect.php");

/* DELETE */
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
  $productNumber = mysqli_real_escape_string($conn, $_POST['productNumber']);

  $delete_sql = "DELETE FROM products WHERE productnumber = '$productNumber'";

  if (mysqli_query($conn, $delete_sql)) {
    echo "<script>alert('Product deleted successfully!');</script>";
  } else {
    echo "<script>alert('Error deleting product.');</script>";
  }
}

/* UPDATE */
if (isset($_POST['action']) && $_POST['action'] == 'update') {
  $productNumber = mysqli_real_escape_string($conn, $_POST['productNumber']);
  $qty = mysqli_real_escape_string($conn, $_POST['qty']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);

  $update_sql = "UPDATE products 
                 SET quantity = '$qty', price = '$price' 
                 WHERE productnumber = '$productNumber'";

  if (mysqli_query($conn, $update_sql)) {
    echo "<script>alert('Product updated successfully!');</script>";
  } else {
    echo "<script>alert('Error updating product.');</script>";
  }
}
?>

    <h3>Current Inventory</h3>

<?php
$products_sql = "SELECT * FROM products ORDER BY productnumber";
$products_result = mysqli_query($conn, $products_sql);

if (mysqli_num_rows($products_result) > 0) {
?>
  <table>
    <thead>
      <tr>
        <th>Product #</th>
        <th>Name</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Brand</th>
        <th>Photo</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php while($row = mysqli_fetch_assoc($products_result)) { ?>
      <tr>
        <td><?php echo htmlspecialchars($row['productnumber']); ?></td>

        <td><?php echo htmlspecialchars($row['productname']); ?></td>

        <td>
          <?php
            $stock_qty = (int)$row['quantity'];

            if ($stock_qty == 0) {
              echo '<span class="stock-out">Out of Stock</span>';
            } elseif ($stock_qty < 20) {
              echo '<span class="stock-low">'.$stock_qty.' (Low Stock)</span>';
            } else {
              echo $stock_qty;
            }
          ?>
        </td>

        <td>₱<?php echo htmlspecialchars($row['price']); ?></td>

        <td>
          <?php
            echo htmlspecialchars($row['productbrand'] ?? 'N/A');
          ?>
        </td>

        <td>
          <?php if (!empty($row['photo']) && file_exists($row['photo'])) { ?>
            <img src="<?php echo htmlspecialchars($row['photo']); ?>" 
                 style="width:50px;height:50px;object-fit:cover;">
          <?php } else { ?>
            <span>No Photo</span>
          <?php } ?>
        </td>

        <td>
          <!-- UPDATE -->
          <form method="post" class="action-form">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="productNumber" value="<?php echo $row['productnumber']; ?>">

            Qty:
            <input type="number" class="edit-input" name="qty"
                   value="<?php echo $row['quantity']; ?>" required>

            Price:
            <input type="number" step="0.01" class="edit-input" name="price"
                   value="<?php echo $row['price']; ?>" required>

            <button type="submit" class="update-btn">Update</button>
          </form>

          <!-- DELETE -->
          <form method="post" class="action-form"
                onsubmit="return confirm('Delete <?php echo $row['productname']; ?>?');">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="productNumber" value="<?php echo $row['productnumber']; ?>">
            <button type="submit" class="delete-btn">Delete</button>
          </form>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

<?php
} else {
  echo "<p>No products in inventory.</p>";
}

mysqli_close($conn);
?>

    <div class="signup-link" style="margin-top: 20px;">
      <a href="products_masterlist.php">Products Masterlist</a> |
      <a href="index.php">Home</a>
    </div>

  </div>
</div>

</body>
</html>