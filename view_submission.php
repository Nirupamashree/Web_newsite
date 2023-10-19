<?php
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

// Retrieve the facultyName input, if provided
$facultyFilter = $_POST['facultyName'] ?? '';

// Prepare the SQL statement based on the faculty filter
if (!empty($facultyFilter)) {
    $stmt = $conn->prepare("SELECT * FROM bundle WHERE facultyName = ?");
    $stmt->bind_param("s", $facultyFilter);
} else {
    $stmt = $conn->prepare("SELECT * FROM bundle");
}

// Execute the statement and fetch the results
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Records</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 8px;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
        }

        /* Custom CSS for the table */
        .attendance-table {
            background-color: #f7f7f7;
            border: 1px solid #ddd;
        }

        .attendance-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .attendance-table td {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <h1>Bundle Submission Records</h1>

    <form action="" method="post">
        <label for="facultyName">Faculty Name:</label>
        <input type="text" id="facultyName" name="facultyName" value="<?php echo $facultyFilter; ?>">
        <input type="submit" value="Filter">
    </form>

    <table class="attendance-table">
        <tr>
            <th>Faculty Name</th>
            <th>Date</th>
            <th>Number of Students</th>
            <th>Number of Absentees</th>
            <th>Number of Papers Collected</th>
            <th>Subject</th>
            <th>Class</th>
            <th>Venue</th>
        </tr>
        <?php
        // Display the records in the table
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['facultyName'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['numStudents'] . "</td>";
            echo "<td>" . $row['numAbsentees'] . "</td>";
            echo "<td>" . $row['numPapersCollected'] . "</td>";
            echo "<td>" . $row['subject'] . "</td>";
            echo "<td>" . $row['class'] . "</td>";
            echo "<td>" . $row['venue'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
