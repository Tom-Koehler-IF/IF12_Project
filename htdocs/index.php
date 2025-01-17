<?php
// Include the login functions
define('INDEX_PAGE', 1);
include('include/login.php');
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
        <form method="POST" action="action/login.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>

            <input type="hidden" name="redirect" value="<?php echo $_GET['redirect'] ?? '';?>">
            
            <button type="submit">Login</button>
        </form>
    <?php else: ?>
        <!-- Welcome Message & Logout Button -->
        <p>Welcome, <?php echo $_SESSION[SESSION_ACCOUNT]->name; ?>!</p>
        <a href="action/logout.php">Logout</a>
    <?php endif; ?>
</body>
</html>

