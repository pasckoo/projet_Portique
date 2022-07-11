<?php
require_once('fonctions.php');
require_once('familles/famille.php');
require_once('modeles/modele.php');
require_once('secteurs/secteur.php');
require_once('periodicites/periodicite.php');
require_once('deconnexion.php');
require_once('controle.php');
require_once('controles/controle.php');
require_once('planning/planning.php');
require_once('utilisateurs.php'); // pour utiliser les modals supp, modif, ajout
require_once('modele.class.php');
require_once('tableauDeBord.php');





//On démarre une nouvelle session
//session_start();

// sécurité lien direct: On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['username'])) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: connexion.php');
  exit();
}else{/*$db->enregistrementLogin($_SESSION['username'],'connexion');*/} // enregistrement dans la table 'Login'

/*On utilise session_id() pour récupérer l'id de session s'il existe.
 *Si l'id de session n'existe  pas, session_id() rnevoie une chaine
 *de caractères vide*/
$id_session = session_id();
$imageSession = $_SESSION['image'];
$imageFond = $_SESSION['imageFond'];

//$_SESSION['titre'] = "Projet Gestion des Réglementaires";
$_SESSION['nbrLignesAffiche'] = 10;
//$_SESSION['image'] = '..\IMG\photos\6.png';

// pour voir si on est connecté autre que Utilisateur pour afficher des champs cachés
if($_SESSION['type'] > 0){
  $actif = "enable"; $visible = "visible";}else{$actif = "disabled"; $visible = "hidden";}

?>
<!DOCTYPE html>
<html lang='en'>

<head>
<meta charset="UTF-8" name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" integrity="sha384-ejwKkLla8gPP8t2u0eQyL0Q/4ItcnyveF505U0NIobD/SMsNyXrLti6CWaD0L52l" crossorigin="anonymous">

<link rel="stylesheet" href="../CSS/style.css">
<link rel="stylesheet" href="../CSS/chart.css">


<!-- Pour la pagination -->
<link href="https://unpkg.com/bootstrap-table@1.20.0/dist/bootstrap-table.min.css" rel="stylesheet">
<!--<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>-->
<!--<link rel = "stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap5.min.css">-->


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css"/>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="../JS/monscript.js"></script>
<script src="../JS/famille_script.js"></script> 
<script src="../JS/modele_script.js"></script>
<script src="../JS/secteur_script.js"></script>
<script src="../JS/periodicite_script.js"></script>
<script src="../JS/materiel_script.js"></script>
<script src="../JS/controle_script.js"></script>
<script src="../JS/planning_script.js"></script>

<title>
<?php echo $_SESSION['titre'];
$A= "";
if($_SESSION['type'] > 0){ $A="Administrateur ";}else{$A="Utilisateur ";};
?>
</title>
<head>
  
</head>
<body onload="voirTdb()">


<div class="container-fluid">

