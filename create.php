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

// Query to select all records from tbluseraccount
$selectQuery = "SELECT * FROM tbluseraccount";

// Execute the query
$result = $conn->query($selectQuery);

if ($result->num_rows > 0) {
    // Display the records
    while ($row = $result->fetch_assoc()) {
        echo "USERID: " . $row["USERID"] . "<br>";
        echo "Name: " . $row["U_NAME"] . "<br>";
        echo "Username: " . $row["U_USERNAME"] . "<br>";
        echo "Contact: " . $row["U_CON"] . "<br>";
        echo "Email: " . $row["U_EMAIL"] . "<br>";
        echo "Role: " . $row["U_ROLE"] . "<br>";
        echo "Code: " . $row["Code"] . "<br>";
        echo "Secret Key: " . $row["SECRET_KEY"] . "<br>";
        echo "User Image: <img src='" . $row["USERIMAGE"] . "' alt='User Image' style='max-width: 100px; max-height: 100px;'><br>";
        echo "2FA Verified: " . ($row["IS_2FA_VERIFIED"] ? "Yes" : "No") . "<br>";
        echo "-----------------------------------<br>";
    }
} else {
    echo "No records found in 'tbluseraccount' table.";
}

// Close the connection
$conn->close();
?>
