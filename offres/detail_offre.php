<?php include $_SERVER['DOCUMENT_ROOT'] . '/config.php'; ?>

<?php
if (isset($_GET['ref'])) {
    $ref = $_GET['ref'];

    // Préparer la requête pour récupérer l'offre en fonction de la référence
    $stmt = $db->prepare("SELECT * FROM offres WHERE ref = :ref");
    $stmt->execute(['ref' => $ref]);

    // Récupérer une seule offre (avec fetch)
    $offres = $stmt->fetch();

    // Vérifier si l'offre existe
    if ($offres) {
        // Afficher les détails de l'offre
        echo "<article>";
        echo "<h3>" . htmlspecialchars($offres['services']) . "</h3>";
        echo "<h3>" . htmlspecialchars($offres['nom']) . "</h3>";
        echo '<div>';
        echo "<p>Offre : " . htmlspecialchars($offres['type']) . "</p>";
        echo "<p>Lieu : " . htmlspecialchars($offres['lieu']) . "</p>";
        echo "<p>Expérience exigée : " . htmlspecialchars($offres['experience']) . "</p>";
        echo '<p>Réf de l\'annonce : ' . htmlspecialchars($offres['ref']) . "</p>";
        echo '</div>';
        echo '<h4>Description :</h4>';
        echo '<p>' . htmlspecialchars($offres['descrip']) . "</p>";
        echo '<h4>Mission :</h4>';
        echo '<p>' . htmlspecialchars($offres['mission']) . "</p>";
        echo '<h4>Profil :</h4>';
        echo '<p>' . htmlspecialchars($offres['profil']) . "</p>";
        echo '<p>' . '<a href="/pages/nouscontacter?offre=' . htmlspecialchars($offres['id']) . '">POSTULER</a></p>';

        // Vérifier si l'utilisateur est connecté pour afficher les options de modification/suppression
        if (isset($_SESSION['LOGGED_USER'])){
            echo '<p><a href="/offres/formulaire?action=suppr&id=' . htmlspecialchars($offres['id']) . '">Supprimer l\'annonce ' . htmlspecialchars($offres['id']) . '</a></p>';
            echo '<p><a href="/offres/formulaire?action=modif&id=' . htmlspecialchars($offres['id']) . '">Modifier l\'annonce ' . htmlspecialchars($offres['id']) . '</a></p>';
        }

        echo "</article>";
    } else {
        // Si aucune offre n'a été trouvée pour cette référence
        echo "<p>Annonce introuvable.</p>";
    }
} else {
    echo "<p>Aucune annonce sélectionnée.</p>";
}
?>