<?php 
include("webconnect.php");

$id = $_REQUEST['empid'];
$sql = "DELETE from employees where id = '$id' "; 
$result = mysqli_query($conn, $sql);
?>

<script>
    <!--
    alert("Record has been successfully deleted");
    
</script>
<script>
 <!--
  location.href="employees_masterlist.php";
  
</script>