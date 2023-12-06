<?php
include ('login.php');// partea asta nu functioneaza si trebuie modificat in css cate ceva
include('conexiune.php');
// Select the database
$databaseName = 'articole';
$GLOBALS['conn']->select_db($databaseName);

//get role from query parameter
$userRole = isset($_GET['role']) ? $_GET['role'] : '';

$sql = "SELECT * FROM utilizatori WHERE rol = '$userRole'";
$result = $GLOBALS['conn']->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $errorMessage = 'Invalid user role.';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Jurnalisti</title>
    <!-- Include Bootstrap CSS and JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Link to the separate CSS file -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<!--<div class="overlay"></div>-->

<div class="container" >
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome, <?php echo isset($user['nume']) ? $user['nume'] : 'Guest'; ?>!</h1>
    </div>

    <?php if ($userRole === 'jurnalist'): ?>
        <button class="btn btn-success mr-2" onclick="writeArticle()">Write Article</button>
        <button class="btn btn-info" onclick="readArticles()">Read Article</button>
    <?php elseif ($userRole === 'editor'): ?>
        <button class="btn btn-primary mr-2" onclick="validateArticle()">Validate Article</button>
        <button class="btn btn-info" onclick="readArticles()">Read Article</button>
    <?php elseif ($userRole === 'cititor'): ?>
        <button class="btn btn-info" onclick="readArticles()">Read Article</button>
    <?php else: ?>
        <p class="text-danger">Unknown role</p>
    <?php endif; ?>
</div>

<script>
    function writeArticle() {
        alert('Write article!');
    }

    function validateArticle() {
        alert('Validate article!');
    }

    function readArticles() {
        alert('Read article!');
    }
</script>

</body>
</html>