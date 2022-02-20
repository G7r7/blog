<?php
include 'includes/global.php';
session();
?>
<!DOCTYPE HTML>
  <html>
      <head>
          <meta charset='utf-8' />
          <link rel="stylesheet" href="style.css" />
      </head>
      <body>
<?php
menu();
echo "<h3>Derniers billets postés</h3>";
billet();
pages();
?>
    </body>
  <html>
