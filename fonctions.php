<?php

function recupOffre($idOffre) {
    global $db;
    // Retourne false si l'offre n'existe pas, sinon retourne les infos de l'offre.
    if (! isset($idOffre)) {
        return false;
    }
    $stockoffre= $db->prepare('SELECT * FROM `offres` WHERE `id` LIKE :idoffre');
    $getOffre = htmlspecialchars($idOffre);
    $stockoffre->execute([
        'idoffre' => $getOffre
    ]);
    $offrepostuler = $stockoffre->Fetch();
    if ($offrepostuler == "") {
        return false;
    } else {
        return $offrepostuler;
    }
}

function traitementUpload($name) {
    global $erreur;
    global $_FILES;
    // Variables :
    $allowedExtensions = ['pdf','jpeg','png','jpg','webp'];
    $allowedSizeMo = "20"; // Mo
    $path = '/uploads/';

    $pathupload = __DIR__ . $path;

    // cv est le name de l'uploads

    if (isset($_FILES[$name]) && $_FILES[$name]['error'] == 0) {
        $allowedSize = $allowedSizeMo * 1000000; //transforme en octets
        if ($_FILES[$name]['size'] > $allowedSize) {
            $erreur++;
            echo "L'envoi n'a pas pu être effectué, élément trop volumineux !";
        }
    }
    

    // Vérifier l'extension du fichier
    $fileInfo = pathinfo($_FILES[$name]['name']);
    $extension = $fileInfo['extension'];
    if (!in_array($extension, $allowedExtensions)) {
        $erreur++;
        echo "L'envoi n'a pas pu être effectué, l'extension {$extension} n'est pas autorisée !";
    }

    // Vérifier le dossier de stockage des uploads
    if (!is_dir($pathupload)) {
        $erreur++;
        echo "L'envoi n'a pas pu être éffectué, le dossier uploads est manquant !";
    }

    // Gérer le nom du fichier que l'on upload
    $longueur = 16;
    $filename = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', $longueur)), 0, $longueur);
    $filebasename = $pathupload . $filename . '.' . $extension;

    //Déplacer définitivement le fichier dans son emplacement final
    if ($erreur == 0) {
        if (move_uploaded_file($_FILES[$name]['tmp_name'], $filebasename)) {
            return $path . $filename . '.' . $extension;
        } else {
            echo "Erreur de stockage, contactez l'administrateur !";
        }
    }
}

?>