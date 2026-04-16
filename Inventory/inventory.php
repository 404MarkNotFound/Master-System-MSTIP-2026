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
      .action-form { margin: 2px; }
      .edit-input { width: 60px; }
      button { padding: 4px 8px; cursor: pointer; }
      .delete-btn { background: #ff4444; color: white; border: none; }
  .update-btn { background: #4CAF50; color: white; border: none; }
  
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
    <?php include("../mainmenu.php"); ?>
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Inventory Management</span></div>
        
        <?php
        include("../webconnect.php");
        
        // Handle Delete
        if (isset($_POST['action']) && $_POST['action'] == 'delete') {
          $productNumber = mysqli_real_escape_string($conn, $_POST['productNumber']);
          $delete_sql = "DELETE FROM products WHERE productNumber = '$productNumber'";
          if (mysqli_query($conn, $delete_sql)) {
            echo "<script>alert('Product deleted successfully!');</script>";
          } else {
            echo "<script>alert('Error deleting product.');</script>";
          }
        }
        
        // Handle Update
        if (isset($_POST['action']) && $_POST['action'] == 'update') {
          $productNumber = mysqli_real_escape_string($conn, $_POST['productNumber']);
          $qty = mysqli_real_escape_string($conn, $_POST['qty']);
          $price = mysqli_real_escape_string($conn, $_POST['price']);
          $update_sql = "UPDATE products SET qty = '$qty', price = '$price' WHERE productNumber = '$productNumber'";
          if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Product updated successfully!');</script>";
          } else {
            echo "<script>alert('Error updating product.');</script>";
          }
        }
        
        // Handle Add
        if(isset($_POST['Submit'])) {
          $productNumber = mysqli_real_escape_string($conn, $_POST['productNumber']);
          $productName = mysqli_real_escape_string($conn, $_POST['productName']);
          $qty = mysqli_real_escape_string($conn, $_POST['qty']);
          $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
          $price = mysqli_real_escape_string($conn, $_POST['price']);
          
          $check_sql = "SELECT * FROM products WHERE productNumber = '$productNumber'";
          $check_result = mysqli_query($conn, $check_sql);
          $count = mysqli_num_rows($check_result);
          
          if($count == 0) {
            $sql = "INSERT INTO products (productNumber, productName, qty, lastname, price) VALUES('$productNumber', '$productName', '$qty', '$lastname', '$price')";
            if (mysqli_query($conn, $sql)) {
              echo "<script>alert('Product added successfully!'); location.href='inventory.php';</script>";
            } else {
              echo "<script>alert('Error adding product: " . mysqli_error($conn) . "');</script>";
            }
          } else {
            echo "<script>alert('Product Number already exists!');</script>";
          }
        }
        ?>
        
        <!-- Add Product Form -->
        <h3>Add New Product</h3>
        <form action="inventory.php" method="post">
          <div class="row">
            <i class="fas fa-barcode"></i>
            <input type="text" name="productNumber" placeholder="Product Number" required>
          </div>
          <div class="row">
            <i class="fas fa-tag"></i>
            <input type="text" name="productName" placeholder="Product Name" required>
          </div>
          <div class="row">
            <i class="fas fa-box"></i>
            <input type="number" name="qty" placeholder="Quantity" required>
          </div>
          <div class="row">
            <i class="fas fa-list"></i>
            <input type="text" name="lastname" placeholder="Category/Description" required>
          </div>
          <div class="row">
            <i class="fas fa-money-bill"></i>
            <input type="number" step="0.01" name="price" placeholder="Unit Price" required>
          </div>
          <div class="row button">
            <input type="submit" value="Add Product" name="Submit">
          </div>
        </form>
        
        <!-- Inventory Table -->
        <h3>Current Inventory</h3>
        <?php
        $products_sql = "SELECT * FROM products ORDER BY productNumber";
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
              <th>Category</th>
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
                $stock_qty = (int)$row['qty'];
                if ($stock_qty == 0) {
                    echo '<span class="stock-out">Out of Stock</span>';
                } elseif ($stock_qty < 20) {
                    echo '<span class="stock-low">' . $stock_qty . ' (Low Stock)</span>';
                } else {
                    echo $stock_qty;
                }
                ?>
              </td>
              <td>$<?php echo htmlspecialchars($row['price']); ?></td>
              <td><?php echo htmlspecialchars($row['lastname']); ?></td>
              <td>
                <!-- Update Form -->
                <form method="post" class="action-form" style="display: inline;">
                  <input type="hidden" name="action" value="update">
                  <input type="hidden" name="productNumber" value="<?php echo $row['productnumber']; ?>">
                  Qty: <input type="number" class="edit-input" name="qty" value="<?php echo $row['qty']; ?>" required>
                  Price: <input type="number" step="0.01" class="edit-input" name="price" value="<?php echo $row['price']; ?>" required>
                  <button type="submit" class="update-btn">Update</button>
                </form>
                <!-- Delete Form -->
                <form method="post" class="action-form" style="display: inline;" onsubmit="return confirm('Delete <?php echo $row['productname']; ?>?');">
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
        
        <div class="signup-link" style="margin-top: 20px;"><a href="products_masterlist.php">Products Masterlist</a> | <a href="index.php">Home</a></div>
      </div>
    </div>
  </body>
</html>

