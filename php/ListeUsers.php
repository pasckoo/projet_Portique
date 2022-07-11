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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" integrity="sha384-ejwKkLla8gPP8t2u0eQyL0Q/4ItcnyveF505U0NIobD/SMsNyXrLti6CWaD0L52l" crossorigin="anonymous">
  <title>Exo2_Liste</title>
</head>
<header>
<?php en_tete('../IMG/shutdown.png', '../IMG/change_password.png','../IMG/listing.png'  );?>  <!-- affichage de l'en-tete -->
</header>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand p-2" href="#"><i class="bi bi-gem"></i>&nbsp;Diamind</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Accueil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Blog</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">A Propos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h4 class="text-center text-white font-weight-normal my-3 bg-dark">CRUD Biens à vendre Php Poo</h4>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">
      <h4 mt-2>Tous les articles en vente</h4>
    </div>
    <div class="col-lg-6">
      <button type="button" class="btn btn-info m-1 float-end" data-toggle="modal" data-target="#addModal">
        <i class="bi bi-archive-fill"></i>&nbsp;AJOUTER un nouvel article</button>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive" id="showUsers">
          <h3 class="text-center text-success" style="margin-top: 150px">Recupération des données en cours...</h3>
      </div>
    </div>
  </div>
</div>

  <!-- Modal Pour Modifier un  utilisateur  -->
  <div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title mx-auto">Modifier un  Article</h4>
          <button type="button" class="close" data-dismiss="modal"><i class="bi bi-x"></i></button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body px-4">
         <form action="" method="POST" id="edit-form-data">
           <input type="hidden" name="id" id="id">
                <div class="form-group p-2">
                  <input type="text" name="title" class="form-control" id="title" required>
                </div>

                <div class="form-group p-2">
                  <input type="text" name="description" class="form-control" id="description" required>
                </div>

                <div class="form-group p-2">
                  <input type="number" step="0.01" name="price" class="form-control" id="price" required>
                </div>

                <div class="form-group p-2">
                  <input type="text" name="author" class="form-control" id="author" required>
                </div>

                <div class="form-group p-2">
                  <input type="submit" name="update" id="update" value="VALIDER"
                  class="btn btn-outline-primary btn-block form-control">
                </div>
         </form>
        </div>      
      </div>
    </div>
  </div>

  <!-- Modal Pour Supprimer un  article  
  <div class="modal fade" id="suppModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
         Modal Header 
        <div class="modal-header">
          <h4 class="modal-title mx-auto">Supprimer un  Article</h4>
          <button type="button" class="close" data-dismiss="modal"><i class="bi bi-x"></i></button>
        </div>
        
          Modal body 
        <div class="modal-body px-4">
         <form action="" method="POST" id="supp-form-data">
           <input type="hidden" name="id" id="id">
           <div class="form-group p-2">
                  <input type="text" name="supp_id" class="form-control" id="supp_id">
                </div>

                <div class="form-group p-2">
                  <input type="text" name="supp_title" class="form-control" id="supp_title">
                </div>

                <div class="form-group p-2">
                  <input type="text" name="supp_description" class="form-control" id="supp_description">
                </div>

                <div class="form-group p-2">
                  <input type="number" step="0.01" name="supp_price" class="form-control" id="supp_price">
                </div>

                <div class="form-group p-2">
                  <input type="text" name="supp_author" class="form-control" id="supp_author">
                </div>

                <div class="form-group p-2">
                  <input type="submit" name="delete" id="delete" value="SUPPRIMER"
                  class="btn btn-outline-danger btn-block form-control">
                </div> -->
         </form>
        </div>      
      </div>
    </div>
  </div>
  

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  
  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="monscript.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>