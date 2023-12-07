<?php
// Include config file
require_once "../config.php";

// Include Article and ArticleManager classes
require_once "../models/Article.php";
require_once "../models/ArticleManager.php";
require_once "../models/UserManager.php";

// Initialize the session
session_start();

// Check if the user is logged in and has the necessary permissions
if(empty($_SESSION["user_id"])){
    header("location: ../login.php");
    exit;
}


// Check if article ID is provided in the URL
if (!isset($_GET["article_id"])) {
    // Redirect to an error page or handle appropriately
    header("location: error.php");
    exit();
}

// Retrieve article details
$articleId = $_GET["article_id"];
$articleManager = new ArticleManager($mysqli);
$article = $articleManager->getArticleById($articleId);

// Check if the article exists
if (!$article) {
    // Redirect to an error page or handle appropriately
    header("location: error.php");
    exit();
}

// Check if the logged-in user has the necessary permissions to approve/reject articles
// You may want to implement a more sophisticated role-based access control system
$userManager = new UserManager($mysqli);
$user = $userManager->getUserById($_SESSION["user_id"]);

if (!$user || $user->getRole() !== 'editor' ) {
    // Redirect to an error page or handle appropriately
    header("location: error.php");
    exit();
}

// Handle form submission for approving/rejecting the article
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["approve"])) {
        $status = 'approved';
        $statusMessage = $_POST["status_message"];
        if($articleManager->updateArticleStatus($articleId, $status, $statusMessage))
            header("location: index.php");

    } elseif (isset($_POST["reject"])) {
        $status = 'rejected';
        $statusMessage = $_POST["status_message"];
        if($articleManager->updateArticleStatus($articleId, $status, $statusMessage))
        {
            header("location: index.php");
        }
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Article Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }

        .article-container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="article-container">
    <?php if ($article): ?>
        <h2><?php echo htmlspecialchars($article->getTitle()); ?></h2>
        <p><?php echo nl2br(htmlspecialchars($article->getContent())); ?></p>
        <div class="card mb-3">
            <div class="card-header">
                    <span class="badge <?php echo getStatusBadgeClass($article->getStatus()); ?>">
                        <?php echo htmlspecialchars($article->getStatus()); ?>
                    </span>
                Current Status
            </div>
            <div class="card-body">
                <p class="card-text">Status Message: <?php echo nl2br(htmlspecialchars($article->getStatusMessage())); ?></p>
            </div>
        </div>

        <div class="btn-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?article_id=" . $articleId); ?>" method="post">
                <div class="form-group">
                    <label for="status_message">Status Message:</label>
                    <textarea class="form-control" name="status_message" required></textarea>
                </div>
                <button type="submit" class="btn btn-success" name="approve">Approve</button>
                <button type="submit" class="btn btn-danger" name="reject">Reject</button>
            </form>
        </div>

        <div class="btn-container">
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
        </div>
    <?php else: ?>
        <p>Article not found.</p>
    <?php endif; ?>
</div>
</body>
</html>

<?php
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