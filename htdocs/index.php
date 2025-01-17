<?php
session_start();

// Include the login functions
include('include/login.php');

// Handle the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login($username, $password)) {
        echo "Login successful! Welcome, $username.";
    } else {
        echo "Invalid credentials. Please try again.";
    }
}

// Handle logout button click
if (isset($_GET['logout'])) {
    logout();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>
    <?php if (!isset($_SESSION[SESSION_ACCOUNT])): ?>
        <!-- Login Form -->
        <form method="POST" action="index.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>
            
            <button type="submit">Login</button>
        </form>
    <?php else: ?>
        <!-- Welcome Message & Logout Button -->
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
        <a href="index.php?logout=true">Logout</a>
    <?php endif; ?>
</body>
</html>

