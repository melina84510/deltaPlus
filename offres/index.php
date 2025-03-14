<?php include $_SERVER['DOCUMENT_ROOT'] . '/config.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/head.php'; ?>

<title>Offres d'Emploi chez Delta Plus | Rejoignez notre Leader en EPI</title>
<meta name="description" content="Découvrez les offres d'emploi actuelles chez Delta Plus, leader dans la fabrication d'Équipements de Protection Individuelle (EPI). Postulez dès maintenant pour rejoindre une entreprise familiale innovante et dynamique.">

<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/header.php'; ?>
    <main>
        <section>
            <div class="entrepot">
                <h1>Nos offres d'emploi</h1>
                <img class="groupe" src="/images/offres.webp" alt="Des hommes habillaient avec des EPI de chez delta plus">
            </div>
            <div>
                <h2>
                    Vous souhaitez prendre part à l'aventure Delta Plus ?
                    Vous souhaitez contribuer à la protection de millions de travailleurs dans le monde ?
                    Jetez un œil à nos offres d'emploi.
                </h2>
            </div>
            <div class="case">
                <div>
                    <a href="/metiers">Nos métiers</a>
                </div>
                <div>
                    <a href="/offres">Nos offres emploi</a>
                </div>
                <div>
                    <a href="/pages/nouscontacter">Candidature spontanée</a>
                </div>
            </div>
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/offres/listeservices.php'); ?>

                <?php
                if (isset($_SESSION['LOGGED_USER'])){
                    echo '<p><a href="formulaire?action=ajout">Ajouter une annonce</a></p>';
                }
                ?>
        </section>
        <section>
            <script src="/js/AfficherPlus.js"></script>
                <?php
                    $AfficheOffres = $db->prepare('SELECT * FROM `offres` WHERE `services` LIKE :nomservice');
                    $AfficheOffres->execute([
                        'nomservice' => $service
                    ]);
                    $ListeOffres = $AfficheOffres->FetchAll();

                    foreach ($ListeOffres as $a) {
                        echo "<article>";
                            echo "<h3>" . $a['services'] . "</h3>";
                            if ( isset($_SESSION['LOGGED_USER']) ) {
                                echo '<svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"><path d="M17.5.917a6.4,6.4,0,0,0-5.5,3.3A6.4,6.4,0,0,0,6.5.917,6.8,6.8,0,0,0,0,7.967c0,6.775,10.956,14.6,11.422,14.932l.578.409.578-.409C13.044,22.569,24,14.742,24,7.967A6.8,6.8,0,0,0,17.5.917Z"/></svg>';
                            } 
                            echo "<h3>" . $a['nom'] . "</h3>";
                            echo '<div>';
                                echo "<p>Offre : " . $a['type'] . "</p>";
                                echo "<p>Lieu : " . $a['lieu'] . "</p>";
                                echo "<p>Expérience exigée : " . $a['experience'] . "</p>";
                                echo '<p>Réf de l\'annonce : ' . $a['ref'] . "</p>";
                            echo '</div>';
                            echo '<h4 class="cacher" data-group="' . $a['id'] . "\">Description :</h4>";
                            echo '<p class="cacher" data-group="' . $a['id'] . '">' . $a['descrip'] . "</p>";
                            echo '<h4 class="cacher" data-group="' . $a['id'] . "\">Mission :</h4>";
                            echo '<p class="cacher" data-group="' . $a['id'] . '">' . $a['mission'] . "</p>";
                            echo '<h4 class="cacher" data-group="' . $a['id'] . "\">Profil :</h4>";
                            echo '<p class="cacher" data-group="' . $a['id'] . '">' . $a['profil'] . "</p>";
                            echo '<p class="cacher" data-group="' . $a['id'] . '">' . '<a href="/pages/nouscontacter?offre=' . $a['id'] . '">POSTULER</a></p>';
                            echo '<p><a href="javascript:;" data-group="' . $a['id'] . '" onclick="AfficherPlus(this)">Plus d\'infos</a></p>';
                            if (isset($_SESSION['LOGGED_USER'])){
                            echo '<p><a href="formulaire?action=suppr&id=' . $a['id'] . '">Supprimer l\'annonce ' . $a['id'] . '</a></p>';
                            echo '<p><a href="formulaire?action=modif&id=' . $a['id'] . '">Modifier l\'annonce ' . $a['id'] . '</a></p>';
                        }
                        echo "</article>"; 
                    }
                ?>
        </section>
        <section>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/images.php'; ?>
            <img class="groupe" src="/images/offres.webp" alt="Des hommes habillaient avec des EPI de chez delta plus">
        </section>
    </main>
</body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/footer.php'; ?>