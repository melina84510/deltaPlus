<?php include('config.php'); ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?>
<title>Delta Plus | Entreprise Familiale Leader en Fabrication d'EPI</title>
<meta name="description" content="Découvrez Delta Plus, une entreprise familiale et leader dans la fabrication d'Équipements de Protection Individuelle (EPI). Forts de notre héritage, nous protégeons les travailleurs du monde entier avec des solutions innovantes et fiables.">
<main>
    <section>
    <?php $erreur = 0; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="colform">
                        <label for="nom">Votre Nom</label>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            if (!empty($_POST['nom'])) {
                                $nom = htmlspecialchars($_POST['nom']);
                            } else {
                                $erreur++;
                                echo '<div class="alert">Veuillez saisir un nom.</div>';
                            }
                        }
                        ?>
                        <input type="text" name="nom" placeholder="Votre nom" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-" title="Il y a un problème avec le nom !" value="<?php if (isset($nom)) { echo $nom; } ?>"required>


                        <label for="prenom">Votre Prénom *</label>
                        <?php
                            if ($_SERVER['REQUEST_METHOD']=='POST') {
                                if (!isset($_POST['prenom'])) {
                                    $erreur++;
                                    echo '<div class="alert">Il y a un problème avec le prenom !</div>';
                                } elseif (empty($_POST['prenom'])) {
                                    $erreur++;
                                    echo '<div class="alert">Veuillez saisir le prenom !</div>';
                                } else {
                                    $prenom = htmlspecialchars($_POST['prenom']);
                                }
                            }
                        ?>
                        <input type="text" name="prenom" placeholder="Votre Prénom" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-" title="Il y a un problème avec le prénom !" value="<?php if (isset($prenom)) { echo $prenom; } ?>" required>

                        <label for="telephone">Votre Téléphone *</label>
                        <?php 
                            if ($_SERVER['REQUEST_METHOD']=='POST') {
                                if( !isset($_POST['telephone']) || empty($_POST['telephone']) ) {
                                    $erreur++;
                                    echo '<div class="alert">Il y a un problème avec le tel</div>';
                                } elseif (!preg_match('/^0[0-9]{9}$/', $_POST['telephone'])) { 
                                    $erreur++;
                                    echo '<div class="alert">Le numéro saisi ne ressemble pas a un numéro français à 10 chiffres.</div>';
                                } else {
                                    $tel = htmlspecialchars($_POST['telephone']);
                                }
                            }
                        ?>
                        <input type="text" name="telephone" placeholder="Votre Téléphone" patern="\d{10}" title="Il y a un problème avec le numéro de téléphone !" value="<?php if (isset($tel)) { echo $tel; } ?>" required>

                        <label for="email">Votre Email</label>
                        <?php 
                        if ($_SERVER['REQUEST_METHOD']=='POST') {
                            if( !isset($_POST['email']) || empty($_POST['email']) ) {
                                $erreur++;
                                echo '<div class="alert">Il y a un problème avec l\'adresse mail</div>';
                            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                                // Pour le mail, on vérifie aussi que la valeur transmise ressemble à une adresse mail valide :
                                $erreur++;
                                echo '<div class="alert">Cet email ne ressemble pas à un email</div>';
                            } else {
                                // Si tout est OK, alors je sécurise ma valeur.
                                $email = htmlspecialchars($_POST['email']);
                            } 
                        }
                        ?>
                        <input type="text" name="email" placeholder="Votre Email" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_.@" title="Il y a un problème avec le mail !" value="<?php if (isset($email)) { echo $email; } ?>" required>

                        <div>
                            <label for="pass">Mot de passe :</label>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (!empty($_POST['pass'])) {
                                    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                                } else {
                                    echo "Le mot de passe est vide.";
                                }
                            }
                            ?>
                            <input type="password" name="pass" placeholder="Mot de passe" title="Il y a un problème avec le mot de passe !" required>
                        </div>

                        <label for="naissance">Date de naissance</label>
                        <?php
                         if ($_SERVER['REQUEST_METHOD']=='POST') { 
                            if (!empty($_POST['naissance'])) {
                                try {
                                    $date = DateTime::createFromFormat('Y-m-d', $_POST['naissance']);
                                    if ($date && $date->format('Y-m-d') === $_POST['naissance']) {
                                        $naissance = $date->format('Y-m-d'); // Conversion au format MySQL
                                    } else {
                                        $erreur++;
                                        echo '<div class="alert">Format de date invalide. Utilisez JJ/MM/AAAA.</div>';
                                    }
                                } catch (Exception $e) {
                                    $erreur++;
                                    echo '<div class="alert">Date invalide.</div>';
                                }
                            } else {
                                $erreur++;
                                echo '<div class="alert">Date de naissance requise.</div>';
                            }
                        }   
                        ?>
                        <input type="date" name="naissance" placeholder="Date de naissance" title="Il y a un problème avec la date de naissance !" value="<?php if (isset($naissance)) { echo $naissance; } ?>" required>

                        <label for="secteur">Secteur d'activité</label>
                        <?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (!empty($_POST['secteur'])) {
                                if (preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+$/", $_POST['secteur'])) {
                                    $secteur = htmlspecialchars($_POST['secteur']);
                                } elseif (empty($_POST['secteur'])) {
                                    $erreur++;
                                    echo '<div class="alert">Veuillez saisir un secteur d\'activité valide (lettres et espaces uniquement).</div>';
                                }
                            } else {
                                $erreur++;
                                echo '<div class="alert">Le secteur d\'activité est requis.</div>';
                            }
                        }
                        ?>
                        <input type="text" name="secteur" placeholder="Secteur d\activité" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz" title="Il y a un problème avec le secteur d'activité !" value="<?php if (isset($secteur)) { echo $secteur; } ?>" required>
                <!-- <?php
                if ($_SERVER['REQUEST_METHOD']=='POST') { //si le message est envoyé
                    // Vérification du captcha 
                    if ( isset($_POST['h-captcha-response']) ) {
                        $retour = $_POST['h-captcha-response'];
                    } else {
                        $retour = "";
                    }
                    
                    $remoteip = $_SERVER['REMOTE_ADDR'];
                    $api_url = "https://hcaptcha.com/siteverify?secret=". $secret . "&response=" . $retour . "&remoteip=" . $remoteip;
                    $decode = json_decode(file_get_contents($api_url), true);
                    if ($decode['success'] == false) {
                        $erreur++;  
                        echo '<div class="alert">Le captcha n\'a pas fonctionner</div>';
                    }
                }
                ?>
                <div class="h-captcha" data-sitekey="<?php echo $public; ?>"></div>
                <script src="https://js.hcaptcha.com/1/api.js" async defer></script> -->
                <div>
                    <input type="submit" value="Envoyer">
                </div>
                <!-- <?php $erreur = 0; ?> -->


                <?php
                
         
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($erreur === 0) {
                        // Génère un token unique
                        $token = bin2hex(random_bytes(32));

                        try {
                            $SqlQuery = $db->prepare('INSERT INTO `inscription` (nom, prenom, telephone, email, pass, naissance, secteur, active, token) VALUES (:nom, :prenom, :telephone, :email, :pass, :naissance, :secteur, :active, :token)');
                            $SqlQuery->execute([
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'telephone' => $tel,
                                'email' => $email,
                                'pass' => $pass,
                                'naissance' => $naissance,
                                'secteur' => $secteur,
                                'active' => 0,
                                'token' => $token,
                            ]);

                            $activationLink = "https://deltaplus.optimhum.fr/verif.php?token=" . urlencode($token);

                            $to = $email; // Adresse email du destinataire
                            $subject = "Confirmation de votre inscription";

                            $message = "
                            <!DOCTYPE html>
                            <html lang='fr'>
                            <head>
                                <meta charset='UTF-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                <title>Confirmation d'inscription</title>
                            </head>
                            <body style='font-family: Arial, sans-serif; line-height: 1.6;'>
                                <h2>Bienvenue sur notre plateforme !</h2>
                                <p>Bonjour <strong>$prenom $nom</strong>,</p>
                                <p>Merci de vous être inscrit sur notre plateforme.</p>
                                <p>Pour activer votre compte, veuillez cliquer sur le lien ci-dessous :</p>
                                <p>
                                    <a href='$activationLink' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Activer mon compte</a>
                                </p>
                                <p>Si le bouton ne fonctionne pas, vous pouvez copier et coller ce lien dans votre navigateur :</p>
                                <p><a href='$activationLink'>$activationLink</a></p>
                                <p>Nous espérons vous voir bientôt sur notre site !</p>
                                <p>Merci,<br>L'équipe de Delta Plus</p>
                            </body>
                            </html>
                            ";

                            // En-têtes pour l'email
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                            $headers .= "From: srv.optimhum@gmail.com" . "\r\n"; // Adresse de l'expéditeur
                            $headers .= "Reply-To: melina.meneghini@deltaplus.fr" . "\r\n"; // Adresse pour les réponses

                            // Envoi de l'email
                            if (mail($to, $subject, $message, $headers)) {
                                echo '<div id="popup" onclick="closePopup();">ENREGISTREMENT RÉUSSI ! Un mail de confirmation vous a été envoyé.</div>';
                            } else {
                                echo '<div class="alert">Erreur lors de l\'envoi de l\'email. Veuillez réessayer plus tard.</div>';
                            }
                        } catch (PDOException $e) {
                            echo '<div class="alert">Erreur d\'insertion : ' . htmlspecialchars($e->getMessage()) . '</div>';
                        }
                    } else {
                        echo '<div id="popup" onclick="closePopup();">' . $erreur . ' erreur(s) détectée(s) !</div>';
                    }                   
                }
                ?>
        </form>
    </section>
</main>

<?php include('footer.php'); ?>