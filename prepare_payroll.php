<?php
@session_start();
include("webconnect.php");

// Default values
$payrollPeriod = isset($_POST['payroll_period']) ? $_POST['payroll_period'] : date('Y-m');
$dateFrom = isset($_POST['date_from']) ? $_POST['date_from'] : date('Y-m-01');
$dateTo = isset($_POST['date_to']) ? $_POST['date_to'] : date('Y-m-t');
$filterDept = isset($_POST['filter_dept']) ? $_POST['filter_dept'] : '';
$filterEmp = isset($_POST['filter_emp']) ? $_POST['filter_emp'] : '';
$searchEmp = isset($_POST['search_emp']) ? $_POST['search_emp'] : '';

// Kung may type sa search, yun ang gamitin
if(!empty($searchEmp)) {
    $filterEmp = $searchEmp;
}

$rangeStart = strtotime($dateFrom);
$rangeEnd = strtotime($dateTo);
$totalPeriodDays = 0;
if($rangeStart !== false && $rangeEnd !== false && $rangeStart <= $rangeEnd) {
    $totalPeriodDays = floor(($rangeEnd - $rangeStart) / 86400) + 1;
}

$payrollTableExists = false;
$tableCheck = mysqli_query($conn, "SHOW TABLES LIKE 'payroll'");
if($tableCheck && mysqli_num_rows($tableCheck) > 0) {
    $payrollTableExists = true;
}

// Get departments for dropdown
$deptQuery = "SELECT DISTINCT department FROM employees WHERE department IS NOT NULL AND department != '' ORDER BY department";
$deptResult = mysqli_query($conn, $deptQuery);

// Get employees for dropdown - mga may timelogs lang
$empQuery = "SELECT DISTINCT e.emp_num, e.lname, e.fname 
             FROM employees e 
             INNER JOIN attendance_logs t ON e.emp_num = t.emp_num 
             ORDER BY e.lname, e.fname";
$empResult = mysqli_query($conn, $empQuery);

// Build employee filter
$empWhere = "WHERE 1=1";
if(!empty($filterDept)) {
    $empWhere .= " AND department = '$filterDept'";
}
if(!empty($filterEmp)) {
    $empWhere .= " AND emp_num LIKE '%$filterEmp%'";
}

// Calculate Payroll Preview
$payrollData = array();

