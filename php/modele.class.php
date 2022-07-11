<?php
require_once('PDO_connexion.class.php');

date_default_timezone_set('UTC'); // adapter la date à la zone actuelle	

class Database extends Connexion_PDO{
    public $CNX;
    
    public function __construct(){
      parent::__contruct();
        
      }
    
    public function read(){
      
        $data = array();
        $query = 'SELECT 
                    id_user,
                    nom_user,
                    prenom_user,
                    login_user,
                    fonction_user,
                    date_crea_user,
                    type_user 
                  FROM user order by id_user desc';
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUserById($id){
        $query = "SELECT * FROM user WHERE id_user = :id";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([':id'=>$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
      }

      public function getUserByLogin($login, $mdp){
        $query = "SELECT * FROM user
                   WHERE login_user = :login 
                   AND mdp_user = sha2(:mdp, 512)";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([':login'=>$login,
                        ':mdp'=>$mdp
                        ]);
        $result = $stmt->rowCount();
        if($result == 1){return $result;}else{echo'<script>alert('.$result.')</script>'; exit();}
      }

      public function delete($id){
        $query = "DELETE FROM user WHERE id_user = :id";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([':id'=>$id]);
        return true;
        
      }
      
      public function update($id,$nom,$prenom,$login, $fonction, $date, $type){
        $query = "UPDATE user SET
                    nom_user = :nom,
                    prenom_user = :prenom,
                    login_user = :logine,
                    date_crea_user = :date_crea,
                    fonction_user = :fonction,
                    type_user = :typeperm 
                  WHERE id_user = :id";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([
          ':id'=>$id,
          ':nom'=>$nom,
          ':prenom'=>$prenom,
          ':logine'=>$login,
          ':fonction'=>$fonction,
          ':date_crea'=>$date,
          ':typeperm'=>$type         
          ]);
          return true;
      }

      public function updateperm($id, $type){
        $query = "UPDATE user SET type_user = :typeperm WHERE id_user = :id";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([
          ':id'=>$id,
          ':typeperm'=>$type         
          ]);
          return true;
      }
      
      public function updateImage($login, $image){
        $query = "UPDATE user SET image_user = :image WHERE login_user = :login";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([
          ':login'=>$login,
          ':image'=>$image        
          ]);
          return true;
      } 
      
      public function updateImageFond($login, $imageFond){
        $query = "UPDATE user SET fond_user = :imageFond WHERE login_user = :login";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute([
          ':login'=>$login,
          ':imageFond'=>$imageFond        
          ]);
          return true;
      }  


    public function totalRowCount(){
        $query = "SELECT * FROM user";
        $stmt = $this->CNX->prepare($query);
        $stmt->execute();
        $t_rows = $stmt->rowCount();
        return $t_rows;
      }

    public function enregistrement_user($nom, $prenom, $login, $mdp, $fonction){
        //Récup de la date d'aujourd'hui qui nous servira pour la requête d'insertion
        $date= new DateTime();
    
    //Création de la requête d'insertion
        $req_ins="insert into user values 
          (0, :nom, :prenom, :login, sha2(:mdp, 512), :fonction, :date_crea, :type_user, :image_user, :imageFond)";
    //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd
    
    $res_ins=$this->CNX->prepare($req_ins);
    //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête
    
    
    $res_ins->execute(array(':nom'=> $nom,
                            ':prenom'=> $prenom,
                            ':login'=> $login,                                                       
                            ':mdp'=> $mdp, 
                            ':fonction'=>$fonction,                                                        
                            ':date_crea'=>$date->format('Y-m-d'),
                            ':type_user' => 0,
                            ':image_user'=> 6,
                            ':imageFond'=> 4
                            
  
      ));
      
       //vérifier si la requête d'insertion a réussi
       if($this->CNX){
        return true;
        
      }else{
           
            
      }
      
    }
    
    public function enregistrementLogin($login, $type){
      //Récup de la date d'aujourd'hui qui nous servira pour la requête d'insertion
      date_default_timezone_set('Europe/Paris');
      $date1 = date('Y-m-d H:i:s');
    
      //Création de la requête d'insertion
          $req_ins="insert into loginusers values (0, :login, :heure_login, :type_login )";
      //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd
      
      $res_ins=$this->CNX->prepare($req_ins);
      //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête
      
      
      $res_ins->execute(array(':login'=> $login,
                              ':heure_login'=>$date1,
                              ':type_login'=>$type                              
    
        ));
         //vérifier si la requête d'insertion a réussi
        if($this->CNX){
          return true;
          
        }else{
          return false;    
              
        }


    }

    public function LireJournalUsers(){
      
      $data = array();
      $query = 'SELECT id_login, login_login, heure_login, type_login  FROM loginusers order by id_login desc';
      $stmt = $this->CNX->prepare($query);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    public function ViderJournalUsers(){
      
      $data = array();
      $query = 'DELETE FROM loginusers';
      $stmt = $this->CNX->prepare($query);
      $stmt->execute();
      return true;
    }

    public function totalRowConnexionCount(){
      $query = "SELECT * FROM loginusers";
      $stmt = $this->CNX->prepare($query);
      $stmt->execute();
      $t_rows = $stmt->rowCount();
      return $t_rows;
    }

    public function getUserByMdp($mdp){
      $query = "SELECT * FROM user WHERE mdp_user = sha2(:mdp, 512)";
      $stmt = $this->CNX->prepare($query);
      $stmt->execute([':mdp'=>$mdp]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    }


    public function modif_mdp($login, $new_mdp){
      
      
      //Création de la requête de modif 
      $req_update = 'update user set mdp_user = sha2(:new_mdp, 512) where login_user = :session'; 
      //Préparation de la requête grâce à la variable $co qui établit la connexion avec la bdd
      $res_update = $this->CNX->prepare($req_update);
      //Execution de la requête avec l'envoi du tableau contenant les données traitées dans la requête  
      $res_update -> execute(array(
                                  ':new_mdp'=> $new_mdp,
                                  ':session' => $login
                                  
                                  ));
      
      // vérifier si la requête update a réussi
      
      if($this->CNX){

          return true;
          
          }else{
              echo"Échec de l'opération d'insertion";
          }
                        
    }
    
    public function totalRetardCount(){
      $query = 'SELECT * FROM prochain_controle 
      WHERE prochain_controle < NOW()';
      $stmt = $this->CNX->prepare($query);
      $stmt->execute();
      $affiche = $stmt->rowCount();
      return $affiche;
    }

    public function controle30joursCount(){
      $query = 'SELECT * FROM prochain_controle 
      WHERE prochain_controle BETWEEN NOW() AND ADDDATE(NOW(), INTERVAL 30 DAY)
      ORDER BY prochain_controle';
      $stmt = $this->CNX->prepare($query);
      $stmt->execute();
      $affiche = $stmt->rowCount();
      return $affiche;
    }

    public function controleResteCount(){
      $query = 'SELECT * FROM prochain_controle 
      WHERE prochain_controle > ADDDATE(NOW(), INTERVAL 30 DAY) 
      ORDER BY prochain_controle';
      $stmt = $this->CNX->prepare($query);
      $stmt->execute();
      $affiche = $stmt->rowCount();
      return $affiche;
    }


    public function listeMaterielSansControle(){
      $query = 'SELECT  * FROM materiel
      WHERE  materiel.id_materiel NOT IN(
          SELECT id_materiel
          FROM controle
      )';
      $stmt = $this->CNX->prepare($query);
      $stmt->execute();
      $affiche = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $affiche; 

    }

    public function materielSansControle(){
      $query = 'SELECT  * FROM materiel
      WHERE  materiel.id_materiel NOT IN(
          SELECT id_materiel
          FROM controle
      )';
      $stmt = $this->CNX->prepare($query);
      $stmt->execute();
      $affiche = $stmt->rowCount();
      return $affiche; 

    }
    
}

?>