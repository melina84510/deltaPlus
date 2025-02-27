<?php include('config.php'); ?>
<?php include('head.php'); ?>
<?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['chgPWD'])) {
                if (!empty($_POST['pass1']) && !empty($_POST['pass2'])) {
                    if ($_POST['pass1'] == $_POST['pass2']) {
                        $pass = password_hash($_POST['pass1'], PASSWORD_DEFAULT);
                        //requete UPDATE
                        $updateSQL = $db->prepare('UPDATE `inscription` SET  `pass` = :pass WHERE `inscription`.`id` = :id');
                        $updateSQL->execute([
                            'id' => $_SESSION['USER_ID'],
                            'pass' => $pass
                        ]);
                        header('Location: logout');
                        exit();
                    } else {
                        echo "Les mots de passe ne correspondent pas !";
                    }
                } else {
                    echo "Le mot de passe est vide.";
                }
            }
            ?>
<title>Delta Plus | Entreprise Familiale Leader en Fabrication d'EPI</title>
<meta name="description" content="Découvrez Delta Plus, une entreprise familiale et leader dans la fabrication d'Équipements de Protection Individuelle (EPI). Forts de notre héritage, nous protégeons les travailleurs du monde entier avec des solutions innovantes et fiables.">

<?php include('header.php'); ?>
    <main>
        <section>
            <div class="entrepot">
                <h1>Mon Profil</h1>
                <img class="groupe" src="/images/entreprise.webp" alt="Vue aérienne du siège social de Delta Plus à Apt, montrant les bâtiments et les installations de l'entreprise leader en fabrication d'Équipements de Protection Individuelle (EPI).">
        </section>
        <section>
            <?php
                if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['photo'])) {
                    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                        // Chemin temporaire de l'photo uploadée
                        $tmpFilePath = $_FILES['photo']['tmp_name'];
                
                        // Charger l'image avec Imagick
                        try {
                            $imagick = new Imagick($tmpFilePath);
                
                            // Réduire la taille de l'image (par exemple, 800px max en largeur ou hauteur)
                            $maxWidth = 200;
                            $maxHeight = 200;
                            $imagick->resizeImage($maxWidth, $maxHeight, Imagick::FILTER_LANCZOS, 1, true);
                
                            // Réduire la qualité de l'image pour encore diminuer le poids (si JPEG ou PNG)
                            $imagick->setImageCompressionQuality(100);
                
                            // Convertir l'image en chaîne binaire
                            $imageData = $imagick->getImageBlob();
                
                            // Encoder en Base64
                            $base64Image = base64_encode($imageData);
                
                            // Obtenir le type MIME
                            $mimeType = $imagick->getImageMimeType();
                
                            // Générer une chaîne base64 complète avec le type MIME
                            $base64ImageString = "data:$mimeType;base64,$base64Image";
                
                            // Libérer les ressources
                            $imagick->clear();
                            $imagick->destroy();

                            
                            //UPDATE photoProfil dans inscription $base64ImageString 
                            $updateSQL = $db->prepare('UPDATE `inscription` SET  `photo` = :photo WHERE `inscription`.`id` = :id');
                            $updateSQL->execute([
                            'id' => $_SESSION['USER_ID'],
                            'photo' => $base64ImageString
                        ]);
                        } catch (Exception $e) {
                            echo "Erreur lors du traitement de l'image : " . $e->getMessage();
                        }
                    }
                }

                if (isset($_SESSION['LOGGED_USER'])) {
                    // Préparer la requête SQL pour récupérer 
                    $profilUsers = $db->prepare("SELECT nom, prenom, telephone, email, naissance, secteur, photo FROM inscription WHERE email = :adressemail");
                    $profilUsers->execute([
                        'adressemail' => $_SESSION['LOGGED_USER']
                    ]);
                    $user = $profilUsers->fetch();
                }
            echo '<h2>Ma photo de profil :</h2>';
            echo '<img src="' . $user['photo'] . '" alt="" />';
            ?>
        

        <form action="" method="POST" enctype="multipart/form-data" id="upload-form">
            <div class="upload-container">
                <label for="file-input" class="custom-file-label">
                    <span>📷 Modifier ma photo de profil</span>
                </label>
                <input type="file" id="file-input" name="photo" class="custom-file-input" accept=".jpeg, .png, .webp, .jpg">
            </div>
            <div>
                <input type="submit" name="chgPhoto" value="Modifier photo">
            </div>
            <script>
                // Sélectionne le champ de fichier
                // const fileInput = document.getElementById('file-input');

                // // Ajoute un événement lorsque le fichier est sélectionné
                // fileInput.addEventListener('change', () => {
                // const form = document.getElementById('upload-form'); // Sélectionne le formulaire

                // // Vérifie qu'un fichier est bien sélectionné
                // if (fileInput.files.length > 0) {
                //     console.log("Fichier sélectionné :", fileInput.files[0].name); // Pour debug
                //     form.submit(); // Soumet le formulaire
                // }
                // });

                // A CORRIGER / TESTER
            </script>
        </form>
        </section>
        <section>
            <h2>Mes coordonnées :</h2>
        <?php
        if (isset($_SESSION['LOGGED_USER'])) {
            if ($user) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chgProfil'])) {
                    if (!empty($_POST['nom'])) {
                        $nom = htmlspecialchars($_POST['nom']);
                    } else {
                        $erreur++;
                        echo '<div class="alert">Veuillez saisir un nom.</div>';
                    }

                    if (!isset($_POST['prenom'])) {
                        $erreur++;
                        echo '<div class="alert">Il y a un problème avec le prenom !</div>';
                    } elseif (empty($_POST['prenom'])) {
                        $erreur++;
                        echo '<div class="alert">Veuillez saisir le prenom !</div>';
                    } else {
                        $prenom = htmlspecialchars($_POST['prenom']);
                    }

                    if( !isset($_POST['telephone']) || empty($_POST['telephone']) ) {
                        $erreur++;
                        echo '<div class="alert">Il y a un problème avec le tel</div>';
                    } elseif (!preg_match('/^0[0-9]{9}$/', $_POST['telephone'])) { 
                        $erreur++;
                        echo '<div class="alert">Le numéro saisi ne ressemble pas a un numéro français à 10 chiffres.</div>';
                    } else {
                        $telephone = htmlspecialchars($_POST['telephone']);
                    }

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

                    if (!isset($_POST['secteur'])) {
                        $erreur++;
                        echo '<div class="alert">Il y a un problème avec le secteur !</div>';
                    } elseif (empty($_POST['secteur'])) {
                        $erreur++;
                        echo '<div class="alert">Veuillez saisir le prenom !</div>';
                    } else {
                        $secteur = htmlspecialchars($_POST['secteur']);
                    }
                }
            // Afficher les informations de l'utilisateur connecté
                echo '<form class="profil" action="" method="POST">';
                        echo '<div>';
                            echo '<div><label for="nom"><b>Nom : </b></label><input type="text" name="nom" value="' . htmlspecialchars($user['nom']) . '"></input></div>';
                            echo '<div><label for="prenom"><b>Prénom : </b></label><input type="text" name="prenom" value="'. htmlspecialchars($user['prenom']) . '"></input></div>';
                            echo '<div><label for="telephone"><b>Téléphone : </b></label><input type="text" name="telephone" value="' . htmlspecialchars($user['telephone']) . '"></input></div>';
                            echo '<div><label for="email"><b>Email : </b></label><input type="text" name="email" value="'. htmlspecialchars($user['email']) . '"></input></div>';
                        echo "</div>";
                        echo '<div>';
                            echo '<div><label for="naissance"><b>Date de naissance : </b></label><input type="date" name="naissance" value="'. htmlspecialchars($user['naissance']) . '"></input></div>';
                            echo '<div><label for="secteur"><b>Secteur : </b></label><select name="secteur"></div>';
                                echo '<option>' . htmlspecialchars($user['secteur']) . '</option>';
                                foreach ($listeservices as $a => $b) {
                                    echo '<option value="' . $a . '">' . $b . '</option>';
                                } 
                            echo "</select></div>";
                        echo "</div>";
                    echo '<div><input type="submit" name="chgProfil" value="Envoyer"></div>';
                echo '</form>';
            } else {
                echo "Erreur : Utilisateur introuvable.";
                exit;
            }
        } else {
            echo "Erreur : Vous devez être connecté pour accéder à cette page.";
            exit;
        }


        if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['chgProfil'])) {
            if ($erreur == 0) {
                    $updateSQL = $db->prepare('UPDATE `inscription` SET `nom` = :nom, `prenom` = :prenom, `telephone` = :telephone, `email` = :email, `naissance` = :naissance, `secteur` = :secteur WHERE `inscription`.`id` = :id');
                    $updateSQL->execute([
                        'id' => $_SESSION['USER_ID'],
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'telephone' => $telephone,
                        'email' => $email,
                        'naissance' => $naissance,
                        'secteur' => $secteur,
                    ]);
                    echo '<div id="messageenvoye" onclick="closeMessage()">
                        <span class="close-btn" onclick="closeMessage()">&times;</span>
                        <p>Mise à jour effectuée.</p>
                        </div>';
                    echo '<script>
                        function closeMessage() {
                        window.location.href = ""}
                        </script>';

            }
       }
        ?>  
        </section>
        <section>
            <h2>Mot de passe : </h2>
            <form action="" method="POST">
                <div>
                    <label for="">Nouveau mot de passe :</label>
                    <input type="password" name="pass1" required>
                </div>
                <div>
                    <label for="">Confirmation mot de passe :</label>
                    <input type="password"  name="pass2" required>
                </div>
                <div>
                    <label for=""></label>
                    <input type="submit" name="chgPWD" value="Valider">
                </div>
            </form>
        </section> 
    </main>
<?php include('footer.php'); ?>