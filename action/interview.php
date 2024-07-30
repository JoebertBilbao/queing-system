<?php
require '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $interest = $_POST['interest'];
    $experience = $_POST['experience'];
    $expectations = $_POST['expectations'];
    $interviewer = $_POST['interviewer'];
    $department_head = $_POST['department_head'];
    $availability = $_POST['availability'];
    $additional_comments = $_POST['additional'];

    $sql = "INSERT INTO interview_form (full_name, email, phone, address, interest, experience, expectations, interviewer, department_head, availability, additional_comments)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $full_name, $email, $phone, $address, $interest, $experience, $expectations, $interviewer, $department_head, $availability, $additional_comments);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
?>