<?php
@session_start();
include("webconnect.php");

// Get filter values
$payrollMonth = isset($_POST['payroll_month']) ? $_POST['payroll_month'] : date('Y-m');
$filterEmp = isset($_POST['filter_emp']) ? $_POST['filter_emp'] : '';
$searchEmp = isset($_POST['search_emp']) ? $_POST['search_emp'] : '';

if(!empty($searchEmp)) {
    $filterEmp = $searchEmp;
}

// Date range for selected month
$monthStart = $payrollMonth . '-01';
$monthEnd = date('Y-m-t', strtotime($monthStart));

// Build where clause
$whereParts = array();
$whereParts[] = "a.log_date BETWEEN '$monthStart' AND '$monthEnd'";
if(!empty($filterEmp)) {
    $whereParts[] = "e.emp_num LIKE '%$filterEmp%'";
}

$whereClause = "WHERE " . implode(" AND ", $whereParts);

// Query to get employee payroll data (fixed for attendance_logs)
$query = "SELECT 
    e.emp_num,
    e.lname,
    e.fname,
    e.mname,
    e.position,
    e.department,
    COALESCE(e.rateperday, e.salary / 26) as rateperday,
    e.salary,
    COALESCE(e.sss, 0) as sss,
    COALESCE(e.philhealth, 0) as philhealth,
    COALESCE(e.pagibig, 0) as pagibig,
    COUNT(CASE WHEN a.time_in IS NOT NULL THEN 1 END) as days_worked,
    SUM(CASE WHEN TIME(a.time_in) > '08:00:00' OR a.status = 'Late' THEN 1 ELSE 0 END) as late_count,
    (DAY(LAST_DAY('$monthStart')) - COUNT(CASE WHEN a.time_in IS NOT NULL THEN 1 END)) as absent_count
FROM employees e
LEFT JOIN attendance_logs a ON e.emp_num = a.emp_num AND a.log_date BETWEEN '$monthStart' AND '$monthEnd'
$whereClause
GROUP BY e.emp_num, e.lname, e.fname, e.mname, e.position, e.department, e.rateperday, e.salary, e.sss, e.philhealth, e.pagibig
ORDER BY e.lname, e.fname";

$result = mysqli_query($conn, $query);

// For employee dropdown
$empQuery = "SELECT DISTINCT e.emp_num, e.lname, e.fname 
             FROM employees e 
             INNER JOIN attendance_logs a ON e.emp_num = a.emp_num 
             ORDER BY e.lname, e.fname";
$empResult = mysqli_query($conn, $empQuery);

// Calculate totals
$totalGross = 0;
$totalDeduct = 0;
$totalNet = 0;
$payrollData = array();

while ($row = mysqli_fetch_assoc($result)) {  
    $daysWorked = (int)$row['days_worked'];
    $daysAbsent = (int)$row['absent_count'];
    $lateCount = (int)$row['late_count'];
    $ratePerDay = (float)$row['rateperday'];
    
    $grossPay = $daysWorked * $ratePerDay;
    $deductAbsent = $daysAbsent * $ratePerDay;
    $deductLate = $lateCount * ($ratePerDay * 0.1);
    $sss = (float)$row['sss'];
    $philhealth = (float)$row['philhealth'];
    $pagibig = (float)$row['pagibig'];
    
    $totalDeductions = $deductAbsent + $deductLate + $sss + $philhealth + $pagibig;
    $netPay = $grossPay - $totalDeductions;
    
    $totalGross += $grossPay;
    $totalDeduct += $totalDeductions;
    $totalNet += $netPay;
    
    $payrollData[] = array(
        'emp_num' => $row['emp_num'],
        'name' => $row['lname'] . ', ' . $row['fname'] . ($row['mname'] ? ' ' . substr($row['mname'], 0, 1) . '.' : ''),
        'position' => $row['position'],
        'department' => $row['department'],
        'days' => $daysWorked,
        'absent' => $daysAbsent,
        'late' => $lateCount,
        'rate' => $ratePerDay,
        'gross' => $grossPay,
        'deduct' => $totalDeductions,
        'net' => $netPay
    );
}

