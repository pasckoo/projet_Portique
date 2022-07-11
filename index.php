<?php
require_once('php/fonctions.php');


  //On démarre une nouvelle session
session_start(); // À placer obligatoirement avant tout code HTML.
$id_session = session_id();
/*On utilise session_id() pour récupérer l'id de session s'il existe.
 *Si l'id de session n'existe  pas, session_id() rnevoie une chaine
 *de caractères vide*/
$_SESSION['titre'] = "Gestion des contrôles réglementaires";
$_SESSION['mdp'] = "Bonjour10%";
$_SESSION['imageFond'] = "IMG/fonds/0.jpg";
?>
<!DOCTYPE html>

<html lang='fr'>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" integrity="sha384-ejwKkLla8gPP8t2u0eQyL0Q/4ItcnyveF505U0NIobD/SMsNyXrLti6CWaD0L52l" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/style.css">
  <script src="JS/monscript.js"></script>

  <title>Gestion des contrôles réglementaires</title>
</head>
<body class="indexBody" background="IMG/fonds/0.jpg">
  <div class="container ">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow  rounded-3 my-5"> 
          <div class="card-body p-4 p-sm-5">
            <h1 class="card-title text-center mb-1 fw-light fs-1"><?php echo $_SESSION['titre']; ?>
            <hr class="my-2">
              <br>
              
              
          </h1>
            <h5 class="card-title text-center mb-5 fw-light fs-3 bi bi-unlock"> Identification
            </h5>
            
            <form  method="post">
               
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="login" placeholder="name@example.com" name="login" value="" required>
                <label for="floatingInput">Adresse mail</label>
              </div>

              <div class="form-floating mb-3">               
              <input type="password" class="form-control" id="mdp" placeholder="Password" name="mdp" required>                  
                <label for="floatingPassword">Mot de passe</label>                
              </div>

              <!-- bouton valider -->
              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit" name="valider"> Valider                  
                </button>
              </div>

              <hr class="my-3">
              <div id="index_affiche"></div>
                
            </form>
          </div>
          <form>
            <br>
          <div class="text-center"><a type="link" href="PHP/oublie.php" class="btn btn-link" name="oublie">Mot de passe oublié ?</a></div>
          </form>
        </div>
      </div>
    </div>
    
  </div>
    
</body>

</html>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  
  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="JS/monscript.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php

if (isset($_POST['valider'])){

 
  if((isset($_POST['mdp'])) && (isset($_POST['login']))){
    //$connexion = $db->getUserByLogin($_POST['login'], $_POST['mdp']);
    //if($mdp = $_SESSION['mdp']){header('location: PHP/modif.php'); exit();}//else{$connexion = $db->getUserByLogin($_POST['login'], $_POST['mdp']);};
    $authentification_user = new Authentification($connex, $_POST['login'], $_POST['mdp']);
  }
  else{
    
    
    //$authentification_user = new Authentification($connex, $_POST['login'], $_POST['mdp']);
  }; 
  

}


?>