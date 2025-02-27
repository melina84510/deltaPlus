<?php
require_once 'config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Recherche de l'utilisateur avec le token
    $SqlQuery = $db->prepare('SELECT * FROM inscription WHERE token = :token');
    $SqlQuery->execute(['token' => $token]);
    $user = $SqlQuery->fetch();

    if ($user) {
        // Activation du compte
        $updateStmt = $db->prepare('UPDATE inscription SET active = 1 WHERE token = :token');
        $updateStmt->execute(['token' => $token]);

        echo '<meta http-equiv="refresh" content="0;url=ucandidats.php">';
    } else {
        echo "Token invalide.";
    }
} else {
    echo "Aucun token fourni.";
}
?>