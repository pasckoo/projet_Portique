<?php
  require_once('fonctions.php');
  
  //require_once(PDO_connexion.class.php');
  //On démarre une nouvelle session
  session_start();
  
  /*On utilise session_id() pour récupérer l'id de session s'il existe.
   *Si l'id de session n'existe  pas, session_id() rnevoie une chaine
   *de caractères vide*/
  //$id_session = session_id();
?>

<!DOCTYPE html>
<html lang='fr'>
<head>
<meta charset='utf-8'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="../CSS/style.css">
<title>Test PDO</title>
</head>
<body>
<header>
<?php //en_tete('../IMG/shutdown.png','../IMG/change_password.png','../IMG/listing.png' );?>  <!-- affichage de l'en-tete -->
</header>
  <div class="container w-50">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
          
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-3">Incription</h5>

            <form method="post" action="">


              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInputUsername" placeholder="myusername" name="nom" value="" required>
                <label for="floatingInputUsername">Nom</label>
              </div>
              

              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInputUserfirstname" placeholder="myuserfirstname" name="prenom" value="" required>
                <label for="floatingInputUserfirstname">Prénom</label>
              </div>

              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInputEmail" placeholder="name@example.com" name="login" value="" required>
                <label for="floatingInputEmail">Adresse mail</label>
              </div>

              

              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="mdp" value="">
                <label for="floatingPassword">Mot de passe</label>
                
              </div>

              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="confirm_mdp" value="">
                <label for="floatingPassword">confirmer le mot de passe</label>
                
              </div>

              <br>

              <div class="d-grid mb-2">
                <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit" name="valider">Valider</button>
              </div>              

              <hr class="my-4">

            

              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php

  /*if(verif_mdp(($_POST['mdp']),($_POST['confirm_mdp']))){
      echo"Les mots de passe sont identiques";
  } else{echo"Les mots de passe ne sont pas identiques";};*/
  

  if (isset($_POST['valider']) && (!empty($_POST['login'])) && (bon_mdp($_POST['mdp']))  && verif_mdp(($_POST['mdp']),($_POST['confirm_mdp'])))      /* && (bon_mdp($_POST['mdp']) && verif_mdp(($_POST['mdp']),($_POST['confirm_mdp'])))*/
  {
    
    $entrer = new Inserer($connex, $_POST['nom'], $_POST['prenom'], $_POST['login'], $_POST['mdp']); 
    //insert($connex, $_POST['nom'], $_POST['prenom'], $_POST['login'], $_POST['mdp']);  
    
  };

?>