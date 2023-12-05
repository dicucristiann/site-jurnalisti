<?php
include('conexiune.php');

$username = '';
$password = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //validation
    if (empty($username) || empty($password)) {
        $errorMessage = 'Please enter both username and password.';
    } else {
        // authentication
        $sql = "SELECT * FROM utilizatori WHERE user = '$username' AND parola = '$password'";
        $result = $GLOBALS['conn']->query($sql);

        //check if successful
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $userRole = $user['rol']; // get the user's role

            // redirect to index.php with user role as query
            header("Location: index.php?role=$userRole");
            exit();
        } else {
            $errorMessage = 'Invalid username or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<form method="post" action="login.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
    <br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>

    <button type="submit">Login</button>
</form>

<p style="color: red;"><?php echo $errorMessage; ?></p>

</body>
</html>