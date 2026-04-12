
<?php 
@session_start();
include("webconnect.php");

if((@$_SESSION['accesslevel']!="Admin") && (@$_SESSION['accesslevel']!="SuperAdmin"))  { ?>
<SCRIPT Language=Javascript>
  <!--
  //	alert("You are not logged -in or you have no authorization to view this page!");
  // End 
  -->
</SCRIPT>

<SCRIPT Language=Javascript>
  <!--
  //	history.back();
  // End 
  -->
</SCRIPT>
<?php
} 
		

$id = $_REQUEST['id']; 
$sql = "DELETE FROM cart where id = '$id' " ;
$result2 = mysqli_query($conn,$sql);
 	if($result2) {
	?>
<SCRIPT Language=Javascript>
  <!--
  alert("Student record successfully DELETED!");
  // End 
  -->
</SCRIPT>

<SCRIPT Language=Javascript>
  <!--
  location.href = "cash_register.php";
  // End 
  -->
</SCRIPT>
<?php
  }
?>   
</body>
</html>