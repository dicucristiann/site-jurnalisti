<?php

require_once "../config.php";
require_once "../models/ArticleManager.php";
require_once "../models/Article.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (empty($_SESSION["user_id"])) {
    header("location: ../login.php");
    exit;
}

$articleManager = new ArticleManager($mysqli);

// Get the category from the URL parameter
$category = isset($_GET['category']) ? $_GET['category'] : null;

// Fetch articles based on the category
$articles = $articleManager->getMyArticlesByCategory($_SESSION["user_id"], $category);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font: 14px sans-serif; text-align: center; }
        h1 { margin-top: 50px; }
        ul { list-style: none; padding: 0; }
        li { border: 1px solid #ddd; margin: 10px 0; padding: 10px; border-radius: 5px; }
        .badge { margin-right: 5px; }
        .edit-btn { margin-top: 10px; }
        .nav-tabs { margin-bottom: 20px; }
        .nav-tabs .nav-item { margin-right: 10px; }
    </style>
</head>
<body>
<div class="container">
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link <?php echo $category === null ? 'active' : ''; ?>" href="?category=all">All</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $category === 'artistic' ? 'active' : ''; ?>" href="?category=artistic">Artistic</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $category === 'technic' ? 'active' : ''; ?>" href="?category=technic">Technical</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $category === 'science' ? 'active' : ''; ?>" href="?category=science">Science</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $category === 'moda' ? 'active' : ''; ?>" href="?category=moda">Moda</a>
        </li>
    </ul>

    <ul>
        <?php foreach ($articles as $article): ?>
            <li>
                <h2><?php echo $article->getTitle(); ?></h2>
                <?php if(isset($_SESSION["user_id"])): ?>
                    <p><?php echo $article->getContent(); ?></p>
                <?php endif; ?>
                <span class="badge <?php echo getStatusBadgeClass($article->getStatus()); ?>"><?php echo $article->getStatus(); ?></span>

                <?php if ($article->getStatus() !== 'approved'): ?>
                    <a href="edit-article.php?article_id=<?php echo $article->getId(); ?>" class="btn btn-info edit-btn">Edit</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <p>
        <a href="create-article.php" class="btn btn-primary">Add article</a>
        <a href="../reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="../logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
</div>
</body>
</html>

<?php
// Close the database connection
$mysqli->close();

function getStatusBadgeClass($status)
{
    switch ($status) {
        case 'waiting':
            return 'badge-warning';
        case 'approved':
            return 'badge-success';
        case 'rejected':
            return 'badge-danger';
        default:
            return 'badge-secondary';
    }
}
?>
