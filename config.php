<?php 

//lancer une session, activation de la superglobale $_SESSION
// if (!isset($_SESSION)) {
    session_start();
// }

//Paramètres de la BDD 
$host = 'localhost';
$dbname = 'deltaplus';
$username = 'deltaplus';
$pass = 'thoo3ioxaizigo';

$secret = 'ES_bd2103ab9a6a48d69cdf043b50506e6c';
$public = '153ac59a-75ea-4c0a-8fd4-bfa206e0f226';
//Connexion à la BDD + alertes erreurs
try
{
    $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8',$username,$pass);
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

// echo "<pre>";print_r($_SESSION);echo "</pre>";

if (isset($_SESSION['LOGGED_USER']) && !empty($_SESSION['LOGGED_USER'])) {
    if (!isset($_SESSION['2FA']) || ($_SESSION['2FA'] == false)) {
        if (!isset($_SESSION['verification_code'])) {
            // Générer un code de vérification unique et Enregistrer ce code dans la session
            $_SESSION['verification_code'] = rand(100000, 999999);;
            $_SESSION['verification_email'] = $_SESSION['LOGGED_USER'];

            // Envoyer le code de vérification à l'utilisateur par email
            mail($_SESSION['verification_email'], 'Code de vérification', "Voici votre code de vérification : ".$_SESSION['verification_code']);
        }
    }
    
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/fonctions/fonctions.php';
$erreur = 0;

$listeservices = [
    'accueil' => 'Accueil',
    'finance' => 'Finance',
    'rh' => 'Ressources humaine',
    'it' => 'Informatique',
    'logistique' => 'Logistique',
    'exp' => 'Export',
    'marketing' => 'Marketing',
    'achats' => 'Achats',
    'commerce' => 'Commerce',
    'produits' => 'Produits',
    'servicegene' => 'Services généraux',
]

?>