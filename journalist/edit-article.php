<!-- edit-article.php -->

<?php
require_once "../config.php";
require_once "../models/ArticleManager.php";
require_once "../models/Article.php";

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (empty($_SESSION["user_id"])) {
    header("location: ../login.php");
    exit;
}

$articleManager = new ArticleManager($mysqli);

// Check if the article_id is provided in the URL
if (!isset($_GET["article_id"])) {
    header("location: index.php");
    exit;
}

$articleId = $_GET["article_id"];
$article = $articleManager->getArticleById($articleId);

error_log(print_r($article->getAuthorId(), TRUE));

// Check if the article exists and the author is the current user
if (!$article || $article->getAuthorId() !== $_SESSION["user_id"]) {
    header("location: journalist_view.php");
    exit;
}

// Handle form submission to update the article
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newTitle = $_POST["title"];
    $newContent = $_POST["content"];
    $newCategory = $_POST["category"];

    // Validate and update the article
    // You should add proper validation and error handling here
    if (!empty($newTitle) && !empty($newContent) && !empty($newCategory)) {
        $article->setTitle($newTitle);
        $article->setContent($newContent);
        $article->setCategory($newCategory);

        // Update the article in the database
        $articleManager->updateArticle($article);

        // Redirect to journalist view after updating
        header("location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Article</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font: 14px sans-serif; text-align: center; }
        h1 { margin-top: 50px; }
        form { max-width: 600px; margin: auto; }
    </style>
</head>
<body>
<div class="container">
    <h1 class="my-5">Edit Article</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?article_id=" . $articleId); ?>" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($article->getTitle()); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="8" required><?php echo htmlspecialchars($article->getContent()); ?></textarea>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-select" id="category" name="category" value="<?php echo htmlspecialchars($article->getCategory()); ?>" required>
                <option value="artistic">Artistic</option>
                <option value="technic">Technic</option>
                <option value="science">Science</option>
                <option value="moda">Moda</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Article</button>
    </form>
</div>
</body>
</html>