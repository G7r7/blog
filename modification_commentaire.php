<?php
    include 'includes/global.php';
    session ();
?>

<!DOCTYPE HTML>
    <html>
<!-- -------------------------Entête de la page ----------------->
        <head>
            <meta charset='utf-8' />
            <link rel="stylesheet" href="style.css" />
        </head>

<!-- -------------------------Corps de la page ----------------->
        <body>

<!-- -------------------------Titre page ----------------->
            <?php

                menu ();

                echo '<h3>Modification de commentaire</h3>';

// ---------------------------Si l'id n'est pas définie on demande de rensigner l'id -------------------------------

                If (!isset($_GET['id']))
                {
                      echo 'Merci de renseigner l\'id du commentaire à modifier.';

// ---------------------------Si l'id est bien définie -------------------------------

                } else {

// ---------------------------Connexion à la BDD -------------------------------

                    try {
                        $db=connexion_bdd();



/*----Requête sélection de tous les commentaires avec l'ID correspondante-----------*/

                        $req=$db->prepare('SELECT * FROM commentaires WHERE id=:id');
                        $req->execute(array('id'=>$_GET['id']));


/*-Boucle d'affichage-*/
                        WHILE ($donnees=$req->fetch())
                        {
                          echo
                              '<form method=post action=modification_commentaire.php?id=' . $_GET['id'] . '>
                                  <label for=pseudo>Pseudo : </label><input type="text" name="pseudo" id="pseudo" value="' . htmlspecialchars($donnees['pseudo']) . '"><br /><br />
                                  <label for=commentaire>Commentaire: </label><textarea rows=10 cols=40 name="commentaire" id="commentaire">' . htmlspecialchars($donnees['commentaire']) . '</textarea><br /><br />
                                  <input type="submit" value="Mettre à jour &#8608;">
                              </form><br />';

                          $id_billet=htmlspecialchars($donnees['id_billet']);
                        }

//---------------------------------------------Redirection vers l'accueil si la mise à jour a été effectuée-------------------

                        If ($_SERVER['REQUEST_METHOD'] == 'POST')
                        {
                            $req=$db->prepare('SELECT id_auteur
                                                FROM commentaires
                                                WHERE id=:id');

                            $req->execute(array('id'=>$_GET['id']));

                            While ($donnees=$req->fetch())
                            {
                                $id_auteur=$donnees['id_auteur'];
                            }

                            If ($id_auteur==$_SESSION['id']
                                OR $_SESSION['id']==13)
                            {
                                $req=$db->prepare('UPDATE commentaires SET pseudo=:pseudo, commentaire=:commentaire, date_modification_commentaire=NOW() WHERE id=:id');

                                $req->execute(array('id'=>$_GET['id'],
                                                    'pseudo'=>$_POST['pseudo'],
                                                    'commentaire'=>$_POST['commentaire']));

                        } else {
                            echo
                                'Vous n\'êtes pas l\'auteur de ce billet.<br />
                                Vous n\'avez pas le droit de modification.<br />';
                        }//Fin du else


                        echo 'Le commentaire a bien été mis à jour.<br /><br />';
                        echo '<strong>Redirection en cours ...</strong><br /><br />';
                        echo '<img src=images/chargement.gif alt=Veuillez patienter ... />';

                        header('Refresh: 2;url=comments.php?id=' . $id_billet);

                      }//Fin du If

//-------Affichage message d'erreur et interruption du programme si commexion impossible
                } catch (\Exception $e) {
                  die('Connexion impossible à la base de données.');

                }//fin du try

}

?>
    </body>
  <html>
