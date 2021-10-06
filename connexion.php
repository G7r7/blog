<?php
//----------------------Scripts de routines ----------------------------------//
include 'includes/global.php';
session ();
//-------------------------Fin des scripts de routine-------------------------//
?>

<!DOCTYPE HTML>
<!----------------------Début de la page HTML ------------------------------->
  <html>
    <head>
      <title>Connexion</title>
      <meta charset="utf-8" />
      <link rel="stylesheet" href="style.css">
    </head>
    <body>
      <?php
//------------------------Affichage du menu-----------------------------------//
          menu();
       ?>
       <br />
<div style='min-width: 300px; width: 30%;'>


<!-------------------------Affichage du formulaire de connexion-------------->
<form METHOD=POST ACTION=connexion.php>
       <fieldset>
         <legend>Connexion</legend>
           <label for=pseudo>Pseudo : </label><input type=text name=pseudo id=pseudo><br /><br />
           <label for=mdp>Mot de passe : </label><input type=password name=mdp id=mdp><br /><br />

          <input type='hidden' id='sent' name='sent' value='true'>

           <button type=submit>Se connecter</button>
      </fieldset>
    </form>
</div>
<?php

//------------Vérification des variables lorsque le formulaire est validé-----//

If (isset($_POST['sent']) //Si le formulaire a été envoyé
AND isset($_POST['pseudo']) //Si la variable pseudo a été envoyée
AND isset($_POST['mdp']) //Si la variable mot de passe a été envoyée
AND $_POST['pseudo']!=NULL //Si la variable pseudo est différente de rien
AND $_POST['mdp']!=NULL //Si la variable mdp est différente de rien
AND $_POST['sent']==true) //Si la variable d'envoi du formulaire est vrai


{
//---------------Si les conditions ci-dessus sont remplies alors :-----------//
  $pseudo=$_POST['pseudo']; //On affecte la variable pseudo
  $mdp=$_POST['mdp']; //On affecte la variable mdp

  $db=connexion_bdd();

$req=$db->prepare('SELECT id, pseudo, mdp FROM membres WHERE pseudo=:pseudo');
$req->execute(array('pseudo'=>$pseudo));

//----------------Récupération id et mot de passe crypté du pseudo saisi------//
$i=0;
  While ($donnees=$req->fetch())
  {
    $id[$i]=$donnees['id'];
    $mdp_bdd[$i]=$donnees['mdp'];
    $i++;
  }
  $mdp_bdd=$mdp_bdd[0];
  $id=$id[0];

//-------------------Test correspondance des mots de passe--------------------//
            if(!function_exists('hash_equals')) {
                function hash_equals($str1, $str2) {
                    if(strlen($str1) != strlen($str2)) {
                        return false;
                    } else {
                        $res = $str1 ^ $str2;
                        $ret = 0;
                        for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
                        return !$ret;
                    }
                }
            }

            If (hash_equals($mdp_bdd, crypt($mdp, $mdp_bdd)))
            {
            //---------Si le test est positif--------------------------------//
              echo '<br /><br />Connexion réussie !<br /><br />';
              echo '<strong>Redirection en cours ...</strong><br /><br />';
              echo '<img src=images/chargement.gif alt=Veuillez patienter ... />';
              header('Refresh: 2;url=index.php');

              $_SESSION['pseudo']=$pseudo; //On passe pseudo en session
              $_SESSION['id']=$id; //On passe l'id en session


            } else {
              //-------Si le test est négatif--------------------------------//
              echo '<strong>Pseudo ou mot de passe incorrect, veuillez réessayer.</strong><br /><br />';

            }
  }

 ?>
    </body>
  </html>
