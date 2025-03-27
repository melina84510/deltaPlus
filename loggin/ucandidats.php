<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

//traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if ( isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['pass']) && !empty($_POST['pass']) ) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $erreur_login = 'il faut un email valide pour soumettre le formulaire.';
        } else {
            //tentative de récupération des infos de l'utilisateur dans la BDD
            $mail = htmlspecialchars($_POST['email']);
            // //Recherche dans la BDD de la ligne avec le mail saisie par l'utilisateur
            $RecupUsers = $db->prepare('SELECT * FROM `inscription` WHERE email =:adressemail');
            $RecupUsers->execute([
                'adressemail' => $mail
            ]);

            // //Fetch au lieu de fetchall car logiquement on ne récupère qu'une seule ligne dans ce cas ! 
            $retoursql = $RecupUsers->fetch();

            //vérification des infos saisies :
            if (isset($retoursql['email']) && isset($retoursql['pass'])) {
                // Vérification si l'utilisateur est activé
                if ($retoursql['active'] == 1) {
                    // Si l'utilisateur est actif, on entre ses informations en session
            //     //password_verify car on ne stock jamais un mot de passe en clair dans la BDD, on le hash ! 
                    if ( $retoursql['email'] === $mail && password_verify($_POST['pass'],$retoursql['pass'])) {
                //         //si utilisateur reconnu, entrer ses infos en session : 
                        $_SESSION['LOGGED_USER'] = $retoursql['email'];
                        $_SESSION['USER_ROLE'] = 'candidat';
                        $_SESSION['USER_ID'] = $retoursql['id'];
                        $_SESSION['NOMPRENOM'] = $retoursql['nom'] . ' ' . $retoursql['prenom'];
                        $_SESSION['2FA'] = false;
                        header("Location: /loggin/verify.php");
                        exit();
                    } 
                }
            }
        }
        if (!isset($_SESSION['LOGGED_USER'])) {
            $erreur_login = 'Les informations envoyées ne permettent pas de vous identifier ou votre compte n\'est pas activé.';
            //DEBUG : echo password_verify($_POST['password'], $user['pass']);
        }
    }
}

include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/header.php';

//  : si $_SESSION['LOGGED_USER'] n'existe pas alors afficher le formulaire
if (!isset($_SESSION['LOGGED_USER'])) : ?>

<main>
    <section>
        <div>
            <h2>Votre espace utilisateur</h2>
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
                <input type="password" name="pass" placeholder="" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@.+-_0123456789-!:?" title="Il y a un problème avec le mot de passe" <?php if (isset($modeajout)) { echo "required"; } ?>>
                <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (!empty($_POST['pass'])) {
                            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                        } else {
                            echo "Le mot de passe est vide.";
                        }
                    }
                ?>
            </div>
            <div>
                <input type="submit" value="Envoyer">
            </div>
        </form>
    </section>
</main>

<?php  else : ?>
<main>
    <section>
        <h2 style="margin-bottom: 15px;">Bienvenue dans votre espace <?php echo htmlspecialchars($_SESSION['NOMPRENOM']); ?> !</h2>
        <div class='of'>
            <a onclick="location.href='/candidat/profil.php'">Mon profil</a>
            <a onclick="location.href='/candidat/documents.php'">Mes documents</a>
            <a onclick="location.href='/offres/favoris.php'">Mes annonces</a>
            <a onclick="location.href='/candidat/messages.php'">Mes messages</a>
        </div>
    </section>
    <section>
        <form action="/loggin/logout.php" method="POST">
            <input type="submit" value="Déconnexion">
        </form>
    </section>
</main>

<?php 

endif; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/footer.php'; ?>