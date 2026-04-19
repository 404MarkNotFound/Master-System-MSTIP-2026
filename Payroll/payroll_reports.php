<?php
@session_start();
include("webconnect.php");

// Get filter values
$payrollMonth = isset($_POST['payroll_month']) ? $_POST['payroll_month'] : date('Y-m');
$filterEmp = isset($_POST['filter_emp']) ? $_POST['filter_emp'] : '';
$searchEmp = isset($_POST['search_emp']) ? $_POST['search_emp'] : '';

// Kung may type sa search, yun ang gamitin
if(!empty($searchEmp)) {
    $filterEmp = $searchEmp;
}

// Date range for selected month
$monthStart = $payrollMonth . '-01';
$monthEnd = date('Y-m-t', strtotime($monthStart));

// Build where clause
$whereParts = array();
$whereParts[] = "t.login_date BETWEEN '$monthStart' AND '$monthEnd'";
if(!empty($filterEmp)) {
    $whereParts[] = "e.emp_num LIKE '%$filterEmp%'";
}

$whereClause = "WHERE " . implode(" AND ", $whereParts);

// Query to get employee payroll data
$query = "SELECT 
    e.emp_num,
    e.lname,
    e.fname,
    e.mname,
    e.position,
    e.department,
    e.rateperday,
    e.salary,
    e.sss,
    e.philhealth,
    e.pagibig,
    COUNT(CASE WHEN t.status IN ('Present', 'Late') THEN 1 END) as days_worked,
    SUM(CASE WHEN t.status = 'Late' THEN 1 ELSE 0 END) as late_count,
    COUNT(CASE WHEN t.status = 'Absent' THEN 1 END) as absent_count
FROM employees e
LEFT JOIN timelogs t ON e.emp_num = t.emp_num AND t.login_date BETWEEN '$monthStart' AND '$monthEnd'
$whereClause
GROUP BY e.emp_num, e.lname, e.fname, e.mname, e.position, e.department, e.rateperday, e.salary, e.sss, e.philhealth, e.pagibig
ORDER BY e.lname, e.fname";

$result = mysqli_query($conn, $query);

// For employee dropdown - mga may timelogs lang
$empQuery = "SELECT DISTINCT e.emp_num, e.lname, e.fname 
             FROM employees e 
             INNER JOIN timelogs t ON e.emp_num = t.emp_num 
             ORDER BY e.lname, e.fname";
$empResult = mysqli_query($conn, $empQuery);

// Calculate totals for PDF
$totalGross = 0;
$totalDeduct = 0;
$totalNet = 0;
$payrollData = array();

