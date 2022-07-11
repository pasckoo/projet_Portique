<?php
require_once('../PDO_connexion.class.php');

date_default_timezone_set('UTC'); // adapter la date à la zone actuelle	

class Database_Modele extends Connexion_PDO{
    public $CNX;
    
    public function __construct(){
      parent::__contruct();
        
      }

      // lecture de la table modèle
      public function read_modele(){      
        $data = array();
        $query = 'select 
        modele.id_modele,
        modele.type_modele,
        modele.designation_modele,
        famille.categorie_famille
        from modele, famille 
        where
        modele.id_famille = famille.id_famille
        ';

        /*$query = 'SELECT * FROM modele';*/
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // comptage des lignes table modele
      public function totalRowCount(){
        $query = "SELECT * FROM modele";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $t_rows = $stmt->rowCount();
        return $t_rows;
      }

    // ajout d'un modèle 
      public function enregistrement_modele($type_modele, $designation_modele, $id_famille_modele){
         //Création de la requête d'insertion
         $req_ins="insert into modele values (0, :type_modele, :designation_modele, :id_famille_modele)";
         
         //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd        
         $res_ins=$this->CNX->prepare($req_ins);

         //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête         
         $res_ins->execute(array(':type_modele'=> $type_modele,
                                 ':designation_modele'=> $designation_modele,                                                      
                                 ':id_famille_modele'=> $id_famille_modele 
                                 
       
           ));
           
            //vérifier si la requête d'insertion a réussi
            if($this->CNX){
             return true;
             
           }else{
                
                 
           }

    }

    // suppression d'un modèle
      public function deleteModele($id_modele){
        $query = "DELETE FROM modele WHERE id_modele = :id_modele";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([':id_modele'=>$id_modele]);
        return true;
      
    }

    // modification d'un modèle (pour affichage dans modal modification)
    public function getModeleById($id_modele){
      $query = "SELECT * FROM modele WHERE id_modele = :id_modele";
      $stmt = $this->CNX->prepare($query);
      $stmt->execute([':id_modele'=>$id_modele]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function updateModele($Mid_modele, $Mtype_modele, $Mdesignation_modele, $Mid_famille_modele){
      $query = "UPDATE modele SET
       type_modele = :Mtype_modele,
       designation_modele = :Mdesignation_modele,
        id_famille = :Mid_famille_modele
       WHERE id_modele = :Mid_modele";

        $stmt = $this->CNX->prepare($query);

        $stmt->execute([
          ':Mid_modele'=>$Mid_modele,
          ':Mtype_modele'=>$Mtype_modele,
          ':Mdesignation_modele'=>$Mdesignation_modele,
          ':Mid_famille_modele'=>$Mid_famille_modele                 
          ]);
          return true;
    } 
    
    // lecture de la table famille pour insertion dans select famille
    public function read_famille_for_modele(){      
        $data = array();
        $query = 'SELECT DISTINCT id_famille, categorie_famille  FROM famille';
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // lecture de la table secteur pour insertion dans select secteur
    public function read_secteur_for_modele(){      
      $data = array();
      $query = 'SELECT DISTINCT id_secteur, designation_secteur  FROM secteur';
      $stmt = $this->CNX->prepare($query);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
  }

  // Requete pour affichage des modèles pour une famille sélectionnée
  public function modeles__par_famille($id_famille){      
    $data = array();
    $query = 'SELECT id_modele, type_modele FROM modele, famille WHERE famille.id_famille = modele.id_famille AND modele.id_famille = :id_famille';                           
    $stmt = $this->CNX->prepare($query);
    $stmt->execute(([
      ':id_famille'=> $id_famille               
      ]));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  
  // vérification des modèles sans planning
  public function getModeleSansPlanning($id_modele){
    $query = "SELECT planning.id_modele 
              FROM planning, modele 
              WHERE planning.id_modele = modele.id_modele
              AND modele.id_modele = :id_modele";
    $stmt = $this->CNX->prepare($query);
    $stmt->execute([':id_modele'=>$id_modele]);
    $result = $stmt->rowCount();
    return $result;
  }
}



?>