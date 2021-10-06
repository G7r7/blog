<?php
function connexion_bdd() {
    try {
        $db=new PDO ('mysql:host=mysql-grullier.alwaysdata.net;dbname=grullier_blog', 'grullier', 'Password');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (Exception $e) {
        echo "Erreur de connexion à la base de données : ". $e->getMessage();
    }
}
?>
