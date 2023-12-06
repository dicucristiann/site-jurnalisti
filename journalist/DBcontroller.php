<?php
$hostname = "localhost";
$port = "8081";
$username = "root";
$password = "";
$database = "articole";

// Conexiune la serverul MySQL
$conn = new mysqli($hostname, $username, $password, $database);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiune esuata: " . $conn->connect_error);
}

// Creare baza de date
$sqlCreateDb = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sqlCreateDb) === TRUE) {
    echo "Baza de date a fost creata\n";
} else {
    echo "Eroare baza de date: " . $conn->error . "\n";
}

$conn->close();

// Conectare la baza de date
$conn = new mysqli($hostname, $username, $password, $database);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiune esuata: " . $conn->connect_error);
}

// Creare tabele și inserare date
$sqlPath = 'db.sql';
if (file_exists($sqlPath)) {
    $sql = file_get_contents($sqlPath);

    if ($conn->multi_query($sql) === TRUE) {
        echo "Tabele și date create cu succes\n";
    } else {
        echo "Eroare la crearea tabelelor și datelor: " . $conn->error . "\n";
    }

    $conn->close();
} else {
    echo "Fișierul db.sql nu a fost găsit\n";
}
?>