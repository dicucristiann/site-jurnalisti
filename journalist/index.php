<?php
include('conexiune.php');

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
    <title>User Dashboard</title>
</head>
<body>

<h1>Welcome, <?php echo isset($user['nume']) ? $user['nume'] : 'Guest'; ?>!</h1>

<?php if ($userRole === 'jurnalist'): ?>
    <button onclick="writeArticle()">Scrie Articol</button>
    <button onclick="readArticles()">Citeste Articol</button>
<?php elseif ($userRole === 'editor'): ?>
    <button onclick="validateArticle()">Valideaza Articol</button>
    <button onclick="readArticles()">Citeste Articol</button>
<?php elseif ($userRole === 'cititor'): ?>
    <button onclick="readArticles()">Citeste Articol</button>
<?php else: ?>
    <p>rol necunoscut</p>
<?php endif; ?>

<script>
    function writeArticle() {
        alert('Scrie articol!');
    }

    function validateArticle() {
        alert('Valideaza articol!');
    }

    function readArticles() {
        alert('Citeste articol!');
    }
</script>

</body>
</html>