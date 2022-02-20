
<?php
include 'includes/global.php';
session ();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" />
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
menu ();
echo '<form method=post action=redaction.php>';
if(isset($_SESSION['pseudo']) AND isset($_SESSION['id']) AND $_SESSION['pseudo']!=NULL AND $_SESSION['id']!=NULL) {
    echo 'Auteur : <strong>' . $_SESSION['pseudo'] . '</strong></br></br>
    <input type="hidden" id="id_auteur" name="id_auteur" value="' . $_SESSION['id'] . '">
    <input type="hidden" id="auteur" name="auteur" value="' . $_SESSION['pseudo'] . '">';
} else {
    echo '<label for=auteur>Auteur : </label><input type="text" name="auteur" id="auteur"><br /><br />
    <input type="hidden" id="id_auteur" name="id_auteur" value=13>';
}
echo '<label for=titre>Titre billet : </label><input type="text" name="titre" id="titre"><br /><br />
<label for=contenu>Contenu billet: </label><textarea rows=10 cols=40 name="contenu" id="contenu"></textarea><br /><br />
<input type="submit" value="Poster &#8608;">
</form>';
If (isset($_POST['auteur']) AND isset($_POST['titre']) AND isset($_POST['contenu'])) {
    $db=connexion_bdd();

    try {
        $req="INSERT INTO billets (titre, auteur, contenu, date_creation, id_auteur) values(:titre, :auteur, :contenu, NOW(), :id_auteur)";
        $req=$db->prepare($req);
        $req->execute(array('titre'=>$_POST['titre'], 'auteur'=>$_POST['auteur'], 'contenu'=>$_POST['contenu'], 'id_auteur'=>$_POST['id_auteur']));
        echo '<p>Le billet nommé <strong>"'. htmlspecialchars($_POST['titre']) .'"</strong> a bien été posté.</p>';
        echo '<p><strong>Redirection en cours ...</strong></p>';
        echo '<p><img src=images/chargement.gif alt=Veuillez patienter ... /></p>';
        header('Refresh: 2;url=index.php');
    } catch (Exception $e) {
        echo "<p>Erreur création du billet : ".$e-getMessage();
    }
} else {
    echo "<p>Ecrivez votre message puis cliquez sur \"Poster\".</p>";
}
?>
</body>
</html>
