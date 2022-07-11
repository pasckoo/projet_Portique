<?php
class Modif extends Connexion_PDO{   
    public function __construct($CONNEX, $NEW_MDP){
        parent::__contruct();
        $this->CONNEX = $CONNEX;       
        $this->NEW_MDP = $NEW_MDP;
        //$this->modif_mdp();    
       } 
          
    
         
}
?>