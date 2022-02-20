<?php
function connexion_bdd() {
    try {
        $db=new PDO ('mysql:host=blog_db;dbname=blog', 'db_user', 'password');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (Exception $e) {
        echo "Erreur de connexion à la base de données : ". $e->getMessage();
    }
}
?>
