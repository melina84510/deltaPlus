<?php include $_SERVER['DOCUMENT_ROOT'] . '/config.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/head.php'; ?>

<title>Delta Plus | Entreprise Familiale Leader en Fabrication d'EPI</title>
<meta name="description" content="Découvrez Delta Plus, une entreprise familiale et leader dans la fabrication d'Équipements de Protection Individuelle (EPI). Forts de notre héritage, nous protégeons les travailleurs du monde entier avec des solutions innovantes et fiables.">

<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/header.php'; ?>

<?php
// Définir le chemin de stockage des fichiers téléchargés
$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
$error_message = ''; // Variable pour stocker les messages d'erreur
$success_message = ''; // Variable pour stocker le message de succès

// Définir les extensions autorisées
$allowed_extensions = ['pdf', 'doc', 'docx']; // <-- Définir les extensions ici

// Traitement du formulaire lors de l'envoi des fichiers
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier si les fichiers sont téléchargés
    if (isset($_FILES['cv']) || isset($_FILES['lettre'])) {
        // Vérification du CV
        if (isset($_FILES['cv'])) {
            $cv = $_FILES['cv'];
            $cv_ext = pathinfo($cv['name'], PATHINFO_EXTENSION);

            // Vérifier l'extension du fichier
            if (!in_array($cv_ext, $allowed_extensions)) {
                $error_message .= "Le CV doit être au format PDF, DOC ou DOCX. <br>";
            }

            // Vérifier si le fichier est trop gros (5 Mo max)
            if ($cv['size'] > 5 * 1024 * 1024) {
                $error_message .= "Le fichier du CV est trop volumineux. La taille maximale est de 5 Mo. <br>";
            }

            // Si tout va bien, on déplace le fichier
            if (empty($error_message)) {
                // Générer un nom unique pour le fichier
                $cv_name = uniqid('cv_', true) . '.' . $cv_ext;

                // Déplacer le fichier téléchargé dans le dossier 'uploads'
                if (move_uploaded_file($cv['tmp_name'], $upload_dir . $cv_name)) {
                    // Supprimer l'ancien fichier du dossier si il existe
                    if (!empty($user_documents['cv']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $user_documents['cv'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . $user_documents['cv']);
                    }

                    // Mettre à jour la base de données
                    $update_query = $db->prepare("UPDATE inscription SET cv = :cv_path WHERE id = :id");
                    $update_query->execute([
                        ':cv_path' => '/uploads/' . $cv_name,
                        ':id' => $_SESSION['USER_ID']
                    ]);
                    $success_message = "Le CV a été mis à jour avec succès.";
                } else {
                    $error_message .= "Une erreur s'est produite lors du téléchargement du CV. <br>";
                }
            }
        }

        // Vérification de la lettre de motivation
        if (isset($_FILES['lettre'])) {
            $lettre = $_FILES['lettre'];
            $lettre_ext = pathinfo($lettre['name'], PATHINFO_EXTENSION);

            // Vérifier l'extension du fichier
            if (!in_array($lettre_ext, $allowed_extensions)) {
                $error_message .= "La lettre de motivation doit être au format PDF, DOC ou DOCX. <br>";
            }

            // Vérifier si le fichier est trop gros (5 Mo max)
            if ($lettre['size'] > 5 * 1024 * 1024) {
                $error_message .= "Le fichier de la lettre de motivation est trop volumineux. La taille maximale est de 5 Mo. <br>";
            }

            // Si tout va bien, on déplace le fichier
            if (empty($error_message)) {
                // Générer un nom unique pour le fichier
                $lettre_name = uniqid('lettre_', true) . '.' . $lettre_ext;

                // Déplacer le fichier téléchargé dans le dossier 'uploads'
                if (move_uploaded_file($lettre['tmp_name'], $upload_dir . $lettre_name)) {
                    // Supprimer l'ancien fichier du dossier si il existe
                    if (!empty($user_documents['lettre']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $user_documents['lettre'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . $user_documents['lettre']);
                    }

                    // Mettre à jour la base de données
                    $update_query = $db->prepare("UPDATE inscription SET lettre = :lettre_path WHERE id = :id");
                    $update_query->execute([
                        ':lettre_path' => '/uploads/' . $lettre_name,
                        ':id' => $_SESSION['USER_ID']
                    ]);
                    $success_message = "La lettre de motivation a été mise à jour avec succès.";
                } else {
                    $error_message .= "Une erreur s'est produite lors du téléchargement de la lettre de motivation. <br>";
                }
            }
        }
    } else {
        $error_message = "Veuillez télécharger à la fois un CV et une lettre de motivation. <br>";
    }
}

// Récupérer le chemin des fichiers actuels de l'utilisateur
$user_id = $_SESSION['USER_ID'];
$get_documents = $db->prepare("SELECT cv, lettre FROM inscription WHERE id = :id");
$get_documents->execute(['id' => $user_id]);
$user_documents = $get_documents->fetch();
?>

<main>
    <section>
        <div class="entrepot">
            <h1>Mes documents</h1>
            <img class="groupe" src="/images/entreprise1.webp" alt="Vue aérienne du siège social de Delta Plus à Apt, montrant les bâtiments et les installations de l'entreprise leader en fabrication d'Équipements de Protection Individuelle (EPI).">
        </div>
    </section>

    <section>
        <h2>Affichage de votre CV en PDF</h2>
        <?php if ($user_documents['cv']) : ?>
            <iframe src="<?php echo $user_documents['cv']; ?>" width="90%" height="600px"></iframe>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="cv" accept=".pdf, .doc, .docx">
                <input type="submit" value="Modifier le CV">
            </form>
        <?php else : ?>
            <p>Aucun CV téléchargé. <a href="upload_cv_form.php">Téléchargez votre CV ici.</a></p>
        <?php endif; ?>
    </section>

    <section>
        <h2>Affichage de votre Lettre de motivation en PDF</h2>
        <?php if ($user_documents['lettre']) : ?>
            <iframe src="<?php echo $user_documents['lettre']; ?>" width="90%" height="600px"></iframe>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="lettre" accept=".pdf, .doc, .docx">
                <input type="submit" value="Modifier la Lettre de motivation">
            </form>
        <?php else : ?>
            <p>Aucune lettre de motivation téléchargée. <a href="upload_lettre_form.php">Téléchargez votre lettre de motivation ici.</a></p>
        <?php endif; ?>
    </section>

    <!-- Affichage des messages d'erreur ou de succès -->
    <?php if (isset($error_message)) : ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php elseif (isset($success_message)) : ?>
        <div class="success"><?php echo $success_message; ?></div>
    <?php endif; ?>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/footer.php'; ?>