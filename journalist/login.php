<?php
require_once 'conexiune.php';

// Select DB
$databaseName = 'articole';
$GLOBALS['conn']->select_db($databaseName);

// Check connection
if ($GLOBALS['conn']->connect_error) {
    die("Connection failed: " . $GLOBALS['conn']->connect_error);
}

// Retrieve data from the HTML form
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Authentication
$sql = "SELECT * FROM utilizatori WHERE user = '$username' AND parola = '$password'";
$result = $GLOBALS['conn']->query($sql);

// Process authentication results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Authentication successful, process user data if necessary
        echo "Authentication successful for user: " . $row['user'];
    }
} else {
    // Authentication failed err
    echo "Authentication failed. Incorrect username and/or password.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="login-container">
    <div class="login-card">
        <h1 class="login-title h4 mb-0">Login</h1>
        <form class="login-form" method="post" action="login.php">
            <div class="form-group">
                <label class="login-label" for="username">Username:</label>
                <input type="text" class="login-input form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="form-group">
                <label class="login-label" for="password">Password:</label>
                <input type="password" class="login-input form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="login-button btn btn-primary btn-block">Login</button>
        </form>
        <p class="login-error mt-3"><?php echo mysqli_error($GLOBALS['conn']); ?></p>
    </div>
</div>

</body>
</html>

<?php
// Close the connection when done
$GLOBALS['conn']->close();
?>
