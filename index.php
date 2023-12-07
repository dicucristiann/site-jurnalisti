<?php

require_once "config.php";
require_once "./models/ArticleManager.php";
require_once "./models/Article.php";

session_start();
// Initialize the session


$articleManager = new ArticleManager($mysqli);

?>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body { font: 14px sans-serif; text-align: center; }
            .article {
                margin-bottom: 20px;
                border: 1px solid #ccc;
                padding: 10px;
            }
        </style>
    </head>
    <body>

    <h1 class="my-5">Hi, Welcome to our site.</h1>
    <div>
        <?php foreach ($articleManager->getApprovedArticles() as $article): ?>
            <div class="article">
                <h2><?php echo $article->getTitle(); ?></h2>
                <?php if(isset($_SESSION["user_id"])): ?>
                    <p><?php echo $article->getContent(); ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <p>
        <?php if(isset($_SESSION["user_id"])): ?>
            <a href="logout.php" class="btn btn-danger ml-3">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary ml-3">Login</a>
        <?php endif; ?>
    </p>

    </body>
    </html>

<?php
// Close the database connection
$mysqli->close();
?>