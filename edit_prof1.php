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

$name = "";
$old_password = "";
$new_password = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        echo "You are not logged in.";
        exit;
    }

    // Get user information from session
    $userId = $_SESSION["userId"];
    $name = $_POST["name"];
    $old_password = $_POST["oldPassword"];
    $new_password = $_POST["newPassword"];

    // Validate input
    if (empty($old_password) || empty($new_password)) {
        echo "Please fill in all fields.";
    } else {
        // Check if the provided old password matches the user's current password
        $sql = "SELECT * FROM user_form WHERE id='$userId' AND password='$old_password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // Update password
            $sql = "UPDATE user_form SET password='$new_password' WHERE id='$userId'";
            if ($conn->query($sql) === TRUE) {
                echo "Password updated successfully.";
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "Invalid password.";
        }
    }
}

// Retrieve the user's name from the database based on login credentials
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $username = $_SESSION["username"];
    $sql = "SELECT name FROM user_form WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row["name"];
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 1.2em;
        }
        
        label {
            margin: 10px 0;
            width: 200px;
            text-align: right;
            padding-right: 10px;
        }
        
        input[type=text], input[type=email], input[type=password], input[type=number], input[type=date] {
            margin: 10px 0;
            width: 300px;
            padding: 5px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        
        input[type=submit] {
            margin: 20px 0;
            padding: 10px;
            font-size: 1.2em;
            background-color: #464544;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        input[type=submit]:hover {
            background-color: #464544;
        }
        
        .error {
            color: red;
            font-size: 0.8em;
            margin: 5px 0 0 0;
        }
    </style>
</head>
<body>
    <h1>Edit Profile</h1>
    <form id="editProfileForm" method="POST">
    <label for="name">Name:</label>
        <?php echo $_SESSION['username']; ?>
        


        <label for="oldPassword">Old Password:</label>
        <input type="password" id="oldPassword" name="oldPassword" required>

        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required>

        <input type="submit" value="Save Changes">
    </form>
</body>
</html>
