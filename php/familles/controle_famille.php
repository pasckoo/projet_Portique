<?php
/*---CONTROLE_FAMILLE.PHP---*/

require_once('modele_famille.class.php');

session_start();

$db_famille = new Database_Famille();



// Visualisation de la table famille
if(isset($_POST['listingFamille']) && ($_POST['listingFamille']  == 'voirFamille')){
  
  // on teste si on est admin pour afficher le bouton ajouter
  if($_SESSION['type'] > 0){
  echo'<script>
  var root = document.querySelector(":root"); 
  root.style.setProperty("--visible", "visible");
  </script>';}; 

    // affichage du bandeau titre supérieur
    echo'
    <div class="row bg-light border border-dark">
            <h1>Liste des familles</h1> 
        </div>';
        
    // affichage dans la page
    $output = '<div id="tableFamille></div>';
  echo'<div class="row  p-3 " id="showFamilles">';
    
    $data = $db_famille->read_famille();

    $toutesLignes = $db_famille->totalRowCount();
    
    if($toutesLignes > -1){
      $output = '';
      $output .= "<script>
      var tabFamille = $('#tableauFamille').DataTable(
        
        { 'columnDefs': [ { 'visible': true, 'targets': [0] }],
        
          order: [[0, 'desc']],
          dom: 'Bflrtpi', 
          buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
          {extend:'excel', text: 'EXCEL', title:'Liste des familles', filename:'Liste_familles', titleAttr:'Exporter vers Excel'},
          {extend:'csv', text: 'CSV', title:'Liste des familles', filename:'Liste_familles', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Liste des familles', messageTop:'Liste des familles de matériel', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste des familles', message:'Liste des familles de matériel', titleAttr:'imprimer la liste des familles de matériel' },
          'spacer','spacer', 'spacer',
          { text: 'AJOUTER UNE FAMILLE', action: function ( e, dt, node, config ) { $('#ajoutFamille').modal('show');}, titleAttr:'Ajouter une famille de matériel', className:'ajouter'}
           
                  ],             

          'language': {
            
            'lengthMenu': 'Affiche _MENU_ familles par page',
            'zeroRecords': 'Aucune famille à afficher',
            'info': 'Liste des _MAX_ familles page _PAGE_ sur _PAGES_',
            'count': '{total} found',

            'infoEmpty': 'Aucune famille à afficher',
            'infoFiltered': '(filtrée de _MAX_ familles)',
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
        id="tableauFamille" 
        data-toggle="table"
        
      >

      <!--<caption>Liste des familles</caption>-->
      <thead class="table-danger">
        <tr class="text-center">
          <th>ID</th>
          <th>Catégorie</th>
          <th>désignation</th>
          <th>Periodicité 1</th>
          <th>Periodicité 2</th>
          <th>Periodicité 3</th>';
          if($_SESSION["type"] > 0){$output .= '<th>Action</th>';};
        $output .= '</tr>
      </thead>
      <tbody>';
      echo'<div class="listeFamille row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"

      foreach($data as $row){ 
        $output .=' <tr class="text-center 1text-secondary" >
        <td>'.$row['id_famille'].'</td>
        <td>'.$row['categorie_famille'].'</td>
        <td>'.$row['designation_famille'].'</td>
        <td>'.$row['periodicite1_famille'].'</td>
        <td>'.$row['periodicite2_famille'].'</td>
        <td>'.$row['periodicite3_famille'].'</td>';

        if($_SESSION["type"] > 0){
          $output .= '<td>          
          <a href="#" title="Modifier cette famille" class="editBtn_famille text-primary "
          data-toggle="modal" data-target="#editModal_Famille" id="'.$row['id_famille'].'">
            <i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;
            
          <a href="#" title="Supprimer cette famille" class="suppBtn_Famille text-danger "
          data-toggle="modal" data-target="#suppModal_Famille" id="'.$row['id_famille'].'">
            <i class="bi bi-trash"></i></a>&nbsp;&nbsp;
          </td>
          </tr>';       
         };      
      }
      $output .= '</tbody></table>';
      echo $output;
      
    };
    
  
}

  // Ajout d'une famille
  if( isset( $_POST['Acategorie'])){

    $A_categorie = htmlspecialchars($_POST['Acategorie']);
    $A_designation = htmlspecialchars($_POST['Adesignation']);
    $A_perio1 = htmlspecialchars($_POST['Aperio1']);
    $A_perio2 = htmlspecialchars($_POST['Aperio2']);
    $A_perio3 = htmlspecialchars($_POST['Aperio3']);
    
    $db_famille->enregistrement_famille($A_categorie, $A_designation, $A_perio1, $A_perio2, $A_perio3);    
  }
    
//Recuperation des données pour les insérer dans le modal Suppression d'une famille
if(isset($_POST['supp_id_famille'])){  
  $id_famille = htmlentities($_POST['supp_id_famille']);
  $db_famille->deleteFamille($id_famille);
}

//Recuperation des données pour les insérer dans le modal Modification d'une famille
if(isset($_POST['edit_id_famille'])){
  $id_famille = $_POST['edit_id_famille'];
  $row = $db_famille->getFamilleById($id_famille);

  echo json_encode($row);// response retournée
}

// Modification de famille via le modal
if(isset($_POST['Mcategorie'])){
  $Mid = htmlentities($_POST['Mid']);
  $Mcategorie = htmlspecialchars($_POST['Mcategorie']);
  $Mdesignation = htmlspecialchars($_POST['Mdesignation']);
  $Mperio1 = htmlspecialchars($_POST['Mperio1']);
  $Mperio2 = htmlspecialchars($_POST['Mperio2']);
  $Mperio3 = htmlspecialchars($_POST['Mperio3']);
  
  
  $db_famille->updateFamille($Mid, $Mcategorie, $Mdesignation, $Mperio1, $Mperio2, $Mperio3);
}

?>