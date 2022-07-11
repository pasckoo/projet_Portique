<?php
/*---CONTROLE_SECTEUR.PHP---*/

require_once('modele_secteur.class.php');

session_start();

$db_secteur = new Database_Secteur();



// Visualisation de la table famille
if(isset($_POST['listingSecteur']) && ($_POST['listingSecteur']  == 'voirSecteur')){
  
  // on teste si on est admin pour afficher le bouton ajouter
  if($_SESSION['type'] > 0){
  echo'<script>
  var root = document.querySelector(":root"); 
  root.style.setProperty("--visible", "visible");
  </script>';}; 

    // affichage du bandeau titre supérieur
    echo'
    <div class="row bg-light border border-dark">
            <h1>Liste des secteurs</h1> 
        </div>';
        
    // affichage dans la page
    $output = '<div id="tableSecteur></div>';
  echo'<div class="row  p-3 " id="showUsers">';
    
    $data = $db_secteur->read_secteur();

    $toutesLignes = $db_secteur->totalRowCount();
    
    if($toutesLignes > -1){
      $output = '';
      $output .= "<script>
      var tabSecteur = $('#tableauSecteur').DataTable(
        
        { 'columnDefs': [ { 'visible': true, 'targets': [0] }],
        
          order: [[0, 'desc']],
          dom: 'Bflrtpi', 
          buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
          {extend:'excel', text: 'EXCEL', title:'Liste des secteurs', filename:'Liste_secteurs', titleAttr:'Exporter vers Excel'},
          {extend:'csv', text: 'CSV', title:'Liste des secteurs', filename:'Liste_secteurs', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Liste des secteurs', messageTop:'Liste des secteurs', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste des secteurs', message:'Liste des secteurs', titleAttr:'imprimer la liste des secteurs' },
          'spacer','spacer', 'spacer',
          { text: 'AJOUTER UN SECTEUR', action: function ( e, dt, node, config ) { $('#ajoutSecteur').modal('show');}, titleAttr:'Ajouter un secteur', className:'ajouterSecteur'}
           
                  ],             

          'language': {
            
            'lengthMenu': 'Affiche _MENU_ secteurs par page',
            'zeroRecords': 'Aucun secteur à afficher',
            'info': 'Liste des _MAX_ secteurs page _PAGE_ sur _PAGES_',
            'count': '{total} found',

            'infoEmpty': 'Aucun secteur à afficher',
            'infoFiltered': '(filtrée de _MAX_ secteurs)',
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
        id="tableauSecteur" 
        data-toggle="table"
        
      >

      <!--<caption>Liste des secteurs</caption>-->
      <thead class="table-danger">
        <tr class="text-center">
          <th>ID</th>
          <th>Désignation</th>
          <th>Commentaire</th> ';
          if($_SESSION["type"] > 0){$output .= '<th>Action</th>';};
        $output .= '</tr>
      </thead>
      <tbody>';
      echo'<div class="listeSecteur row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"

      foreach($data as $row){ 
        $output .=' <tr class="text-center 1text-secondary" >
        <td>'.$row['id_secteur'].'</td>
        <td>'.$row['designation_secteur'].'</td>
        <td>'.$row['commentaire_secteur'].'</td>';

        if($_SESSION["type"] > 0){
          $output .= '<td>          
          <a href="#" title="Modifier ce secteur" class="editBtn_secteur text-primary "
          data-toggle="modal" data-target="#editModal_Secteur" id="'.$row['id_secteur'].'">
            <i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;
            
          <a href="#" title="Supprimer ce secteur" class="suppBtn_Secteur text-danger "
          data-toggle="modal" data-target="#suppModal_Secteur" id="'.$row['id_secteur'].'">
            <i class="bi bi-trash"></i></a>&nbsp;&nbsp;
          </td>
          </tr>';       
         };      
      }
      $output .= '</tbody></table>';
      echo $output;
      
    };


   
}

  // Ajout d'un secteur
      
      if( isset( $_POST['Adesignation_secteur'])){

    $A_designation_secteur = htmlspecialchars($_POST['Adesignation_secteur']);
    $A_commentaire_secteur = htmlspecialchars($_POST['Acommentaire_secteur']);
    
    $db_secteur->enregistrement_secteur($A_designation_secteur, $A_commentaire_secteur);    
  }

  //Recuperation des données pour les insérer dans le modal Suppression d'un secteur
  if(isset($_POST['supp_id_secteur'])){  
    $id_secteur = ($_POST['supp_id_secteur']);
    $db_secteur->deleteSecteur($id_secteur);
  }

  //Recuperation des données pour les insérer dans le modal Modification d'un secteur
  if(isset($_POST['edit_id_secteur'])){
    $id_secteur = $_POST['edit_id_secteur'];
    $row = $db_secteur->getSecteurById($id_secteur);

    echo json_encode($row);// response retournée
  }

  // Modification de secteur via le modal
  if(isset($_POST['Mdesignation_secteur'])){
    $Mid_secteur = ($_POST['Mid_secteur']);
    $Mdesignation_secteur = htmlspecialchars($_POST['Mdesignation_secteur']);
    $Mcommentaire_secteur = htmlspecialchars($_POST['Mcommentaire_secteur']);
     
    $db_secteur->updateSecteur($Mid_secteur, $Mdesignation_secteur, $Mcommentaire_secteur);
  }

?>