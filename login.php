<?php
// Start the session to manage user errors
session_start();

// Retrieve stored errors from the session
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];

    // Clear errors after displaying to prevent repeated messages
    unset($_SESSION['errors']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> <!-- Set character encoding for proper text display -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Enable mobile responsiveness -->
    <title>Register & Login</title> <!-- Page title -->

    <!-- Import Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Link external CSS file for styling -->
    <link rel="stylesheet" href="formstyles.css">
</head>

<body>

    <!-- Login Form Container -->
    <div class="container" id="Login">

        <!-- School Logo -->
        <img src="unnamed.jpg" alt="School logo" class="logo" 
             style="display: block; margin: 0 auto; width: 120px; height: auto;">

        <!-- Login Form Title -->
        <h1 class="form-title">Log In</h1>

        <p class="login-text">Use your email and password to log in</p>


        <!-- Display Login Error if exists -->
        <?php
        if (isset($errors['login'])) {
            echo '<div class="error-main"><p>' . $errors['login'] . '</p></div>';
        }
        ?>

        <!-- Login Form -->
        <form method="POST" action="process.php">

            <!-- Email Input Field -->
            <div class="input-group">
                <i class="fas fa-envelope"></i> <!-- Email icon -->
                <input type="email" name="email" id="email" placeholder="Email" required>
                
                <!-- Display Email Error if exists -->
                <?php
                if (isset($errors['email'])) {
                    echo '<div class="error"><p>' . $errors['email'] . '</p></div>';
                }
                ?>
            </div>

            <!-- Password Input Field -->
            <div class="input-group password">
                <i class="fas fa-lock"></i> <!-- Lock icon -->
                <input type="password" name="password" id="password" placeholder="Password" required>

                <!-- Eye icon for password visibility -->
                <i id="eye" class="fa fa-eye"></i>

                <!-- Display Password Error if exists -->
                <?php
                if (isset($errors['password'])) {
                    echo '<div class="error"><p>' . $errors['password'] . '</p></div>';
                }
                ?>
                


            </div>
            <!-- Link to Registration again to register with new password -->
            <div class="links">
             <p><button type="button" class="forgot-password" onclick="showWarning()"> 
    <i class="fas fa-exclamation-circle warning-icon"></i> Forgot Password?
</button></p>

<!-- Warning Modal -->
<div id="warningModal" class="modal">
    <div class="modal-content">
        <i class="fas fa-exclamation-triangle warning-icon"></i>
        <h2>Sorry! We Can't Help You Recover Your Password</h2>
        <p>You need to register again with a new password.</p>

        <button onclick="redirectToRegister()"><em>Continuous With new Registration</em></button>
    </div>
</div>
            </div>
            <!-- Submit Button -->
            <input type="submit" class="btn" value="Login" name="Login">
        </form>

        <!-- Link to Registration Page -->
        <div class="links">
            <p>Don't Regestered yet?</p>
            <a href="form.html">Register Now!</a>
        </div>

    </div>

    <!-- Import JavaScript for error handling -->
    <script src="errorhandling.js"></script> 

</body>
</html>
