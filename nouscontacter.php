<?php include('config.php'); ?>
<?php include('head.php'); ?>
    <link rel="stylesheet" href="nouscontacter.css">
    <title>Contactez Delta Plus | Leader en EPI & Opportunités d'Emploi</title>
    <meta name="description" content="Contactez Delta Plus, leader en fabrication d'EPI, pour toute question concernant nos produits de protection individuelle ou pour en savoir plus sur nos opportunités d'emploi. Nous sommes là pour vous aider !">
    </head>
<body>
<?php include('header.php'); ?>
<main>
    <section>
        <div class="entrepot">
            <h1>Candidatures</h1>
            <img class="groupe" src="images/carriere.webp" alt="Des hommes habillaient avec des EPI de chez delta plus">
        </div>
    </section>
    <section>
        <div>
            <h2>
            Vous souhaitez prendre part à l'aventure Delta Plus ?
            Vous souhaitez contribuer à la protection de millions de travailleurs dans le monde ?
            Vous êtes au bon endroit.
            </h2>
        </div>
        <div class="case">
            <div>
                <a href="metiers">Nos métiers</a>
            </div>
            <div>
                <a href="offres">Nos offres emploi</a>
            </div>
            <div>
                <a href="nouscontacter">Candidature spontanée</a>
            </div>
        </div>
    </section>
    <section>
        <div>
            <h3>
                Déposez votre cv en ligne afin de le rendre consultable par notre service recrutement. <br> Envoyez votre candidature spontanée
            </h3>
        </div>
    </section>
    <section class="sform">
            <div>                    
                <div>
                    <p>
                        * Indique les champs obligatoires
                    </p>
                </div>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <?php 
                    if (isset($_GET['offre'])) {
                        // REQUETE POUR VERIFIER QUE LOFFRE EXISTE + RECUPERER SON NOM
                        $offrepostuler = recupOffre($_GET['offre']);
                        // print_r($offrepostuler);
                        if ($offrepostuler == "") {
                            echo '<input type="hidden" name="idoffre" value="spontanne">';
                        } else {
                            echo '<p>Vous postulez pour : ' . $offrepostuler['nom'] .'</p>';
                            echo '<input type="hidden" name="idoffre" value="' . $offrepostuler['id'] .'">';
                        }
                    } else {
                        echo '<input type="hidden" name="idoffre" value="spontanne">';
                    }
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if ( (!isset($_POST['idoffre'])) || (empty($_POST['idoffre'])) || ($_POST['idoffre'] == "spontanne") ) {
                            $idoffre = NULL;
                        } else {
                            $idoffre = recupOffre($_POST['idoffre']);
                            if ($idoffre == false){
                                $idoffre = NULL;
                            } else {
                                $idoffre = $idoffre['id'];
                            }
                        }
                    }
                    ?>



                    <div class="colform">
                        <label for="Nom">Votre Nom *</label>
                        <?php
                            if ($_SERVER['REQUEST_METHOD']=='POST') {
                                if (!isset($_POST['nom'])) {
                                    $erreur++;
                                    echo '<div class="alert">Il y a un problème avec le nom !</div>';
                                } elseif (empty($_POST['nom'])) {
                                    $erreur++;
                                    echo '<div class="alert">Veuillez saisir le nom !</div>';
                                } else {
                                    $nom = htmlspecialchars($_POST['nom']);
                                }
                            }
                        ?>
                        <input type="text" name="nom" placeholder="Votre nom" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-" title="Il y a un problème avec le nom !" value="<?php if (isset($nom)) { echo $nom; } ?>"required>
                    </div>

                    
                    <div class="colform">
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
                    </div>
                </div>

                <div>
                    <div class="colform">
                        <label for="telephone">Votre Téléphone *</label>
                        <?php 
                            if ($_SERVER['REQUEST_METHOD']=='POST') {
                                if( !isset($_POST['telephone']) || empty($_POST['telephone']) ) {
                                    $erreur++;
                                    echo '<div class="alert">Il y a un problème avec le tel</div>';
                                } elseif (!preg_match('/^0[0-9]{9}$/', $_POST['telephone'])) { 
                                    // Vérifier que la valeur saisie ressemble a un numéro de téléphone français
                                    $erreur++;
                                    echo '<div class="alert">Le numéro saisi ne ressemble pas a un numéro français à 10 chiffres.</div>';
                                } else {
                                    $tel = htmlspecialchars($_POST['telephone']);
                                }
                            }
                        ?>
                        <input type="text" name="telephone" placeholder="Votre Téléphone" patern="0123456789" title="Il y a un problème avec le numéro de téléphone !" value="<?php if (isset($tel)) { echo $tel; } ?>" required>
                    </div>

                    

                    <div class="colform">
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
                    </div>
                </div>
                <div>
                    <label class="message" for="message">Message</label>
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
                    <textarea type="text" name="message" placeholder="Message" required><?php if (isset($message)) { echo $message; } ?></textarea>
                </div>

                <?php
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

                

                if ($_SERVER['REQUEST_METHOD']=='POST') {
                    $cv = traitementUpload('cv');
                    $lettremotiv = traitementUpload('lm');  
                }
                ?>


                <div>
                    <label for="cv">Sélectionnez votre CV * :</label>
                    <input type="file" id="cv" name="cv" accept=".pdf, .doc, .docx">
                </div>
                <div>
                    <label for="lm">Sélectionnez votre Lettre de motivation * :</label>
                    <input type="file" id="lm" name="lm" accept=".pdf, .doc, .docx">
                </div>

                <div class="h-captcha" data-sitekey="<?php echo $public; ?>"></div>
                <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
                </div>
                <div>
                    <input type="submit" value="Envoyer">
                </div>
                <?php
                if ($_SERVER['REQUEST_METHOD']=='POST') {
                    if ($erreur === 0) {
                        $SqlQuery = $db->prepare('INSERT INTO `candidat` (id, nom, prenom, telephone, mail, message, cv, lettremotiv, date, idoffre) VALUES (NULL, :nom, :prenom, :telephone, :mail, :message, :cv, :lettremotiv, NOW(), :idoffre)');
                        $SqlQuery->execute([
                            'nom' => $nom,
                            'prenom' => $prenom,
                            'telephone' => $tel,
                            'mail' => $email,
                            'message' => $message,
                            'cv' => $cv,
                            'lettremotiv' => $lettremotiv,
                            'idoffre' => $idoffre
                        ]);
                        echo '<div id="popup" onclick="closePopup();">ENREGISTREMENT REUSSI !</div>';
                    } else {
                        echo '<div id="popup" onclick="closePopup();">' . $erreur . 'erreur détecté !</div>';
                    }
                }
                ?>
            </form>
        </div>
    </section>
    <section>
        <?php include('images.php'); ?> 
    </section>
    <section>
        <div>
            <img class="groupe" src="images/carriere.webp" alt="Des hommes habillaient avec des EPI de chez delta plus">
        </div>
    </section>
</main>
</body>
<?php include('footer.php'); ?>