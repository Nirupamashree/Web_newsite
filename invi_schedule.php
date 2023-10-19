

<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user1_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get input values
    $faculty = $_POST["faculty"];
    $venue = $_POST["venue"];
    $slot = $_POST["slot"];
    $subject = $_POST["subject"];
    $date = $_POST["date"];

    // Check if the record already exists
    $sql = "SELECT * FROM allocate_slot WHERE faculty='$faculty' AND venue='$venue' AND slot='$slot' AND subject='$subject' AND date='$date'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "The slot is already allocated.";
    } else {
        // Insert data into allocate_slot table
        $sql = "INSERT INTO allocate_slot (faculty, venue, slot, subject, date) VALUES ('$faculty', '$venue', '$slot', '$subject', '$date')";
        if ($conn->query($sql) === TRUE) {
            echo "Slot allocated successfully.";
        } else {
            echo "Error allocating slot: " . $conn->error;
        }
    }
}

// Retrieve previous records from allocate_slot table
$sql = "SELECT * FROM allocate_slot";
$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Allocate Slot</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-top: 0;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="submit"] {
            padding: 8px;
            width: 200px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Allocate Slot</h1>
    <form method="POST">
        <label for="faculty">Faculty:</label>
        <input type="text" id="faculty" name="faculty" required>

        <label for="venue">Venue:</label>
        <input type="text" id="venue" name="venue" required>

        <label for="slot">Slot:</label>
        <input type="text" id="slot" name="slot" required>

        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" required>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <input type="submit" value="Allocate Slot">
    </form>

    <?php if ($result->num_rows > 0): ?>
        <h2>Previous Records</h2>
        <table>
            <tr>
                <th>Faculty</th>
                <th>Venue</th>
                <th>Slot</th>
                <th>Subject</th>
                <th>Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["faculty"]; ?></td>
                    <td><?php echo $row["venue"]; ?></td>
                    <td><?php echo $row["slot"]; ?></td>
                    <td><?php echo $row["subject"]; ?></td>
                    <td><?php echo $row["date"]; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No previous records.</p>
    <?php endif; ?>
</body>
</html>
