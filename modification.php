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

        <h3>Modification de billet</h3>


<!----------------------------Partie Php ---------------------------->
<?php

// ---------------------------Si l'id n'est pas définie on demande de rensigner l'id -------------------------------

If (!isset($_GET['id']))
{
  echo 'Merci de renseigner l\'id du billet à modifier.';
}

// ---------------------------Si l'id est bien définie -------------------------------

else {

//----------------------------Vérification de la méthode de requête pour savoir si le formulaire a été validé-------------------------

  //echo '<strong>' . $_SERVER['REQUEST_METHOD'] . '</strong><br /><br />';


// ---------------------------Connexion à la BDD -------------------------------

try {
    $db=connexion_bdd();


//------------------------------Si le formaulaire de mise à jour a été validé on met à jour la base de données--------------

    If ($_SERVER['REQUEST_METHOD'] == 'POST')
    {

    }


/*----Requête sélection de tous les billets avec l'ID correspondante-----------*/


  $req=$db->prepare('SELECT * FROM billets WHERE id=:id');
  $req->execute(array('id'=>$_GET['id']));


/*-Boucle d'affichage-*/
  WHILE ($donnees=$req->fetch())
  {
    echo '
    <form method=post action=modification.php?id=' . $_GET['id'] . '>
      <label for=auteur>Auteur : </label><input type="text" name="auteur" id="auteur" value="' . htmlspecialchars($donnees['auteur']) . '"><br /><br />
      <label for=titre>Titre billet : </label><input type="text" name="titre" id="titre" value="' . htmlspecialchars($donnees['titre']) . '"><br /><br />
      <label for=contenu>Contenu billet: </label><textarea rows=10 cols=40 name="contenu" id="contenu">' . htmlspecialchars($donnees['contenu']) . '</textarea><br /><br />
      <input type="submit" value="Mettre à jour &#8608;">
    </form>
    <br />
    ';
  }

//---------------------------------------------Redirection vers l'accueil si la mise à jour a été effectuée-------------------

If ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $req=$db->prepare('SELECT id_auteur FROM billets WHERE id=:id');
  $req->execute(array('id'=>$_GET['id']));

while($donnees=$req->fetch())
{
  $id_auteur=$donnees['id_auteur'];
}

if($id_auteur==$_SESSION['id'] OR $_SESSION['id']==13)
{
  $req=$db->prepare('UPDATE billets SET auteur=:auteur, titre=:titre, contenu=:contenu, date_modification=NOW() WHERE id=:id');
  $req->execute(array('id'=>$_GET['id'],
                      'auteur'=>$_POST['auteur'],
                      'titre'=>$_POST['titre'],
                      'contenu'=>$_POST['contenu']));

  echo 'Le billet nommé <strong>"'. htmlspecialchars($_POST['titre']) .'"</strong> a bien été mis à jour.<br /><br />';
} else {
  echo 'Vous n\'$êtes pas l\auteur de ce billet.<br />Vous n\'avez pas le droit de modification.';
}
  echo '<strong>Redirection en cours ...</strong><br /><br />';
  echo '<img src=images/chargement.gif alt=Veuillez patienter ... />';

  header('Refresh: 2;url=index.php');

}

//-------Affichage message d'erreur et interruption du programme si commexion impossible
} catch (\Exception $e) {
  die('Connexion impossible à la base de données.');

}

}

?>
    </body>
  <html>
