<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Employee Masterlist</title>
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
.style138 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style139 {font-size: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style141 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }

-->
</style>
</head>

<?php 
@session_start();
include("webconnect.php");

$datep=date('M d, Y H:i:s');

/*
ini_set("post_max_size","128M");
ini_set("session.gc_maxlifetime","10800"); 
ini_set("upload_max_filesize", "200M");
*/

$sql1 = " SELECT * from employees order by lname ASC, department ASC ";
$result = mysqli_query($conn, $sql1) ; 

// //-- SEARCH by individual
if(isset($_POST['btnSearch2'])) 
{
   $criteria2 = $_POST['criteria'];
   $variable2 = trim($_POST['textsearch2']);

   $allowed = array('emp_num','lname','department','gender','email');
   if($variable2 == "" || !in_array($criteria2, $allowed)) {
      $sql25 = "select * from employees ORDER by lname ASC";
      $result = mysqli_query($conn, $sql25);
   } else {
      $criteria2 = mysqli_real_escape_string($conn, $criteria2);
      $variable2 = mysqli_real_escape_string($conn, $variable2);
      $sql27 = "select * from employees where $criteria2 LIKE '%$variable2%' ORDER by lname ASC";
      $result = mysqli_query($conn, $sql27);
   }
}

// //- VIEW ALL
// //-- SEARCH by individual
if(isset($_POST['btnSearch22'])) 
{
 //if($criteria2 == "description") {
   $sql28 = "select * from employees ORDER by lname ASC, department ASC " ;
   $result = mysqli_query($conn, $sql28);
 //$row2 = mysqli_fetch_assoc($result);
}


?>

<body>
<?php include("mainmenu.php"); ?>
<center>
  <table width="98%" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
  <tr>
    <td height="33" colspan="7" class="style13"><form id="form4" name="form4" method="post">
      <span class="style92">Search by:</span>
      <select name="criteria" id="criteria">
        <option selected="selected" value="">Select</option>
        <option value="emp_num">Employee Number</option>
        <option value="lname">Employee Lastname</option>
        <option value="department">Department</option>
        <option value="gender">Gender</option>
        <option value="email">Email Address</option>
      </select>
      <input name="textsearch2" type="text" id="textsearch2" size="28" />
      <input name="btnSearch2" type="submit" id="btnSearch2" value="  Go  " />
      <input name="btnSearch22" type="submit" id="btnSearch22" value="  View All  " />
    </form>      </td>
    <td colspan="3" class="style13"><span class="style141">Employees Masterlist &nbsp;&nbsp;<a href="employees_grid_view.php">Grid View</a> </span></td>
    </tr>
  <tr>
    <td width="10%" height="24" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Emp. Num </strong></td>
    <td width="10%" align="center" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Photo</strong></td>
    <td width="10%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Last Name </strong></td>
    <td width="10%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>First Name </strong></td>
    <td width="10%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>&nbsp;M.I.</strong></td>
    <td width="22%" colspan="2%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Department</strong></td>
    <td width="14%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Email Address </strong><strong> </strong></td>
    <td width="8%" align="center" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Actions</strong></td>
    </tr>
 <?php 
 	while($row4 = mysqli_fetch_assoc($result)) {
	$emailadd = $row4['email']; 
	
	 			// --- alternating row colors
			if(@$color == "#DDE0EE") {
		     	@$color = "#F4F4F4";
    			} else {
      			@$color = "#DDE0EE";
    		}			

 ?>
  <tr>
    <td width="10%" height="26" bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['emp_num']; ?></span></td>
    <td width="10%" height="26" align="center" bgcolor="<?php echo $color; ?>" class="style127 style136 style139" ><?php if($row4['photo'] && file_exists($row4['photo'])) { ?><img src="<?php echo $row4['photo']; ?>" width="40" height="40" style="object-fit:cover;border-radius:4px;"><?php } else { echo 'No photo'; } ?></td>
    <td width="10%" bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['lname']; ?></span></td>
    <td width="10%" bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['fname']; ?></span></td>
    <td width="10%" align="left" bgcolor="<?php echo $color; ?>" class="style127 style136 style139" >&nbsp;<?php echo $row4['mname']; ?></td>
    <td width="22%" colspan="2" bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['department']; ?></span></td>
    <td width="14%" bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['email']; ?></span></td>
    <td width="8%" align="center" bgcolor="<?php echo $color; ?>" class="style127 style136 style139" ><a href="hr_delete.php?empid=<?php echo $row4['id']; ?>"><img src="delete.png" width="22" height="24" title="Delete"></a>&nbsp;<a href="hr_update.php?id=<?php echo $row4['id']; ?>" title="Edit"><img src="update.png" width="22" height="24"></a></td>
    </tr>
 <?php } ?> 
</table>
</center>
<br />
<center><span class="style49 style136"><a href="home.php">MSTIP</a>-Home </span>
</center>
</body>

</html>

