<?php
$data = include('../php/edit_payslip.php'); // your PHP backend script
$employee = $data['employee'];
$payroll_result = $data['payroll_result'];
$rate_labels = $data['rate_labels'];
$payroll_data = $data['payroll_data'];
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
    <input type="hidden" name="payroll_id" value="<?= htmlspecialchars($payroll_data['payroll_id'] ?? '') ?>">

    <!-- Year -->
    <label>Year:</label>
    <select name="year" required>
        <option value="">-- Select Year --</option>
        <?php for($y=date("Y"); $y>=2000; $y--): ?>
            <option value="<?= $y ?>" <?= ($payroll_data['year']??'')==$y?'selected':'' ?>><?= $y ?></option>
        <?php endfor; ?>
    </select><br><br>

    <!-- Payroll Week -->
    <label>Payroll Period:</label>
    <select name="week" id="payrollPeriod" required>
        <option value="">-- Select Payroll Period --</option>
        <?php while($row=$payroll_result->fetch_assoc()): ?>
            <option value="<?= htmlspecialchars($row['week']) ?>" <?= ($payroll_data['week']??'')==$row['week']?'selected':'' ?>><?= htmlspecialchars($row['week']) ?></option>
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

    <!-- Rate Inputs -->
    <?php foreach ($rate_labels as $name => $data): 
        $rate_key = $data['key'];
        $label = $label_overrides[$name] ?? $data['label'];
        $value = $payroll_data[$name] ?? 0;
        $multiplier = $employee[$rate_key] ?? 0;
    ?>
        <div class="rate-box">
            <label><?= htmlspecialchars($label) ?>:</label>
            <input 
                id="add-payslip-for-num"
                type="number" 
                name="<?= htmlspecialchars($name) ?>" 
                min="0" 
                value="<?= htmlspecialchars($value) ?>"
                id="input_<?= htmlspecialchars($rate_key) ?>"
                data-multiplier="<?= htmlspecialchars($multiplier) ?>"
            >
            <p><strong>Result:</strong> <span id="result_<?= htmlspecialchars($rate_key) ?>">0.00</span></p>
        </div>
    <?php endforeach; ?>

    <!-- Gross Pay -->
    <table id="add-payslip-data">
        <tr id="add-payslip-row">
            <td>Gross Pay:</td>
            <td>0.00</td>
        </tr>
    </table>

    <!-- Government Deductions Toggle -->
    <div style="margin-top:10px; margin-bottom:5px;">
        <label for="disableGovDeductionsToggle">
            <input type="checkbox" id="disableGovDeductionsToggle" style="margin-left: 15px;">
            Disable Government Deductions (SSS, Pagibig, PhilHealth)
        </label>
    </div>

    <!-- Deductions -->
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
        <input 
            id="cater_deductions"
            style="margin-left: 26.5px;"
            type="number" 
            name="cater_deductions" 
            value="<?= htmlspecialchars($payroll_data['cater_deductions']??0) ?>">
    </div>
    <div>
        <span class="for-indent">Advance: </span>
        <input 
            id="advance_deductions"
            type="number" 
            name="advance_deductions" 
            value="<?= htmlspecialchars($payroll_data['advance_deductions']??0) ?>">
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

    <!-- Hidden inputs for form submit -->
    <input type="hidden" id="hidden_total_amount" name="total_amount">
    <input type="hidden" id="hidden_sss" name="sss">
    <input type="hidden" id="hidden_pagibig" name="pagibig">
    <input type="hidden" id="hidden_philhealth" name="philhealth">
    <input type="hidden" id="hidden_total_deductions" name="total_deductions">
    <input type="hidden" id="hidden_net_pay" name="net_pay">

    <button class="save-edit-button" type="submit">Update</button>
</form>
