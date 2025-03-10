<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/config.php'; 

//traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if ( isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['pass']) && !empty($_POST['pass']) ) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $erreur_login = 'il faut un email valide pour soumettre le formulaire.';
        } else {
            //tentative de récupération des infos de l'utilisateur dans la BDD
            $mail = htmlspecialchars($_POST['email']);
            // //Recherche dans la BDD de la ligne avec le mail saisie par l'utilisateur
            $RecupUsers = $db->prepare('SELECT * FROM `users` WHERE mail =:adressemail');
            $RecupUsers->execute([
                'adressemail' => $mail
            ]);

            // //Fetch au lieu de fetchall car logiquement on ne récupère qu'une seule ligne dans ce cas ! 
            $retoursql = $RecupUsers->fetch();
            // echo "retour base :";
            // print_r($retoursql);

            // echo $retoursql['pass'];
            // echo $retoursql['mail'];

            //vérification des infos saisies :
                if (isset($retoursql['mail']) && isset($retoursql['pass'])) {
                //     //password_verify car on ne stock jamais un mot de passe en clair dans la BDD, on le hash ! 
                    if ( $retoursql['mail'] === $mail && password_verify($_POST['pass'],$retoursql['pass'])) {
                        // echo "mot de passe OK !"; 
                //         //si utilisateur reconnu, entrer ses infos en session : 
                        $_SESSION['LOGGED_USER'] = $retoursql['mail'];
                        $_SESSION['USER_ROLE'] = $retoursql['role'];
                //         $_SESSION['LOGGED_USER'] = ['mail' => $user['mail'], 'id' => $user ['id'],];
                    }
                }
        }
    }
    if (!isset($_SESSION['LOGGED_USER'])) {
        $erreur_login = 'Les informations envoyées ne permettent pas de vous identifier.';
        //DEBUG : echo password_verify($_POST['password'], $user['pass']);
    }
}

include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/header.php';
//  : si $_SESSION['LOGGED_USER'] n'existe pas alors afficher le formulaire
if (!isset($_SESSION['LOGGED_USER'])) : ?>

<main>
    <section>
        <div>
            <h2>Votre espace</h2>
        </div>
        <form action="" method="POST">
            <div>
                <label for="email">Email :</label>
                <input type="email" name="email" placeholder="" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@.+-_0123456789-" title="Il y a un problème avec l\'email !" required>
            </div>
            <?php 
                if (isset($erreur_login)) {
                    echo $erreur_login;
                }
            ?>
            <div>
                <label for="pass">Mot de passe :</label>
                <input type="password" name="pass" placeholder="" title="Il y a un problème avec le mot de passe !" required>
            </div>
            <div>
                <input type="submit" value="Envoyer">
            </div>
        </form>
    </section>
</main>

<?php 
// fermer le if du dessus
else : ?>

<main>
    <section>
        <?php 
            echo '<p class="of">' . $_SESSION['LOGGED_USER'] . ' est connecté ! <a href="offres">Offres</a> <a href="candidats">Candidatures</a> <a href="usercandidats">Candidats</a>';
            if ($_SESSION['USER_ROLE'] === 'admin') {
                echo ' <a href="utilisateurs">Utilisateurs</a></p>'; 
            }
        ?>
        <form action="logout.php" method="POST">
            <input type="submit" value="Déconnexion">
        </form>
    </section>

</main>

<?php endif; ?>



<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/footer.php'; ?>