<?php
require_once("DBController.php");

session_start();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM articles WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['title']; ?></title>
</head>
<body>
<h2><?php echo $row['title']; ?></h2>
<p>Author: <?php echo $row['journalist_id']; ?></p>
<p>Published at: <?php echo $row['published_at']; ?></p>
<p><?php echo $row['content']; ?></p>
</body>
</html>