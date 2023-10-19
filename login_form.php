<?php
session_start(); // Start the session at the beginning of the code

@include 'config.php';

if(isset($_POST['submit'])){
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = $_POST['password'];

   $query = "SELECT * FROM user_form WHERE email='$email' AND password='$pass'";
   $result = mysqli_query($conn, $query);

   if (mysqli_num_rows($result) == 1) {
      // User found, fetch user details
      $row = mysqli_fetch_assoc($result);
      $userId = $row['id'];
      $username = $row['name'];

      // Store user information in session variables
      $_SESSION['userId'] = $userId;
      $_SESSION['email'] = $email;
      $_SESSION['username'] = $username;

      header('Location: faculty.html'); // Redirect to the desired page after successful login
      exit();
   } else {
      $error[] = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <!-- custom CSS file link -->
   <link rel="stylesheet" href="style1.css">
</head>
<body>
   <div class="form-container">
      <form action="" method="post">
         <h3>Login Now</h3>
         <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<span class="error-msg">'.$error.'</span>';
            }
         }
         ?>
         <div class="form-group">
            <input type="email" name="email" required placeholder="Enter your email">
         </div>
         <div class="form-group">
            <input type="password" name="password" required pattern=".{6,}" title="Password must be at least 6 characters long." placeholder="Enter your password">
         </div>
         <input type="submit" name="submit" value="Login Now" class="form-btn">
         <p><a href="forgot_password.php">Forgot Password?</a></p>
      </form>
   </div>
</body>
</html>
