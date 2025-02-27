<?php include('../config.php'); ?>
<?php 

//Vérifier que $_GET['idoffre'] existe dans la liste des offres
// $idoffre

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $favorite = $db->prepare("SELECT *  FROM offres WHERE id = :id");
    $favorite->execute(['id' => $id]);
    $retour = $favorite->fetch();

    if ( empty($retour) ) {
        exit();
    }

    //récupérer dans la base les idoffres déjà intégré dans la BDD pour l'utlisateur // voir ce que l'on a fait pour "mes annonces"

    if (isset($_SESSION['LOGGED_USER'])) {
        // Préparer la requête SQL pour récupérer l'idofavoris
        $RecupUsers = $db->prepare('SELECT idofavoris FROM `inscription` WHERE email = :adressemail');
        $RecupUsers->execute([
            'adressemail' => $_SESSION['LOGGED_USER']
        ]);
        $retoursql = $RecupUsers->fetch();
        $listeOffresFavorites = json_decode($retoursql['idofavoris'], true); //récupérer des données au format JSON dans la BDD //true avec json pour récupérer un tableau array
         
        // verifier si cette offre est déjà dans l'array
        if ( in_array($id, $listeOffresFavorites)) {
            // echo "est deja favori";
            $listeOffresFavorites = array_diff($listeOffresFavorites, [$id]);
            $listeOffresFavorites = array_values($listeOffresFavorites); // réindexe l'array
        } else {
            //n'est pas en favori
            $listeOffresFavorites[] = $id;
        }
        print_r($listeOffresFavorites);

        // UPDATE la nouvelle valeur dans la BDD avec json_encode($listeOffresFavorites, true)
    }
}
exit();



