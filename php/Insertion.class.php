<?php
class Inserer extends Connexion_PDO{   
    public function __construct($NOM, $PRENOM, $LOGIN, $MDP){
        parent::__contruct();
        
        $this->NOM = $NOM;
        $this->PRENOM = $PRENOM;
        $this->LOGIN = $LOGIN;
        $this->MDP = $MDP;
        $this->enregistrement_user();    
       } 
          
    private function enregistrement_user(){
        //Récup de la date d'aujourd'hui qui nous servira pour la requête d'insertion
    $date= new DateTime();
    
    //Création de la requête d'insertion
    $req_ins="insert into user values (0, :nom, :prenom, :login, sha2(:mdp, 512), :date_crea, :type_user)";
    //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd
    
    $res_ins=$this->CNX->prepare($req_ins);
    //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête
    
    
    $res_ins->execute(array(':nom'=> $this->NOM,
                            ':prenom'=> $this->PRENOM,
                            ':login'=> $this->LOGIN,
                            ':mdp'=> $this->MDP,
                            ':date_crea'=>$date->format('Y-m-d'),
                            ':type_user' => 0
  
      ));
       //vérifier si la requête d'insertion a réussi
      if($this->CNX){
        //$_SESSION['username'] = $this->LOGIN;
	      header("Location: ../index.php");
        
      }else{
            echo"Échec de l'opération d'insertion";
            
      }
    }
       
    
}
  
?>