<?php
// Retrieve form data
if (isset($_POST['facultyName']) && isset($_POST['date']) &&
    isset($_POST['numStudents']) &&
    isset($_POST['numAbsentees']) &&
    isset($_POST['numPapersCollected']) &&
    isset($_POST['subject']) &&
    isset($_POST['class']) &&
    isset($_POST['venue'])) {

    $facultyName = $_POST['facultyName'];
    $date = $_POST['date'];
    $numStudents = $_POST['numStudents'];
    $numAbsentees = $_POST['numAbsentees'];
    $numPapersCollected = $_POST['numPapersCollected'];
    $subject = $_POST['subject'];
    $class = $_POST['class'];
    $venue = $_POST['venue'];

    // Database connection settings
    $servername = "localhost";
    $username = "root"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $dbname = "user1_db";

    // Create a new MySQLi object and connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO bundle (facultyName,date, numStudents, numAbsentees,numPapersCollected, subject, class, venue) VALUES (?,?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiisss",$facultyName, $date, $numStudents, $numAbsentees, $numPapersCollected, $subject, $class, $venue);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Form submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} 
?>


<!DOCTYPE html>
<html>
<head>
    <title>Bundle submission Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="date"],
        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Bundle submission form</h1>

    <form action="" method="POST">

        <label for="class">Faculty name:</label>
        <input type="text" id="facultyName" name="facultyName" required>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="numStudents">Number of Students:</label>
        <input type="number" id="numStudents" name="numStudents" required>

        <label for="numAbsentees">Number of Absentees:</label>
        <input type="number" id="numAbsentees" name="numAbsentees" required>

        <label for="numPapersCollected">Number of Papers Collected:</label>
        <input type="number" id="numPapersCollected" name="numPapersCollected" required>

        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" required>

        <label for="class">Class:</label>
        <input type="text" id="class" name="class" required>

        <label for="venue">Venue:</label>
        <input type="text" id="venue" name="venue" required>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
