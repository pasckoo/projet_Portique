<?php
/*---CONTROLE_CONTROLE.PHP---*/

require_once('modele_controle.class.php');

session_start();

$db_controle = new Database_controle();


// Visualisation de la table contrôles réalisés
if(isset($_POST['listingControle']) && $_POST['listingControle']='voirControle'){
  
  // on teste si on est admin pour afficher le bouton "ajouter un contrôle"
  if($_SESSION['type'] > 0){
  echo'<script>
  var root = document.querySelector(":root"); 
  root.style.setProperty("--visible", "visible");
  </script>';}; 

    // affichage du bandeau titre supérieur
    

    echo'
    <div class="row bg-light border border-dark">
            <h1>Liste des contrôles réalisés</h1> 
        </div>';
        
    // affichage dans la page
    $output = '<div id="tableModele></div>';
  echo'<div class="row  p-3 " id="showUserss">';
    
    $data = $db_controle->read_controle();
    $toutesLignes = $db_controle->totalRowCount();
    
    
      $output = '';
      $output .= "<script>
      var tabControle = $('#tableauControle').DataTable(
        
        { 'columnDefs': [ { 'visible': false, 'targets': [0] }],
        
          order: [[0, 'desc']],
          dom: 'Bflrtpi', 
          buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
          {extend:'excel', text: 'EXCEL', title:'Liste des contrôles', filename:'Liste_controles', titleAttr:'Exporter vers Excel'},
          {extend:'csv', text: 'CSV', title:'Liste des contrôles', filename:'Liste_controles', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Liste des controles', messageTop:'Liste des contrôles des matériels', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste des contrôles', message:'Liste des contrôles des matériels', titleAttr:'imprimer la liste des contrôles' },
          'spacer','spacer', 'spacer',
          { text: 'AJOUTER UN CONTROLE REALISE', action: function ( e, dt, node, config ) { $('#ajoutControle').modal('show');
             remplissage_select_rep('ajout_controle_materiel');
              remplissage_select_user('ajout_controle_user');}, titleAttr:'Ajouter un contrôle', className:'ajouterControle'}
           
                  ],             

          'language': {
            
            'lengthMenu': 'Affiche _MENU_ contrôles par page',
            'zeroRecords': 'Aucun contrôle à afficher',
            'info': 'Liste des _MAX_ contrôles page _PAGE_ sur _PAGES_',
            'count': '{total} found',

            'infoEmpty': 'Aucun contrôle à afficher',
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
        id="tableauControle" 
        data-toggle="table"
        
      >

      <!--<caption>Liste des contrôles</caption>-->
      <thead class="table-primary">
        <tr class="text-center">
          <th>ID</th>
          <th>Date du contrôle</th>
          <th>Repère matériel</th>
          <th>Périodicité du contrôle</th>
          <th>Contrôleur</th>
          <th>Commentaire</th>
          <th>Date prochain contrôle</th>
          ';
          if($_SESSION["type"] > 0){$output .= '<th>Action</th>';};
        $output .= '</tr>
      </thead>
      <tbody>';
      echo'<div class="listeControles row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"

      foreach($data as $row){
        $date = date_create($row['date_controle']);
        $dateProchaine = date_create($row['prochain_controle']);
        $output .=' <tr class="text-center 1text-secondary" >
        <td>'.$row['id_controle'].'</td>
        
        <td>'.$row['date_controle']= date_format($date, 'd/m/Y').'</td>
        <td>'.$row['rep_materiel'].'</td>
        <td>'.$row['intitule_perio'].'</td>
        <td>'.$row['login_user'].'</td>
        <td>'.$row['comment_controle'].'</td>
        <td>'.$row['date_controle']= date_format($dateProchaine, 'd/m/Y').'</td>
        ';

        if($_SESSION["type"] > 0){
          $output .= '<td>          
          <a href="#" title="Modifier ce contrôle" class="editBtn_controle text-primary "
          data-toggle="modal" data-target="#modifControle" id="'.$row['id_controle'].'">
            <i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;
            
          <a href="#" title="Supprimer ce contrôle" class="suppBtn_Controle text-danger "
          data-toggle="modal" data-target="#suppModal_Controle" id="'.$row['id_controle'].'">
            <i class="bi bi-trash"></i></a>&nbsp;&nbsp;
          </td>
          </tr>';       
         };      
      }
      $output .= '</tbody></table>';
      echo $output;
      
     
}

// Visualisation de la table des contrôles en retard
if(isset($_POST['listingRetards']) && $_POST['listingRetards']='voirRetards'){
  
  // on teste si on est admin pour afficher le bouton "ajouter un contrôle"
  if($_SESSION['type'] > 0){
  echo'<script>
  var root = document.querySelector(":root"); 
  root.style.setProperty("--visible", "visible");
  </script>';}; 

    // affichage du bandeau titre supérieur
    echo'
    <div class="row bg-light border border-dark">
            <h1>Contrôles en retard</h1> 
        </div>';
        
    // affichage dans la page
    $output = '<div id="tableModele></div>';
  echo'<div class="row  p-3 " id="showUserss">';
    
    $data = $db_controle->voirRetardControles();
    //$toutesLignes = $db_controle->totalRowCount();
    
    
      $output = '';
      $output .= "<script>
      var tabRetard = $('#tableauRetard').DataTable(
        
        { 'columnDefs': [ { 'visible': true, 'targets': [0] }],
        
          order: [[0, 'desc']],
          dom: 'Bflrtpi', 
          buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
          {extend:'excel', text: 'EXCEL', title:'Liste des contrôles', filename:'Liste_controles', titleAttr:'Exporter vers Excel'},
          {extend:'csv', text: 'CSV', title:'Liste des contrôles', filename:'Liste_controles', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Liste des controles', messageTop:'Liste des contrôles des matériels', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste des contrôles', message:'Liste des contrôles des matériels', titleAttr:'imprimer la liste des contrôles' },
          'spacer','spacer', 'spacer'
          
           
                  ],             

          'language': {
            
            'lengthMenu': 'Affiche _MENU_ contrôles par page',
            'zeroRecords': 'Aucun contrôle à afficher',
            'info': 'Liste des _MAX_ contrôles page _PAGE_ sur _PAGES_',
            'count': '{total} found',

            'infoEmpty': 'Aucun contrôle à afficher',
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
        id="tableauRetard" 
        data-toggle="table"
        
      >

      <!--<caption>Liste des contrôles en retard</caption>-->
      <thead class="table-primary">
        <tr class="text-center">
          <th>Date maxi prévue</th>
          <th>Repère du matériel</th>
          <th>Catégorie matériel</th>
          <th>Type de matériel</th>
          <th>Périodicité</th>
          <th>Action</th>
          ';
          
        $output .= '</tr>
      </thead>
      <tbody>';
      echo'<div class="listeRetard row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"

      foreach($data as $row){
        
        $dateProchaine = date_create($row['prochain_controle']);
        $output .=' <tr class="text-center 1text-secondary" >
        <td>'.$row['prochain_controle']= date_format($dateProchaine, 'd/m/Y').'</td>
        <td>'.$row['rep_materiel'].'</td>
        <td>'.$row['categorie_famille'].'</td>
        <td>'.$row['type_modele'].'</td>
        <td>'.$row['intitule_perio'].'</td> 
        ';
        
        if($_SESSION["type"] > -1){
          $output .= '<td>          
          <a href="#" title="Réaliser ce contrôle" class="FaireBtn_controle text-primary "
          data-toggle="modal" data-target="#AjoutControle" id="'.$row['rep_materiel'].'">
            <i class="bi bi-ui-checks"></i></a>&nbsp;&nbsp;
            
          <!--<a href="#" title="Supprimer ce contrôle" class="suppBtn_Controle text-danger "
          data-toggle="modal" data-target="#suppModal_Controle" id="'.$row['rep_materiel'].'">
            <i class="bi bi-trash"></i></a>&nbsp;&nbsp;-->
          </td>
          </tr>';       
         };    
      }
      $output .= '</tbody></table>';
      echo $output;
      
     
}

// Visualisation de la table des contrôles à 30 jours
if(isset($_POST['listing30Jours']) && $_POST['listing30Jours']='voir30Jours'){
  
  // on teste si on est admin pour afficher le bouton "ajouter un contrôle"
  if($_SESSION['type'] > 0){
  echo'<script>
  var root = document.querySelector(":root"); 
  root.style.setProperty("--visible", "visible");
  </script>';}; 

    // affichage du bandeau titre supérieur avec les dates aujourd'hui et + 30 jours  
    $dates30jours = $db_controle->dates30Jours();
    foreach($dates30jours as $row){
      $now = $row['now']; $trente = $row['trente'];      
    }
    echo'
    <div class="row bg-light border border-dark">
            <h1>Contrôles planifiés à 30 jours<span class="span1">&nbsp &nbsp(du '.date("d/m/Y", strtotime($now)).' au '.date("d/m/Y", strtotime($trente)).')</span></h1> 
        </div>';
        
    // affichage dans la page
    $output = '<div id="tableModele></div>';
  echo'<div class="row  p-3 " id="showUserss">';
    
    $data = $db_controle->VoirControles30jours();
    //$toutesLignes = $db_controle->totalRowCount();
    
    
      $output = '';
      $output .= "<script>
      var tabRetard = $('#tableauRetard').DataTable(
        
        { 'columnDefs': [ { 'visible': true, 'targets': [0] }],
        
          order: [[0, 'asc']],
          dom: 'Bflrtpi', 
          buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
          {extend:'excel', text: 'EXCEL', title:'Liste des contrôles', filename:'Liste_controles', titleAttr:'Exporter vers Excel'},
          {extend:'csv', text: 'CSV', title:'Liste des contrôles', filename:'Liste_controles', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Liste des controles', messageTop:'Liste des contrôles des matériels', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste des contrôles', message:'Liste des contrôles des matériels', titleAttr:'imprimer la liste des contrôles' },
          'spacer','spacer', 'spacer'
          
           
                  ],             

          'language': {
            
            'lengthMenu': 'Affiche _MENU_ contrôles par page',
            'zeroRecords': 'Aucun contrôle à afficher',
            'info': 'Liste des _MAX_ contrôles page _PAGE_ sur _PAGES_',
            'count': '{total} found',

            'infoEmpty': 'Aucun contrôle à afficher',
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
        id="tableauRetard" 
        data-toggle="table"
        
      >

      <!--<caption>Liste des contrôles en retard</caption>-->
      <thead class="table-primary">
        <tr class="text-center">
          <th>Date maxi prévue</th>
          <th>Repère du matériel</th>
          <th>Catégorie matériel</th>
          <th>Type de matériel</th>
          <th>Périodicité</th>
          ';
          
        $output .= '</tr>
      </thead>
      <tbody>';
      echo'<div class="liste30jours row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"

      foreach($data as $row){
        
        $dateProchaine = date_create($row['prochain_controle']);
        $output .=' <tr class="text-center 1text-secondary" >
        <td>'.$row['prochain_controle']= date_format($dateProchaine, 'd/m/Y').'</td>
        <td>'.$row['rep_materiel'].'</td>
        <td>'.$row['categorie_famille'].'</td>
        <td>'.$row['type_modele'].'</td>
        <td>'.$row['intitule_perio'].'</td> 
        ';  
      }
      $output .= '</tbody></table>';
      echo $output;
      
     
}

// Visualisation de la table des contrôles planifiés
if(isset($_POST['listingPlanifies']) && $_POST['listingPlanifies']='voirPlanifies'){
  
  // on teste si on est admin pour afficher le bouton "ajouter un contrôle"
  if($_SESSION['type'] > 0){
  echo'<script>
  var root = document.querySelector(":root"); 
  root.style.setProperty("--visible", "visible");
  </script>';}; 

    // affichage du bandeau titre supérieur
    echo'
    <div class="row bg-light border border-dark">
            <h1>Contrôles planifiés</h1> 
        </div>';
        
    // affichage dans la page
    $output = '<div id="tableControlesPlanifies></div>';
  echo'<div class="row  p-3 " id="showUserss">';
    
    $data = $db_controle->VoirControlesPlanifies();
    //$toutesLignes = $db_controle->totalRowCount();
    
    
      $output = '';
      $output .= "<script>
      var tabPlanifies = $('#tableauPlanifies').DataTable(
        
        { 'columnDefs': [ { 'visible': true, 'targets': [0] }],
        
          order: [[0, 'asc']],
          dom: 'Bflrtpi', 
          buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
          {extend:'excel', text: 'EXCEL', title:'Liste des contrôles', filename:'Liste_controles', titleAttr:'Exporter vers Excel'},
          {extend:'csv', text: 'CSV', title:'Liste des contrôles', filename:'Liste_controles', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Liste des controles', messageTop:'Liste des contrôles des matériels', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste des contrôles', message:'Liste des contrôles des matériels', titleAttr:'imprimer la liste des contrôles' },
          'spacer','spacer', 'spacer'
          
           
                  ],             

          'language': {
            
            'lengthMenu': 'Affiche _MENU_ contrôles par page',
            'zeroRecords': 'Aucun contrôle à afficher',
            'info': 'Liste des _MAX_ contrôles page _PAGE_ sur _PAGES_',
            'count': '{total} found',

            'infoEmpty': 'Aucun contrôle à afficher',
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
        id="tableauPlanifies" 
        data-toggle="table"
        
      >

      <!--<caption>Liste des contrôles en retard</caption>-->
      <thead class="table-primary">
        <tr class="text-center">
          <th>Date maxi prévue</th>
          <th>Repère du matériel</th>
          <th>Catégorie matériel</th>
          <th>Type de matériel</th>
          <th>Périodicité</th>
          ';
          
        $output .= '</tr>
      </thead>
      <tbody>';
      echo'<div class="listePlanifies row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"

      foreach($data as $row){
        
        $dateProchaine = date_create($row['prochain_controle']);
        $output .=' <tr class="text-center 1text-secondary" >
        <td>'.$row['prochain_controle']= date_format($dateProchaine, 'd/m/Y').'</td>
        <td>'.$row['rep_materiel'].'</td>
        <td>'.$row['categorie_famille'].'</td>
        <td>'.$row['type_modele'].'</td>
        <td>'.$row['intitule_perio'].'</td> 
        ';  
      }
      $output .= '</tbody></table>';
      echo $output;
      
     
}



// remplissage select user contrôleur
if((isset($_POST['remplissage_controleur']) && ($_POST['remplissage_controleur']  == 'remplissageControleur'))){
  
  // execution de la requete d'insertion des options select famille
  $data_select_user = $db_controle->read_user_for_controle();

  $remplissage_user = "<option></option>";
  
  foreach($data_select_user as $row_user){ 
    $remplissage_user .= '<option class="bg-warning" value="'.$row_user['id_user'].'">'.$row_user['login_user'].'</option>';    
  }  
  echo $remplissage_user;
}

// remplissage select repere matériel
if((isset($_POST['remplissage_rep']) && ($_POST['remplissage_rep']  == 'remplissageRep'))){
  
  // execution de la requete d'insertion des options select repère
  $data_select_rep = $db_controle->read_rep_for_controle();

  $remplissage_rep = "<option></option>";
  
  foreach($data_select_rep as $row_rep){ 
    $remplissage_rep .= '<option class="bg-warning" value="'.$row_rep['id_materiel'].'">'.$row_rep['rep_materiel'].'</option>';    
  }  
  echo $remplissage_rep;
}

// remplissage select type matériel
if((isset($_POST['remplissage_type']) && ($_POST['remplissage_type']  == 'remplissageType'))){
  
  // execution de la requete d'insertion des options select type
  $data_select_type = $db_controle->read_type_for_controle();

  $remplissage_type = "<option></option>";
  
  foreach($data_select_type as $row_type){ 
    $remplissage_type .= '<option class="bg-warning" value="'.$row_type['id_perio'].'">'.$row_type['intitule_perio'].'</option>';    
  }  
  echo $remplissage_type;
}

// remplissage select type matériel/planning
if((isset($_POST['planning_id_materiel']))){
  $idMateriel = $_POST['planning_id_materiel'];
  // execution de la requete d'insertion des options select type
  $data_select_planning = $db_controle->read_planning_for_controle($idMateriel);

  $remplissage_planning = "<option></option>";
  
  foreach($data_select_planning as $row_planning){ 
    $remplissage_planning .= '<option class="bg-warning" value="'.$row_planning['id_perio'].'">'.$row_planning['intitule_perio'].'</option>';    
  }  
  echo $remplissage_planning;
}



// Ajout d'un contrôle
if( isset( $_POST['Arep_controle'])){
  $A_date_controle = htmlspecialchars($_POST['Adate_controle']); 
  $A_rep_controle = htmlspecialchars($_POST['Arep_controle']);
  $A_type_controle = htmlspecialchars($_POST['Atype_controle']);
  $A_user_controle = htmlspecialchars($_POST['Auser_controle']);
  $A_commentaire_controle = htmlspecialchars($_POST['Acommentaire_controle']);

  // recuperation de l'id_controle et 
  $recup =  $db_controle->enregistrement_controle($A_date_controle, $A_rep_controle, $A_type_controle, $A_user_controle, $A_commentaire_controle); 
  //$Nb = $result[0]['Nb'];
  //$type_perio = $result[1]['Type_perio'];   
}

// Modif d'un contrôle
if( isset( $_POST['Mid_controle'])){
  $M_id_controle = htmlspecialchars($_POST['Mid_controle']); 
  $M_date_controle = htmlspecialchars($_POST['Mdate_controle']); 
  $M_rep_controle = htmlspecialchars($_POST['Mrep_controle']);
  $M_type_controle = htmlspecialchars($_POST['Mtype_controle']);
  $M_user_controle = htmlspecialchars($_POST['Muser_controle']);
  $M_commentaire_controle = htmlspecialchars($_POST['Mcommentaire_controle']);
    
  $db_controle->update_controle($M_id_controle, $M_date_controle, $M_rep_controle, $M_type_controle, $M_user_controle, $M_commentaire_controle);
}

//Recuperation des données pour les insérer dans le modal Modification d'un contrôle
if(isset($_POST['edit_id_controle'])){
  $id_controle = $_POST['edit_id_controle'];
  $row = $db_controle->getControleById($id_controle);

  echo json_encode($row);// response retournée
}

//Recuperation de "rep_materiel" pour insertion dans le modal ajout d'un contrôle
if(isset($_POST['rep_materiel'])){
  $rep_materiel = $_POST['rep_materiel'];
  $row = $db_controle->getControleByRep_materiel($rep_materiel);

  echo json_encode($row);// response retournée
}

//Recuperation des données pour les insérer dans le modal Suppression d'un contrôle
if(isset($_POST['supp_id_controle'])){  
  $id_controle = htmlentities($_POST['supp_id_controle']);
  $db_controle->deleteControle($id_controle);
}




?>