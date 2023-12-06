<?php
$servername = "localhost";
$port = "8081";
$username = "root";
$password = "";
$database = "articole";

$GLOBALS['conn'] = new mysqli($servername, $username, $password);

if ($GLOBALS['conn']->connect_error) {
    die("Nu se poate conecta la bd: " . $GLOBALS['conn']->connect_error);
}
?>