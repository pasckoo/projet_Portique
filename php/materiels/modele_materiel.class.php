<?php
require_once('../PDO_connexion.class.php');

date_default_timezone_set('UTC'); // adapter la date à la zone actuelle	

class Database_Materiel extends Connexion_PDO{
    public $CNX;
    
    public function __construct(){
      parent::__contruct();
        
      }

      // lecture de la table materiel
      public function read_materiel(){      
        $query = 'select
                      materiel.id_materiel, 
                      materiel.rep_materiel,
                      materiel.designation_materiel,
                      materiel.reference_materiel,
                      materiel.date_mes_materiel,
                      materiel.commentaire_materiel,
                      materiel.photo_materiel,
                      secteur.designation_secteur,
                      modele.type_modele,
                      famille.categorie_famille        
                  from materiel, secteur, modele, famille
                  where
                      materiel.id_secteur = secteur.id_secteur
                  and materiel.id_modele = modele.id_modele
                  and materiel.id_famille = famille.id_famille';
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // comptage des lignes table materiel
      public function totalRowCount(){
        $query = "SELECT * FROM materiel";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $t_rows = $stmt->rowCount();
        return $t_rows;
      }

      // ajout d'un matériel 
      public function enregistrement_materiel(
          $A_rep_materiel, $A_designation_materiel,
          $A_reference_materiel,$A_mes_materiel,
          $A_commentaire_materiel,
          $A_photo_materiel, $A_id_secteur,
          $A_id_famille, $A_id_modele){
            $req_ins="insert into materiel values (
            0,
          :rep_materiel,
          :designation_materiel,
          :reference_materiel,
          :mes_materiel,
          :commentaire_materiel,
          :photo_materiel,
          :id_secteur,
          :id_famille, 
          :id_modele
                  
          )";
        
        //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd        
        $res_ins=$this->CNX->prepare($req_ins);

        //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête         
        $res_ins->execute(array(
          ':rep_materiel'=> mb_strtoupper($A_rep_materiel, 'UTF-8'), // mise en mujuscule du repère
          ':designation_materiel'=> $A_designation_materiel,
          ':reference_materiel'=> $A_reference_materiel,
          ':mes_materiel'=> $A_mes_materiel, 
          ':commentaire_materiel'=> $A_commentaire_materiel,
          ':photo_materiel'=> $A_photo_materiel = basename($A_photo_materiel), // pour supprimer le C:\fakepath\ du chemin stocké dans myQSL
          ':id_secteur'=> $A_id_secteur, 
          ':id_famille'=> $A_id_famille, 
          ':id_modele'=> $A_id_modele 
                       
      
          ));
          
           //vérifier si la requête d'insertion a réussi
           if($this->CNX){
            return true;
            
          }else{
               
                
          }

   }

   // requete affichage d'un matériel dans le formulaire "Afficher un matériel" 
   public function getMaterielById($id_materiel){
     
    $query = "select
                  materiel.id_materiel, 
                  materiel.rep_materiel,
                  materiel.designation_materiel,
                  materiel.reference_materiel,
                  materiel.date_mes_materiel,
                  materiel.commentaire_materiel,
                  materiel.id_secteur,
                  materiel.id_famille,
                  materiel.id_modele,
                  modele.type_modele,
                  MIN(prochain_controle.prochain_controle) AS controleAvantLe                          
              from materiel, secteur, modele, famille, prochain_controle
              where
                  materiel.id_secteur = secteur.id_secteur
              and materiel.id_modele = modele.id_modele
              and materiel.id_famille = famille.id_famille
              and prochain_controle.rep_materiel = materiel.rep_materiel
              and id_materiel = :id_materiel";
                 
    $stmt = $this->CNX->prepare($query);
    $stmt->execute([':id_materiel'=>$id_materiel]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result;
    
  }

  // suppression d'un matériel
  public function deleteMateriel($id_materiel){
    $query = "DELETE FROM materiel WHERE id_materiel = :id_materiel";
    $stmt = $this->CNX->prepare($query);
    $stmt->execute([':id_materiel'=>$id_materiel]);
    return true;
  
  }

  public function updateMateriel($Mid_materiel,
                                 $Mrep_materiel,
                                 $Mdesignation_materiel,
                                 $Mreference_materiel,
                                 $Mmes_materiel,
                                 $Mcommentaire_materiel,
                                 $Mid_secteur,
                                 $Mid_famille,
                                 $Mid_modele
                                 ){

    $query = "UPDATE materiel SET
                id_materiel = :Mid_materiel,
                rep_materiel = :Mrep_materiel,
                designation_materiel = :Mdesignation_materiel,
                reference_materiel = :Mreference_materiel,  
                date_mes_materiel = :Mmes_materiel,                           
                commentaire_materiel = :Mcommentaire_materiel,
                id_secteur = :Mid_secteur,
                id_famille = :Mid_famille,
                id_modele = :Mid_modele
              WHERE id_materiel = :Mid_materiel";

        $stmt = $this->CNX->prepare($query);

        $stmt->execute([
          ':Mid_materiel'=>$Mid_materiel, 
          ':Mrep_materiel'=>mb_strtoupper($Mrep_materiel, 'UTF-8'), // mise en majuscucle
          ':Mdesignation_materiel'=>$Mdesignation_materiel, 
          ':Mreference_materiel'=>$Mreference_materiel,
          ':Mmes_materiel'=>$Mmes_materiel,            
          ':Mcommentaire_materiel'=>$Mcommentaire_materiel,
          ':Mid_secteur'=>$Mid_secteur, 
          ':Mid_famille'=>$Mid_famille,
          ':Mid_modele'=>$Mid_modele  
          ]);
          
    return true;     
  }

  


}