while ($row = mysqli_fetch_assoc($result)) {  
    $daysWorked = $row['days_worked'] ? $row['days_worked'] : 0;
    $daysAbsent = $row['absent_count'] ? $row['absent_count'] : 0;
    $lateCount = $row['late_count'] ? $row['late_count'] : 0;
    $ratePerDay = $row['rateperday'] ? $row['rateperday'] : 0;
    
    $grossPay = $daysWorked * $ratePerDay;
    $deductAbsent = $daysAbsent * $ratePerDay;
    $deductLate = $lateCount * ($ratePerDay * 0.1);
    $sss = $row['sss'] ? $row['sss'] : 0;
    $philhealth = $row['philhealth'] ? $row['philhealth'] : 0;
    $pagibig = $row['pagibig'] ? $row['pagibig'] : 0;
    
    $totalDeductions = $deductAbsent + $deductLate + $sss + $philhealth + $pagibig;
    $netPay = $grossPay - $totalDeductions;
    
    $totalGross += $grossPay;
    $totalDeduct += $totalDeductions;
    $totalNet += $netPay;
    
    $payrollData[] = array(
        'emp_num' => $row['emp_num'],
        'name' => $row['lname'] . ', ' . $row['fname'] . ' ' . substr($row['mname'], 0, 1) . '.',
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

// Reset result pointer
mysqli_data_seek($result, 0);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PAYROLL REPORTS - MakSci Enterprise Architecture</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="icon" type="image/png" href="inc/pcaaticon.ico">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<!-- PDF Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

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

/* Print button */
.btn-pdf {
    background: #dc3545;
    color: white;
    border: none;
    padding: 5px 15px;
    cursor: pointer;
    font-weight: bold;
}

/* No record message */
.no-record {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    padding: 30px;
    margin: 20px auto;
    width: 80%;
    text-align: center;
    font-size: 14px;
}
-->
</style>

<script>
$(function() {
    $("#payroll_month").datepicker({
        dateFormat: 'yy-mm',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val(year + '-' + (parseInt(month)+1).toString().padStart(2, '0'));
        }
    });
});

// Formal PDF Print Function
function printPDF() {
    // Check if may data
    <?php if(empty($payrollData)): ?>
    alert('No records to print. Please generate payroll data first.');
    return;
    <?php endif; ?>
    
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4');
    
    // Colors
    const primaryColor = [0, 51, 102]; // Dark blue #003366
    const secondaryColor = [91, 155, 213]; // Light blue #5b9bd5
    const lightGray = [245, 245, 245]; // #f5f5f5
    
    // HEADER SECTION 
    
    // Top border line
    doc.setDrawColor(primaryColor[0], primaryColor[1], primaryColor[2]);
    doc.setLineWidth(2);
    doc.line(10, 10, 287, 10);
    
    // Company Name
    doc.setFontSize(20);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(primaryColor[0], primaryColor[1], primaryColor[2]);
    doc.text('MAKSCI ENTERPRISE ARCHITECTURE', 148.5, 22, { align: 'center' });
    
    // Company Address/Info
    doc.setFontSize(9);
    doc.setFont("helvetica", "normal");
    doc.setTextColor(100, 100, 100);
    doc.text('123 Business Street, Makati City, Philippines', 148.5, 28, { align: 'center' });
    doc.text('Tel: (02) 8123-4567 | Email: info@maksci.com', 148.5, 32, { align: 'center' });
    
    // Horizontal line
    doc.setDrawColor(secondaryColor[0], secondaryColor[1], secondaryColor[2]);
    doc.setLineWidth(0.5);
    doc.line(10, 36, 287, 36);
    
    // DOCUMENT TITLE
    
    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(primaryColor[0], primaryColor[1], primaryColor[2]);
    doc.text('PAYROLL REPORT', 148.5, 46, { align: 'center' });
    
    
    
    // Box background
    doc.setFillColor(lightGray[0], lightGray[1], lightGray[2]);
    doc.rect(10, 52, 277, 20, 'F');
    
    // Box border
    doc.setDrawColor(secondaryColor[0], secondaryColor[1], secondaryColor[2]);
    doc.setLineWidth(0.3);
    doc.rect(10, 52, 277, 20);
    
    // Info labels
    doc.setFontSize(10);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(primaryColor[0], primaryColor[1], primaryColor[2]);
    doc.text('PAYROLL PERIOD:', 15, 60);
    doc.text('DATE RANGE:', 120, 60);
    doc.text('GENERATED:', 220, 60);
    
    // Info values
    doc.setFont("helvetica", "normal");
    doc.setTextColor(0, 0, 0);
    doc.text('<?php echo strtoupper(date('F Y', strtotime($monthStart))); ?>', 15, 67);
    doc.text('<?php echo $monthStart; ?> to <?php echo $monthEnd; ?>', 120, 67);
    doc.text('<?php echo date('F d, Y h:i A'); ?>', 220, 67);
    
    // TABLE 
    
    const tableStartY = 78;
    
    // Table headers
    const headers = [
        ['EMP. NO.', 'EMPLOYEE NAME', 'POSITION', 'DEPT', 'DAYS', 'ABSENT', 'LATE', 'RATE/DAY', 'GROSS PAY', 'DEDUCTIONS', 'NET PAY']
    ];
    
    // Table data
    const data = [
        <?php 
        if(!empty($payrollData)):
        foreach($payrollData as $data): ?>
        [
            '<?php echo $data['emp_num']; ?>',
            '<?php echo addslashes($data['name']); ?>',
            '<?php echo addslashes($data['position']); ?>',
            '<?php echo addslashes($data['department']); ?>',
            '<?php echo $data['days']; ?>',
            '<?php echo $data['absent']; ?>',
            '<?php echo $data['late']; ?>',
            '<?php echo number_format($data['rate'], 2); ?>',
            '<?php echo number_format($data['gross'], 2); ?>',
            '<?php echo number_format($data['deduct'], 2); ?>',
            '<?php echo number_format($data['net'], 2); ?>'
        ],
        <?php 
        endforeach;
        endif; 
        ?>
    ];
    
    // Add totals row
    data.push([
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        'TOTALS:',
        '<?php echo number_format($totalGross, 2); ?>',
        '<?php echo number_format($totalDeduct, 2); ?>',
        '<?php echo number_format($totalNet, 2); ?>'
    ]);
    
    // Generate table
    doc.autoTable({
        head: headers,
        body: data,
        startY: tableStartY,
        theme: 'grid',
        
        // Header styles
        headStyles: { 
            fillColor: primaryColor,
            textColor: 255,
            fontStyle: 'bold',
            fontSize: 9,
            halign: 'center',
            valign: 'middle',
            cellPadding: 3
        },
        
        // Body styles
        bodyStyles: {
            fontSize: 8,
            cellPadding: 2,
            valign: 'middle'
        },
        
        // Alternate row colors
        alternateRowStyles: { 
            fillColor: [250, 250, 250]
        },
        
        // Column styles
        columnStyles: {
            0: { cellWidth: 20, halign: 'center' },      // Emp No
            1: { cellWidth: 45, halign: 'left' },        // Name
            2: { cellWidth: 40, halign: 'left' },        // Position
            3: { cellWidth: 30, halign: 'center' },      // Dept
            4: { cellWidth: 12, halign: 'center' },      // Days
            5: { cellWidth: 12, halign: 'center' },      // Absent
            6: { cellWidth: 12, halign: 'center' },      // Late
            7: { cellWidth: 22, halign: 'right' },       // Rate
            8: { cellWidth: 25, halign: 'right' },       // Gross
            9: { cellWidth: 25, halign: 'right' },       // Deductions
            10: { cellWidth: 25, halign: 'right', fontStyle: 'bold' }  // Net
        },
        
        // Totals row style (last row)
        didParseCell: function(data) {
            if (data.row.index === data.table.body.length - 1) {
                data.cell.styles.fillColor = [230, 240, 255];
                data.cell.styles.fontStyle = 'bold';
                data.cell.styles.textColor = primaryColor;
            }
        }
    });
    
    // SUMMARY BOX 
    
    const finalY = doc.lastAutoTable.finalY + 10;
    
    // Summary box
    doc.setFillColor(lightGray[0], lightGray[1], lightGray[2]);
    doc.rect(150, finalY, 137, 25, 'F');
    doc.setDrawColor(secondaryColor[0], secondaryColor[1], secondaryColor[2]);
    doc.rect(150, finalY, 137, 25);
    
    doc.setFontSize(10);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(primaryColor[0], primaryColor[1], primaryColor[2]);
    doc.text('SUMMARY:', 155, finalY + 8);
    
    doc.setFont("helvetica", "normal");
    doc.setTextColor(0, 0, 0);
    doc.text('Total Employees: <?php echo count($payrollData); ?>', 155, finalY + 15);
    doc.text('Total Gross Pay: Php <?php echo number_format($totalGross, 2); ?>', 155, finalY + 22);
    doc.text('Total Net Pay: Php <?php echo number_format($totalNet, 2); ?>', 220, finalY + 22);
    
    // FOOTER 
    
    const pageHeight = doc.internal.pageSize.height;
    
    // Footer line
    doc.setDrawColor(primaryColor[0], primaryColor[1], primaryColor[2]);
    doc.setLineWidth(1);
    doc.line(10, pageHeight - 20, 287, pageHeight - 20);
    
    // Footer text
    doc.setFontSize(8);
    doc.setTextColor(100, 100, 100);
    doc.text('This is a computer-generated document. No signature required.', 148.5, pageHeight - 12, { align: 'center' });
    doc.text('MakSci Enterprise Architecture - Confidential', 148.5, pageHeight - 8, { align: 'center' });
    
    // Page number
    const pageCount = doc.internal.getNumberOfPages();
    for(let i = 1; i <= pageCount; i++) {
        doc.setPage(i);
        doc.setFontSize(8);
        doc.text('Page ' + i + ' of ' + pageCount, 287, pageHeight - 8, { align: 'right' });
    }
    
    //  SAVE PDF 
    
    doc.save('Payroll_Report_<?php echo $payrollMonth; ?>.pdf');
}
</script>

</head>

<body>
<?php include("mainmenu.php"); ?>
<center>


<table width="99%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td width="50%" height="28" valign="middle" bgcolor="#99CCFF" style="padding: 5px;"> 
        <form id="form3" name="form3" method="post" action=""> 
            <span class="style92">Payroll Period:</span>
            <input type="text" name="payroll_month" id="payroll_month" size="10" value="<?php echo $payrollMonth; ?>" />
            
            <input type="submit" value="GO" style="background: #5cb85c; color: white; border: none; cursor: pointer;" />
            <input type="button" value="All" onclick="window.location='payroll_reports.php'" style="background: #f0f0f0; border: 1px solid #ccc; cursor: pointer;" />
        </form>
    </td>
    <td width="50%" align="right" valign="middle" bgcolor="#CCFFCC" style="padding: 5px;">
        <form method="post" action="">
            <input type="hidden" name="payroll_month" value="<?php echo $payrollMonth; ?>">
            
            <span class="style85">
            <!-- Type to search -->
            <input type="text" name="search_emp" size="8" value="<?php echo $searchEmp; ?>" placeholder="Type Emp#" />
            
            OR
            
            <!-- Select from dropdown -->
            <select name="filter_emp" style="width: 120px;">
                <option value="">Emp. Number</option>
                <?php 
                if($empResult && mysqli_num_rows($empResult) > 0):
                mysqli_data_seek($empResult, 0);
                while($emp = mysqli_fetch_assoc($empResult)): 
                    $selected = ($filterEmp == $emp['emp_num']) ? 'selected' : '';
                ?>
                <option value="<?php echo $emp['emp_num']; ?>" <?php echo $selected; ?>>
                    <?php echo $emp['emp_num'] . ' - ' . $emp['lname']; ?>
                </option>
                <?php 
                endwhile;
                endif; 
                ?>
            </select>
            <input type="submit" value="Go" style="background: #5cb85c; color: white; border: none; cursor: pointer;">
            
            <!-- PDF Print Button -->
            <button type="button" onclick="printPDF()" class="btn-pdf" style="margin-left: 10px;" <?php echo empty($payrollData) ? 'disabled' : ''; ?>>
                PRINT PDF
            </button>
            </span>
        </form> 
    </td>
  </tr>
</table>

<!-- Show active filter -->
<?php if(!empty($filterEmp)): ?>
<div style="background: #fff3cd; border: 1px solid #ffc107; padding: 5px; margin: 5px auto; width: 99%; font-size: 12px;">
    <strong>Filter:</strong> Employee #<?php echo $filterEmp; ?> 
    <a href="payroll_reports.php?payroll_month=<?php echo $payrollMonth; ?>" style="color: #856404; text-decoration: underline; float: right;">Clear Filter</a>
</div>
<?php endif; ?>

<!-- NO RECORD MESSAGE -->
<?php if(empty($payrollData)): ?>

<div class="no-record">
    <p class="style11" style="font-size: 16px; margin-bottom: 10px;"><strong>⚠ NO RECORDS FOUND</strong></p>
    <p class="style11">There are no payroll records for the selected period.</p>
    <p class="style11" style="font-size: 12px; margin-top: 15px;">
        Payroll Period: <strong><?php echo strtoupper(date('F Y', strtotime($monthStart))); ?></strong><br>
        Date Range: <?php echo $monthStart; ?> to <?php echo $monthEnd; ?>
    </p>
    <p class="style11" style="font-size: 12px; margin-top: 15px; color: #856404;">
        Tips:<br>
        • Make sure there are attendance records in timelogs table<br>
        • Check if employees have rate per day set<br>
        • Try selecting a different month or date range
    </p>
</div>

<!-- DATA TABLE WITH RECORDS -->
<?php else: ?>

<table width="99%" height="52" border="0" cellpadding="3" cellspacing="1" bordercolor="#99CCCC" align="center" id="payrollTable">
    <tr bgcolor="#000033">
      <td width="80" bgcolor="#6699CC" class="style85 style77 style68"><span class="style17 style11 style116 style93"><strong>Emp. No.</strong></span></td>
      <td width="150" bgcolor="#6699CC" class="style85 style77 style68"><span class="style17 style11 style116 style93"><strong>Employee Name</strong></span></td>
      <td width="120" align="left" bgcolor="#6699CC" class="style85 style77 style68"><span class="style17 style11 style116 style93"><strong>Position</strong></span></td>
      <td width="100" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Dept</span></td>
      <td width="50" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Days</span></td>
      <td width="50" align="center" bgcolor="#6699CC" class="style85 style77 style68"><span class="style18">Absent</span></td>
      <td width="50" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Late</span></td>
      <td width="80" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Rate/Day</span></td>
      <td width="90" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Gross</span></td>
      <td width="90" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Deduct</span></td>
      <td width="90" align="center" bgcolor="#6699CC" class="style68 style77 style85"><span class="style18">Net Pay</span></td>
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
        <span class="style114 style11 style13"><?php echo $data['emp_num']; ?></span>
      </td>
      <td height="24" valign="top" bgcolor="<?php echo $color; ?>" class="style114">
        <span class="style114 style11 style13"><?php echo $data['name']; ?></span>
      </td>
      <td align="left" valign="top" bgcolor="<?php echo $color; ?>" class="style114">
        <span class="style114 style11 style13"><?php echo $data['position']; ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114">
        <span class="style114 style11 style13"><?php echo $data['department']; ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114">
        <span class="style114 style11 style13"><?php echo $data['days']; ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114">
        <span class="style114 style11 style13"><?php echo $data['absent']; ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114">
        <span class="style114 style11 style13"><?php echo $data['late']; ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114 style11 style13">
        <span class="style114"><?php echo number_format($data['rate'], 2); ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114 style11 style13">
        <span class="style114"><?php echo number_format($data['gross'], 2); ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114 style11 style13">
        <span class="style114"><?php echo number_format($data['deduct'], 2); ?></span>
      </td>
      <td align="center" valign="top" bgcolor="<?php echo $color; ?>" class="style114 style11 style13">
        <span class="style114" style="font-weight: bold; color: #28a745;"><?php echo number_format($data['net'], 2); ?></span>
      </td>
    </tr>

     <?php
 	  }
  ?>
    <tr bgcolor="#d4edda" style="font-weight: bold;">
      <td height="24" colspan="8" align="right" valign="middle" class="style114">
        <span class="style114 style11 style13"><strong>TOTALS:</strong></span>
      </td>
      <td align="center" valign="middle" class="style114 style11 style13">
        <span class="style114"><strong><?php echo number_format($totalGross, 2); ?></strong></span>
      </td>
      <td align="center" valign="middle" class="style114 style11 style13">
        <span class="style114"><strong><?php echo number_format($totalDeduct, 2); ?></strong></span>
      </td>
      <td align="center" valign="middle" class="style114 style11 style13">
        <span class="style114" style="color: #28a745;"><strong><?php echo number_format($totalNet, 2); ?></strong></span>
      </td>
    </tr>
  </table>

<?php endif; ?>

</center>

</body>
</html>