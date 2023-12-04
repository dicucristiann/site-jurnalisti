<?php
session_start();
require_once("DBController.php");

if (!isset($_SESSION['editor_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM articles WHERE is_approved = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Articles</title>
</head>
<body>
<h2>Approve Articles</h2>
<ul>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "Title: " . $row['title'] . "<br>";
        echo "Author: " . $row['journalist_id'] . "<br>";
        echo "Published at: " . $row['published_at'] . "<br>";
        echo "<a href='read_article.php?id=" . $row['id'] . "'>Read more</a><br>";
        echo "<a href='approve_article.php?id=" . $row['id'] . "'>Approve</a>";
        echo "</li><br>";
    }
    ?>
</ul>
</body>
</html>
?>
