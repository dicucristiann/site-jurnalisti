<?php
// Initialize the session

global $mysqli;
ini_set('display_startup_errors',1);
ini_set('display_errors',1);

require_once "models/UserManager.php";
require_once "models/User.php";

// Include config file
require_once "config.php";
session_start();

// Processing form data when form is submitted
// Check if the user is already logged in, redirect to index.php if true
if (!empty($_SESSION["user_id"])) {
    $role = $_SESSION["role"];
    if ($role === "journalist") {
        header("location: journalist/index.php");
    } elseif ($role === "editor") {
        header("location: editor/index.php");
    } else {
        // Redirect to a default page if the role is not recognized
        header("location: index.php");
    }
    exit();
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before authenticating
    if (empty($username_err) && empty($password_err)) {
        $userManager = new UserManager($mysqli);

        // Authenticate the user
        $user = $userManager->authenticateUser($username, $password);

        if ($user) {
            // Store the user object in the session
            $_SESSION["username"] = $user->getUsername();
            $_SESSION["role"] = $user->getRole();
            $_SESSION["user_id"] = $user->getId();


            // Redirect to index.php
            // Redirect based on the user's role
            if ($user->getRole() === "journalist") {
                header("location: journalist/index.php");
            } elseif ($user->getRole() === "editor") {
                header("location: editor/index.php");
            } else {
                // Redirect to a default page if the role is not recognized
                header("location: index.php");
            }
            exit();
        } else {
            // Display an error message if authentication fails
            $password_err = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="wrapper">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>

    <?php
    if(!empty($login_err)){
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-secondary" value="Login">
        </div>
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
</div>
</body>
</html>