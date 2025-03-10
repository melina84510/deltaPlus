<?php include $_SERVER['DOCUMENT_ROOT'] . '/config.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/head.php'; ?>

<title>Fiches métiers chez Delta Plus</title>
<meta name="description" content="retrouvez tout les profils métier présent chez Delta Plus">
<link rel="stylesheet" href="fiches.css">

<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/header.php'; ?>
<main>


<?php

$fiche = isset($_GET['fiche']) ? $_GET['fiche'] : null;
// if (isset($_GET['fiche'])) {
//     $fiche = $_GET['fiche'];
// } else {
//     $fiche = null;
// }

if ($fiche !== null) {
    $lien = "fiches/$fiche.html";

    if (file_exists($lien)) {
        include($lien);
        include('images.php');
    } else {
        // Rediriger vers la page metiers
        header("Location: metiers");
        exit(); // Assurez-vous de quitter le script après la redirection
    }
} else {
    // Rediriger vers la page metiers
    header("Location: metiers");
    exit(); // Assurez-vous de quitter le script après la redirection
}

?>

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/footer.php'; ?>