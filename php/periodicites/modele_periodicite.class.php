<?php
require_once('../PDO_connexion.class.php');

date_default_timezone_set('UTC'); // adapter la date à la zone actuelle	

class Database_Perio extends Connexion_PDO{
    public $CNX;
    
    public function __construct(){
      parent::__contruct();
        
      }

      // lecture de la table perio
      public function read_perio(){      
        $data = array();
        $query = 'SELECT * FROM perio';
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // comptage des lignes table perio
      public function totalRowCount(){
        $query = "SELECT * FROM perio";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $t_rows = $stmt->rowCount();
        return $t_rows;
      }

    // ajout d'une périodicité 
    public function enregistrement_perio($intitule_perio, $type_perio, $nb_perio, $commentaire_perio){
      //Création de la requête d'insertion
      $req_ins="insert into perio values (0, :intitule, :type, :nb, :commentaire)";
      
      //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd        
      $res_ins=$this->CNX->prepare($req_ins);

      //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête         
      $res_ins->execute(array(':intitule'=> $intitule_perio,
                              ':type' => $type_perio,
                              ':nb' => $nb_perio,                            
                              ':commentaire'=> $commentaire_perio 
                            ));
        
         //vérifier si la requête d'insertion a réussi
         if($this->CNX){
          return true;
          
        }else{
             
              
        }

    }

    // suppression d'une périodicité
    public function deletePerio($id_perio){
      $query = "DELETE FROM perio WHERE id_perio = :id_perio";
      $stmt = $this->CNX->prepare($query);
      $stmt->execute([':id_perio'=>$id_perio]);
      return true;
    
    }

    // modification d'une périodicité renvoi données à remplir
    public function getPerioById($id_perio){
      $query = "SELECT * FROM perio WHERE id_perio = :id_perio";
      $stmt = $this->CNX->prepare($query);
      $stmt->execute([':id_perio'=>$id_perio]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function updatePerio($Mid_perio, $Mintitule_perio, $Mtype_perio, $Mnb_perio, $Mcommentaire_perio){
      $query = "UPDATE perio SET
       intitule_perio = :Mintitule_perio,
       type_perio = :Mtype_perio,
       nb_perio = :Mnb_perio,
       commentaire_perio = :Mcommentaire_perio
       
       WHERE id_perio = :Mid_perio";

        $stmt = $this->CNX->prepare($query);

        $stmt->execute([
          ':Mid_perio'=>$Mid_perio,
          ':Mintitule_perio' =>$Mintitule_perio,
          ':Mtype_perio'=>$Mtype_perio,
          ':Mnb_perio'=>$Mnb_perio, 
          ':Mcommentaire_perio'=>$Mcommentaire_perio      
          ]);
          return true;
    }


}
?>