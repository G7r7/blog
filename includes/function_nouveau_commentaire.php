<?php

function nouveau_commentaire() {

echo '<p><strong>Commentaires</strong></p>
<form method=post action=comments.php?id=' . $_GET['id'] . '>';

if(isset($_SESSION['pseudo']) AND isset($_SESSION['id']) AND $_SESSION['pseudo']!=NULL AND $_SESSION['id']!=NULL)
{
  echo 'Pseudo : <strong>' . $_SESSION['pseudo'] . '</strong></br></br>
  <input type="hidden" id="id_auteur" name="id_auteur" value="' . $_SESSION['id'] . '">
  <input type="hidden" id="pseudo" name="pseudo" value="' . $_SESSION['pseudo'] . '">';
} else {
  echo '<label for=auteur>Pseudo : </label><input type="text" name="pseudo" id="pseudo"><br /><br />
        <input type="hidden" id="id_auteur" name="id_auteur" value=13>';
}
  echo '<label for=commentaire>Commentaire: </label><textarea rows=3 cols=40 name="commentaire" id="commentaire"></textarea><br /><br />
    <input type="submit">
  </form><br /><br />';

  $db=connexion_bdd();

If (isset($_POST['pseudo']) AND isset($_POST['commentaire']) AND isset($_GET['id']))
{

//-----------------REQUETE INSERTION NOUVEAU COMMENTAIRE-----------------------
$req2=$db->prepare('INSERT INTO commentaires(pseudo, commentaire, id_billet, date_commentaire, id_auteur) values(:pseudo, :commentaire, :id_billet, NOW(), :id_auteur)');
$req2->execute(array('pseudo'=>$_POST['pseudo'], 'commentaire'=>$_POST['commentaire'], 'id_billet'=>$_GET['id'], 'id_auteur'=>$_POST['id_auteur']));
}

}//Fin de la fonction nouveau_commentaire

?>
