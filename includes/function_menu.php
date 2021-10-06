<?php
function menu() {
    echo "<table style='border-collapse: collapse;'>";
    echo "<td style='border: 1px solid black; border-collapse: collapse;'><a href=index.php><strong>Accueil</strong></a></td>";
    echo "<td style='border: 1px solid black; border-collapse: collapse;'><a href=redaction.php><strong>Rédiger un nouveau billet</strong></a></td>";
    echo "<td style='border: 1px solid black; border-collapse: collapse;'><a href=inscription.php><strong>S'inscrire</strong></a></td>";
    echo "<td style='border: 1px solid black; border-collapse: collapse;'><a href=connexion.php><strong>Se connecter</strong></a></td>";
    if (isset($_SESSION['pseudo']) AND isset($_SESSION['id']) AND $_SESSION['pseudo']!=NULL AND $_SESSION['id']!=NULL) {
        echo "<td style='border: 1px solid black; border-collapse: collapse;'><a href=deconnexion.php><strong>Se déconnecter</strong></a></td>";
    }
    echo "</table><br />";
}
?>
