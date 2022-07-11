<?php
require_once('PDO_connexion.class.php');
class Authentification extends Connexion_PDO{
      
   public function __construct($CONNEX, $LOGIN, $MDP){
    parent::__contruct();
    //this->CNX = $CONNEX;
    $this->LOGIN = $LOGIN;
    $this->MDP = $MDP;
    $this->connexion_user();    
   } 
	  
    private function connexion_user(){
      
        //Création de la requête
        //$req_ins="select login_user, mdp_user, nom_user, prenom_user, type_user from user where login_user = :email and mdp_user = sha2(:mdp, 512)"; 
        $req_ins="select * from user where login_user = :email and mdp_user = sha2(:mdp, 512)"; 
        //Préparation de la requête grâce à la variable $connexion qui établit la connexion avec la bdd
        
        $res_ins=$this->CNX->prepare($req_ins); 
        
        //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête
        $res_ins->execute(array(':email'=> $this->LOGIN, ':mdp' => $this->MDP));                                                                                      	
        
        $sel=$res_ins->fetchAll();
        
      // Démarrage d'une session si $sel ramène 1 ligne
	    if(count($sel)==1){ 
        $_SESSION['username'] = $this->LOGIN;
        if($this->MDP == $_SESSION['mdp']){header('location: PHP/modif.php'); exit();}   
	        

        // Recherche dans la requete des valeurs 'nom_user' et 'prenom_user' et stockage dans $_SESSION
            foreach($sel as $donnees => $valeur){
          $_SESSION['nom'] = $valeur['nom_user'];
          $_SESSION['prenom'] = $valeur['prenom_user'];
          $_SESSION['type'] = $valeur['type_user'];
          $_SESSION['image'] = $valeur['image_user'];
          $_SESSION['imageFond'] = $valeur['fond_user'];   
          
           

        // Redirection vers le tableau de bord       
	        header("Location: php/tdb.php");
          exit();}
       }else{header("Location: php/connexion.php"); exit();}
      
            
    }
    
  
    
}

?>