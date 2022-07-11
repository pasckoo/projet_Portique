<?php
class Mdp_Oublie extends Connexion_PDO{   
    public function __construct($CONNEX, $LOGIN){
        parent::__contruct();
        $this->CONNEX = $CONNEX;       
        $this->LOGIN = $LOGIN;
        $this->oublie();    
       } 
          
    private function oublie(){
        
        // Génération d'un mot de passe provisoire
        $mdp_provisoire = 'Bonjour10%';
        
        //Création de la requête d'update
        $req_update = 'update user set mdp_user = sha2(:new_mdp, 512) where login_user = :login'; 
        //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd
        
        $res_update=$this->CNX->prepare($req_update);
        //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête
            
        $res_update->execute(array(':login'=> $this->LOGIN,
                                ':new_mdp'=> $mdp_provisoire
                                
        ));
        // vérifier si la requête d'insertion a réussi
        if($this->CNX){
            $_SESSION['username'] = $this->LOGIN;
            header("Location: ../index.php");
        }        
    
}

    
    
}
?>