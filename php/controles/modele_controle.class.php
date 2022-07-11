<?php
require_once('../PDO_connexion.class.php');

date_default_timezone_set('UTC'); // adapter la date à la zone actuelle	

class Database_Controle extends Connexion_PDO{
    public $CNX;
    
    public function __construct(){
      parent::__contruct();
        
    }

    // lecture de la table contrôle
    public function read_controle(){      
        $data = array();
        $query = 'SELECT 
                      controle.id_controle,
                      controle.date_controle,
                      materiel.rep_materiel,
                      perio.intitule_perio,
                      user.login_user,
                      controle.comment_controle,
                      CASE
                          WHEN perio.type_perio="jour" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  DAY) 
                          WHEN perio.type_perio="semaine" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  WEEK) 
                          WHEN perio.type_perio="mois" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  MONTH)        
                          WHEN perio.type_perio="annee" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  YEAR) 
                          END AS prochain_controle
                  FROM controle, materiel, user, perio
                  WHERE
                      controle.id_materiel = materiel.id_materiel
                  AND  controle.id_user = user.id_user
                  AND  controle.id_perio = perio.id_perio
                   ';
                  

        
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // comptage des lignes table modele
    public function totalRowCount(){
        $query = "SELECT * FROM controle";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $t_rows = $stmt->rowCount();
        return $t_rows;
    }

    // lecture de la table user pour insertion dans select controle_user
    public function read_user_for_controle(){      
        $data = array();
        $query = 'SELECT id_user, login_user  FROM user where fonction_user = "controleur"';
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // lecture de la table matériel pour insertion dans select controle_rep
    public function read_rep_for_controle(){      
        $data = array();
        $query = 'SELECT id_materiel, rep_materiel FROM materiel';
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // lecture de la table periodicite pour insertion dans select controle_type
    public function read_type_for_controle(){      
        $data = array();
        $query = 'SELECT id_perio, intitule_perio FROM perio order by id_perio';
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // lecture de la table planning pour insertion dans select controle_type
    public function read_planning_for_controle($idMateriel){      
      $data = array();
      $query = 'SELECT DISTINCT    
                    modele.id_modele,
                    planning.id_perio,
                    perio.intitule_perio
                FROM planning, modele, materiel, perio
                WHERE     
                    modele.id_modele = planning.id_modele
                AND perio.id_perio = planning.id_perio
                AND materiel.id_modele = modele.id_modele 
                AND materiel.id_materiel = :id_materiel
                order by id_modele asc';
      $stmt = $this->CNX->prepare($query);
      $stmt->execute([':id_materiel'=> $idMateriel]);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
  }

    // ajout d'un contrôle
    public function enregistrement_controle($A_date_controle, $A_rep_controle, $A_type_controle, $A_user_controle, $A_commentaire_controle){
        //Création de la requête d'insertion
        $req_ins="insert into controle values (0, :date_controle, :id_materiel, :type_controle, :id_user, :comment_controle, :date_controle)";
        
        //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd        
        $res_ins=$this->CNX->prepare($req_ins);

        //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête         
        $res_ins->execute(array(':date_controle'=> $A_date_controle,
                                ':id_materiel'=> $A_rep_controle,
                                ':type_controle'=> $A_type_controle,
                                ':id_user'=> $A_user_controle,
                                ':comment_controle'=> $A_commentaire_controle
                                     
          ));
          
           //vérifier si la requête d'insertion a réussi
           if($this->CNX){
            return true;
            
          }else{
               
                
          }

   }

   // modification d'un contrôle (pour affichage dans modal modification)
   public function getControleById($id_controle){
    $query = "SELECT * FROM controle WHERE id_controle = :id_controle";
    $stmt = $this->CNX->prepare($query);
    $stmt->execute([':id_controle'=>$id_controle]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  // récupération de rep_materiel(pour affichage dans modal ajout ccontrôle)
  public function getControleByRep_materiel($rep_materiel){
    $query = 'SELECT DISTINCT
                  materiel.id_materiel,
                  perio.id_perio   
              FROM prochain_controle, materiel, perio
              WHERE prochain_controle < NOW()
              AND prochain_controle.rep_materiel = materiel.rep_materiel
              AND prochain_controle.intitule_perio = perio.intitule_perio
              AND prochain_controle.rep_materiel = :rep_materiel';

    $stmt = $this->CNX->prepare($query);
    $stmt->execute([':rep_materiel'=>$rep_materiel]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  // suppression d'un controle
  public function deleteControle($id_controle){
    $query = "DELETE FROM controle WHERE id_controle = :id_controle";
    $stmt = $this->CNX->prepare($query);
    $stmt->execute([':id_controle'=>$id_controle]);
    return true;
  
  }

  // lecture de la table contrôle pour un matériel
  public function read_controleUnMateriel($ID_MAT){      
    $data = array();
    $query = '  SELECT 
                    controle.id_controle,
                    controle.date_controle,
                    materiel.rep_materiel,
                    perio.intitule_perio,
                    user.login_user,
                    controle.comment_controle,
                    CASE
                        WHEN perio.type_perio="jour" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  DAY ) 
                        WHEN perio.type_perio="semaine" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  WEEK ) 
                        WHEN perio.type_perio="mois" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  MONTH )       
                        WHEN perio.type_perio="annee" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  YEAR ) 
                        END AS prochain_controle
                FROM controle, materiel, user, perio
                WHERE
                    controle.id_materiel = materiel.id_materiel
                AND  controle.id_user = user.id_user
                AND  controle.id_perio = perio.id_perio
                AND  materiel.id_materiel = :id_materiel
               ';
              

    
    $stmt = $this->CNX->prepare($query);
    $stmt->execute([':id_materiel'=>$ID_MAT]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    
  }

  // Requête de mise à jour de la ligne contrôle
  public function update_controle($M_id_controle,
                                  $M_date_controle,
                                  $M_rep_controle, 
                                  $M_type_controle, 
                                  $M_user_controle, 
                                  $M_commentaire_controle
                                 ){

    $query = "UPDATE controle SET
                
                date_controle = :Mdate_controle,
                id_materiel = :Mid_materiel,
                id_perio = :Mid_perio,  
                id_user = :Mid_user,                           
                comment_controle = :Mcomment_controle
                
              WHERE id_controle = :Mid_controle";

        $stmt = $this->CNX->prepare($query);

        $stmt->execute([
          ':Mid_controle' => $M_id_controle,
          ':Mdate_controle'=>$M_date_controle,
          ':Mid_materiel'=>$M_rep_controle, 
          ':Mid_perio'=>$M_type_controle,
          ':Mid_user'=>$M_user_controle,            
          ':Mcomment_controle'=>$M_commentaire_controle  
          ]);
          
    return true;     
  }

public function affichage_controles($id_materiel){   
  $query = "SELECT rep_materiel FROM materiel WHERE id_materiel = :id_materiel";
  $stmt = $this->CNX->prepare($query);
  $stmt->execute([':id_materiel' =>$id_materiel]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;    
}

public function controleByIdPerio($id_controle){
  $query = 'SELECT
              perio.nb_perio AS Nb,
              perio.type_perio AS Type_perio
            FROM perio, controle
            WHERE controle.id_perio = perio.id_perio
            AND controle.id_controle = :id_controle ';
  $stmt = $this->CNX->prepare($query);
  $stmt->execute([':id_controle' =>$id_controle]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  return $result;

}

// modification matériel -> données à remplir dans le formulaire
public function getRecupRepereById($id_materiel){
  $query = "SELECT materiel.rep_materiel FROM materiel WHERE id_materiel = :id_materiel";
  $stmt = $this->CNX->prepare($query);
  $stmt->execute([':id_materiel'=>$id_materiel]);
  $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

  return $resultat;
}

// comptage du nombre de contrôles en retards
/*public function controle_retard(){
  $query = "SELECT COUNT(repere) FROM prochain_controle 
            WHERE prochain_controle < NOW()
            ORDER BY prochain_controle";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $t_rows = $stmt->rowCount();
        return $t_rows;

}*/

// afficher la table des contrôles en retards
public function voirRetardControles(){
  $query = 'SELECT * FROM prochain_controle 
  WHERE prochain_controle < NOW() 
  ORDER BY prochain_controle';
  $stmt = $this->CNX->prepare($query);
  $stmt->execute();
  $affiche = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $affiche;
}

public function VoirControles30jours(){
  $query = 'SELECT * FROM prochain_controle 
  WHERE prochain_controle BETWEEN NOW() AND ADDDATE(NOW(), INTERVAL 30 DAY)
  ORDER BY prochain_controle';
  $stmt = $this->CNX->prepare($query);
  $stmt->execute();
  $affiche = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $affiche;
}

public function VoirControlesPlanifies(){
  $query = 'SELECT * FROM prochain_controle';
  $stmt = $this->CNX->prepare($query);
  $stmt->execute();
  $affiche = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $affiche;
}

public function dates30Jours(){
  $query = 'SELECT NOW() AS now,ADDDATE(NOW(), INTERVAL 30 DAY) AS trente;';
  $stmt = $this->CNX->prepare($query);
  $stmt->execute();
  $affiche = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $affiche;
}



}