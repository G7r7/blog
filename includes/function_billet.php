<?php
function billet($version = 'index') { // Valeur par défaut = "index"
    if ($version == 'index') {
        $db=connexion_bdd();
        if (!isset($_GET['offset'])) {$_GET['offset']=0;}
        /*----Requête sélection de tous les billets réduits à 200 caractères
        triés par date décroissante, limitation aux 5 derniers billets-------*/
        try {
            $req=$db->query('SELECT
                billets.id,
                billets.titre,
                billets.auteur,
                billets.id_auteur,
                billets.date_creation,
                billets.date_modification,
                billets.contenu,
                SUBSTRING(contenu, 1, 200) as contenu_reduit, LENGTH(contenu) as LongueurContenu,
                count(commentaires.id_billet) AS CommentNumber
                FROM billets
                LEFT JOIN commentaires ON billets.id = commentaires.id_billet
                GROUP BY
                billets.id,
                billets.titre,
                billets.auteur,
                billets.id_auteur,
                billets.date_creation,
                billets.date_modification,
                billets.contenu
                ORDER BY date_creation DESC LIMIT '. $_GET['offset'] .', 5');
                /*-Boucle d'affichage-*/
            } catch (Exception $e) {
                echo "Erreur d'affichage des billets : " . $e->getMessage();
            } // Fin du catch

            WHILE ($donnees=$req->fetch()) {
                echo "<div class=contenant_billet>";
                echo "<div class=bandeau>";
                echo "<span class='titre'>";
                if (isset($_SESSION['pseudo']) AND isset($_SESSION['id']) AND $_SESSION['pseudo']!=NULL AND $_SESSION['id']!=NULL AND ($donnees['id_auteur']==$_SESSION['id'] OR $_SESSION['id']==13)) {
                  echo '<a title=\'Supprimer ce billet\' href=suppression.php?id=' . htmlspecialchars($donnees['id']) . '>&#10060;</a>
                  <a title=\'Modifier ce billet\' href=modification.php?id=' . htmlspecialchars($donnees['id']) . '>&#9998;</a> ';
                }
                echo "<strong>" . htmlspecialchars($donnees['titre']) . "</strong> - par :" . htmlspecialchars($donnees['auteur']) ."</span><span class=spacer></span>";
                if (isset($donnees['date_modification'])) {
                      $phpdatemodification=strtotime($donnees['date_modification']);
                      $phpdatemodification=date('d/m/Y H:i:s', $phpdatemodification);
                      echo "<span class='date_modification'>" . htmlspecialchars($phpdatemodification) . "</span>";
                } else {
                          $phpdatecreation=strtotime($donnees['date_creation']);
                          $phpdatecreation=date('d/m/Y H:i:s', $phpdatecreation);
                          echo "<span class='date_creation'>" . htmlspecialchars($phpdatecreation) . "</span>";
                }
                echo  "</div>";
                echo "<div class=contenu_reduit>". nl2br(htmlspecialchars($donnees['contenu_reduit'])) ."</div>";
                echo  "<div class=bandeau_fin>";
                if ($donnees['LongueurContenu'] > 200 AND $version=='index') {
                    echo "<span class=LireLaSuite><strong><a href=comments.php?id=" . htmlspecialchars($donnees['id']) . ">(Lire la suite ...)</a></strong></span>";
                }
                echo "<span class=spacer></span>";
                if ($version=='index') {
                    echo "<span class=lien_commentaire><a href=comments.php?id=" . htmlspecialchars($donnees['id']) . ">(". htmlspecialchars($donnees['CommentNumber']) .") Commentaires</a></span>";
                }
                echo  "</div>
                </div><br />";
            } // Fin du While
        } //Fin du If(version=index)

        if ($version == 'commentaires') {
            $db=connexion_bdd();
            /*---Requête sélection de tous les billets réduits à 200 caractères
            triés par date décroissante, limitation aux 5 derniers billets---*/
            try {
                $req=$db->prepare('SELECT * FROM billets WHERE id=:id');
                $req->execute(array('id' => $_GET['id']));
                //-----------Boucle d'affichage----------------------------
                WHILE ($donnees=$req->fetch()) {
                    echo "<div class=contenant_billet><div class=bandeau><span class='titre'>";
                    if (isset($_SESSION['pseudo']) AND isset($_SESSION['id']) AND $_SESSION['pseudo']!=NULL AND $_SESSION['id']!=NULL AND $donnees['id_auteur']==$_SESSION['id']) {
                        echo '<a title=\'Supprimer ce billet\' href=suppression.php?id=' . htmlspecialchars($donnees['id']) . '>&#10060;</a><a title=\'Modifier ce billet\' href=modification.php?id=' . htmlspecialchars($donnees['id']) . '>&#9998;</a> ';
                    }
                    echo "<strong>" . htmlspecialchars($donnees['titre']) . "</strong> - par :" . htmlspecialchars($donnees['auteur']) ."</span><span class=spacer></span>";
                    if (isset($donnees['date_modification'])) {
                        $phpdatemodification=strtotime($donnees['date_modification']);
                        $phpdatemodification=date('d/m/Y H:i:s', $phpdatemodification);
                        echo  "<span class='date_modification'>" . htmlspecialchars($phpdatemodification) . "</span>";
                    } else {
                        $phpdatecreation=strtotime($donnees['date_creation']);
                        $phpdatecreation=date('d/m/Y H:i:s', $phpdatecreation);
                        echo  "<span class='date_creation'>" . htmlspecialchars($phpdatecreation) . "</span>";
                    }
                    echo  "</div>";
                    echo "<div class=contenu>". nl2br(htmlspecialchars($donnees['contenu'])) ."</div>";
                    echo "<div class=bandeau_fin>";
                    echo "<span class=spacer></span>";
                    echo "</div></div><br />";
                }// Fin du While
            } catch (Exception $e) {
                echo "Erreur requête MySQL : " . $e->getMessage();
            }
        }//Fin du if(version=commentaires)
}// Fin de la fonction billet
?>
