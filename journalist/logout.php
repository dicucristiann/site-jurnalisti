<?php

// Ștergem cookie-ul de autentificare
setcookie('id_jurnalist', '', time() - 3600, '/');

// Redirecționăm utilizatorul către pagina principală
header('Location: index.php');

?>