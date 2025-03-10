<?php include $_SERVER['DOCUMENT_ROOT'] . '/config.php'; ?>

<?php   
if ($_SESSION['USER_ROLE'] === 'admin') {
        echo '<a href="utilisateurs">Page utilisateurs</a>';
    } else {
        header('Location: open');
    }
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/header.php'; ?>

<main>
    <section>
        <?php
            if (isset($_GET['action']) && $_GET['action'] == "supp") {
                // echo "MODE SUPPRESION ! de l'annonce " . $_GET['id'];
                // // 
                // // DELETE FROM offres WHERE `offres`.`id` = 3
                if (isset($_GET['id']) || !empty($_GET['id'])) {
                    $supSQL = $db->prepare('DELETE FROM users WHERE `users`.`id` = :id');
                    $supSQL->execute([
                        'id' => $_GET['id']
                    ]);
                    echo '<p class="alert">Suppression effectuée</p>';
                    // Après la suppression, recharge la page sans les GET
                    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
                    exit;
                }
            } elseif (isset($_GET['action']) && $_GET['action'] == "modif") {
                if (isset($_GET['id']) || !empty($_GET['id'])) {
                    $modifSQL = $db->prepare('SELECT * FROM `users` WHERE `users`.`id` = :id');
                    $modifSQL->execute([
                        'id' => $_GET['id']
                    ]);
                    $user = $modifSQL->Fetch();
                    $remplir=true;
                    $modemodif=true;
                } else {
                    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
                    exit;
                }
            } else {
                $modeajout=true;
            }
            $AfficheUsers = $db->prepare('SELECT * FROM `users`');
            $AfficheUsers->execute([]);
            $ListeUsers = $AfficheUsers->FetchAll();
        ?>
        <table class="styled-table">
            <tr>
                <td>Mail</td>
                <td>Rôle</td>
                <td>Active</td>
                <td>Modifier/Supprimer</td>
            </tr>
            <?php
                foreach ($ListeUsers as $a) {
                    echo '<tr>';
                        echo '<td>'.$a['mail'].'</td>';
                        echo '<td>'.$a['role'].'</td>';
                        echo '<td>'.$a['active'].'</td>';
                        echo '<td><a href="utilisateurs?action=modif&id='.$a['id'].'">Modifier</a> <a href="utilisateurs?action=supp&id='.$a['id'].'">Supprimer</a></td>';
                    echo '</tr>';
                }
            ?>
        </table>
    </section>
    <section>
        <form action="" method="POST">
            <div>
                <label for="email">Email :</label>
                <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if (!isset($_POST['email'])) {
                            $erreur++;
                            echo '<div class="alert">Il y a un problème avec l\'adresse mail</div>';
                        } elseif (empty($_POST['email'])|| !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                            $erreur++;
                            echo '<div class="alert">L\'adresse mail est invalide</div>';
                        } else {
                            $mail = htmlspecialchars($_POST['email']);
                        }
                    }
                ?>
                <input type="email" name="email" placeholder="" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@.+-_0123456789-" title="Il y a un problème avec l\'email !" value="<?php if (isset($remplir)) { echo $user['mail'];} ?>" required>
            </div>
            <div>
                <label for="pass">Mot de passe :</label>
                <input type="password" name="pass" placeholder="" patern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@.+-_0123456789-!:?" title="Il y a un problème avec le mot de passe" <?php if (isset($modeajout)) { echo "required"; } ?>>
                <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST') {
                        if ($modemodif) {
                            if (empty($_POST['pass'])) {
                                $chgmdp=false;
                            } else {
                                $chgmdp=true;
                                $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                            }
                        } elseif (!isset($_POST['pass'])) { //MODE AJOUT
                            $erreur++;
                            echo '<div class="alert">Il y a un problème avec le mot de passe</div>';
                        } else {
                            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                        }
                    }
                ?>
            </div>
            <div>
                <label for="role">Rôle :</label>
                <select id="role" name="role" required>
                    <?php
                    if (isset($_GET['action']) && $_GET['action'] == "modif") {
                        echo '<option value="' . $user['role'] . '">' . $user['role'] . '</option>';
                    } else {
                        echo '<option value="">-- Sélectionner un rôle --</option>';
                    }
                    ?>
                    <option value="admin">Administrateur</option>
                    <option value="rh">RH</option>
                </select>
            <?php
                if ($_SERVER['REQUEST_METHOD']=='POST') {
                    if (!isset($_POST['role']) || empty($_POST['role'])) {
                        $erreur++;
                        echo '<div class="alert">Aucun rôle n\'a été sélectionné</div>';
                    } else {
                        $role = htmlspecialchars($_POST['role']);
                    }
                }
            ?>
            </div>
            <div>
                <label for="active">Statut :</label>
                <select id="active" name="active" required>
                <?php 
                    if (isset($_GET['action']) && $_GET['action'] == "modif") {
                        if ($user['active'] == "1"){
                            echo '<option value="actif">Activé</option>';
                            echo '<option value="desac">désactivé</option>';
                        } else {
                            echo '<option value="desac">désactivé</option>';
                            echo '<option value="actif">Activé</option>';
                        }   
                    } else {
                        echo '<option value="">-- Sélectionner un statut --</option>';
                        echo '<option value="actif">Activé</option>';
                        echo '<option value="desac">désactivé</option>';
                    }
                ?>
                    
                    
                </select>
            <?php
                if ($_SERVER['REQUEST_METHOD']=='POST') {
                    if (!isset($_POST['active']) || empty($_POST['active'])) {
                        $erreur++;
                        echo '<div class="alert">Aucun statut n\'a été sélectionné</div>';
                    } else {
                        if ($_POST['active'] == "actif") {
                            $statut = "1";
                        } else {
                            $statut = "0";
                        }
                    }
                }
            ?>
            </div>
            <div>
                
            <?php 
                if (isset($_GET['action']) && $_GET['action'] == "modif") {
                    echo '<input type="submit" value="Modifier">';
                } else {
                    echo '<input type="submit" value="Ajouter">';
                }
            ?>
            </div>
            <?php
                if ($_SERVER['REQUEST_METHOD']=='POST') {
                    if ($erreur === 0) {
                        if ($modemodif) {
                            if ($chgmdp) {
                                // requête UPDATE si $chgmdp=true 
                                $SqlQuery = $db->prepare('UPDATE `users` SET `mail` = :mail, `pass` = :pass, `role` = :role, `active` = :active WHERE `users`.`id` = :id');
                                $SqlQuery->execute([
                                    'mail' => $mail,
                                    'pass' => $pass,
                                    'role' => $role,
                                    'active' => $statut,
                                    'id' => $_GET['id']
                                ]);
                                echo '<div id="popup" onclick="closePopup();">MODIFICATIONS REUSSIES !</div>';
                            } else { //requête UPDATE si $chgmdp=false
                                $SqlQuery = $db->prepare('UPDATE `users` SET `mail` = :mail, `role` = :role, `active` = :active WHERE `users`.`id` = :id');
                                $SqlQuery->execute([
                                    'mail' => $mail,
                                    'role' => $role,
                                    'active' => $statut,
                                    'id' => $_GET['id']
                                ]);
                                echo '<div id="popup" onclick="closePopup();">MODIFICATIONS REUSSIES !</div>'; 
                            }  
                        } else {
                            try {
                                // Préparer et exécuter la requête SQL
                                $SqlQuery = $db->prepare('INSERT INTO `users` (id, mail, pass, role, active) VALUES (NULL, :mail, :pass, :role, :active)');
                                $SqlQuery->execute([
                                    'mail' => $mail,
                                    'pass' => $pass,
                                    'role' => $role,
                                    'active' => $statut,
                                ]);
                                echo '<div id="popup" onclick="closePopup();">ENREGISTREMENT REUSSI !</div>';
                                // Après la suppression, recharge la page sans les GET
                            } catch (PDOException $e) {
                                echo '<div class="alert">Erreur lors de l\'enregistrement : ' . $e->getMessage() . '</div>';
                            }
                        } 
                    } else {
                        echo '<div id="popup" onclick="closePopup();">' . $erreur . ' erreur(s) détectée(s) !</div>';
                    }
                }
        ?>
        </form>
    </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/elementsreutilise/footer.php'; ?>