<?php
/*---CONTROLE_CONTROLE.PHP---*/

require_once('modele_planning.class.php');

session_start();

$db_planning = new Database_planning();


// Visualisation de la table contrôle
if(isset($_POST['listingPlanning']) && ($_POST['listingPlanning']  == 'voirPlanning')){
  
  // on teste si on est admin pour afficher le bouton "ajouter un contrôle"
  if($_SESSION['type'] > 0){
  echo'<script>
  var root = document.querySelector(":root"); 
  root.style.setProperty("--visible", "visible");
  </script>';}; 

    // affichage du bandeau titre supérieur
    echo'
    <div class="row bg-light border border-dark">
            <h1>Planning</h1> 
        </div>';
        
    // affichage dans la page
    $output = '<div id="tablePlanning></div>';
  echo'<div class="row  p-3 " id="showUserss">';
    
    if(isset($_POST['id_modele'])){$data = $db_planning->read_planning_modele($_POST['id_modele']);}
    else{$data = $db_planning->read_planning();};

    $toutesLignes = $db_planning->totalRowCount();
    
    
      $output = '';
      $output .= "<script>
      var tabPlanning = $('#tableauPlanning').DataTable(
        
        { 'columnDefs': [ { 'visible': false, 'targets': [0, 1] }],
        
          order: [[0, 'desc']],
          dom: 'Bflrtpi', 
          buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
          {extend:'excel', text: 'EXCEL', title:'Liste planning', filename:'Liste_planning', titleAttr:'Exporter vers Excel'},
          {extend:'csv', text: 'CSV', title:'Liste planning', filename:'Liste_planning', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Liste planning', messageTop:'Liste planning', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste planning', message:'Liste planning', titleAttr:'imprimer le planning' },
          'spacer','spacer', 'spacer',
          { text: 'AJOUTER UNE PERIODICITE', action: function ( e, dt, node, config ) { $('#ajoutPlanning').modal('show');
           }, titleAttr:'Ajouter une périodicité', className:'ajouterPlanning'}
           
                  ],             

          'language': {
            
            'lengthMenu': 'Affiche _MENU_ planning par page',
            'zeroRecords': 'Aucun planning à afficher',
            'info': 'Liste des _MAX_ planning page _PAGE_ sur _PAGES_',
            'count': '{total} found',

            'infoEmpty': 'Aucun planning à afficher',
            'infoFiltered': '(filtrée de _MAX_ contrôles)',
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
        id="tableauPlanning" 
        data-toggle="table"
        
      >

      <!--<caption>Planning</caption>-->
      <thead class="table-primary">
        <tr class="text-center">
          <th>id_modèle</th> 
          <th>id_perio</th> 
          <th>Modèle</th>
          <th>Périodicité</th>
         ';
          if($_SESSION["type"] > 0){$output .= '<th>Action</th>';};
        $output .= '</tr>
      </thead>
      <tbody>';
      echo'<div class="listePlanning row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"

      foreach($data as $row){
        
        $output .=' <tr class="text-center 1text-secondary" >
        <td>'.$row['id_modele'].'</td>
        <td>'.$row['id_perio'].'</td>
        <td>'.$row['type_modele'].'</td>
        <td>'.$row['intitule_perio'].'</td>
        ';

        if($_SESSION["type"] > 0){
          $output .= '<td>          
          <a href="#" title="Modifier cette ligne" class="editBtn_planning text-primary "
          data-toggle="modal" data-target="#modifPlanning" id="'.$row['id_modele'].'-'.$row['id_perio'].'">
            <i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;
            
          <a href="#" title="Supprimer cette ligne" class="suppBtn_planning text-danger "
          data-toggle="modal" data-target="#suppModal_planning" id="'.$row['id_modele'].'-'.$row['id_perio'].'">
            <i class="bi bi-trash"></i></a>&nbsp;&nbsp;
          </td>
          </tr>';       
         };      
      }
      $output .= '</tbody></table>';
      echo $output;
      
     
}

// remplissage select modele planning
if((isset($_POST['remplissage_modele_planning']) && ($_POST['remplissage_modele_planning']  == 'remplissageModele'))){
  
    // execution de la requete d'insertion des options select modele
    $data_modele_planning = $db_planning->read_modele_for_planning();
  
    $remplissage_modele_planning = "<option></option>";
    
    foreach($data_modele_planning as $row_modele_planning){ 
      $remplissage_modele_planning .= '<option class="bg-warning" value="'.$row_modele_planning['id_modele'].'">'.$row_modele_planning['type_modele'].'</option>';    
    }  
    echo $remplissage_modele_planning;
}

// remplissage select perio planning
if((isset($_POST['remplissage_perio_planning']) && ($_POST['remplissage_perio_planning']  == 'remplissagePerio'))){
  
    // execution de la requete d'insertion des options select modele
    $data_perio_planning = $db_planning->read_perio_for_planning();
  
    $remplissage_perio_planning = "<option></option>";
    
    foreach($data_perio_planning as $row_perio_planning){ 
      $remplissage_perio_planning .= '<option class="bg-warning" value="'.$row_perio_planning['id_perio'].'">'.$row_perio_planning['intitule_perio'].'</option>';    
    }  
    echo $remplissage_perio_planning;
}

// Ajout d'une ligne planning
if( isset( $_POST['Aid_modele_planning'])){
    $A_id_modele_planning = htmlspecialchars($_POST['Aid_modele_planning']); 
    $A_id_perio_planning = htmlspecialchars($_POST['Aid_perio_planning']);
          
    $db_planning->enregistrement_planning($A_id_modele_planning, $A_id_perio_planning);    
}

//Recuperation des données pour les insérer dans le modal Modification d'une ligne planning
if(isset($_POST['edit_modele'])){
    $edit_modele_planning = $_POST['edit_modele'];
    $edit_perio_planning = $_POST['edit_perio'];
    $row = $db_planning->getPlanningById($edit_modele_planning, $edit_perio_planning);
  
    echo json_encode($row);// response retournée
}
  
// Mise à jour d'un planning
if( isset( $_POST['Mid_modele'])){
    $M_id_modele = htmlspecialchars($_POST['Mid_modele']); 
    $M_id_perio = htmlspecialchars($_POST['Mid_perio']); 
      
    $db_planning->update_planning($M_id_modele, $M_id_perio);
  }

//Recuperation des données pour les insérer dans le modal Suppression d'un contrôle
if(isset($_POST['supp_modele']) && isset($_POST['supp_perio'])){  
    $id_supp_modele = htmlentities($_POST['supp_modele']);
    $id_supp_perio = htmlentities($_POST['supp_perio']);
    $db_planning->deletePlanning($id_supp_modele, $id_supp_perio);
  }
  


?>