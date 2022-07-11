<?php
require_once('../PDO_connexion.class.php');

date_default_timezone_set('UTC'); // adapter la date à la zone actuelle	

class Database_planning extends Connexion_PDO{
    public $CNX;
    
    public function __construct(){
      parent::__contruct();
        
    }

    // lecture de la table planning
    public function read_planning(){      
        $data = array();
        $query = '  SELECT 
                        planning.id_modele,
                        Planning.id_perio,
                        modele.type_modele,
                        perio.intitule_perio
                    FROM planning, modele, perio
                    WHERE
                        planning.id_modele = modele.id_modele
                    AND planning.id_perio = perio.id_perio
    
                   ';        
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // lecture de la table planning pour 1 modèle
    public function read_planning_modele($id_modele){      
        $data = array();
        $query = '  SELECT 
                        planning.id_modele,
                        Planning.id_perio,
                        modele.type_modele,
                        perio.intitule_perio
                    FROM planning, modele, perio
                    WHERE
                        planning.id_modele = modele.id_modele
                    AND planning.id_perio = perio.id_perio
                    AND planning.id_modele = :id_modele    
                   ';        
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([':id_modele'=> $id_modele]);
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // comptage des lignes table planning
    public function totalRowCount(){
        $query = "SELECT * FROM planning";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $t_rows = $stmt->rowCount();
        return $t_rows;
    }

    // lecture de la table modele pour insertion dans select modele planning
    public function read_modele_for_planning(){      
        $data = array();
        $query = 'SELECT id_modele, type_modele  FROM modele';
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // lecture de la table perio pour insertion dans select perio planning
    public function read_perio_for_planning(){      
        $data = array();
        $query = 'SELECT id_perio, intitule_perio  FROM perio';
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // ajout d'un planning
    public function enregistrement_planning($A_id_modele_planning, $A_id_perio_planning){
        //Création de la requête d'insertion
        $req_ins="insert into planning values (:id_modele, :id_perio)";
        
        //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd        
        $res_ins=$this->CNX->prepare($req_ins);

        //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête         
        $res_ins->execute(array(':id_modele'=> $A_id_modele_planning,
                                ':id_perio'=> $A_id_perio_planning
                                     
          ));
          
           //vérifier si la requête d'insertion a réussi
           if($this->CNX){
            return true;
            
          }else{
               
                
          }

    }

    // modification d'une ligne planning (pour affichage dans modal modification)
    public function getPlanningById($edit_modele_planning, $edit_perio_planning){
        $query = "SELECT * FROM planning WHERE id_modele = :id_modele AND id_perio = :id_perio";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([':id_modele'=>$edit_modele_planning,
                        ':id_perio'=>$edit_perio_planning,
                ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Requête de mise à jour de la ligne contrôle
    public function update_planning($M_id_modele, $M_id_perio){

        $query = "UPDATE planning SET
                    id_modele = :Mid_modele,
                    id_perio = :Mid_perio
                    WHERE id_modele = :Mid_modele
                    AND id_perio = :Mid_perio";

        $stmt = $this->CNX->prepare($query);

        $stmt->execute([
        ':Mid_modele' => $M_id_modele,
        ':Mid_perio'=> $M_id_perio
        
        ]);

    return true;     
    }

    // suppression d'un planning
    public function deletePlanning($id_supp_modele, $id_supp_perio){
        $query = "DELETE FROM planning WHERE id_modele = :id_modele AND id_perio = :id_perio";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([':id_modele'=>$id_supp_modele,
                        ':id_perio' =>$id_supp_perio

                    ]);
        return true;
    
    }


}

?>