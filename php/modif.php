<?php
require_once('fonctions.php');
require_once('modele.class.php');

//On démarre une nouvelle session
session_start(); // À placer obligatoirement avant tout code HTML.

// sécurité lien direct: On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['username'])) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: connexion.php');
  exit();
};
$id_session = session_id();
/*On utilise session_id() pour récupérer l'id de session s'il existe.
*Si l'id de session n'existe  pas, session_id() rnevoie une chaine
*de caractères vide*/
//$_SESSION['titre'] = "Projet Gestion des Réglementaires";
//$_SESSION['mdp'] = "Bonjour10%";


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset='utf-8'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
 integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" integrity="sha384-ejwKkLla8gPP8t2u0eQyL0Q/4ItcnyveF505U0NIobD/SMsNyXrLti6CWaD0L52l" crossorigin="anonymous">

<!-- Pour la pagination -->
<link href="https://unpkg.com/bootstrap-table@1.20.0/dist/bootstrap-table.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/> -->
<link rel = "stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="../CSS/style.css">


<title>Gestion des contrôles réglementaires</title>
</head>
<body class="modifBody" background="../IMG/fonds/0.jpg">

<header>
    
</header>
    <div class="container ">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card border-0 shadow  rounded-3 my-5"> 
            <div class="card-body p-4 p-sm-5">
              <h1 class="card-title text-center mb-1 fw-light fs-1">Gestion des contrôles réglementaires
              <hr class="my-2">
                <br>
                
                
            </h1>
              <h5 class="card-title text-center mb-5 fw-light"> Vous avez reçu un mot de passe provisoire, vous devez en changer, merci
              </h5>
              
              <form  method="post">
                
                <div class="form-floating mb-3">               
                  <input type="password" class="form-control" id="modif_password"  name="modif_password" required>                  
                    <label for="modif_password">Mot de passe provisoire</label>                
                </div>
                
  
                <div class="form-floating mb-3">               
                <input type="text" class="form-control" id="modif_newpassword"  name="modif_newpassword" required>                  
                  <label for="modif_newpassword">Nouveau mot de passe</label>                
                </div>

                <div class="form-floating mb-3">               
                  <input type="text" class="form-control" id="modif_confirm_password"  name="modif_confirm_password" required>                  
                    <label for="floatingPassword">Confirmation du mot de passe</label>                
                </div>
  
                <!-- bouton valider -->
                <div class="d-grid">
                  <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit" name="modif_valider"> Valider                  
                  </button>
                </div>
  
                <hr class="my-3">
                <div class="text-center"><a class="btn btn-outline-secondary" href="../index.php" role="button">Retour Indentification</a> 
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>
     

  
</body>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" 
  integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

  <script src="../JS/monscript.js"></script>

  <!-- Pour la pagination -->
  <script type="text/javascript" src=" https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
  <script type="text/javascript" src="DataTables/datatables.min.js"></script>
  
</html>

<?php
if (isset($_POST['modif_valider']) && (bon_mdp($_POST['modif_newpassword']))  && verif_mdp(($_POST['modif_newpassword']),($_POST['modif_confirm_password'])))      /* && (bon_mdp($_POST['mdp']) && verif_mdp(($_POST['mdp']),($_POST['confirm_mdp'])))*/
{
  $db = new database();
  
  $login = $_SESSION[('username')]; 
  $mdpUser = $_POST[('modif_password')]; 
  $new_mdp = $_POST[('modif_newpassword')];
  $db->modif_mdp($login, $new_mdp);
  echo'<script>document.location.href="../index.php"; </script>'; exit();
}
  

 

  
  

  
  

  
?>  