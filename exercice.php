
<?php include('config.php'); ?>
<?php include('head.php'); ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $note1 = $_POST['note1'];
    $note2 = $_POST['note2'];
    $note3 = $_POST['note3'];
    $note4 = $_POST['note4'];

    // Calcul de la moyenne
    $moyenne = ($note1 + $note2 + $note3 + $note4) / 4;

    // Détermination de la mention
    if ($moyenne >= 16) {
        $mention = "Très bien";
    } elseif ($moyenne >= 14) {
        $mention = "Bien";
    } elseif ($moyenne >= 12) {
        $mention = "Assez bien";
    } elseif ($moyenne >= 10) {
        $mention = "Passable";
    } else {
        $mention = "Échec";
    }

    echo '<p>
    Nom : ' . $nom . '<br>
    Prénom : ' . $prenom . '<br>
    Moyenne : ' . $moyenne . '<br>
    Mention : ' . $mention . '<br>
    </p>';

    $sql="INSERT INTO etudiant (id, nom, prenom, note1, note2, note3, note4, moyenne, mention) VALUES (:id, :nom, :prenom, :note1, :note2, :note3, :note4, :moyenne, :mention)";

    $requete= $db ->prepare ($sql);

    $requete-> execute ([
        ':id' => $id,
        ':nom'=> $nom,
        ':prenom'=> $prenom,
        ':note1'=> $note1,
        ':note2'=> $note2,
        ':note3'=> $note3,
        ':note4'=> $note4,
        ':moyenne'=> $moyenne,
        ':mention'=> $mention,
    ]);
}
?>

<form method="post">
    <h2>Ajout d'un étudiant</h2><br><br>

    <label for="nom">Nom :</label>
    <input type="text" name="nom" required><br><br>

    <label for="prenom">Prénom :</label>
    <input type="text" name="prenom" required><br><br>

    <label for="note1">Note 1 :</label>
    <input type="number" name="note1" step="0.1" min="0" max="20" required><br><br>

    <label for="note2">Note 2 :</label>
    <input type="number" name="note2" step="0.1" min="0" max="20" required><br><br>

    <label for="note3">Note 3 :</label>
    <input type="number" name="note3" step="0.1" min="0" max="20" required><br><br>

    <label for="note4">Note 4 :</label>
    <input type="number" name="note4" step="0.1" min="0" max="20" required><br><br>

    <button type="submit">Enregistrer</button>
</form>


<section>
    <table>
        <tr>
            <thead>
                <th>Classement</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Note 1</th>
                <th>Note 2</th>
                <th>Note 3</th>
                <th>Note 4</th>
                <th>Moyenne</th>
                <th>Mention</th>
            </thead>
        </tr>

        <?php
        
    $requete2 = $db->prepare('SELECT * FROM etudiant ORDER BY moyenne DESC LIMIT 10');
    $requete2->execute([]);

    $rang = 1;

    $etudiants = $requete2->fetchAll();
        foreach ($etudiants as $etudiant) { 
            echo "<tr>";
                echo "<td>" . $rang . "</td>";
                echo "<td>" . htmlspecialchars($etudiant['nom']) . "</td>";
                echo "<td>" . htmlspecialchars($etudiant['prenom']) . "</td>";
                echo "<td>" . htmlspecialchars($etudiant['note1']) . "</td>";
                echo "<td>" . htmlspecialchars($etudiant['note2']) . "</td>";
                echo "<td>" . htmlspecialchars($etudiant['note3']) . "</td>";
                echo "<td>" . htmlspecialchars($etudiant['note4']) . "</td>";
                echo "<td>" . htmlspecialchars($etudiant['moyenne']) . "</td>";
                echo "<td>" . htmlspecialchars($etudiant['mention']) . "</td>";
                echo '<td><a href="/exercice?action=suppr&id=' . htmlspecialchars($etudiant['id']) . '">Supprimer l\'annonce ' . htmlspecialchars($etudiant['id']) . '</a></td>';
                echo '<td><a href="/exercice?action=modif&id=' . htmlspecialchars($etudiant['id']) . '">Modifier l\'annonce ' . htmlspecialchars($etudiant['id']) . '</a></td>';
            echo "</tr>";
            $rang++;
        }
?>
    </table>
</section>


<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            background-color: #ffcc00;
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
</style>



