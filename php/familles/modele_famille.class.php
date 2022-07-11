<?php
require_once('../PDO_connexion.class.php');

date_default_timezone_set('UTC'); // adapter la date à la zone actuelle	

class Database_Famille extends Connexion_PDO{
    public $CNX;
    
    public function __construct(){
      parent::__contruct();
        
      }

      // lecture de la table famille
      public function read_famille(){      
        $data = array();
        $query = 'SELECT * FROM famille';
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // comptage des lignes table famille
      public function totalRowCount(){
        $query = "SELECT * FROM famille";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $t_rows = $stmt->rowCount();
        return $t_rows;
      }

    // ajout d'une famille  
      public function enregistrement_famille($categorie, $designation, $perio1, $perio2, $perio3){
         //Création de la requête d'insertion
         $req_ins="insert into famille values (0, :categorie, :designation, :perio1, :perio2, :perio3)";
         
         //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd        
         $res_ins=$this->CNX->prepare($req_ins);

         //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête         
         $res_ins->execute(array(':categorie'=> $categorie,
                                 ':designation'=> $designation,                                                      
                                 ':perio1'=> $perio1, 
                                 ':perio2'=>$perio2,                                                        
                                 ':perio3'=>$perio3
       
           ));
           
            //vérifier si la requête d'insertion a réussi
            if($this->CNX){
             return true;
             
           }else{
                
                 
           }

    }

    // suppression d'une famille
      public function deleteFamille($id_famille){
        $query = "DELETE FROM famille WHERE id_famille = :id_famille";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([':id_famille'=>$id_famille]);
        return true;
      
    }

    // modification d'une famille renvoi données à remplir
    public function getFamilleById($id_famille){
      $query = "SELECT * FROM famille WHERE id_famille = :id_famille";
      $stmt = $this->CNX->prepare($query);
      $stmt->execute([':id_famille'=>$id_famille]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function updateFamille($Mid, $Mcategorie, $Mdesignation, $Mperio1, $Mperio2, $Mperio3){
      $query = "UPDATE famille SET
       categorie_famille = :Mcat,
       designation_famille = :Mdesi,
       periodicite1_famille = :Mperio1,
       periodicite2_famille = :Mperio2, 
       periodicite3_famille = :Mperio3 
       WHERE id_famille = :Mid";

        $stmt = $this->CNX->prepare($query);

        $stmt->execute([
          ':Mid'=>$Mid,
          ':Mcat'=>$Mcategorie,
          ':Mdesi'=>$Mdesignation,
          ':Mperio1'=>$Mperio1,
          ':Mperio2'=>$Mperio2,
          ':Mperio3'=>$Mperio3        
          ]);
          return true;
    }
    
    
}




?>