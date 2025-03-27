<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/config.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/head.php';
// Vérifier si une session est déjà active
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
            <a href="inbox">Messages reçus</a>
            <a href="">Messages supprimés</a>
        </div>
    </section>

    <?php
                    $Affichemess = $db->prepare('SELECT * FROM `messages` WHERE idcandidat = :idcandidat');
                    $Affichemess->execute([
                        'idcandidat' => $_SESSION['USER_ID'],
                    ]);
                    $Listemess = $Affichemess->FetchAll();

                    if (!empty($Listemess)) {
                        echo "<table border='1'>";
                        echo "<tr><th>User</th><th>Message</th><th>Date</th></tr>";
                        
                        foreach ($Listemess as $mess) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($mess['user']) . "</td>";
                            echo "<td>" . htmlspecialchars($mess['message']) . "</td>";
                            echo "<td>" . htmlspecialchars($mess['date']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }  
                        
                        ?>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/footer.php'; ?>
     

    