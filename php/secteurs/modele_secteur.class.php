<?php
require_once('../PDO_connexion.class.php');

date_default_timezone_set('UTC'); // adapter la date à la zone actuelle	

class Database_Secteur extends Connexion_PDO{
    public $CNX;
    
    public function __construct(){
      parent::__contruct();
        
      }

      // lecture de la table secteur
      public function read_secteur(){      
        $data = array();
        $query = 'SELECT * FROM secteur';
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // comptage des lignes table secteur
      public function totalRowCount(){
        $query = "SELECT * FROM secteur";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $t_rows = $stmt->rowCount();
        return $t_rows;
      }

    // ajout d'un secteur  
    public function enregistrement_secteur($designation, $commentaire){
      //Création de la requête d'insertion
      $req_ins="insert into secteur values (0, :designation, :commentaire)";
      
      //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd        
      $res_ins=$this->CNX->prepare($req_ins);

      //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête         
      $res_ins->execute(array(':designation'=> $designation,                                                      
                              ':commentaire'=> $commentaire 
                            ));
        
         //vérifier si la requête d'insertion a réussi
         if($this->CNX){
          return true;
          
        }else{
             
              
        }

    }

    // suppression d'un secteur
    public function deleteSecteur($id_secteur){
      $query = "DELETE FROM secteur WHERE id_secteur = :id_secteur";
      $stmt = $this->CNX->prepare($query);
      $stmt->execute([':id_secteur'=>$id_secteur]);
      return true;
    
    }

    // modification d'un secteur renvoi données à remplir
    public function getSecteurById($id_secteur){
      $query = "SELECT * FROM secteur WHERE id_secteur = :id_secteur";
      $stmt = $this->CNX->prepare($query);
      $stmt->execute([':id_secteur'=>$id_secteur]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function updateSecteur($Mid_secteur, $Mdesignation_secteur, $Mcommentaire_secteur){
      $query = "UPDATE secteur SET
       designation_secteur = :Mdesignation_secteur,
       commentaire_secteur = :Mcommentaire_secteur 
       WHERE id_secteur = :Mid_secteur";

        $stmt = $this->CNX->prepare($query);

        $stmt->execute([
          ':Mid_secteur'=>$Mid_secteur,
          ':Mdesignation_secteur'=>$Mdesignation_secteur,
          ':Mcommentaire_secteur'=>$Mcommentaire_secteur,      
          ]);
          return true;
    }


}



?>