<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; ?>
<?php

// Récupérer les 4 dernières offres
$query = $db->prepare("SELECT * FROM offres ORDER BY id DESC LIMIT 6");
$query->execute();
$offres = $query->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="carousel">
    <div class="carousel-container">
        <?php if (count($offres) > 0): ?>
            <?php foreach ($offres as $index => $offre): ?>
                <div class="carousel-item">
                        <h2>Poste : <?php echo htmlspecialchars($offre['nom']); ?></h2>
                        <h3>Service : <?php echo htmlspecialchars($offre['services']); ?></h3>
                        <p><strong>Type :</strong> <?php echo htmlspecialchars($offre['type']); ?></p>
                        <p><strong>Lieu :</strong> <?php echo htmlspecialchars($offre['lieu']); ?></p>
                        <p><strong>Expérience :</strong> <?php echo htmlspecialchars($offre['experience']); ?></p>
                        <p><strong>Référence :</strong> <?php echo htmlspecialchars($offre['ref']); ?></p>
                        <p><strong>Description :</strong> <?php echo htmlspecialchars(substr($offre['descrip'], 0, 150)); ?>...</p>
                        <p><strong>Mission :</strong> <?php echo htmlspecialchars(substr($offre['mission'], 0, 150)); ?>...</p>
                        <p><strong>Profil :</strong> <?php echo htmlspecialchars(substr($offre['profil'], 0, 150)); ?>...</p>
                        <button class="btn-view-more" onclick="openPopupoffre('<?php echo htmlspecialchars($offre['ref']); ?>')">Voir plus</button>
                    </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div id="popupoffre" class="popupoffre" onclick="closePopupoffre()"></div>
    <button class="carousel-nav prev">&lt;</button>
    <button class="carousel-nav next">&gt;</button>
</div>
<script>
    function openPopupoffre(ref) {
        var xhr = new XMLHttpRequest();

        xhr.open("GET", `/offres/detail_offre.php?ref=${ref}`);

        // Configurer la réponse en cas de succès
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Insérer les données reçues dans l'élément #popupoffre
                document.getElementById("popupoffre").innerHTML = xhr.responseText;
            } else {
                console.error("Erreur lors du chargement des détails : " + xhr.statusText);
            }
        };

        // Envoyer la requête
        xhr.send();

        // Display the popup
        document.getElementById("popupoffre").style.display = "block";
        console.warn("Ouverture.");
    }

    function closePopupoffre() {
        // Cache le popup en changeant le style
        document.getElementById("popupoffre").style.display = "none";

        // Vide la source de l'iframe (optionnel pour éviter les rechargements inutiles)
        // document.getElementById("popup-iframe").src = "";
        console.warn("Fermeture.");
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.carousel-item');
    const prevButton = document.querySelector('.carousel-nav.prev');
    const nextButton = document.querySelector('.carousel-nav.next');
    const container = document.querySelector('.carousel-container');
    const itemsPerSlide = 2; // Nombre d'annonces visibles par ligne
    const totalItems = items.length;
    const totalSlides = Math.ceil(totalItems / itemsPerSlide);
    let currentSlide = 0;

    const updateCarousel = () => {
        const offset = -currentSlide * 100; // Calcul de la position en %
        container.style.transform = `translateX(${offset}%)`;
    };

    prevButton.addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateCarousel();
    });

    nextButton.addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
    });

    updateCarousel(); // Initialisation
});
</script>



