<?php
require_once('fonctions.php');
//On démarre une nouvelle session
session_start();

/*On utilise session_id() pour récupérer l'id de session s'il existe.
 *Si l'id de session n'existe  pas, session_id() rnevoie une chaine
 *de caractères vide*/
$id_session = session_id();
?>

<!DOCTYPE html>
<html lang='fr'>
<head>
<meta charset='utf-8'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="../CSS/style.css">
<title>Gestion des contrôles réglementaires</title>
</head>
<body class="oublieBody" background="../IMG/fonds/0.jpg">
<header>
<?php //en_tete('../IMG/shutdown.png', '../IMG/change_password.png','../IMG/listing.png');?>  <!-- affichage de l'en-tete -->
</header>
<div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-1 fw-light fs-3">Mot de passe oublié
            </h5>
            <hr class="my-3">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Un administrateur va vous envoyer par email un mot de passe privisoire, vous devrez le changer immédiatement!!
            </h5>
            <form method="post">
              
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="login" value="" required>
                <label for="floatingInput">Adresse mail</label>
              </div>

              
              <!-- bouton envoyer -->
              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit" name="mdpenvoyer"> Envoyer                 
                </button>
              </div>

              <hr class="my-4">
              <?php //if(($_SESSION['username'] == '') && (isset($_POST['envoyer'])) ){echo '<div>Votre mot de passe privisoire est:<b> Bonjour10%</b></div>';}  ?>
              <br>
              <div class="text-center"><a class="btn btn-outline-secondary" href="../index.php" role="button">Page Identification</a>
          <form>
          
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</boby>
</html>

<?php

if (isset($_POST['mdpenvoyer']))
{
   
  $mdp_oublie = new Mdp_Oublie($connex, $_POST['login']);
}       
 

?>
