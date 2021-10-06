<?php

function commentaires () {

$db=connexion_bdd();


//------------------REQUETE SQL SELECT * COMMENTAIRES-----------------------------
$req3=$db->prepare('SELECT * from commentaires where id_billet=:id order by date_commentaire desc');
$req3->execute(array('id' => $_GET['id']));

//------------------ BOUCLE AFFICHAGE COMMENTAIRES------------------------------------------------
while ($donnees=$req3->fetch())
{
  echo "
    <div class=contenant_commentaire>
        <div class=bandeau_commentaire>

              <span class=pseudo_commentaire>";

              If (isset($_SESSION['pseudo'])
              AND isset($_SESSION['id'])
              AND $_SESSION['pseudo']!=NULL
              AND $_SESSION['id']!=NULL
              AND ($donnees['id_auteur']==$_SESSION['id'] OR $_SESSION['id']==13))
              {
              echo "<a title=\"Supprimer ce commentaire\" href=suppression_commentaire.php?id=" . htmlspecialchars($donnees['id']) . ">&#10060;</a>
              <a href=modification_commentaire.php?id=" . htmlspecialchars($donnees['id']) . ">&#9998;</a> ";
              }
              echo  htmlspecialchars($donnees['pseudo']) . "
              </span>

              <span class=spacer>
              </span>";

              if (isset($donnees['date_modification_commentaire']))
              {
                $phpdatemodificationcommentaire=strtotime($donnees['date_modification_commentaire']);
                $phpdatemodificationcommentaire=date('d/m/Y H:i:s', $phpdatemodificationcommentaire);

                echo  "<span class='date_modification_commentaire'>
                          " . htmlspecialchars($phpdatemodificationcommentaire) . "
                      </span>";
              } else {
                $phpdatecreationcommentaire=strtotime($donnees['date_commentaire']);
                $phpdatecreationcommentaire=date('d/m/Y H:i:s', $phpdatecreationcommentaire);
                echo  "<span class='date_commentaire'>
                          " . htmlspecialchars($phpdatecreationcommentaire) . "
                      </span>";
              }

        echo "</div>

        <div class=commentaire>
              ". nl2br(htmlspecialchars($donnees['commentaire'])) ."
        </div>
    </div><br />";

}

}//Fin de la fonction commentaires
 ?>
