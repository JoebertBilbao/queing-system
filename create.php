<?php
// Database connection details
$servername = "localhost";
$username = "u510162695_dried";
$password = "1Dried_password";
$dbname = "u510162695_dried";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get all table names
$showTablesQuery = "SHOW TABLES";
$result = $conn->query($showTablesQuery);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_array()) {
        $tableName = $row[0];
        echo "<h2>Table: $tableName</h2>";

        // Query to select all records from the current table
        $selectQuery = "SELECT * FROM $tableName";
        $tableResult = $conn->query($selectQuery);

        if ($tableResult->num_rows > 0) {
            // Display the table headers dynamically
            echo "<table border='1' cellspacing='0' cellpadding='10'>";
            echo "<tr>";
            while ($field = $tableResult->fetch_field()) {
                echo "<th>" . $field->name . "</th>";
            }
            echo "</tr>";

            // Display each row of data
            while ($row = $tableResult->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $key => $value) {
                    if (strpos($key, 'IMAGE') !== false && $value) {
                        // Display as an image if the column name contains 'IMAGE'
                        echo "<td><img src='$value' alt='$key' style='max-width: 50px; max-height: 50px;'></td>";
                    } else {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                }
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No records found in table '$tableName'.</p>";
        }
    }
} else {
    echo "<p>No tables found in the database.</p>";
}

// Close the connection
$conn->close();
?>
