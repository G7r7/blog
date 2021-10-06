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
            <?php
                menu ();
                echo "<div style='min-width: 300px; width: 30%;'>
                          <fieldset>
                                  <legend>Inscription</legend>
                                  <form method=POST action=inscription.php>
                                      <label for='email'>E-Mail </label><input type=text name='email' id='email'><br />
                                      <label for='pseudo'>Pseudo </label><input type=text name='pseudo' id='pseudo'><br />
                                      <label for='mdp'>Mot de passe </label><input type=password name='mdp' id='mdp'><br />
                                      <label for='mdp2'>Mot de passe </label><input type=password name='mdp2' id='mdp2'><br /><br />
                                      <input type='hidden' id='sent' name='sent' value='true'>
                                      <button type=submit>S'inscrire</button>
                                  </form>
                          </fieldset>
                  </div>";

                  If (
                        $_POST['sent']==true// Le formulaire a été posté
                        AND $_POST['email']!=NULL//Email est différent de rien
                        AND $_POST['pseudo']!=NULL//Pseudo est différent de rien
                        AND $_POST['mdp']!=NULL//Mot de passe est différent de rien
                        AND $_POST['mdp2']!=NULL//Mot de passe 2 est différent de rien

                        AND strlen($_POST['email'])>=3//L'Email fait au moins 3 caractères
                        AND strlen($_POST['pseudo'])>=3//Pseudo fait au moins 3 caractères
                        AND strlen($_POST['mdp'])>=3//Le mot de passe fait au moins 3 caractères
                        AND strlen($_POST['mdp2'])>=3//Le mot de passe fait au moins 3 caractères
                        AND $_POST['mdp']===$_POST['mdp2'] /*Les mots de passe correspondent*/

                    ) {
                        //Si les conditions sont remplies//

                                $mdp=crypt($_POST['mdp']);//Cryptage du password dans la variable $mdp
                                $db=connexion_bdd();
                        try {
                                $req=$db->prepare('INSERT INTO membres(email, pseudo, date_creation, mdp) VALUES(:email, :pseudo, NOW(), :mdp)');
                                $req->execute(array('pseudo'=>$_POST['pseudo'], 'email'=>$_POST['email'], 'mdp'=>$mdp));

                                echo '<br /><br />Inscription réussie.<br /><br />';
                                echo '<strong>Redirection en cours ...</strong><br /><br />';
                                echo '<img src=images/chargement.gif alt=Veuillez patienter ... />';
                                header('Refresh: 2;url=index.php');

                        } catch (Exception $e) {
                            echo "Erreur création membre : ".$e->getMessage();
                        }
                    } elseif (!isset ($_POST['sent'])) {
                        echo "<br />Veuillez saisir vos identifiants pour vous inscrire";
                    } else {
                        echo '<br />Non valide, veuillez réessayer s\'il vous plaît.';
                    }



            ?>
    </body>
  <html>
