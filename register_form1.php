<!DOCTYPE html>
<html>
<head>
    <title>User Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .success {
            color: green;
            margin-top: 10px;
        }

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
        }

        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            height: 30px;
            margin-bottom: 10px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            width: 100%;
            height: 40px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var confirmInput = document.getElementById("confirm_password");
            var passwordVisibility = document.getElementById("password_visibility");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                confirmInput.type = "text";
                passwordVisibility.textContent = "Hide Password";
            } else {
                passwordInput.type = "password";
                confirmInput.type = "password";
                passwordVisibility.textContent = "Show Password";
            }
        }
    </script>
</head>
<body>


<?php
// Database connection
$host = 'localhost';
$db = 'user1_db';
$user = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Function to validate password strength
function validatePassword($password) {
    // Password must be at least 6 characters long
    if (strlen($password) < 6) {
        return false;
    }

    // Password must contain a combination of letters, numbers, and special characters
    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
        return false;
    }

    return true;
}

// Handle form submission
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $errorMsg = '';

    // Check if username already exists in the database
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM user_form WHERE name = ?');
    $stmt->execute([$name]);
    $nameCount = $stmt->fetchColumn();

    if ($nameCount > 0) {
        $errorMsg = 'Username already exists.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = 'Invalid email address.';
    } elseif ($password !== $confirmPassword) {
        $errorMsg = 'Password and confirm password do not match.';
    } elseif (!validatePassword($password)) {
        $errorMsg = 'Password must be at least 6 characters long and contain a combination of letters, numbers, and special characters.';
    } else {
        // Check if email already exists in the database
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM user_form WHERE email = ?');
        $stmt->execute([$email]);
        $emailCount = $stmt->fetchColumn();

        if ($emailCount > 0) {
            $errorMsg = 'Email address already registered.';
        } else {
            // Store user information in the database
            $stmt = $pdo->prepare('INSERT INTO user_form (name, email, password) VALUES (?, ?, ?)');
            $stmt->execute([$name, $email, $password]);

            $successMsg = 'Registration successful.';
        }
    }
}
?>


    <div class="form-container">
        <h2>User Registration Form</h2>

        <?php
    if (isset($errorMsg)) {
        echo '<p class="error">' . $errorMsg . '</p>';
    }

    if (isset($successMsg)) {
        echo '<p class="success">' . $successMsg . '</p>';
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <input type="checkbox" id="password_visibility" onclick="togglePasswordVisibility()">
            <label for="password_visibility">Show Password</label>

        <input type="submit" name="submit" value="Register">
    </form>
</div>