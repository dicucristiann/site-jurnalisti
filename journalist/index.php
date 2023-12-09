<?php

global $mysqli;
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
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Bun venit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body { font: 14px sans-serif; text-align: center; }
        h1 { margin-top: 50px; }

        /* Stil pentru zona de navigare */
        .nav-tabs { margin-bottom: 20px; display: flex; justify-content: space-around; }
        .nav-tabs .nav-item { flex: 1; text-align: center; }

        /* Stil pentru lista de articole */
        ul { list-style: none; padding: 0; }
        li { border: 1px solid #ddd; margin: 10px 0; padding: 10px; border-radius: 5px; }
        .badge { margin-right: 5px; }
        .edit-btn { margin-top: 10px; }

        /* Stil pentru butoanele de acțiune */
        .action-buttons { margin-top: 20px; }
        .action-buttons a { margin-right: 10px; }
    </style>
</head>

<body>

<div class="container">
    <h1 class="my-5">Salut, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bine ai venit pe site-ul nostru.</h1>

    <div class="action-buttons">
        <a href="create-article.php" class="btn btn-primary">Adaugă articol</a>
        <a href="../reset-password.php" class="btn btn-warning">Resetează parola</a>
        <a href="../logout.php" class="btn btn-danger">Deconectează-te</a>
    </div>

    <ul class="nav nav-tabs">
        <!-- Meniul pentru categorii -->
        <li class="nav-item">
            <a class="nav-link <?php echo $category === null ? 'active' : ''; ?>" href="?category=all">Toate</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $category === 'artistic' ? 'active' : ''; ?>" href="?category=artistic">Artistic</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $category === 'technic' ? 'active' : ''; ?>" href="?category=technic">Tehnic</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $category === 'science' ? 'active' : ''; ?>" href="?category=science">Știință</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $category === 'moda' ? 'active' : ''; ?>" href="?category=moda">Modă</a>
        </li>
    </ul>

    <ul>
        <?php foreach ($articles as $article): ?>
            <!-- Structura pentru afișarea articolelor -->
            <li>
                <h2><?php echo $article->getTitle(); ?></h2>
                <?php if(isset($_SESSION["user_id"])): ?>
                    <p><?php echo $article->getContent(); ?></p>
                <?php endif; ?>
                <span class="badge <?php echo getStatusBadgeClass($article->getStatus()); ?>"><?php echo $article->getStatus(); ?></span>

                <?php if ($article->getStatus() !== 'approved'): ?>
                    <a href="edit-article.php?article_id=<?php echo $article->getId(); ?>" class="btn btn-info edit-btn">Editează</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
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
