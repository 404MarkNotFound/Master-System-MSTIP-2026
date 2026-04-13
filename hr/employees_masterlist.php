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
   $variable2 = $_POST['textsearch2'];

  if($variable2 =="") {
  $sql25 =" select * from employees ORDER by lname ASC ";
  $result = mysqli_query($conn, $sql25);
//$row2 = mysqli_fetch_assoc($result);

} else {

 //if($criteria2 == "description") {
   $sql27 = "select * from employees where $criteria2 LIKE '%%$variable2%%' ORDER by lname ASC " ;
   $result = mysqli_query($conn, $sql27);
 //$row2 = mysqli_fetch_assoc($result);
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
        <option selected="selected">Select</option
        >
        <option value="emp_no">Employee Number</option>
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
    <td width="6%" height="24" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Emp. Num </strong></td>
    <td width="8%" align="center" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Photo</strong></td>
    <td width="10%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Last Name </strong></td>
    <td width="11%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>First Name </strong></td>
    <td width="9%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>&nbsp;M.I.</strong></td>
    <td colspan="2" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Department</strong></td>
    <td width="20%" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>Email Address </strong><strong> </strong></td>
    <td width="5%" align="center" bgcolor="#E0E8F1" class="style139 style136 style13"><strong>*</strong></td>
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
    <td height="26" bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['emp_num']; ?></span></td>
    <td height="26" align="center" bgcolor="<?php echo $color; ?>" class="style127 style136 style139" >
      <?php if (!empty($row4['photo'])): ?>
        <img src="<?php echo htmlspecialchars($row4['photo']); ?>" alt="Employee Photo" style="max-width:60px; max-height:60px; border-radius:4px;">
      <?php else: ?>
        -
      <?php endif; ?>
    </td>
    <td bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['lname']; ?></span></td>
    <td bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php echo $row4['fname']; ?></span></td>
    <td align="left" bgcolor="<?php echo $color; ?>" class="style127 style136 style139" >&nbsp;<?php ; ?></td 
    >
    <td colspan="2" bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php ; ?></span></td>
    <td bgcolor="<?php echo $color; ?>" class="style127" ><span class="style138"><?php ; ?></span></td>
    <td align="center" bgcolor="<?php echo $color; ?>" class="style127 style136 style139" ><a href="update_memo.php?email=<?php echo $row4['email']; ?>"><img src="buttons/pclip2.jpg" width="27" height="22" /></a></td>
    </tr>
 <?php } ?> 
</table>
</center>
<br />
<center><span class="style49 style136"><a href="index.php">MSTIP</a>-Home </span>
</center>
</body>

</html>

