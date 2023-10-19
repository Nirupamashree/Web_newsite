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
    // Get user information from session
    $userId = $_SESSION["userId"];
    $old_password = $_POST["oldPassword"];
    $new_password = $_POST["newPassword"];

    // Validate input
    if (empty($old_password) || empty($new_password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } else {
        // Check if the provided old password matches the user's current password
        $sql = "SELECT * FROM user_form WHERE id='$userId' AND password='$old_password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // Update password
            $sql = "UPDATE user_form SET password='$new_password' WHERE id='$userId'";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Password updated successfully.');</script>";
            } else {
                echo "<script>alert('Error updating password: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    }
}

// Retrieve the user's name from the database based on login credentials
if (isset($_SESSION["userId"])) {
    $userId = $_SESSION["userId"];
    $sql = "SELECT name FROM user_form WHERE id='$userId'";
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
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .password-toggle {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .password-toggle input[type=password] {
            flex: 1;
        }

        .password-toggle .toggle-btn {
            background-color: #ddd;
            border: none;
            padding: 8px;
            cursor: pointer;
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-top: 5px;
        }
        
        /* Added CSS to align the form elements */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            width: 120px;
            display: inline-block;
        }
        
        .password-toggle {
            align-items: baseline;
        }
        
        .toggle-btn {
            margin-left: 10px;
        }
    </style>
    <script>
        function togglePasswordVisibility(fieldId) {
            var field = document.getElementById(fieldId);
            var toggleBtn = document.getElementById(fieldId + '-toggle');

            if (field.type === 'password') {
                field.type = 'text';
                toggleBtn.innerHTML = 'Hide';
            } else {
                field.type = 'password';
                toggleBtn.innerHTML = 'Show';
            }
        }

        function showMessage(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <form id="editProfileForm" method="POST" onsubmit="showMessage('Submitting form...')">
        <h1>Edit Profile</h1>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $_SESSION['username']; ?>" disabled>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" disabled>
        </div>

        <div class="form-group password-toggle">
            <label for="oldPassword">Old Password:</label>
            <input type="password" id="oldPassword" name="oldPassword" required>
            <button type="button" id="oldPassword-toggle" class="toggle-btn" onclick="togglePasswordVisibility('oldPassword')">Show</button>
        </div>

        <div class="form-group password-toggle">
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required>
            <button type="button" id="newPassword-toggle" class="toggle-btn" onclick="togglePasswordVisibility('newPassword')">Show</button>
        </div>

        <input type="submit" value="Save Changes">
    </form>
</body>
</html>
