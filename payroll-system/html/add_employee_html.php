<form method="POST" action="add_employee.php" class="add-form">
    <fieldset class="add-fieldset">
        <div class="add-form-group">
            <label class="add-label" for="last_name"><strong>Last Name:</strong></label>
            <input oninput="this.value = this.value.toUpperCase()" type="text" id="add-name" name="last_name" required>
        </div>

        <div class="add-form-group">
            <label class="add-label" for="first_name"><strong>First Name:</strong></label>
            <input oninput="this.value = this.value.toUpperCase()" type="text" id="add-name" name="first_name" required>
        </div>

        <div class="add-form-group">
            <label class="add-label" for="position"><strong>Position:</strong></label>
            <input oninput="this.value = this.value.toUpperCase()" type="text" id="add-name" name="position" required>
        </div>

        <div class="add-form-group">
            <label class="add-label" for="status"><strong>Status:</strong></label>
            <select id="add-status" name="status" required>
                <option value="Permanent">PERMANENT</option>
                <option value="On-Call">ON-CALL</option>
            </select>
        </div>

        <div class="add-form-group">
            <label class="add-label" for="board_lodging"><strong>Board & Lodging:</strong></label>
            <select id="add-board_lodging" name="board_lodging" required onchange="toggleLodgingAddress(this.value)">
                <option value="Yes">YES</option>
                <option value="No" selected>NO</option>
            </select>
        </div>

        <div id="lodging_address_wrapper" class="form-group" style="display:none;">
            <label class="add-label" for="lodging_address"><strong>Lodging Address:</strong></label>
            <input oninput="this.value = this.value.toUpperCase()" type="text" id="add-lodging_address" name="lodging_address">
        </div>

        <div class="add-form-group">
            <label class="add-label" for="food_allowance"><strong>Food Allowance:</strong></label>
            <select id="add-food_allowance" name="food_allowance" required>
                <option value="Full">FULL</option>
                <option value="Partial">PARTIAL</option>
                <option value="None">NONE</option>
            </select>
        </div>

        
    </fieldset>

    <fieldset class="add-fieldset">
        <h5 class="add-h5" style="text-align: center;">Employee Rates</h5>

        <div class="add-form-group">
    <label class="add-label" for="rate_1_daily_minimum_wage"><strong>Daily Minimum Wage:</strong></label>
    <div class="input-with-currency">
        <span class="currency">₱</span>
        <input oninput="this.value = this.value.toUpperCase()" type="number" id="rate_1_daily_minimum_wage" name="rate_1_daily_minimum_wage" value="470.00" required>
    </div>
</div>

<div class="add-form-group">
    <label class="add-label" for="rate_2_sunday_rest_day"><strong>Sunday Rest Day:</strong></label>
    <div class="input-with-currency">
        <span class="currency">₱</span>
        <input oninput="this.value = this.value.toUpperCase()" type="number" id="rate_2_sunday_rest_day" name="rate_2_sunday_rest_day" value="611.00">
    </div>
</div>

<div class="add-form-group">
    <label class="add-label" for="rate_3_legal_holiday"><strong>Legal Holiday:</strong></label>
    <div class="input-with-currency">
        <span class="currency">₱</span>
        <input oninput="this.value = this.value.toUpperCase()" type="number" id="rate_3_legal_holiday" name="rate_3_legal_holiday" value="940.00">
    </div>
</div>

<div class="add-form-group">
    <label class="add-label" for="rate_4_special_holiday"><strong>Special Holiday:</strong></label>
    <div class="input-with-currency">
        <span class="currency">₱</span>
        <input oninput="this.value = this.value.toUpperCase()" type="number" id="rate_4_special_holiday" name="rate_4_special_holiday" value="611.00">
    </div>
</div>

<div class="add-form-group">
    <label class="add-label" for="rate_5_regular_overtime_perhour"><strong>Regular Overtime Per Hour:</strong></label>
    <div class="input-with-currency">
        <span class="currency">₱</span>
        <input oninput="this.value = this.value.toUpperCase()" type="number" id="rate_5_regular_overtime_perhour" name="rate_5_regular_overtime_perhour" value="73.44">
    </div>
</div>

<div class="add-form-group">
    <label class="add-label" for="rate_6_special_overtime_perhour"><strong>Special Overtime Per Hour:</strong></label>
    <div class="input-with-currency">
        <span class="currency">₱</span>
        <input oninput="this.value = this.value.toUpperCase()" type="number" id="rate_6_special_overtime_perhour" name="rate_6_special_overtime_perhour" value="76.38">
    </div>
</div>

<div class="add-form-group">
    <label class="add-label" for="rate_7_special_holiday_overtime_perhour"><strong>Special Holiday Overtime Per Hour:</strong></label>
    <div class="input-with-currency">
        <span class="currency">₱</span>
        <input oninput="this.value = this.value.toUpperCase()" type="number" id="rate_7_special_holiday_overtime_perhour" name="rate_7_special_holiday_overtime_perhour" value="99.29">
    </div>
</div>

<div class="add-form-group">
    <label class="add-label" for="rate_8_regular_holiday_overtime_perhour"><strong>Regular Holiday Overtime Per Hour:</strong></label>
    <div class="input-with-currency">
        <span class="currency">₱</span>
        <input oninput="this.value = this.value.toUpperCase()" type="number" id="rate_8_regular_holiday_overtime_perhour" name="rate_8_regular_holiday_overtime_perhour" value="152.75">
    </div>
</div>

<div class="add-form-group">
    <label class="add-label" for="rate_9_cater"><strong>Cater:</strong></label>
    <div class="input-with-currency">
        <span class="currency">₱</span>
        <input oninput="this.value = this.value.toUpperCase()" type="number" id="rate_9_cater" name="rate_9_cater" value="1000.00">
    </div>
</div>
    </fieldset>

    <div class="add-form-actions">
        <input oninput="this.value = this.value.toUpperCase()" type="submit" value="Add Employee" class="add-submit-btn">
    </div>
</form>

<script>
function toggleLodgingAddress(value) {
    document.getElementById('lodging_address_wrapper').style.display = (value === 'Yes') ? 'block' : 'none';
}
</script>