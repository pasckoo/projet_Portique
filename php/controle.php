<?php
require_once('fonctions.php');
require_once('tableauDeBord.php');

session_start();

$db = new Database();
  
//Visualisation de l'ensemble de la table user
if(isset($_POST['listingBtn']) && ($_POST['listingBtn']  == 'view')){
  
  // on teste si on est admin pour afficher le bouton ajouter
  if($_SESSION['type'] > 0){
  echo'<script>
  var root = document.querySelector(":root"); 
  root.style.setProperty("--visible", "visible");
  </script>';};    

  // affichage du bandeau titre supérieur
  echo'
  <div class="row bg-light border border-dark">
          <h1>Liste des utilisateurs</h1> 
      </div>'; 
  
  // affichage dans la page    
  $output = '<div id="tableUser></div>';
  echo'<div class="row  p-3 " id="showUsers">';
    
    $data = $db->read();

    $toutesLignes = $db->totalRowCount();
    
    if($toutesLignes > 0){
      $output = '';
      $output .= "<script>
      
      $('#tableau').DataTable(
        
        { 'columnDefs': [ { 'visible': false, 'targets': [0] }],
        
          order: [[0, 'desc']],
          dom: 'Bflrtpi', 
          buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
          {extend:'excel', text: 'EXCEL', title:'Liste des utilisateurs', filename:'ListeUtilisateurs', titleAttr:'Exporter vers Excel'},
          {extend:'csv', text: 'CSV', title:'Liste des utilisateurs', filename:'ListeUtilisateurs', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Liste des utilisateurs', messageTop:'Ici le message à afficher', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste des utilisateurs', message:'Ici le message à afficher', titleAttr:'imprimer la liste des Utilisateurs' },
          'spacer', 'spacer', 'spacer',
          { text: 'AJOUTER UN UTILISATEUR', action: function ( e, dt, node, config ) { $('#ajoutUser').modal('show');}, titleAttr:'Ajouter un utilisateur', className:'ajouterUnUtilisateur'}
           
                  ],             

          'language': {
            
            'lengthMenu': 'Affiche _MENU_ utilisateurs par page',
            'zeroRecords': 'Aucun utilisateurs à afficher',
            'info': 'Liste des _MAX_ utilisateurs page _PAGE_ sur _PAGES_',
            'count': '{total} found',

            'infoEmpty': 'Aucun utilisateur à afficher',
            'infoFiltered': '(filtrée de _MAX_ utilisateurs)',
            'search': 'Rechercher',
            'paginate': {
                          'previous': 'Précédent',
                          'next' : 'Suivant'
                        }
            
        }
        
      } );

      </script>";

      $output .='
      <table 
        class="table
          caption-top
          table-striped
          table-ms
          table-bordered
          table-hover
          table-secondary" 
        id="tableau" 
        data-toggle="table"
        
      >

      <!--<caption>Liste des utilisateurs</caption>-->
      <thead class="table-dark">
        <tr class="text-center">
          <th>ID</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Login</th>
          <th>Fonction</th>
          <th>Date de création</th>
          <th>Type</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>';
      echo'<div class="listeConnexions  row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"

      foreach($data as $row){
        // on transforme le 0,1 en utilisateur admin
        $row['type_user'] == 0 ? $row['type_user']= 'utilisateur' : $row['type_user']="Admin";
        $row['type_user'] == 0 ? $types='"bi bi-lock"' : $types='"bi bi-unlock"';
        $date = date_create($row['date_crea_user']);
        $row['date_crea_user'] = date_format($date, 'd/m/Y');
        $output .=' <tr class="text-center 1text-secondary" >
        <td>'.$row['id_user'].'</td>
        <td>'.$row['nom_user'].'</td>
        <td>'.$row['prenom_user'].'</td>
        <td>'.$row['login_user'].'</td>
        <td>'.$row['fonction_user'].'</td>
        <td>'.$row['date_crea_user'].'</td>
        <td>'.$row['type_user'].'</td>
        <td>
        
        <a href="#" title="Droits Utilisateur" class=" permBtn  text-black"
          data-toggle="modal" data-target="#permModal" id="'.$row['id_user'].'">
          <i class='.$types.'></i></a>&nbsp;&nbsp;
        
        
  
        <a href="#" title="Modifier cet utilisateur" class="editBtn text-primary "
        data-toggle="modal" data-target="#editModal" id="'.$row['id_user'].'">
          <i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;
          
        <a href="#" title="Supprimer cet utilisateur" class="suppBtn text-danger "
        data-toggle="modal" data-target="#suppModal" id="'.$row['id_user'].'">
          <i class="bi bi-trash"></i></a>&nbsp;&nbsp;
      </td></tr>';
      }
    
      $output .= '</tbody></table>';
      echo $output;
      
    }else{
      echo '<h3 class="text-center text-secondary mt-5">Aucun utilisateur pour le moment</h3>';
      
    }
   

  }

//Recuperation des données pour les insérer dans le modal Modification

if(isset($_POST['edit_id'])){
  $id = $_POST['edit_id'];
  $row = $db->getUserById($id);

  echo json_encode($row);// response retournée
}

// Modification de user via le modal
if(isset($_POST['action']) && $_POST['action']=='update'){
  $id = htmlspecialchars($_POST['id']);
  $nom = htmlspecialchars($_POST['nom']);
  $prenom = htmlspecialchars($_POST['prenom']);
  $login = htmlspecialchars($_POST['login']);
  $fonction = htmlentities($_POST['fonction']);
  $date = htmlspecialchars($_POST['date']);
  $type = htmlspecialchars($_POST['type']);
  
  $db->update($id,$nom,$prenom,$login, $fonction, $date, $type);
}