if(isset($_POST['btnPreview']) || isset($_POST['btnProcess'])) {
    // Get employees
    $empListQuery = "SELECT * FROM employees $empWhere ORDER BY lname, fname";
    $empListResult = mysqli_query($conn, $empListQuery);
    
    while($emp = mysqli_fetch_assoc($empListResult)) {
        // Get attendance from timelogs
        $attQuery = "SELECT 
            COUNT(CASE WHEN time_in IS NOT NULL THEN 1 END) as days_worked,
            SUM(CASE WHEN status = 'Late' OR TIME(time_in) > '08:00:00' THEN 1 ELSE 0 END) as late_count
            FROM attendance_logs 
            WHERE emp_num = '{$emp['emp_num']}' 
            AND log_date BETWEEN '$dateFrom' AND '$dateTo'";
        $attResult = mysqli_query($conn, $attQuery);
        $att = mysqli_fetch_assoc($attResult);
        
        // Calculate
        $daysWorked = $att['days_worked'] ? $att['days_worked'] : 0;
        $daysAbsent = $totalPeriodDays > 0 ? max($totalPeriodDays - $daysWorked, 0) : 0;
        $lateCount = $att['late_count'] ? $att['late_count'] : 0;
              // FIX: Get rate with proper fallback
        $ratePerDay = 0;
        if(!empty($emp['rateperday']) && $emp['rateperday'] > 0) {
            $ratePerDay = (float)$emp['rateperday'];
        } elseif(!empty($emp['salary']) && $emp['salary'] > 0) {
            $ratePerDay = (float)$emp['salary'] / 26;
        }
        
        // FIX: If still no rate set minimum or show warning
        if($ratePerDay <= 0) {
            $ratePerDay = 500.00; // Default rate - palitan mo kung ano ang standard nyo
        }
        
        // Gross pay
        $grossPay = $daysWorked * $ratePerDay;
        
        // Deductions
        $deductAbsent = $daysAbsent * $ratePerDay;
        $deductLate = $lateCount * ($ratePerDay * 0.1);
        $sss = $emp['sss'] ? $emp['sss'] : 0;
        $philhealth = $emp['philhealth'] ? $emp['philhealth'] : 0;
        $pagibig = $emp['pagibig'] ? $emp['pagibig'] : 0;
        
        $totalDeduct = $deductAbsent + $deductLate + $sss + $philhealth + $pagibig;
        $netPay = $grossPay - $totalDeduct;
        
        // Store data
        $payrollData[] = array(
            'emp_num' => $emp['emp_num'],
            'lname' => $emp['lname'],
            'fname' => $emp['fname'],
            'mname' => $emp['mname'],
            'position' => $emp['position'],
            'department' => $emp['department'],
            'days_worked' => $daysWorked,
            'days_absent' => $daysAbsent,
            'late_count' => $lateCount,
            'rate_per_day' => $ratePerDay,
            'gross_pay' => $grossPay,
            'deduction_absent' => $deductAbsent,
            'deduction_late' => $deductLate,
            'deduction_sss' => $sss,
            'deduction_philhealth' => $philhealth,
            'deduction_pagibig' => $pagibig,
            'total_deductions' => $totalDeduct,
            'net_pay' => $netPay
        );
    }
}

