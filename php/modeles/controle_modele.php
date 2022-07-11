<?php
/*---CONTROLE_MODELE.PHP---*/

require_once('modele_modele.class.php');

session_start();

$db_modele = new Database_modele();



// Visualisation de la table modèle
if(isset($_POST['listingModele']) && ($_POST['listingModele']  == 'voirModele')){
  
  // on teste si on est admin pour afficher le bouton "ajouter un modèle"
  if($_SESSION['type'] > 0){
  echo'<script>
  var root = document.querySelector(":root"); 
  root.style.setProperty("--visible", "visible");
  </script>';}; 

    // affichage du bandeau titre supérieur
    echo'
    <div class="row bg-light border border-dark">
            <h1>Liste des modèles</h1> 
        </div>';
        
    // affichage dans la page
    $output = '<div id="tableModele></div>';
  echo'<div class="row  p-3 " id="showUserss">';
    
    $data = $db_modele->read_modele();

    $toutesLignes = $db_modele->totalRowCount();
    
    if($toutesLignes > -1){
      $output = '';
      $output .= "<script>
      var tabModele = $('#tableauModele').DataTable(
        
        { 'columnDefs': [ { 'visible': false, 'targets': [0] }],
        
          order: [[0, 'desc']],
          dom: 'Bflrtpi', 
          buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
          {extend:'excel', text: 'EXCEL', title:'Liste des modèles', filename:'Liste_modeles', titleAttr:'Exporter vers Excel'},
          {extend:'csv', text: 'CSV', title:'Liste des modèles', filename:'Liste_modeles', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Liste des modèless', messageTop:'Liste des modèles des familles de matériel', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste des modèles', message:'Liste des modèles des familles de matériel', titleAttr:'imprimer la liste des modèles' },
          'spacer','spacer', 'spacer',
          { text: 'AJOUTER UN MODELE', action: function ( e, dt, node, config ) { $('#ajoutModele').modal('show');}, titleAttr:'Ajouter un modèle', className:'ajouterModele'}
           
                  ],             

          'language': {
            
            'lengthMenu': 'Affiche _MENU_ modèles par page',
            'zeroRecords': 'Aucun modèle à afficher',
            'info': 'Liste des _MAX_ modèles page _PAGE_ sur _PAGES_',
            'count': '{total} found',

            'infoEmpty': 'Aucun modèle à afficher',
            'infoFiltered': '(filtrée de _MAX_ modèles)',
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
        id="tableauModele" 
        data-toggle="table"
        
      >

      <!--<caption>Liste des modèles</caption>-->
      <thead class="table-danger">
        <tr class="text-center">
          <th>ID</th>
          <th>Type</th>
          <th>Désignation</th>
          <th>Famille</th>';
          if($_SESSION["type"] > 0){$output .= '<th>Action</th>';};
        $output .= '</tr>
      </thead>
      <tbody>';
      echo'<div class="listeModele row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"

      foreach($data as $row){
        $getModeleSansPlanning = $db_modele->getModeleSansPlanning($row['id_modele']);
        if($getModeleSansPlanning == 0){$couleur="bg-danger";}else{$couleur="text-success";};
        $output .=' <tr class="text-center 1text-secondary" >
        <td>'.$row['id_modele'].'</td>
        <td>'.$row['type_modele'].'</td>
        <td>'.$row['designation_modele'].'</td>
        <td>'.$row['categorie_famille'].'</td>';

        if($_SESSION["type"] > 0){
          $output .= '<td>
          <a href="#" title="Si rouge: aucune périodicité de définie pour ce modèle'."\n".' Vous devez en définir afin de créer des contrôles" class="periodicites_modele text-primary "
          data-toggle="modal" data-target="#listePlanning" id="'.$row['id_modele'].'">
            <i class="bi bi-alarm '.$couleur.'"></i></a>&nbsp;&nbsp;
          
          <a href="#" title="Modifier ce modèle" class="editBtn_modele text-primary "
          data-toggle="modal" data-target="#editModal_Modele" id="'.$row['id_modele'].'">
            <i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;
            
          <a href="#" title="Supprimer ce modèle" class="suppBtn_Modele text-danger "
          data-toggle="modal" data-target="#suppModal_Modele" id="'.$row['id_modele'].'">
            <i class="bi bi-trash"></i></a>&nbsp;&nbsp;
          </td>
          </tr>';       
         };      
      }
      $output .= '</tbody></table>';
      echo $output;
      
    }; 
}

  // Ajout d'un modèle
  if( isset( $_POST['Atype_modele'])){
    
    $A_type_modele = htmlspecialchars($_POST['Atype_modele']);
    $A_designation_modele = htmlspecialchars($_POST['Adesignation_modele']);
    $Aid_famille_modele = htmlspecialchars($_POST['Aid_famille_modele']);
    
    $db_modele->enregistrement_modele($A_type_modele, $A_designation_modele, $Aid_famille_modele);    
  }
    
//Recuperation des données pour les insérer dans le modal Suppression d'un modèle
if(isset($_POST['supp_id_modele'])){  
  $id_modele = htmlentities($_POST['supp_id_modele']);
  $db_modele->deleteModele($id_modele);
}

//Recuperation des données pour les insérer dans le modal Modification d'un modèle
if(isset($_POST['edit_id_modele'])){
  $id_modele = $_POST['edit_id_modele'];
  $row = $db_modele->getModeleById($id_modele);

  echo json_encode($row);// response retournée
}

// Modification via le modal modèle
if(isset($_POST['Mtype_modele'])){
  $Mid_modele = htmlspecialchars($_POST['Mid_modele']);
  $Mtype_modele = htmlspecialchars($_POST['Mtype_modele']);
  $Mdesignation_modele = htmlspecialchars($_POST['Mdesignation_modele']);
  $Mid_famille_modele = htmlspecialchars($_POST['Mid_famille_modele']);  
  
  $db_modele->updateModele($Mid_modele, $Mtype_modele, $Mdesignation_modele, $Mid_famille_modele);
}

// remplissage select famille
if((isset($_POST['remplissage']) && ($_POST['remplissage']  == 'remplissage'))){
  
  // execution de la requete d'insertion des options select famille
  $data_select_famille = $db_modele->read_famille_for_modele();

  $remplissage = "<option></option>";
  
  foreach($data_select_famille as $row_famille){ 
    $remplissage .= '<option class="bg-warning" value="'.$row_famille['id_famille'].'">'.$row_famille['categorie_famille'].'</option>';    
  }  
  echo $remplissage;
}

// remplissage select secteur
if((isset($_POST['remplissage_secteur']) && ($_POST['remplissage_secteur']  == 'remplissage_secteur'))){
  
  // execution de la requete d'insertion des options select famille
  $data_select_secteur = $db_modele->read_secteur_for_modele();

  $remplissage_secteur = "<option></option>";
  
  foreach($data_select_secteur as $row_secteur){ 
    $remplissage_secteur .= '<option class="bg-warning" value="'.$row_secteur['id_secteur'].'">'.$row_secteur['designation_secteur'].'</option>';    
  }  
  echo $remplissage_secteur;
}

// remplissage select modele
if((isset($_POST['remplissage_modele']) && ($_POST['remplissage_modele']  == 'remplissage_modele'))){

  $id_famille = $_POST["id_famille"];
  
  // execution de la requete d'insertion des options select modele
  $data_select_modele = $db_modele->modeles__par_famille($id_famille);

  $remplissage_modele = "<option></option>";
  
  foreach($data_select_modele as $row_modele){ 
    $remplissage_modele .= '<option class="bg-warning" value="'.$row_modele['id_modele'].'">'.$row_modele['type_modele'].'</option>';    
  }  
  echo $remplissage_modele;
}


?>