<?php
function pages() {
    $db=connexion_bdd();
    try {
        $req=$db->query('SELECT ID from billets');
        $PostNumber=$req->rowcount();
        $NumeroDePage=1;
        echo "Pages : ";
        while ($PostNumber > 0) {
            echo "<a href=index.php?offset=" . ($NumeroDePage-1)*5 . ">" . $NumeroDePage . "</a> ";
            $NumeroDePage=$NumeroDePage+1;
            $PostNumber=$PostNumber-5;
        }
    } catch(Exception $e) {
        echo "Erreur d'affichage des boutons de pagination : ".$e->getMessage();
    }
}

?>
