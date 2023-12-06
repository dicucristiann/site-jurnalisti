<?php
// conexiune.php

$servername = "localhost";
$username = "root";
$password = "";
$database = "articole";

// Crearea conexiunii
$GLOBALS['conn'] = new mysqli($servername, $username, $password, $database);

// Verificarea conexiunii
if ($GLOBALS['conn']->connect_error) {
    die("Connection failed: " . $GLOBALS['conn']->connect_error);
}

?>