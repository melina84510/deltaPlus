<?php include('config.php'); ?>
<?php include('head.php'); ?>

<title>Emplois au Service Accueil chez Delta Plus | Rejoignez notre Équipe d'Excellence</title>
<meta name="description" content="Découvrez les opportunités d'emploi au service accueil de Delta Plus, leader en fabrication d'Équipements de Protection Individuelle (EPI). Postulez pour faire partie d'une équipe dédiée à offrir un service client exceptionnel.">

<body>
<?php include('header.php'); ?>
<main>
    <section>
        <div class="entrepot">
            <h1>
                Accueil
            </h1>
            <img class="groupe" src="images/entreprise.webp" alt="Vue aérienne du siège social de Delta Plus à Apt, montrant les bâtiments et les installations de l'entreprise leader en fabrication d'Équipements de Protection Individuelle (EPI).">
        </div>
    </section>
    <section>
        <h2>
            Vous souhaitez découvrir les métiers de l'Accueil chez Delta Plus? Vous êtes au bon endroit.
        </h2>
        <?php include('listesservices.php'); ?>
    </section>
    <section class="mark">
        <div>
            <img src="images/enjoysafety2.webp" alt="slogan de Delta Plus entreprise d'EPI en france">
        </div>
        <div>
            <figure>
                <figcaption><a href="fiches.php?fiche=assistanteadmin">Assistante Administrative Polyvalente</a></figcaption>
                <img src="images/assistantcom.webp" alt="Assistant communication travaillant sur des supports de communication, organisant des événements ou rédigeant des contenus pour promouvoir les activités de l'entreprise.">
            </figure>
            <figure>
                <figcaption><a href="fiches.php?fiche=hotesseaccueil">Hôtesse d'Accueil</a></figcaption>
                <img src="images/graphiste.webp" alt="Graphiste travaillant sur un design créatif à l'ordinateur, utilisant des outils de conception graphique pour créer des visuels attractifs et professionnels.">
            </figure>
        </div>
    </section>
</main>
<?php include('footer.php'); ?>