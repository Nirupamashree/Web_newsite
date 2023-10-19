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

if (isset($_SESSION["userId"])) {
    $userId = $_SESSION["userId"];
    $sql = "SELECT name FROM user_form WHERE id='$userId'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row["name"];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f0f0;
        }

        h1 {
            font-size: 2.5em;
            color: #333;
        }

        p {
            font-size: 1.5em;
            color: #666;
            margin: 0;
            padding: 0;
        }

        .quote {
            margin-top: 30px;
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h1><?php echo "WELCOME " . $_SESSION['username']; ?></h1>
    <br>
    <br>
    <p id="date"></p>
    <p id="time"></p>
    
    <div class="quote">
        <p>"The best way to predict the future is to create it."</p>
        <p>- Abraham Lincoln</p>
    </div>

    <script>
        function showDateTime() {
            var today = new Date();
            var date = today.toLocaleDateString();
            var time = today.toLocaleTimeString();
            document.getElementById("date").innerHTML = date;
            document.getElementById("time").innerHTML = time;
        }

        setInterval(showDateTime, 1000);
    </script>
</body>
</html>