<?php
$servername = "127.0.0.1"; // Replace with your hosting's DB hostname
$username = "u510162695_mccsystem";
$password = "1Mccsystem";
$dbname = "u510162695_mccsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get a list of all tables in the database
$tablesQuery = "SHOW TABLES";
$tablesResult = $conn->query($tablesQuery);

if ($tablesResult->num_rows > 0) {
    while ($tableRow = $tablesResult->fetch_array()) {
        $tableName = $tableRow[0];
        echo "<h2>Table: $tableName</h2>";

        // Fetch records from the current table
        $recordsQuery = "SELECT * FROM $tableName";
        $recordsResult = $conn->query($recordsQuery);

        if ($recordsResult->num_rows > 0) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr>";
            
            // Output column headers dynamically
            $fields = $recordsResult->fetch_fields();
            foreach ($fields as $field) {
                echo "<th style='padding: 8px; text-align: left;'>" . htmlspecialchars($field->name) . "</th>";
            }
            echo "</tr>";
            
            // Output data of each row
            while ($row = $recordsResult->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td style='padding: 8px;'>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table><br>";
        } else {
            echo "<p>No records found in table $tableName.</p>";
        }
    }
} else {
    echo "No tables found in the database.";
}

$conn->close();
?>
