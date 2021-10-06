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

        <h3>Suppression de billet</h3>


<!----------------------------Partie Php ---------------------------->
<?php

// ---------------------------Si l'id n'est pas définie on demande de rensigner l'id -------------------------------

If (!isset($_GET['id']) AND $_SERVER['REQUEST_METHOD'] == 'GET')
{
  echo 'Merci de renseigner l\'id du billet à supprimer.';
}

// ---------------------------Si l'id est bien définie -------------------------------

else if (isset($_GET['id']) AND $_SERVER['REQUEST_METHOD'] == 'GET') {

// ---------------------------Connexion à la BDD -------------------------------

try {
    $db=connexion_bdd();

/*----Requête sélection de tous les billets avec l'ID correspondante-----------*/


  $req=$db->prepare('SELECT * FROM billets WHERE ID="'.$_GET['id'].'"');
  $req->execute();

//-------------------------Boucle d'affichage-----------------------------------------------

  While ($donnees=$req->fetch()) {

   echo 'Etes-vous sûr de vouloir supprimmer le billet nommé <strong>"'. htmlspecialchars($donnees['titre']) .'"</strong> anisi que ses commentaires ?';

   echo '<br /><br /><form method=POST action=suppression.php>
          <input type="hidden" value="'.$_GET['id'].'" name="id" id="id">
          <input type="hidden" value="'.$donnees['titre'].'" name="titre" id="titre">
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

$req=$db->prepare('SELECT id_auteur FROM billets WHERE id=:id');
$req->execute(array('id'=>$_POST['id']));

while($donnees=$req->fetch())
{
  $id_auteur=$donnees['id_auteur'];
}

if ($id_auteur==$_SESSION['id'] OR $_SESSION['id']==13)
{
$req=$db->prepare('DELETE FROM billets WHERE id=:id');
$req->execute(array('id'=>$_POST['id']));


$req=$db->prepare('DELETE FROM commentaires WHERE id_billet=:id');
$req->execute(array('id'=>$_POST['id']));

  echo 'Le billet nommé <strong>"'. htmlspecialchars($_POST['titre']) .'"</strong> a bien été supprimé.<br /><br />';
} else {
  echo 'Vous n\'êtes pas l\'auteur de ce billet.<br /><br />';
  echo 'Vous n\'avez pas le droit de supprimer le billet nommé <strong>"'. htmlspecialchars($_POST['titre']) .'"</strong>.<br /><br />';
}
  echo '<strong>Redirection en cours ...</strong><br /><br />';
  echo '<img src=images/chargement.gif alt=Veuillez patienter ... />';

  header('Refresh: 2;url=index.php');

} catch (\Exception $e) {
  die('Connexion impossible à la base de données.');

}


}



?>
    </body>
  <html>
