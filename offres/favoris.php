<?php include $_SERVER['DOCUMENT_ROOT'] . '/config.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/head.php'; ?>

<title>Delta Plus | Entreprise Familiale Leader en Fabrication d'EPI</title>
<meta name="description" content="Découvrez Delta Plus, une entreprise familiale et leader dans la fabrication d'Équipements de Protection Individuelle (EPI). Forts de notre héritage, nous protégeons les travailleurs du monde entier avec des solutions innovantes et fiables.">

<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/header.php'; ?>
    <main>
        <section>
            <div class="entrepot">
                    <h1>
                        Mes annonces
                    </h1>
                    <img class="groupe" src="/images/entreprise1.webp" alt="Vue aérienne du siège social de Delta Plus à Apt, montrant les bâtiments et les installations de l'entreprise leader en fabrication d'Équipements de Protection Individuelle (EPI).">
                </div>
        </section>
        <section>
        <?php 
        if (isset($_SESSION['LOGGED_USER'])) {
            // Préparer la requête SQL pour récupérer l'idofavoris
            $RecupUsers = $db->prepare('SELECT idofavoris FROM `inscription` WHERE email = :adressemail');
            $RecupUsers->execute([
                'adressemail' => $_SESSION['LOGGED_USER']
            ]);
            $retoursql = $RecupUsers->fetch();
            //json_encode($array);
            if (empty($retoursql['idofavoris'])) {
                $listeOffresFavorites = NULL;
            } else {
                $listeOffresFavorites = json_decode($retoursql['idofavoris'], true); //récupérer des données au format JSON dans la BDD //true avec json pour récupérer un tableau array
            }
            
        } else {
            // header
            exit();
        }
        ?>
        </section>
        <section>
            <script src="/js/AfficherPlus.js"></script>
                <?php
                if ($listeOffresFavorites === NULL) {
                    echo "<p>Aucunes offres favorites</p>";
                } else {
                    foreach ($listeOffresFavorites as $idoffre) {
                        $AfficheOffre = $db->prepare('SELECT * FROM `offres` WHERE `id` LIKE :idoffre');
                        $AfficheOffre->execute([
                            'idoffre' => $idoffre
                        ]);
                        $offre = $AfficheOffre->fetch();
                        echo "<article>";
                            echo "<h3>" . $offre['services'] . "</h3>";
                            echo "<h3>" . $offre['nom'] . "</h3>";
                            echo '<div>';
                                echo "<p>Offre : " . $offre['type'] . "</p>";
                                echo "<p>Lieu : " . $offre['lieu'] . "</p>";
                                echo "<p>Expérience exigée : " . $offre['experience'] . "</p>";
                                echo '<p>Réf de l\'annonce : ' . $offre['ref'] . "</p>";
                            echo '</div>';
                            echo '<h4 class="cacher" data-group="' . $offre['id'] . "\">Description :</h4>";
                            echo '<p class="cacher" data-group="' . $offre['id'] . '">' . $offre['descrip'] . "</p>";
                            echo '<h4 class="cacher" data-group="' . $offre['id'] . "\">Mission :</h4>";
                            echo '<p class="cacher" data-group="' . $offre['id'] . '">' . $offre['mission'] . "</p>";
                            echo '<h4 class="cacher" data-group="' . $offre['id'] . "\">Profil :</h4>";
                            echo '<p class="cacher" data-group="' . $offre['id'] . '">' . $offre['profil'] . "</p>";
                            echo '<p class="cacher" data-group="' . $offre['id'] . '">' . '<a href="/nouscontacter?offre=' . $offre['id'] . '">POSTULER</a></p>';
                            echo '<p><a href="javascript:;" data-group="' . $offre['id'] . '" onclick="AfficherPlus(this)">Plus d\'infos</a></p>';
                            if (isset($_SESSION['LOGGED_USER'])){
                            echo '<p><a href="/formulaire?action=suppr&id=' . $offre['id'] . '">Supprimer l\'annonce ' . $offre['id'] . '</a></p>';
                            echo '<p><a href="/formulaire?action=modif&id=' . $offre['id'] . '">Modifier l\'annonce ' . $offre['id'] . '</a></p>';
                        }
                        echo "</article>"; 
                    }
                }
                ?>
        </section>
    </main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/footer.php'; ?>