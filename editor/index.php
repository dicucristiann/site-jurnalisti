<?php


require_once "../config.php";
require_once "../models/ArticleManager.php";
require_once "../models/Article.php";

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
// Initialize the session

session_start();

// Check if the user is logged in, if not then redirect him to login page
if(empty($_SESSION["user_id"])){
    header("location: ../login.php");
    exit;
}

$articleManager = new ArticleManager($mysqli);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome Editor</h1>
<div>
    <ul>
        <?php foreach ($articleManager->getAllArticles() as $article): ?>
            <li>
                <h2><?php echo $article->getTitle(); ?></h2>
                <p><?php echo $article->getContent(); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<p>
    <a href="../journalist/create-article.php" class="btn btn-primary">Add article</a>
    <a href="../reset-password.php" class="btn btn-warning">Reset Your Password</a>
    <a href="../logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>

</p>
</body>
</html>
<?php
// Close the database connection
$mysqli->close();
?>