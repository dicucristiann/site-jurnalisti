<?php


require_once "../config.php";
require_once "../models/ArticleManager.php";

session_start();

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
// Creating article manager with database connection
$articleManager = new ArticleManager($mysqli);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $category = $_POST["category"]; // New line to get the category field

    if (!empty($title) && !empty($content) && !empty($category)) {
        // Get user_id from session (replace this with your actual session handling)
        $user_id = $_SESSION['user_id'];

        // Create the article
        if ($articleManager->createArticle($title, $content, $user_id, $category)) {
            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            echo "Error creating article";
        }
    } else {
        echo "Please fill in title, content, and category";
    }
}

?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Article</title>
        <!-- Add Bootstrap CSS link -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="display-5">Create Article</h1>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="technology">Technology</option>
                            <option value="science">Science</option>
                            <option value="business">Business</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content:</label>
                        <textarea class="form-control" id="content" name="content" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Article</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js scripts (required for some Bootstrap features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
<?php
// Close the database connection
$mysqli->close();
?>