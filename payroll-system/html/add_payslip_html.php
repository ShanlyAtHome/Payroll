<?php
// add_payslip_form.php
$data = include('../php/add_payslip.php');
$employee = $data['employee'];
$payroll_result = $data['payroll_result'];
$message = $data['message'];
?>

<div class="add-payslip-details">
    <div class="sub-details">
        <p><strong>ID:</strong> <?= mb_strtoupper(htmlspecialchars($employee['employee_id'])) ?></p>
        <p><strong>Name:</strong> <?= mb_strtoupper(htmlspecialchars($employee['first_name'].' '.$employee['last_name'])) ?></p>
    </div>
    <div class="sub-details">
        <p><strong>Position:</strong> <?= mb_strtoupper(htmlspecialchars($employee['position'])) ?></p>
        <p><strong>Status:</strong> <?= mb_strtoupper(htmlspecialchars($employee['status'])) ?></p>
    </div>
</div>

<?php if($message): ?>
    <p style="color:green;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form id="payslipForm" method="post">
    <input type="hidden" name="employee_id" value="<?= htmlspecialchars($employee['employee_id']) ?>">

    <label>Year:</label>
    <select name="year" required>
        <option value="">-- Select Year --</option>
        <?php for($y=date("Y"); $y>=2000; $y--): ?>
            <option value="<?= $y ?>"><?= $y ?></option>
        <?php endfor; ?>
    </select><br><br>

    <label>Payroll Period:</label>
    <select name="payroll_id" required>
        <option value="">-- Select Payroll Period --</option>
        <?php while($row=$payroll_result->fetch_assoc()): ?>
            <option value="<?= htmlspecialchars($row['payroll_id']) ?>"><?= htmlspecialchars($row['week']) ?></option>
        <?php endwhile; ?>
    </select><br><br>

<?php 
$label_overrides = [
    'num_of_days_for_rate_1' => 'Daily Minimum Wage',
    'num_of_days_for_rate_2' => 'Sunday Rest Day',
    'num_of_days_for_rate_3' => 'Legal Holiday',
    'num_of_days_for_rate_4' => 'Special Holiday',
    'num_of_hours_for_rate_5' => 'Regular Overtime/Hour',
    'num_of_hours_for_rate_6' => 'Special Overtime/Hour',
    'num_of_hours_for_rate_7' => 'Special Holiday Overtime/Hour',
    'num_of_hours_for_rate_8' => 'Regular Holiday Overtime/Hour',
    'num_of_days_for_rate_9' => 'Cater',
];
?>

<?php foreach ($rate_labels as $name => $data): 
    $rate_key = $data['key'];
    $label = $label_overrides[$name] ?? $data['label'];
    $multiplier = $employee[$rate_key] ?? 0;
?>
    <div class="rate-box">
        <label><?= htmlspecialchars($label) ?>:</label>
        <input 
            id="add-payslip-for-num"
            type="number" 
            name="<?= htmlspecialchars($name) ?>" 
            id="input_<?= $rate_key ?>" 
            data-multiplier="<?= htmlspecialchars($multiplier) ?>" 
            min="0" 
            value="0">
        <p><strong>Result:</strong> <span id="result_<?= $rate_key ?>">0.00</span></p>
    </div>
<?php endforeach; ?>


<table id="add-payslip-data">
    <tr id="add-payslip-row">
        <td>Gross Pay:</td>
        <td>0.00</td>
    </tr>
</table>

<div style="margin-bottom: 10px;">
    <label>
        <input type="checkbox" id="disableGovDeductionsToggle" style="margin-left: 15px;">
        Disable Government Deductions (SSS, Pagibig, PhilHealth)
    </label>
</div>


<label>Deductions:</label>
<table id="add-payslip-data">
    <tr id="add-payslip-row">
        <td id="for-indent">SSS (5%):</td>
        <td id="sss">0.00</td>
    </tr>
    <tr id="add-payslip-row">
        <td id="for-indent">Pagibig (2%):</td>
        <td id="pagibig">0.00</td>
    </tr>
    <tr id="add-payslip-row">
        <td id="for-indent">PhilHealth (2.5%):</td>  
        <td id="philhealth">0.00</td>
    </tr>
</table>

  <div>
    <span class="for-indent">Cater: </span>
    <input style="margin-left: 26.5px;" class="add-payslip-for-num-special" type="number" id="cater_deductions" name="cater_deductions" value="<?= htmlspecialchars($_POST['cater_deductions'] ?? 0) ?>">
  </div>
  <div>
    <span class="for-indent">Advance: </span>
    <input class="add-payslip-for-num-special" type="number" id="advance_deductions" name="advance_deductions" value="<?= htmlspecialchars($_POST['advance_deductions'] ?? 0) ?>">
  </div>
</div>

<table id="add-payslip-data">
    <tr id="add-payslip-row">
        <td>Total Deductions:</td>
        <td>0.00</td>
    </tr>
</table>

<table id="add-payslip-data">
    <tr id="add-payslip-row">
        <td>Net Pay:</td>
        <td>0.00</td>
    </tr>
</table>

    <button class="save-edit-button" type="submit">Submit</button>
</form>