mysqli_data_seek($result, 0);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Payroll Reports</title>
<link href="style.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
<style>
table { width: 98%; border-collapse: collapse; margin: 10px auto; font-family: Arial; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
th { background: #f4f4f4; font-weight: bold; }
tr:nth-child(even) { background: #f9f9f9; }
.btn-pdf { background: #dc3545; color: white; padding: 8px 16px; border: none; cursor: pointer; }
.no-record { background: #f8d7da; border: 1px solid #f5c6cb; padding: 20px; margin: 20px auto; max-width: 600px; text-align: center; }
</style>
</head>
<body>
<?php include("mainmenu.php"); ?>

<div style="text-align:center; margin:20px;">
<h2>Payroll Reports</h2>
</div>

<form method="post">
<table style="margin: 0 auto;">
<tr>
<td>Period: <input type="month" name="payroll_month" value="<?php echo $payrollMonth; ?>"></td>
<td><input type="text" name="search_emp" placeholder="Emp#" value="<?php echo $searchEmp; ?>"></td>
<td>
<select name="filter_emp">
<option value="">All</option>
<?php 
if($empResult):
while($emp = mysqli_fetch_assoc($empResult)):
?>
<option value="<?php echo $emp['emp_num']; ?>" <?php echo ($filterEmp == $emp['emp_num']) ? 'selected' : ''; ?>><?php echo $emp['emp_num'].' - '.$emp['lname']; ?></option>
<?php endwhile; endif; ?>
</select>
</td>
<td><input type="submit" value="Generate"></td>
<td><button type="button" onclick="printPDF()" class="btn-pdf" <?php echo empty($payrollData)?'disabled':''; ?>>PDF</button></td>
</tr>
</table>
</form>

<?php if(!empty($filterEmp)): ?>
<div style="background: #fff3cd; padding: 10px; margin: 10px auto; max-width: 600px; text-align: center;">
Filter: <?php echo $filterEmp; ?> <a href="?payroll_month=<?php echo $payrollMonth; ?>">Clear</a>
</div>
<?php endif; ?>

<?php if(empty($payrollData)): ?>
<div class="no-record">
<h3>No Records Found</h3>
<p>No attendance data for <?php echo date('F Y', strtotime($monthStart)); ?></p>
<p>Tips: Import data/attendance.sql and data/payroll.sql, set employee rateperday >0</p>
</div>
<?php else: ?>
<table>
<tr>
<th>Emp No</th><th>Name</th><th>Position</th><th>Dept</th><th>Days</th><th>Absent</th><th>Late</th><th>Rate/Day</th><th>Gross</th><th>Deduct</th><th>Net</th>
</tr>
<?php foreach($payrollData as $data): ?>
<tr>
<td><?php echo $data['emp_num']; ?></td>
<td><?php echo htmlspecialchars($data['name']); ?></td>
<td><?php echo htmlspecialchars($data['position']); ?></td>
<td><?php echo htmlspecialchars($data['department']); ?></td>
<td><?php echo $data['days']; ?></td>
<td><?php echo $data['absent']; ?></td>
<td><?php echo $data['late']; ?></td>
<td><?php echo number_format($data['rate'],2); ?></td>
<td><?php echo number_format($data['gross'],2); ?></td>
<td><?php echo number_format($data['deduct'],2); ?></td>
<td style="font-weight:bold;color:green;"><?php echo number_format($data['net'],2); ?></td>
</tr>
<?php endforeach; ?>
<tr style="font-weight:bold;background:#d4edda;">
<td colspan="7"></td>
<td>TOTALS</td>
<td><?php echo number_format($totalGross,2); ?></td>
<td><?php echo number_format($totalDeduct,2); ?></td>
<td><?php echo number_format($totalNet,2); ?></td>
</tr>
</table>
<?php endif; ?>

<script>
function printPDF(){
    if(<?php echo empty($payrollData)?1:0; ?>) return alert('No data');
    const {jsPDF} = window.jspdf;
    const doc = new jsPDF('l');
    doc.text('Payroll Report <?php echo $payrollMonth; ?>', 14, 15);
    doc.autoTable({
        head: [['Emp','Name','Pos','Dept','Days','Abs','Late','Rate','Gross','Deduct','Net']],
        body: <?php echo json_encode(array_map(function($r){return array_values($r);}, $payrollData)); ?>,
        foot: [['','','','','','','','TOTALS','<?php echo number_format($totalGross,2); ?>','<?php echo number_format($totalDeduct,2); ?>','<?php echo number_format($totalNet,2); ?>']]
    });
    doc.save('payroll_<?php echo $payrollMonth; ?>.pdf');
}
</script>

</body>
</html>
