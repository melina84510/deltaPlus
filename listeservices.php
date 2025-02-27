            <div>
                <form class="tableau" action="" method="post">

                    <select name="listeservices" id="">
                        <?php
                            if (isset($_POST['listeservices']) && !empty($_POST['listeservices'])){
                                $service = htmlspecialchars($_POST['listeservices']);
                                $nomservice = $service;
                                if ($service === "%") {
                                    $nomservice = "Tous les services";
                                }
                                echo '<option value="' . $service . '">' . ucfirst($nomservice) . '</option>';
                            } else {
                                $service = "%";
                            }
                        ?>
                        <option value="%">Tous les Services</option>
                        <?php
                            // Récupérer et afficher dans une liste déroulante la liste des services
                            $requete1 = $db->prepare('SELECT DISTINCT `services` FROM `offres` ORDER BY `services` ASC');
                            $requete1->execute();
                            $listes1 = $requete1->fetchAll();
                            foreach ($listes1 as $liste) {
                                echo '<option value="' . $liste['services'] . '">' . $liste['services'] . '</option>';
                            }
                        ?>
                        <option value="spontannee">Spontannée uniquement</option>
                    </select>
                    <input type="submit" value="AFFICHER">
                </form>
                        
            </div>