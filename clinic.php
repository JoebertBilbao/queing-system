<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Clinic Enrollment Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 600px;
        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, 
        .form-group select, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group button {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Clinic Enrollment Form</h1>
        <form>
            <div class="form-group">
                <label for="student-name">Student Name</label>
                <input type="text" id="student-name" name="student_name" required>
            </div>
            <div class="form-group">
                <label for="student-id">Student ID</label>
                <input type="text" id="student-id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="contact-number">Contact Number</label>
                <input type="tel" id="contact-number" name="contact_number" required>
            </div>
            <div class="form-group">
                <label for="contact-number">Contact Number</label>
                <input type="tel" id="contact-number" name="contact_number" required>
           </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="medical-history">Medical History</label>
                <textarea id="medical-history" name="medical_history" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="current-medications">Current Medications</label>
                <input type="text" id="current-medications" name="current_medications">
            </div>
            <div class="form-group">
                <label for="allergies">Allergies</label>
                <input type="text" id="allergies" name="allergies">
            </div>
            <div class="form-group">
                <label for="current-symptoms">Current Symptoms/Concerns</label>
                <textarea id="current-symptoms" name="current_symptoms" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="appointment-date">Preferred Appointment Date</label>
                <input type="date" id="appointment-date" name="appointment_date" required>
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
            <div class="signature">
                <div class="signature-name">Leslie M. Pasaylo</div>
                <br>
                <div class="signature-title">School Nurse</div>
            </div>
        </form>
    </div>
</body>
</html>
