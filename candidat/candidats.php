<?php include $_SERVER['DOCUMENT_ROOT'] . '/config.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/head.php'; ?>

<title>Candidats spontannés et postuler pour des offres emplois delta plus</title>
<meta name="description" content="retrouver toutes les offres d'emplois concernant l'entreprise Delta Plus">

<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/header.php'; ?>
    <main>
        <section>
            <div class="entrepot">
                <h1>Nos candidatures</h1>
                <img class="groupe" src="/images/offres.webp" alt="Des hommes habillaient avec des EPI de chez delta plus">
            </div>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/offres/listeservices.php'; ?>
        </section>
        <section>
            <?php
                if ($service == '%') {
                    $AfficheCandidat = $db->prepare('
                    SELECT c.nom, c.prenom, c.telephone, c.mail, c.message, o.nom, o.services, c.cv, c.lettremotiv
                    FROM candidat c
                    LEFT JOIN offres o ON c.idoffre = o.id;');
                    $AfficheCandidat->execute([]);
                } elseif ($service == "spontannee") {
                    $AfficheCandidat = $db->prepare('
                    SELECT c.nom, c.prenom, c.telephone, c.mail, c.message, o.nom, o.services, c.cv, c.lettremotiv
                    FROM candidat c
                    LEFT JOIN offres o ON c.idoffre = o.id
                    WHERE c.idoffre IS NULL');
                    $AfficheCandidat->execute([]);
                } else {
                    $AfficheCandidat = $db->prepare('
                    SELECT c.nom, c.prenom, c.telephone, c.mail, c.message, o.nom, o.services, c.cv, c.lettremotiv
                    FROM candidat c
                    INNER JOIN offres o ON c.idoffre = o.id
                    WHERE o.services LIKE :service;');
                    $AfficheCandidat->execute([
                        'service' => $service
                    ]);

                    // $AfficheCandidat = $db->query("
                    // SELECT c.nom, c.prenom, c.telephone, c.mail, c.message, o.nom, o.services, c.cv, c.lettremotiv
                    // FROM candidat c
                    // INNER JOIN offres o ON c.idoffre = o.id
                    // WHERE o.services LIKE '$service';
                    // ");
                }
                
                
                $ListeCandidat = $AfficheCandidat->FetchAll();

                foreach ($ListeCandidat as $a) {
                    echo "<article>";
                        echo "<h3>Nom : " . $a[0] . "</h3>";
                        echo "<h3>Prénom : " . $a['prenom'] . "</h3>";
                        echo "<p>Téléphone : " . $a['telephone'] . "</p>";
                        echo "<p>Mail :" . $a['mail'] . "</p>";
                        echo "<p>Message : " . $a['message'] . "</p>";
                        echo "<p>Poste et service : " . $a[5] . " dans la catégorie " . $a['services'] . "</p>";
                        echo '<p><a href="' . $a['cv'] . '" target="_blank">Le CV</a></p>';
                        echo '<p><a href="' . $a['lettremotiv'] . '" target="_blank">La lettre de motivation</a></p>';
                    echo "</article>"; 
                }
            ?>
        </section>
    </main>
</body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/footer.php'; ?>