<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';


session_start();

// Vérifiez si le rôle est défini
if (isset($_SESSION['USER_ROLE'])) {
    $role = $_SESSION['USER_ROLE']; // Sauvegarder le rôle
} else {
    $role = null; // Par défaut, aucun rôle
}




// Rediriger selon le rôle sauvegardé
if ($role == 'rh' || $role == 'admin') {
    header("Location: /open.php");
} else {
    header("Location: /loggin/ucandidats.php");
}

// Détruire la session
session_unset();
session_destroy();
exit;

?>