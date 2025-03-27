<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/config.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/head.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<title>Delta Plus | Messages envoyés par Melina</title>
<meta name="description" content="Afficher les messages envoyés par Melina.">

<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/header.php'; ?>



<main>
    <section>
        <div class="entrepot">
            <h1>Messagerie</h1>
            <img class="groupe" src="/images/entreprise1.webp" alt="Vue aérienne du siège social de Delta Plus à Apt, montrant les bâtiments et les installations de l'entreprise leader en fabrication d'Équipements de Protection Individuelle (EPI).">
        </div>
    </section>
    <section>
        <div>
            <a href="sendmessage">Messages envoyés</a>
            <a href="inbox">Messages reçus</a>
            <a href="">Messages supprimés</a>
        </div>
    </section>

    <!-- Formulaire d'envoi de message -->
    <section>
        <form class="colform" action="messages.php" method="POST">
            <div>
                <label for="message">Message :</label>
                <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if( !isset($_POST['message']) || strlen($_POST['message']) <= 10 ) {
                            $erreur++;
                            echo '<div class="alert">Il y a un problème avec le message !</div>';
                        } elseif (empty($_POST['message'])) {
                            $erreur++;
                            echo '<div class="alert">Veuillez saisir un message !</div>';
                        } else {
                            $message = htmlspecialchars($_POST['message']);
                        }
                    }
                    ?>
                <textarea id="message" name="message" required></textarea>
            </div>
            <div>
            <input type="submit" value="Envoyer">
            </div>

            <?php

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $erreur = 0;
                    if (empty($_POST['message'])) {
                        $erreur++;
                        echo '<div class="alert">Veuillez saisir un message !</div>';
                    } elseif (strlen($_POST['message']) <= 10) {
                        $erreur++;
                        echo '<div class="alert">Le message doit contenir plus de 10 caractères !</div>';
                    } else {
                        $message = htmlspecialchars($_POST['message']);
                    }


                    if ($erreur === 0) {
                        if (isset($_SESSION['USER_ID']) && isset($_SESSION['NOMPRENOM'])) {
                            $SqlQuery = $db->prepare('INSERT INTO `messages` (id, idcandidat, message, user, date) VALUES (NULL, :idcandidat, :message, :user, NOW())');
                            $SqlQuery->execute([
                                'idcandidat' => $_SESSION['USER_ID'],
                                'message' => $message,
                                'user' => $_SESSION['NOMPRENOM']
                            ]);
                            echo '<div id="popup" onclick="closePopup();">Message envoyé !</div>';
                        } else {
                            echo '<div class="alert">Erreur : Utilisateur non connecté.</div>';
                        }
                    } else {
                        echo '<div id="popup" onclick="closePopup();">Erreur détectée !</div>';
                    }
                }
            ?>
        </form>
    </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/footer.php'; ?>