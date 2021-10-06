<?php
include 'includes/global.php';
session ();
?>

<!DOCTYPE HTML>
  <html>
    <head>
      <meta charset="utf-8" />
      <title>Déconnexion</title>
      <link rel="stylesheet" href="style.css">
    </head>
    <body>
      <?php

          menu(); //Affichage du menu

          session_destroy(); //Destruction de la session

          echo '<br /><br />Déconnexion en cours ...<br /><br />';
          echo '<strong>Redirection en cours ...</strong><br /><br />';
          echo '<img src=images/chargement.gif alt=Veuillez patienter ... />';
          header('Refresh: 2;url=index.php');
      ?>
    </body>
  </html>
