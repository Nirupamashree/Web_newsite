<?php
session_start();
// Assuming you have a connection to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user1_db";

// Create a new password for the database connection
$new_password = "your_new_password";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if email, new_password, and confirm_password are set in the $_POST array
if (isset($_POST['email']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    // Get the email, new password, and confirm password from the form submission
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the new password and confirm password match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Error: Passwords do not match.');</script>";
    } else {
        // Retrieve the existing password from the database
        $existing_password = "";
        $select_query = "SELECT password FROM user_form WHERE email = '$email'";
        $result = $conn->query($select_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $existing_password = $row['password'];
        }

        // Check if the new password is the same as the existing password
        if ($new_password === $existing_password) {
            echo "<script>alert('Error: New password must be different from the current password.');</script>";
        } else {
            // Update the password in the database
            $update_query = "UPDATE user_form SET password = '$new_password' WHERE email = '$email'";
            if ($conn->query($update_query) === TRUE) {
                echo "<script>alert('Password updated successfully.');</script>";
            } else {
                echo "<script>alert('Error updating password: " . $conn->error . "');</script>";
            }
        }
    }
} else {
    // Display the initial alert only when the form is not submitted
    if (isset($_POST['email'])) {
        echo "<script>alert('Email, new password, and confirm password are required.');</script>";
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>FORGET PASSWORD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 80%;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            width: 80%;
            padding: 10px;
            background-color: #4caf50;
            border: none;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <br>
    <div class="container">
        <h2>FORGET PASSWORD</h2>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="new_password">New Password:</label>
            <div style="position: relative;">
                <input type="password" id="new_password" name="new_password" required>
                <span style="position: absolute; top: 10px; right: 10px; cursor: pointer;" onclick="togglePasswordVisibility('new_password')">&#x1f441;</span>
            </div><br><br>
            <label for="confirm_password">Confirm Password:</label>
            <div style="position: relative;">
                <input type="password" id="confirm_password" name="confirm_password" required>
                <span style="position: absolute; top: 10px; right: 10px; cursor: pointer;" onclick="togglePasswordVisibility('confirm_password')">&#x1f441;</span>
            </div><br>
            <span class="error" id="password_error"></span><br>
            <input type="submit" value="Reset Password" onclick="showAlert()">
        </form>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }

        function showAlert() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (newPassword !== confirmPassword) {
                alert("Error: Passwords do not match.");
            } else {
                alert("Password reset successfully.");
            }
        }
    </script>
</body>
</html>
