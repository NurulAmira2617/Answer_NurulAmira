<!DOCTYPE html>
<html>
<head>
    <title>Electricity Consumption Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container">
        <h1>Electricity Consumption Calculator</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="voltage">Voltage (V):</label>
                <input type="number" class="form-control" name="voltage" id="voltage" required>
            </div>

            <div class="form-group">
                <label for="current">Current (A):</label>
                <input type="number" step="0.01" class="form-control" name="current" id="current" required>
            </div>

            <div class="form-group">
                <label for="rate">Current Rate (sen/kWh):</label>
                <input type="number" step="0.01" class="form-control" name="rate" id="rate" required>
            </div>

            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>
        <?php
        function calculateElectricityCharge($voltage, $current, $rate, $hour) {
            $power = ($voltage * $current) / 1000; // Convert power to kW
            $energy = $power * $hour; // Calculate energy consumption for the given hour
            $totalCharge = ($energy * $rate) / 100; // Convert rate from sen/kWh to RM/kWh
            
            return array('hour' => $hour, 'energy' => $energy, 'totalCharge' => $totalCharge);
        }
        
        // Example usage with user input
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $voltage = $_POST['voltage'];
            $current = number_format((float)$_POST['current'], 2, '.', ''); // Format current to 2 decimal places
            $rate = $_POST['rate'];
            
            echo "<h2>Calculation Results:</h2>";
            echo "<table class='table'>";
            echo "<thead><tr><th>Hour</th><th>Energy (kWh)</th><th>Rate (RM)</th><th>Total Charge (RM)</th></tr></thead>";
            echo "<tbody>";
            for ($hour = 1; $hour <= 24; $hour++) {
                $result = calculateElectricityCharge($voltage, $current, $rate, $hour);
                echo "<tr>";
                echo "<td>" . $result['hour'] . "</td>";
                echo "<td>" . number_format($result['energy'], 5, '.', '') . "</td>";
                echo "<td>" . number_format($rate / 100, 3, '.', '') . "</td>";
                echo "<td>" . number_format($result['totalCharge'], 2, '.', '') . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            
        }
        ?>


    </div>

</body>
</html>
