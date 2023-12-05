<?php
$servername = "localhost";
$port = "8081";
$username = "root";
$password = "root";
$database = "articole";

$GLOBALS['conn'] = new mysqli($servername, $username, $password, $database);

if ($GLOBALS['conn']->connect_error) {
    die("Nu se poate conecta la bd: " . $GLOBALS['conn']->connect_error);
}
?>