<!-- Barre de menu horizontale Login -->
  <div class="row text-light" id="menu_login">
    <nav class="navbar navbar-expand-lg  text-light rounded">
      <div class="container-fluid">
          <a class="navbar-brand text-light" href="#" type="" name="menuLoginTitre" id="menuLoginTitre"><h2 class="text-light"><?php echo $_SESSION['titre'];?></h2></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>  
      </div>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="width:400px">
      <p><h4><?php $date1 = date('Y-m-d'); setlocale(LC_TIME, "fr_FR", "French"); echo strftime("%A %d %B %G", strtotime($date1));?></h4></p>
      </ul>
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><p class="text-light text-center text-end"><?php echo $A; echo $_SESSION['username'];?></p>
        </li>        
    </ul>
      <div class="nav-item dropdown dropstart" style="width:120px">
              <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img id="img_titre" class="card-img-top" width=50 height=50  src="../IMG/photos/<?php echo $imageSession; ?>.png">
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalImages">Changer l'image</a></li> 
                <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalImages">Changer l'image de fond</a></li>                 
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#disconnect"><img src="../IMG/shutdown.png"/> Déconnexion</a></li>
              </ul>
      </div>
    </nav>
  </div>

  <!-- Barre de menu verticale Gauche -->
  <div class="row" style="height: 91vh">
    <div class="col-1  opacity-75 border border-dark" style="width: 13%" id="menu_vertical">
        <hr class="my-4">
        
        <!-- menu tableau de bord -->
          <div class="text-center ">
            <a class="btn btn-body text-dark fs-5 rounded fw-bold "  href="#" type="button" name="tdb" id="tdb"  value="Tableau de bord"> Tableau de bord </a>
              <hr class="my-4">
          </div>

        <!-- menu utilisateurs -->
              <?php if($_SESSION['type'] > 0){
                      echo '
                            <li class="nav-item dropdown p-1 ">
                              <a class="btn btn-body text-dark fw-bold rounded fs-5 dropdown-toggle link-right" href="#" name="menu_Dropdown" id="menu_Dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Utilisateurs
                              </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdown"> 
                                <li>
                                  <a class ="dropdown-item" href="#" type="submit" name="utilisateurs" id="utilisateurs" data-target="#">Liste des utilisateurs </a>  
                                </li>                  
                                <li>                  
                                  <a class=" dropdown-item" id="idJournalUsers" href="#" data-toggle="modal" data-target="#">Journal des connexions</a>                  
                                </li>
                              </ul>
                      
                            </li> 
        <hr class="my-4">';                
                        
                  }; ?>
        
        <!--Menu déroulant "Tables de base"-->                
                      <li class="nav-item dropdown p-1">
                        <a class="btn btn-body text-dark fw-bold rounded fs-5 dropdown-toggle link-light" href="#" name="menu_Dropdown" id="menu_Dropdown_base" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tables
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown"> 
                          <li>
                            <a class ="dropdown-item" href="#" type="submit" name="menu_familles" id="menu_familles" data-target="#">Familles </a>  
                          </li>
                          <li>
                            <a class ="dropdown-item" href="#" type="submit" name="menu_modeles" id="menu_modeles" data-target="#">Modèles </a>  
                          </li>                  
                          <li>                    
                            <a class=" dropdown-item" id="menu_secteurs" type="submit" name="menu_secteurs" href="#" data-target="#">Secteurs</a>                  
                          </li>
                          <li>                    
                            <a class=" dropdown-item" id="menu_perios" type="submit" name="menu_perios" href="#" data-target="#">Périodicités</a>                  
                          </li>
                          <li>                    
                            <a class=" dropdown-item" id="menu_planning" type="submit" name="menu_planning" href="#" data-target="#">Planning</a>                  
                          </li>
                        </ul>
                
                      </li>
        <hr class="my-4">
        <!--Menu déroulant "Matériel"-->  
                      <li class="nav-item dropdown dropdown p-1">
                      <a class="btn btn-body text-dark fw-bold rounded fs-5 dropdown-toggle link-light" href="#" name="menu_Dropdown_materiel" id="menu_Dropdown_materiel" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Matériel
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown"> 
                        <li>
                          <a class ="dropdown-item" href="#" type="submit" name="menu_listeMateriel" id="menu_listeMateriel" data-target="#">Liste du matériel </a>  
                        </li>
                        <li>
                          <a class ="dropdown-item" href="#" type="submit" name="menu_ajout_materiel" id="menu_ajout_materiel" data-target="#" <?php echo $visible ?>>Ajouter un nouveau matériel </a>  
                        </li>
                        
                      </ul>          
                    </li>
        <hr class="my-4">
        <!--Menu déroulant "Contrôle"-->  
                      <li class="nav-item dropdown dropdown p-1">
                      <a class="btn btn-body text-dark fw-bold rounded fs-5 dropdown-toggle link-light" href="#" name="menu_Dropdown_controle" id="menu_Dropdown_controle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Contrôles
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown"> 
                        <li>
                          <a class ="dropdown-item" href="#" type="submit" name="menu_listeControle" id="menu_listeControle" data-target="#">Contrôles réalisés </a>  
                        </li>
                        <li>
                          <a class ="dropdown-item" href="#" type="submit" name="menu_listeRetard" id="menu_listeRetard" data-target="#">Contrôles en retard </a>  
                        </li>
                        <li>
                          <a class ="dropdown-item" href="#" type="submit" name="menu_listeMois" id="menu_listeMois" data-target="#">Contrôles à 30 jours  </a>  
                        </li>
                        <li>
                          <a class ="dropdown-item" href="#" type="submit" name="menu_planifies" id="menu_planifies" data-target="#">Contrôles planifiés  </a>  
                        </li>
                        
                      </ul>
              
                    </li>
          <hr class="my-4">
            
    </div>
    <div class="col" id="showUsers">    
      <div class="row  p-0 bg-warning" id='' ></div>
      <div class="row  p-0" id='rowA'></div>
  </div>
</div> 
 
<!-- Chargement des Modals -->
<?php 
    
deconnecter();
changeImage();
changeFond();
AjoutFamille();
modif_famille();
AjoutModele();
modif_modele();
ajoutSecteur();
modif_Secteur();
ajoutPerio();
modif_perio();
ajoutControle();
modifControle();
ajoutPlanning();
modifPlanning();


?>
<script>

</script>

<div class="modal fade" id="ajoutUser" tabindex="-1" >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
          <img src="../IMG/user_plus.png"/> 
            <h3 class="modal-title mx-auto">Ajouter un utilisateur</h3>
            <button type="button" class="btn-close" data-dismiss="modal" id="closeUser"></i></button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body px-4">
          <form method="post" name="user_form_data" id="user_form_data" onsubmit="return ajout_user()">
    
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_nom" placeholder=""  name="ajout_nom" required >
            <label for="ajout_nom">Nom</label>
          </div>
          
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_prenom" placeholder=""  name="ajout_prenom" required >
            <label for="ajout_prenom">Prénom</label>
          </div>
    
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="ajout_login" placeholder=""  name="ajout_login" required >
            <label for="ajout_login">Adresse mail</label>
          </div>
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_fonction" placeholder=""  name="ajout_fonction" required>
            <label for="ajout_fonction">Fonction</label>
          </div>
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_mdp" placeholder="" name="ajout_mdp" value="Bonjour10%">
            <label for="ajout_mdp">Mot de passe</label>            
          </div>

          
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_confirm_mdp" placeholder="" name="ajout_confirm_mdp" value="Bonjour10%">
            <label for="ajout_confirm_mdp">confirmer le mot de passe</label>
            
          </div>
    
          <br>
    
          <div class="form-group p-3" >      
          <input type="submit" name="ajout_valider"  id="ajout_valider" class="btn btn-outline-primary btn-block form-control" value="VALIDER">
          </div>
    
        </form>
          
           
          <hr class="my-4">
            
        
          
          </div>      
        </div>
      </div>
    </div>

</body>
 <!-- jQuery library -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  
  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
  <!-- Pour la pagination -->
  <script type="text/javascript" src=" https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
  
  <script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<!--<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap5.min.js"></script>-->

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script>