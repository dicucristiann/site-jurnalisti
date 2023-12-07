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
            body{ font: 14px sans-serif; text-align: center; }
        </style>
    </head>
    <body>
    <h1 class="my-5">Hi, Welcome to our site.</h1>
    <div>
        <ul>
            <?php foreach ($articleManager->getApprovedArticles() as $article): ?>
                <li>
                    <h2><?php echo $article->getTitle(); ?></h2>
                    <p><?php echo $article->getContent(); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <p>
        <?php
        if(empty($_SESSION["user_id"]))
          echo '<a href="login.php" class="btn btn-primary ml-3">Login</a>';
        else
            echo '<a href="logout.php" class="btn btn-danger ml-3">Logout</a>';
        ?>
    </p>
    </body>
    </html>
<?php
// Close the database connection
$mysqli->close();
?>