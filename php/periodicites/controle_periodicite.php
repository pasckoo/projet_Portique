<?php
/*---CONTROLE_PERIODICITE.PHP---*/

require_once('modele_periodicite.class.php');


session_start();

$db_perio = new Database_Perio();


// Visualisation de la table perio
if(isset($_POST['listingPerio']) && ($_POST['listingPerio']  == 'voirPerio')){
  
    //on teste si on est admin pour afficher le bouton ajouter
    if($_SESSION['type'] > 0){
    echo'<script>
    var root = document.querySelector(":root"); 
    root.style.setProperty("--visible", "visible");
    </script>';};
  
      // affichage du bandeau titre supérieur
      echo'
      <div class="row bg-light border border-dark">
              <h1>Liste des périodicités</h1> 
          </div>';
          
      // affichage dans la page
      $output = '<div id="tableSecteur></div>';
    echo'<div class="row  p-3 " id="showUsers">';
      
      $data = $db_perio->read_perio();
  
      $toutesLignes = $db_perio->totalRowCount();
      
      if($toutesLignes > -1){
        $output = '';
        $output .= "<script>
        var tabPerio = $('#tableauPerio').DataTable(
          
          { 'columnDefs': [ { 'visible': true, 'targets': [0] }],
          
            order: [[0, 'desc']],
            dom: 'Bflrtpi', 
            buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
            {extend:'excel', text: 'EXCEL', title:'Liste des périodicités', filename:'Liste_periodicites', titleAttr:'Exporter vers Excel'},
            {extend:'csv', text: 'CSV', title:'Liste des périodicités', filename:'Liste_periodicite', titleAttr:'Exporter vers CSV'},
            {extend:'pdfHtml5', text: 'PDF', title:'Liste des périodicités', messageTop:'Liste des périodicités', download:'open', titleAttr:'Exporter en PDF'},
            {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste des périodicités', message:'Liste des périodicités', titleAttr:'imprimer la liste des périodicités' },
            'spacer','spacer', 'spacer',
            { text: 'AJOUTER UNE PERIODICITE', action: function ( e, dt, node, config ) { $('#ajoutPerio').modal('show');}, titleAttr:'Ajouter une périodicité', className:'ajouterPerio'}
             
                    ],             
  
            'language': {
              
              'lengthMenu': 'Affiche _MENU_ périodicités par page',
              'zeroRecords': 'Aucune périodicité à afficher',
              'info': 'Liste des _MAX_ périodicités page _PAGE_ sur _PAGES_',
              'count': '{total} found',
  
              'infoEmpty': 'Aucune périodicité à afficher',
              'infoFiltered': '(filtrée de _MAX_ périodicités)',
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
          id="tableauPerio" 
          data-toggle="table"
          
        >
  
        <!--<caption>Liste des périodicités</caption>-->
        <thead class="table-dark">
          <tr class="text-center">
            <th>ID</th>
            <th>Intitulé de la période</th>
            <th>Unité de temps</th> 
            <th>Nombre d\'unités</th>
            <th>Commentaire</th>';
            if($_SESSION["type"] > 0){$output .= '<th>Action</th>';};
          $output .= '</tr>
        </thead>
        <tbody>';
        echo'<div class="listePeriodicite row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"
  
        foreach($data as $row){ 
          $output .=' <tr class="text-center 1text-secondary" >
          <td>'.$row['id_perio'].'</td>
          <td>'.$row['intitule_perio'].'</td>
          <td>'.$row['type_perio'].'</td>
          <td>'.$row['nb_perio'].'</td>
          <td>'.$row['commentaire_perio'].'</td>';
  
          if($_SESSION["type"] > 0){
            $output .= '<td>          
            <a href="#" title="Modifier cette périodicité" class="editBtn_perio text-primary "
            data-toggle="modal" data-target="#editModal_Perio" id="'.$row['id_perio'].'">
              <i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;
              
            <a href="#" title="Supprimer cette périodicité" class="suppBtn_Perio text-danger "
            data-toggle="modal" data-target="#suppModal_Perio" id="'.$row['id_perio'].'">
              <i class="bi bi-trash"></i></a>&nbsp;&nbsp;
            </td>
            </tr>';       
           };      
        }
        $output .= '</tbody></table>';
        echo $output;
        
      };  
     
  }

  // Ajout d'une périodicité      
  if( isset( $_POST['Aintitule_perio'])){

    $A_intitule_perio = htmlspecialchars($_POST['Aintitule_perio']);
    $A_type_perio = htmlspecialchars($_POST['Atype_perio']);
    $A_nb_perio = htmlspecialchars($_POST['Anb_perio']);
    $A_commentaire_perio = htmlspecialchars($_POST['Acommentaire_perio']);
    
    
    $db_perio->enregistrement_perio($A_intitule_perio, $A_type_perio, $A_nb_perio, $A_commentaire_perio);    
  }

//Recuperation des données pour les insérer dans le modal Suppression d'une périodicité
if(isset($_POST['supp_id_perio'])){  
  $id_perio = ($_POST['supp_id_perio']);
  $db_perio->deletePerio($id_perio);
}

//Recuperation des données pour les insérer dans le modal Modification d'une périodicité
if(isset($_POST['edit_id_perio'])){
  $id_perio = $_POST['edit_id_perio'];
  $row = $db_perio->getPerioById($id_perio);

  echo json_encode($row);// response retournée
}
  
// Modification de périodicité via le modal
if(isset($_POST['Mintitule_perio'])){
  $Mid_perio = ($_POST['Mid_perio']);
  $Mintitule_perio = htmlspecialchars($_POST['Mintitule_perio']);
  $Mtype_perio = htmlspecialchars($_POST['Mtype_perio']);
  $Mnb_perio = ($_POST['Mnb_perio']);
  $Mcommentaire_perio = htmlspecialchars($_POST['Mcommentaire_perio']);
   
  $db_perio->updatePerio($Mid_perio, $Mintitule_perio, $Mtype_perio, $Mnb_perio, $Mcommentaire_perio);
}

?>