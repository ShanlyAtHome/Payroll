<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("No ID provided.");
}

// Fetch existing employee data
$sql = "SELECT * FROM employee_info WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Employee not found.");
}

$employee = $result->fetch_assoc();

// Update logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $status = $_POST['status'];
$deductions = isset($_POST['deductions']) ? implode(',', $_POST['deductions']) : '';
    $board_lodging = $_POST['board_lodging'];
    $food_allowance = $_POST['food_allowance'];
    $lodging_address = $_POST['lodging_address'] ?? null;

    $update_sql = "UPDATE employee_info SET 
    name = ?, 
    position = ?, 
    status = ?, 
    deductions = ?, 
    board_lodging = ?, 
    food_allowance = ?,
    lodging_address = ?
    WHERE id = ?";

$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("ssssssss", $name, $position, $status, $deductions, $board_lodging, $food_allowance, $lodging_address, $id);

    if ($update_stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . $update_stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="add_edit.css" rel="stylesheet">
    <title>Edit Employee</title>
</head>
<body>

<h2 style="text-align:center;">
    Edit Employee
</h2>

<div id="parent_div">
    <form id="info" method="POST">
    <div id="text_info">
        <label for="id">Employee ID:</label>
        <input type="text" value="<?= htmlspecialchars($employee['id']) ?>" disabled>

        <label for="name">Full Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($employee['name']) ?>" required>

        <label for="position">Position:</label>
        <input type="text" name="position" value="<?= htmlspecialchars($employee['position']) ?>" required>
    </div>

    <label id="text_info">Status:</label>
    <div class="toggle-group">
        <div id="toggle-group-one">
            <input type="radio" name="status" value="Permanent" <?= $employee['status'] === 'Permanent' ? 'checked' : '' ?>> 
            <label>Permanent</label>
        </div>
        <div id="toggle-group-one">
            <input type="radio" name="status" value="On-Call" <?= $employee['status'] === 'On-Call' ? 'checked' : '' ?>> 
            <label>On-Call</label>
        </div>
    </div>

    <label id="text_info">Deductions:</label>
    <div class="toggle-group">
        <div id="toggle-group-one">
            <input type="checkbox" name="deductions[]" value="SSS">
            <label>SSS</label>
        </div>
        <div id="toggle-group-one">
            <input type="checkbox" name="deductions[]" value="PhilHealth"> 
            <label>PhilHealth</label>
        </div>
        <div id="toggle-group-one">
            <input type="checkbox" name="deductions[]" value="Pag-IBIG"> 
            <label>Pag-IBIG</label>
        </div>
        <div id="toggle-group-one">
            <input type="checkbox" name="deductions[]" value="Tax"> 
            <label>Tax</label>
        </div>
        <div id="toggle-group-one">
            <input type="checkbox" name="deductions[]" value="Others"> 
            <label>Others</label>
        </div>
    </div>


    <label id="text_info">Board & Lodging:</label>
    <div class="toggle-group">
        <div id="toggle-group-one">
            <input type="radio" name="board_lodging" value="Yes" <?= $employee['board_lodging'] === 'Yes' ? 'checked' : '' ?> onchange="toggleAddress(true)"> 
            <label>Yes</label>
        </div>
        <div id="toggle-group-one">
            <input type="radio" name="board_lodging" value="No" <?= $employee['board_lodging'] === 'No' ? 'checked' : '' ?> onchange="toggleAddress(false)"> 
            <label>No</label>
        </div>
    </div>

    <div id="addressField" style="display:none; margin-top:10px;">
        <label id="text_info" for="lodging_address">Lodging Address:</label>
        <input type="text" name="lodging_address" id="lodging_address" value="<?= htmlspecialchars($employee['lodging_address'] ?? '') ?>">
    </div>


    <label id="text_info" for="food_allowance">Food Allowance:</label>
    <select name="food_allowance" required>
        <option value="None" <?= $employee['food_allowance'] === 'None' ? 'selected' : '' ?>>None</option>
        <option value="Partial" <?= $employee['food_allowance'] === 'Partial' ? 'selected' : '' ?>>Partial</option>
        <option value="Full" <?= $employee['food_allowance'] === 'Full' ? 'selected' : '' ?>>Full</option>
    </select>

    <button type="submit" class="submit-btn">Update Employee</button>
</form>

<a href="dashboard.php">← Back to Employee List</a>

<script>
function toggleAddress(show) {
    const addressField = document.getElementById('addressField');
    const addressInput = document.getElementById('lodging_address');
    if (show) {
        addressField.style.display = 'block';
        addressInput.setAttribute('required', 'required');
    } else {
        addressField.style.display = 'none';
        addressInput.removeAttribute('required');
        addressInput.value = ''; // optional: clear the value
    }
}

// Trigger the correct state on page load
window.onload = function () {
    const boardLodgingYes = document.querySelector('input[name="board_lodging"][value="Yes"]');
    toggleAddress(boardLodgingYes.checked);
};
</script>
</div>

</body>
</html>
