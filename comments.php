<?php
include 'includes/global.php';
session ();
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>Commentaires</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8" />
  </head>

<!-- ----------------------------------BODY----------------------------------->

  <body>

<?php

menu ();

billet ("commentaires");

nouveau_commentaire();

commentaires();

 ?>
</body>
</html>