// Ajout d'un utilisateur via le modal
/*if(isset($_POST['ajout_nom']) && $_POST['ajout_nom']=='ajout_nom'){
  $nom = htmlspecialchars($_POST['ajout_nom']);
  $prenom = htmlspecialchars($_POST['ajout_prenom']);
  $login = htmlspecialchars($_POST['ajout_login']);
  $mdp = htmlspecialchars($_POST['ajout_mdp']);

  
  $db->enregistrement_user($nom,$prenom,$login,$mdp);
}*/

//Recuperation des données pour les insérer dans le modal Suppression
  if(isset($_POST['supp_id'])){  
  $id = htmlentities($_POST['supp_id']);
  $db->delete($id);
} 
 
//Recuperation des données pour les insérer dans le modal permission
if(isset($_POST['perm_id'])){
  $id = $_POST['perm_id'];
  $row = $db->getUserById($id);
  echo json_encode($row);// response retournée
}

// Modification de user via le modal permission
if(isset($_POST['action']) && $_POST['action']=='updateperm'){
  $id = htmlentities($_POST['idperm']);
  $type = htmlentities($_POST['typeperm']);
  
  $db->updateperm($id, $type);
}

// Modification de user via le modal Image
if(isset($_POST['image_user'])){
  $login = $_SESSION['username'];
  $image = $_POST['image_user'];
  
  $db->updateImage($login, $image);
  $_SESSION['image'] = $image;
}

// Modification de user via le modal ImageFond
if(isset($_POST['imageFond_user'])){
  $login = $_SESSION['username'];
  $imageFond = $_POST['imageFond_user'];
  
  $db->updateImageFond($login, $imageFond);
  $_SESSION['imageFond'] = $imageFond;
}

// affichage du tableau de bord
if(isset($_POST['tdb']) && ($_POST['tdb']  == 'voir')){

  tableauDebord();  // appel dans le fichier tableauDeBord.php
 
}




//Visualisation du journal de connexion
if(isset($_POST['journalusers']) && ($_POST['journalusers']  == 'voirjournal')){
  
  echo'<div class="row bg-light border border-dark">
          <h1>Journal des connexions</h1>
      </div>
  <div class="row  p-3 id=rowServices" id="showUsers">';
  $output = '<div id="tableUser></div>';
  
  
    
    $data = $db->LireJournalUsers();
    
    
      $output = '';
      $output .= "<script>$('#journalUser').DataTable(
        { order: [[0, 'desc']],
          dom: 'Bfrltip',
          buttons: [
          {extend:'excel', text: 'EXCEL', title:'Journal des connexions', filename:'JournalConnexions', titleAttr:'Exporter vers Excel' },
          {extend:'csv', text: 'CSV', title:'Journal des connexions', filename:'JournalConnexions', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Journal des connexions', messageTop:'Ici le message à afficher', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Journal des connexions', message:'Ici le message à afficher', titleAttr:'imprimer le journal des connexions' },
          'spacer','spacer', 'spacer',
          { text: 'EFFACER LE JOURNAL', action: function ( e, dt, node, config ){}, attr:{id:'btneffacer', title:'Effacer le journal'}, className:'btn-danger' },
           
                  ],         


          
          'language': {
            'lengthMenu': 'Affiche _MENU_ connexions par page',
            'zeroRecords': 'Le journal est vide',
            'info': 'Journal des _MAX_ connexions page _PAGE_ sur _PAGES_',
            'infoEmpty': 'Aucune connexion à afficher',
            'infoFiltered': '(filtrée de _MAX_ utilisateurs)',
            'search': 'Rechercher',
            'paginate': {
                          'previous': 'Précédent',
                          'next' : 'Suivant'
                        }
            
          
        }
        
      } );

      </script>";

      $output .='
      <table 
        class="table
          caption-top
          table-striped
          table-lg
          table-bordered
          table-hover
          table-light" 
        id="journalUser" 
        data-toggle="table"
      >

      <!-- <caption>Journal des connexions</caption> -->
      <thead class=" table-dark ">
        <tr class="text-center">
          <th>ID</th>
          <th>Utilisateur</th>
          <th>Date et heures de connexion</th>
          <th>Connexion</th>
        </tr>
      </thead>
      <tbody>';
      echo'<div class="listeConnexions  row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"
      foreach($data as $row){
        // on transforme le 0,1 en utilisateur admin
        //$row['type_user'] == 0 ? $row['type_user']= 'utilisateur' : $row['type_user']="Admin";
        //$row['type_user'] == 0 ? $types='"bi bi-lock"' : $types='"bi bi-unlock"';
        $date = date_create($row['heure_login']);
        $row['heure_login'] = date_format($date, 'd/m/Y: H:i:s');
        $output .=' <tr class="text-center 1text-secondary" >
        <td>'.$row['id_login'].'</td>
        <td>'.$row['login_login'].'</td>
        <td>'.$row['heure_login'].'</td>
        <td>'.$row['type_login'].'</td>
        </tr>';
      }
    
      $output .= '</tbody></table>';
      echo $output;
  
      
    
}

// Vider le journal
if(isset($_POST['effacer']) && ($_POST['effacer']  == 'viderjournal')){ 
  $db->viderJournalUsers();   
  }

  // Ajout d'un utilisateur
  if( isset( $_POST['Aname'])){

    $A_nom = htmlspecialchars($_POST['Aname']);
    $A_prenom = htmlspecialchars($_POST['Aprenom']);
    $A_login = htmlspecialchars($_POST['Alogin']);
    $A_mdp = htmlspecialchars($_POST['Amdp']);
    $A_fonction = htmlspecialchars($_POST['Afonction']);
    
    $db->enregistrement_user($A_nom, $A_prenom, $A_login, $A_mdp, $A_fonction);
    
    
  }

  
?>