
<?php
require_once('PDO_connexion.class.php');
require_once('authentification.class.php');
require_once('Permission.class.php');
require_once('Mdp_Oublie.class.php');
require_once('Modif.class.php');
require_once('Insertion.class.php');
require_once('modele.class.php');




date_default_timezone_set('UTC'); // adapter la date à la zone actuelle	


$connex = new Connexion_PDO();

 

function bon_mdp($mdp){

	$majuscule = preg_match('@[A-Z]@', $mdp);
	$minuscule = preg_match('@[a-z]@', $mdp);
	$chiffre = preg_match('@[0-9]@', $mdp);
  $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
  $carac_special = preg_match($pattern, $mdp);
  
	
	if(!$majuscule || !$minuscule || !$chiffre || !$carac_special || strlen($mdp) < 8)
	{	
		echo'<script>document.location.href="connexion.php"; </script>'; exit(); 
   
	}
	else
		return true;
}

function deconnexion(){
  
  session_destroy(); //deruit la session  
  session_unset();  // supprime les variables de session
  
  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $url = "https"; 
  else
    $url = "http"; 
    
  // Ajoutez // à l'URL.
  $url .= "://"; 
    
  // Ajoutez l'hôte (nom de domaine, ip) à l'URL.
  $url .= $_SERVER['HTTP_HOST']; 
    
  // Ajouter l'emplacement de la ressource demandée à l'URL
 // $url .= $_SERVER['REQUEST_URI']; 
      
      
  // Afficher l'URL
  echo $url; 
  
  header("location:".$url."/Projet_PORTIQUE"); // on redirige vers "index.php" après la déconnexion
  
}

function verif_mdp($mdp, $confirm_mdp){
  if ( $mdp == $confirm_mdp){
          return true;}
      else{
        echo'<script>document.location.href="connexion.php"; </script>'; exit();;
      }; 
  
}


function en_tete(){
  if(($_SESSION['type'] == 1) && ($_SESSION["nom"] !='')){$droits = 'ADMINISTRATEUR';}else{$droits = 'UTILISATEUR';};
  $permission = new Permission();
  
function image(){
  $_SESSION['image'] = "../IMG/PHOTOS/3.png";

}         
  

  echo'<form method="post">';
  if($_SESSION['type'] == 1){}
    
  
}



if(isset($_POST['deco'])){ 
  deconnexion();
}

function controle_connex(){
  
}

?>