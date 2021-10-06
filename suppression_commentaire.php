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

?>

        <h3>Suppression de commentaire</h3>


<!----------------------------Partie Php ---------------------------->
<?php


//----------------------------Vérification de la méthode de requête pour savoir si le formulaire a été validé-------------------------

  //echo '<strong>' . $_SERVER['REQUEST_METHOD'] . '</strong><br /><br />';


// ---------------------------Si l'id n'est pas définie on demande de rensigner l'id -------------------------------

If (!isset($_GET['id']) AND $_SERVER['REQUEST_METHOD'] == 'GET')
{
  echo 'Merci de renseigner l\'id du commentaire à supprimer.';
}

// ---------------------------Si l'id est bien définie -------------------------------

else if (isset($_GET['id']) AND $_SERVER['REQUEST_METHOD'] == 'GET') {

// ---------------------------Connexion à la BDD -------------------------------

try {
    $db=connexion_bdd();

/*----Requête sélection de tous les billets avec l'ID correspondante-----------*/


  $req=$db->prepare('SELECT * FROM commentaires WHERE ID="'.$_GET['id'].'"');
  $req->execute();

//-------------------------Boucle d'affichage-----------------------------------------------

  While ($donnees=$req->fetch()) {

   echo 'Etes-vous sûr de vouloir de supprimmer le commentaire ?';

   echo '<br /><br /><form method=POST action=suppression_commentaire.php>
          <input type="hidden" value="'.$_GET['id'].'" name="id" id="id">
          <input type="hidden" value="'.$donnees['id_billet'].'" name="id_billet" id="id_billet">
          <input type="submit" value="Supprimer">
          <a href="index.php"><button type="button">Non, revenir à l\'accueil</button></a>
        </form>';

  }


//-------Affichage message d'erreur et interruption du programme si commexion impossible
} catch (\Exception $e) {
  die('Connexion impossible à la base de données.');

}
}
//---------------------------------------------Redirection vers l'accueil si le billet a bien été supprimé-------------------

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

//---------------------------------------------Requete de suppression du billet et des commentaires associés------------

try {
    $db=connexion_bdd();

$req=$db->prepare('SELECT id_billet FROM commentaires WHERE id=:id');
$req->execute(array('id'=>$_POST['id']));

WHILE ($donnees=$req->fetch()) {
  $id_billet=$donnees['id_billet'];
}

$req=$db->prepare('SELECT id_auteur FROM commentaires WHERE id=:id');
$req->execute(array('id'=>$_POST['id']));

while($donnees=$req->fetch())
{
  $id_auteur=$donnees['id_auteur'];
}

if ($id_auteur==$_SESSION['id'] OR $_SESSION['id']==13)
{

$req=$db->prepare('DELETE FROM commentaires WHERE id=:id');
$req->execute(array('id'=>$_POST['id']));

  echo 'Le commentaire a bien été supprimé.<br /><br />';
} else {
  echo 'Vous n\'êtes pas l\'auteur de ce commentaire.<br /><br />';
  echo 'Vous n\'avez pas le droit de supprimer ce commentaire.<br /><br />';
}
  echo '<strong>Redirection en cours ...</strong><br /><br />';
  echo '<img src=images/chargement.gif alt=Veuillez patienter ... />';

  header('Refresh: 2;url=comments.php?id=' . $id_billet);

} catch (\Exception $e) {
  die('Connexion impossible à la base de données.');

}


}



?>
    </body>
  <html>