// Process Payroll (Save to database)
if(isset($_POST['btnProcess']) && !empty($payrollData)) {
    if(!$payrollTableExists) {
        $errorMsg = "Payroll table not found. Import data/payroll.sql first.";
    } else {
        $processed = 0;
        foreach($payrollData as $data) {
            $insertQuery = "INSERT INTO payroll (
                payroll_period, date_from, date_to, emp_num, lname, fname, mname,
                department, position, days_worked, days_absent, late_count, rate_per_day,
                gross_pay, deduction_absent, deduction_late, deduction_sss,
                deduction_philhealth, deduction_pagibig, total_deductions, net_pay, status
            ) VALUES (
                '$payrollPeriod', '$dateFrom', '$dateTo',
                '{$data['emp_num']}', '{$data['lname']}', '{$data['fname']}', '{$data['mname']}',
                '{$data['department']}', '{$data['position']}', {$data['days_worked']}, {$data['days_absent']},
                {$data['late_count']}, {$data['rate_per_day']}, {$data['gross_pay']},
                {$data['deduction_absent']}, {$data['deduction_late']}, {$data['deduction_sss']},
                {$data['deduction_philhealth']}, {$data['deduction_pagibig']},
                {$data['total_deductions']}, {$data['net_pay']}, 'Processed'
            )";
            
            if(mysqli_query($conn, $insertQuery)) {
                $processed++;
            }
        }
        
        $successMsg = "Payroll processed successfully! $processed employees saved.";
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prepare Payroll - MakSci Enterprise Architecture</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="icon" type="image/png" href="inc/pcaaticon.ico">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<style type="text/css">
<!--
body {
	background-image: url();
	margin-top: 0px;
}

.inline{   
     display: inline-block;   
     float: right;   
     margin: 20px 0px;   
}            
input, button, select{   
     height: 24px;   
     font-size: 12px;
}    

.tr:nth-child(odd) {
	background-color: #ffffff;
}

s.style114 {font-size: 14}
.style116 {color: #000000}
.style11 {font-family: Geneva, Arial, Helvetica, sans-serif}
.style12 {color: #FF0000; font-size: 12px; font-family: Geneva, Arial, Helvetica, sans-serif; }
.style13 {font-size: 12px}
.style14 {color: #FF0000}
.style17 {font-size: 14px}
.style18 {color: #000000; font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; }
.style19 {color: #0000FF}
.style92 {font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px;}
.style85 {font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px;}
-->
</style>

<script>
$(function() {
    $("#date_from, #date_to").datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
</script>

</head>

<body>
<?php include("mainmenu.php"); ?>
<center>

<!-- Success Message -->
<?php if(isset($successMsg)): ?>
<div style="background: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; margin: 10px auto; width: 99%; text-align: center; font-weight: bold;">
    <?php echo $successMsg; ?>
</div>
<?php endif; ?>

<?php if(isset($errorMsg)): ?>
<div style="background: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; margin: 10px auto; width: 99%; text-align: center; font-weight: bold;">
    <?php echo $errorMsg; ?>
</div>
<?php endif; ?>


<table width="99%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td width="50%" height="28" valign="middle" bgcolor="#99CCFF" style="padding: 5px;"> 
        <form id="form3" name="form3" method="post" action=""> 
            <span class="style92">Period:</span>
            <input type="text" name="payroll_period" size="8" value="<?php echo $payrollPeriod; ?>" />
            
            <label>From:</label>
            <input type="text" name="date_from" id="date_from" size="8" value="<?php echo $dateFrom; ?>" />
            
            <label>To:</label>
            <input type="text" name="date_to" id="date_to" size="8" value="<?php echo $dateTo; ?>" />
            
            <label>Dept:</label>
            <select name="filter_dept" style="width: 100px;">
                <option value="">Select</option>
                <?php 
                mysqli_data_seek($deptResult, 0);
                while($dept = mysqli_fetch_assoc($deptResult)) { 
                    $selected = ($filterDept == $dept['department']) ? 'selected' : '';
                ?>
                <option value="<?php echo $dept['department']; ?>" <?php echo $selected; ?>><?php echo $dept['department']; ?></option>
                <?php } ?>
            </select>
            
            <input type="submit" name="btnPreview" value="PREVIEW" style="background: #5cb85c; color: white; border: none; cursor: pointer;" />
        </form>
    </td>
    <td width="50%" align="right" valign="middle" bgcolor="#CCFFCC" style="padding: 5px;">
        <form method="post" action="">
            <input type="hidden" name="payroll_period" value="<?php echo $payrollPeriod; ?>">
            <input type="hidden" name="date_from" value="<?php echo $dateFrom; ?>">
            <input type="hidden" name="date_to" value="<?php echo $dateTo; ?>">
            <input type="hidden" name="filter_dept" value="<?php echo $filterDept; ?>">
            
            <span class="style85">
            <!-- Type to search -->
            <input type="text" name="search_emp" size="8" value="<?php echo $searchEmp; ?>" placeholder="Type Emp#" />
            
            OR
            
           
            <select name="filter_emp" style="width: 120px;">
                <option value="">Emp. Number</option>
                <?php 
                mysqli_data_seek($empResult, 0);
                while($emp = mysqli_fetch_assoc($empResult)) { 
                    $selected = ($filterEmp == $emp['emp_num']) ? 'selected' : '';
                ?>
                <option value="<?php echo $emp['emp_num']; ?>" <?php echo $selected; ?>>
                    <?php echo $emp['emp_num'] . ' - ' . $emp['lname']; ?>
                </option>
                <?php } ?>
            </select>
            <input type="submit" name="btnPreview" value="Go" style="background: #5cb85c; color: white; border: none; cursor: pointer;">
            </span>
        </form> 
    </td>
  </tr>
</table>

<!-- Show active filter -->
<?php if(!empty($filterEmp)): ?>
<div style="background: #fff3cd; border: 1px solid #ffc107; padding: 5px; margin: 5px auto; width: 99%; font-size: 12px;">
    <strong>Filter:</strong> Employee #<?php echo $filterEmp; ?> 
    <a href="prepare_payroll.php" style="color: #856404; text-decoration: underline; float: right;">Clear Filter</a>
</div>
<?php endif; ?>

<!-- Process Button (if preview done) -->
<?php if(!empty($payrollData) && !isset($successMsg)): ?>
<div style="width: 99%; margin: 10px auto; text-align: right;">
    <form method="post" action="">
        <input type="hidden" name="payroll_period" value="<?php echo $payrollPeriod; ?>">
        <input type="hidden" name="date_from" value="<?php echo $dateFrom; ?>">
        <input type="hidden" name="date_to" value="<?php echo $dateTo; ?>">
        <input type="hidden" name="filter_dept" value="<?php echo $filterDept; ?>">
        <input type="hidden" name="filter_emp" value="<?php echo $filterEmp; ?>">
        <input type="submit" name="btnProcess" value="PROCESS PAYROLL" onclick="return confirm('Process and save this payroll?');" style="background: #28a745; color: white; border: none; cursor: pointer; font-weight: bold; padding: 5px 15px;" />
    </form>
</div>
<?php endif; ?>


<?php if(!empty($payrollData)): ?>
<table width="99%" height="52" border="0" cellpadding="3" cellspacing="1" bordercolor="#99CCCC" align="center">
    <tr bgcolor="#000033">
      <td width="187" bgcolor="#6699CC" class="style85 style77 style68"><span class="style17 style11 style116 style93"><strong>Employee Name </strong></span></td>
      <td width="161" align="left" bgcolor="#6699CC" class="style85 style77 style68"><span class="style17 style11 style116 style93"><strong>Position / Department</strong></span></td>
      <td width="89" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Days</span></td>
      <td width="61" align="center" bgcolor="#6699CC" class="style85 style77 style68"><span class="style18">Absent</span></td>
      <td width="74" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Late</span></td>
      <td width="82" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Rate/Day</span></td>
      <td width="60" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Gross</span></td>
      <td width="60" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Deduct</span></td>
      <td width="60" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Net Pay</span></td>
    </tr>

  <?php
    $rowCount = 0;
    foreach($payrollData as $data) {  
        $rowCount++;
        
      
        if(@$color == "#EBEAE9") {
            @$color = "#DEEFE9";
        } else {
            @$color = "#EBEAE9";
        }			
  ?>

    <tr bordercolor="#996633" bgcolor="#FFCCFF" class="style68">
      <td height="24" valign="top" bgcolor="<?php echo $color; ?>" class="style114">
        <span class="style114 style11 style13">
          <?php echo $data['lname']; ?>,&nbsp;<?php echo $data['fname']; ?>&nbsp;<?php echo substr($data['mname'], 0, 1); ?>.
        </span>
      </td>
      <td align="left" valign="top" bgcolor="<?php echo $color; ?>" class="style114">
        <span class="style114 style11 style13"><?php echo $data['position']; ?> / <?php echo $data['department']; ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114">
        <span class="style114 style11 style13"><?php echo $data['days_worked']; ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114">
        <span class="style114 style11 style13"><?php echo $data['days_absent']; ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114">
        <span class="style114 style11 style13"><?php echo $data['late_count']; ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114 style11 style13">
        <span class="style114"><?php echo number_format($data['rate_per_day'], 2); ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114 style11 style13">
        <span class="style114"><?php echo number_format($data['gross_pay'], 2); ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114 style11 style13">
        <span class="style114"><?php echo number_format($data['total_deductions'], 2); ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114 style11 style13">
        <span class="style114"><?php echo number_format($data['net_pay'], 2); ?></span>
      </td>
    </tr>

     <?php
 	  }
  ?>
  </table>
<?php else: ?>
<div style="padding: 50px; color: #999; text-align: center;">
    <p class="style11">Click "PREVIEW" to calculate payroll</p>
</div>
<?php endif; ?>

</center>

</body>
</html>
