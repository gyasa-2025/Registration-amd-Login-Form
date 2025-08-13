<?php
// Start the session to manage user authentication and errors
session_start();

// Database connection credentials
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "registration_db";  

// Establish a connection to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection failed
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ---------------------- Handling Registration ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    
    // Retrieve and clean user input
    $name = trim($_POST['name']); // Matches 'Username' column in DB
    $phone = trim($_POST['phone']); // Matches 'Phone No' column in DB
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Standardized date format 
    $created_at = date('Y-m-d H:i:s');

    // Initialize an array to store errors
    $errors = [];

    // Validate email format
   if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[^@]+@[^@]+\.[a-z]{2,}$/i', $email)) {
    $errors['email'] = 'Invalid email format: must contain @ and a valid domain.';
}

    // Validate password length
    if (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters.';
    }

    // Ensure passwords match
    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT id FROM users WHERE Email = ?");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors['user_exist'] = 'Email is already registered.';
    }
    $stmt->close();

    // If errors exist, store them in the session and redirect back to the form
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: form.html');
        exit();
    }


    // Hash the password securely before saving
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert new user data into the database
    $stmt = $conn->prepare("INSERT INTO users (Username, `Phone No`, Email, Password, Create_at) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("sssss", $name, $phone, $email, $hashedPassword, $created_at);

    // Execute the statement and handle success or failure
  if ($stmt->execute()) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: 'You have successfully registered!',
                icon: 'success',
                confirmButtonColor: '#28a745' // Green color
            }).then(() => {
                window.location.href = 'login.php';
            });
        });
    </script>";
    exit();
} else {
    die('Error inserting data: ' . $stmt->error);
}

}

// ---------------------- Handling Login ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Login'])) {

    // Retrieve and sanitize login credentials
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate email format before querying the database
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors']['email'] = 'Invalid email format.';
        header('Location: login.php');
        exit();
    }

    // Prepare statement to fetch user data from the database
    $stmt = $conn->prepare("SELECT id, Password FROM users WHERE Email = ?");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows === 0) {
        $_SESSION['errors']['login'] = 'Invalid email or password.';
        header('Location: login.php');
        exit();
    }

    // Bind retrieved data
    $stmt->bind_result($user_id, $hashedPassword);
    $stmt->fetch();

    // Verify hashed password against user input
    if (password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $user_id;
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: 'You have successfully login!',
                icon: 'success',
                confirmButtonColor: '#28a745' // Green color
            }).then(() => {
                window.location.href = 'http://localhost/phpmyadmin';
            });
        });
    </script>";
        exit();
    } else {
        $_SESSION['errors']['login'] = 'Invalid email or password.';
        header('Location: login.php');
        exit();
    }
}
if (isset($_POST['forgot_password'])) {
    // Store a message to show on the registration page (optional)
    exit();
}
?>
