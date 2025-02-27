<?php include('config.php'); ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?>

<?php $erreur=0; ?>
<main>
    <section>
        <div class="entrepot">
            <h1>Nos offres d'emploi Administrateur</h1>
            <img class="groupe" src="images/offres.webp" alt="Des hommes habillaient avec des EPI de chez delta plus">
        </div>
    </section>
    <section class="sform">
        <?php 
            if (isset($_GET['action']) && $_GET['action'] == "suppr") {
                // echo "MODE SUPPRESION ! de l'annonce " . $_GET['id'];
                // // 
                // // DELETE FROM offres WHERE `offres`.`id` = 3
                if (isset($_GET['id']) || !empty($_GET['id'])) {
                    $supSQL = $db->prepare('DELETE FROM offres WHERE `offres`.`id` = :id');
                    $supSQL->execute([
                        'id' => $_GET['id']
                    ]);
                    echo '<p class="alert">Suppression effectuée</p>';
                }
            } else {
        //MODE MODIF et si $_GET['id']
                //Requete SQL pour récupérer les données de toute la ligne de cet ID 
                // SELECT * FROM `offres` WHERE id = :id;
                if (isset($_GET['action']) && $_GET['action'] == "modif") {
                    if (isset($_GET['id']) || !empty($_GET['id'])) {
                        $AfficheOffre = $db->prepare('SELECT * FROM `offres` WHERE id = :id');
                        $AfficheOffre->execute([
                            'id' => $_GET['id']
                        ]);
                        $ListeOffre = $AfficheOffre->FetchAll();
                        $remplir=true;

                        // foreach ($ListeOffre as $a) {
                        //     echo "<article>";
                        //     echo "<h3>" . $a['nom'] . "</h3>";
                        //     echo "<p>Offre : " . $a['type'] . "</p>";
                        //     echo "<p>Lieu : " . $a['lieu'] . "</p>";
                        //     echo "<p>Expérience exigée : " . $a['experience'] . "</p>";
                        //     echo "<p>Réf de l'annonce : " . $a['ref'] . "</p>";
                        //     echo "<h4>Description :</h4>";
                        //     echo "<p>" . $a['descrip'] . "</p>";
                        //     echo "<h4>Mission :</h4>";
                        //     echo "<p>" . $a['mission'] . "</p>";
                        //     echo "<h4>Profil :</h4>";
                        //     echo "<p>" . $a['profil'] . "</p>";
                        //     echo '<a href="/formulaire?action=modif&id=' . $a['id'] . '">Modifier l\'annonce ' . $a['id'] . '</a>';
                        //     echo "</article>";
                        // }
                    } else {
                        $_GET['action'] = "ajout";
                    }
                }
                // print_r($ListeOffre);
        ?>
        <form action="" method="post">
        
            <div class="partie1">
                <div>
                    <label for="services">Service :</label>
                    <select id="services" name="services" required>
                        <?php// if (isset($remplir)) { echo <option>$ListeOffre['0']['services'];} ?>
                        <option value="Accueil">Accueil</option>
                        <option value="Financier">Financier</option>
                        <option value="Ressource Humaine">Ressource Humaine</option>
                        <option value="Informatique">Informatique</option>
                        <option value="Logistique">Logistique</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Achats">Achats</option>
                        <option value="Produits">Produits</option>
                        <option value="Services généraux">Services généraux</option>
                    </select> 

                    <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if (!isset($_POST['services'])) {
                            $erreur++;
                            echo '<p class="alert">Il y a un problème avec le Service !</p>';
                        } elseif (empty($_POST['services'])) {
                            $erreur++;
                            echo '<p class="alert">Veuillez sélectionner le service correspondant !</p>';
                        } else {
                            $services = htmlspecialchars($_POST['services']);
                        }
                    }
                ?>  
                </div>
                <div>
                    <label for="nom">Titre de l'offre :</label>
                    <input type="text" name="nom" placeholder="" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-" title="Il y a un problème avec le titre de l'offre !" value="<?php if (isset($remplir)) { echo $ListeOffre['0']['nom'];} ?>" required>
                    <?php
                        if ($_SERVER['REQUEST_METHOD']=='POST') {
                            if (!isset($_POST['nom'])) {
                                $erreur++;
                                echo '<p class="alert">Il y a un problème avec le titre de l offre !</p>';
                            } elseif (empty($_POST['nom'])) {
                                $erreur++;
                                echo '<p class="alert">Veuillez saisir le titre de l offre correctement !</p>';
                            } else {
                                $nom = htmlspecialchars($_POST['nom']);
                            }
                        }
                    ?>
                </div>
                <div>
                    <label for="type">Offre :</label>
                    <select id="type" name="type" required>
                        <?php// if (isset($remplir)) { echo <option>$ListeOffre['0']['nom'];} ?>
                        <option value="CDI">CDI</option>
                        <option value="CDD">CDD</option>
                    </select>
                
                
                <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if (!isset($_POST['type'])) {
                            $erreur++;
                            echo '<p class="alert">Il y a un problème avec le type de contrat  !</p>';
                        } elseif (empty($_POST['type'])) {
                            $erreur++;
                            echo '<p class="alert">Veuillez saisir le type de contrat  !</p>';
                        } else {
                            $type = htmlspecialchars($_POST['type']);
                        }
                    }
                ?>
                </div>
                <div>
                    <label for="lieu">Lieu :</label>
                    <input type="text" name="lieu" placeholder="" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-" title="Il y a un problème avec le lieu de l'offre !" value="<?php if (isset($remplir)) { echo $ListeOffre['0']['lieu'];} ?>" required>
                
                
                <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if (!isset($_POST['lieu'])) {
                            $erreur++;
                            echo '<p class="alert">Il y a un problème avec le lieu de l offre !</p>';
                        } elseif (empty($_POST['lieu'])) {
                            $erreur++;
                            echo '<p class="alert">Veuillez saisir le lieu de l offre !</p>';
                        } else {
                            $lieu = htmlspecialchars($_POST['lieu']);
                        }
                    }
                ?>
                </div>
                <div>
                    <label for="experience">Expérience exigée :</label>
                    <select id="experience" name="experience" required>
                
                
                <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if (!isset($_POST['experience'])) {
                            $erreur++;
                            echo '<p class="alert">Il y a un problème avec l expérience !</p>';
                        } elseif (empty($_POST['experience'])) {
                            $erreur++;
                            echo '<p class="alert">Veuillez saisir l expérience !</p>';
                        } else {
                            $experience = htmlspecialchars($_POST['experience']);
                        }
                    }

                    for ($compteur = 1; $compteur <= 10; $compteur++) {
                        echo '<option value="' . $compteur . '">' . $compteur . ' an' . ($compteur > 1 ? 's' : '') . '</option>';
                    }
                    
                ?>
                </select>
                </div>
                <div>
                    <label for="ref">Référence de l'annonce :</label>
                    <input type="text" name="ref" placeholder="" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-" title="Il y a un problème avec la référence de l'annnonce !" value="<?php if (isset($remplir)) { echo $ListeOffre['0']['ref'];} ?>" required>

                <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if (!isset($_POST['ref'])) {
                            $erreur++;
                            echo '<p class="alert">Il y a un problème avec la référence de l annonce  !</p>';
                        } elseif (empty($_POST['ref'])) {
                            $erreur++;
                            echo '<p class="alert">Veuillez saisir la référence de l annonce  !</p>';
                        } else {
                            $ref = htmlspecialchars($_POST['ref']);
                        }
                    }
                ?>
                </div>
            </div>
            <div class="partie2">
                <div>
                    <label for="descrip">Description du poste :</label>
                    <textarea type="text" name="descrip" placeholder="" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz.,;:!?-" title="Il y a un problème avec la description du poste !" required><?php if (isset($remplir)) { echo $ListeOffre['0']['descrip'];} ?></textarea>
                
                
                <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if (!isset($_POST['descrip'])) {
                            $erreur++;
                            echo '<p class="alert">Il y a un problème avec la description du poste !</p>';
                        } elseif (empty($_POST['descrip'])) {
                            $erreur++;
                            echo '<p class="alert">Veuillez saisir la description du poste !</p>';
                        } else {
                            $descrip  = htmlspecialchars($_POST['descrip']);
                        }
                    }
                ?>
                </div>
                <div>
                    <label for="mission"> Les missions du poste :</label>
                    <textarea type="text" name="mission" placeholder="" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz.,;:!?-" title="Il y a un problème avec le nom & Prénom !" required><?php if (isset($remplir)) { echo $ListeOffre['0']['mission'];} ?></textarea>
                
                
                <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if (!isset($_POST['mission'])) {
                            $erreur++;
                            echo '<p class="alert">Il y a un problème avec les missions du poste !</p>';
                        } elseif (empty($_POST['mission'])) {
                            $erreur++;
                            echo '<p class="alert">Veuillez saisir les missions !</p>';
                        } else {
                            $mission = htmlspecialchars($_POST['mission']);
                        }
                    }
                ?>
                </div>
                <div>
                    <label for="profil"> Le profil recherché :</label>
                    <textarea type="text" name="profil" placeholder="" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz.,;:!?-" title="Il y a un problème avec le profil !" required><?php if (isset($remplir)) { echo $ListeOffre['0']['profil'];} ?></textarea>
                
                
                <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if (!isset($_POST['profil'])) {
                            $erreur++;
                            echo '<p class="alert">Il y a un problème avec le profil !</p>';
                        } elseif (empty($_POST['profil'])) {
                            $erreur++;
                            echo '<p class="alert">Veuillez saisir le profil recherché !</p>';
                        } else {
                            $profil = htmlspecialchars($_POST['profil']);
                        }
                    }
                ?>
                </div>
            </div>
            <div>
                <input type="submit" value="Envoyer">
                <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if ($erreur == 0) {
                            if ($_GET['action'] == 'modif') {
                                $updateSQL = $db->prepare('UPDATE `offres` SET `services` = :services, `nom` = :nom, `type` = :type, `lieu` = :lieu, `experience` = :experience, `ref` = :ref, `descrip` = :descrip, `mission` = :mission, `profil` = :profil WHERE `offres`.`id` = :id');
                                $updateSQL->execute([
                                    'id' => $_GET['id'],
                                    'services' => $services,
                                    'nom' => $nom,
                                    'type' => $type,
                                    'lieu' => $lieu,
                                    'experience' => $experience,
                                    'ref' => $ref,
                                    'descrip' => $descrip,
                                    'mission' => $mission,
                                    'profil' => $profil
                                ]);
                                echo '<div id="messageenvoye" onclick="closeMessage()">
                                    <span class="close-btn" onclick="closeMessage()">&times;</span>
                                    <p>Mise à jour effectuée.</p>
                                </div>';
                                echo '<script>
                                    function closeMessage() {
                                        window.location.href = "?action=modif&id=' . $_GET['id'] . '";
                                    }
                                </script>';
                            } else {
                                $insertSQL = $db->prepare('INSERT INTO `offres` (`id`, `services`, `nom`, `type`, `lieu`, `experience`, `ref`, `descrip`, `mission`, `profil`) VALUES (NULL, :services, :nom, :type, :lieu, :experience, :ref, :descrip, :mission, :profil)');
                                $insertSQL->execute([
                                    'services' => $services,
                                    'nom' => $nom,
                                    'type' => $type,
                                    'lieu' => $lieu,
                                    'experience' => $experience,
                                    'ref' => $ref,
                                    'descrip' => $descrip,
                                    'mission' => $mission,
                                    'profil' => $profil
                                ]);
                            }
                            
                        }
                    }
                ?>
            </div>
            </form>
            <?php } //Fermeture du else $_GET['action'] == 'suppr' ?>
    </main>
        </section>
<?php include('footer.php'); ?>