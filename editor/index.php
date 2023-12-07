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
        </style>
    </head>
    <body>
    <div class="container">
        <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome Editor</h1>

        <ul>
            <?php foreach ($articleManager->getAllArticles() as $article): ?>
                <li>
                    <h2><?php echo $article->getTitle(); ?></h2>
                    <span class="float-right">
                        <a href="article-details.php?article_id=<?php echo $article->getId(); ?>" class="btn btn-info">Details</a>
                    </span>
                    <p><?php echo $article->getContent(); ?></p>
                    <span class="badge <?php echo getStatusBadgeClass($article->getStatus()); ?>"><?php echo $article->getStatus(); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>

        <p>
            <a href="../journalist/create-article.php" class="btn btn-primary">Add article</a>
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