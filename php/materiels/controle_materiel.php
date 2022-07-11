<?php
/*---CONTROLE_MATERIEL.PHP---*/

require_once('modele_materiel.class.php');
require_once('../controles/controle_controle.php');
require_once('materiel.php');

//session_start();

$db_materiel = new Database_Materiel();


if($_SESSION['type'] > 0){
  $actif = "enable"; $visible = "visible";}else{$actif = "disabled"; $visible = "hidden";}

// Visualisation de la table matériel
if(isset($_POST['listingMateriels']) && ($_POST['listingMateriels']  == 'voirMateriels')){
  
  // on teste si on est admin pour afficher le bouton "ajouter un matériel"
  if($_SESSION['type'] > 0){
  echo'<script>
  var root = document.querySelector(":root"); 
  root.style.setProperty("--visible", "visible");
  </script>';}; 

    // affichage du bandeau titre supérieur
    echo'
    <div class="row bg-light border border-dark">
            <h1>Liste du matériel</h1> 
        </div>';
        
    // affichage dans la page
    $output = '<div id="tableMateriel"></div>';
  echo'<div class="row  p-3 " id="showUsers">';
    
    $data = $db_materiel->read_materiel();

    $toutesLignes = $db_materiel->totalRowCount();
    
    if($toutesLignes > -1){
      $output = '';
      $output .= "<script>
      var tabMateriel = $('#tableauMateriel').DataTable(
        
        { scrollY: '400px',
          scrollCollapse: true,
          paging: true,
          
          'columnDefs': [ { 'visible': false, 'targets': [0] },
                          {'searchable': false, 'targets': [] }
      
      
                        ],
        
          order: [[0, 'desc']],
          dom: 'Bflrtpi', 
          buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
          {extend:'excel', text: 'EXCEL', title:'Liste des matériels', filename:'Liste_matériels', titleAttr:'Exporter vers Excel'},
          {extend:'csv', text: 'CSV', title:'Liste des matériels', filename:'Liste_matériels', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Liste des matériels', messageTop:'Liste des matériels', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste des matériels', message:'Liste des matériels', titleAttr:'imprimer la liste des matériels' },
          'spacer','spacer', 'spacer',
          { text: 'AJOUTER UN MATERIEL', action: function ( e, dt, node, config ) { $('#affichageMateriel').modal('show');}, titleAttr:'Ajouter un matériel', className:'ajouterMateriel'}
           
                  ],             

          'language': {
            
            'lengthMenu': 'Affiche _MENU_ matériels par page',
            'zeroRecords': 'Aucun matériel à afficher',
            'info': 'Liste des _MAX_ matériels page _PAGE_ sur _PAGES_',
            'count': '{total} found',

            'infoEmpty': 'Aucun matériel à afficher',
            'infoFiltered': '(filtrée de _MAX_ matériels)',
            'search': 'Rechercher un matériel par son repère:',
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
        id="tableauMateriel" 
        data-toggle="table"
        
      >

      <!--<caption>Liste des materiels</caption>-->
      <thead class="table-warning">
        <tr class="text-center">
          <th>ID</th>
          <th>Repère</th>
          <th>Désignation</th>
          <th>Référence</th>
          <th>Date de mise en service</th>
          <th>Commentaire</th>
          <th>Secteur</th>
          <th>Famille</th>
          <th>Modele</th>
          <th>Action</th>';
        $output .= '</tr>
      </thead>
      <tbody>';
      echo'<div class="ListeMateriel row  p-3" id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"

      foreach($data as $row){

        $output .=' <tr class="text-center 1text-secondary" >
        <td>'.$row['id_materiel'].'</td>
        <td>'.$row['rep_materiel'].'</td>
        <td>'.$row['designation_materiel'].'</td>
        <td>'.$row['reference_materiel'].'</td>
        <td>'.$row['date_mes_materiel'].'</td>
        <td>'.$row['commentaire_materiel'].'</td>
        <td>'.$row['designation_secteur'].'</td>
        <td>'.$row['categorie_famille'].'</td>
        <td>'.$row['type_modele'].'</td>';

        
          $output .= '<td> 
            <a href="#" title="Voir ce matériel" class="voirBtn_materiel text-primary "
             data-target="#voir_Materiel" id="'.$row['id_materiel'].'">
              <i class="bi bi-eye"></i></a>&nbsp;&nbsp;
            
             
            <a href="#" title="Supprimer ce materiel" class="suppBtn_materiel text-danger"
            data-toggle="modal" data-target="" id="'.$row['id_materiel'].'" '.$visible.' >
              <i class="bi bi-trash"></i></a>&nbsp;&nbsp;
              
          </td>
          </tr>';       
         };      
      }
      $output .= '</tbody></table>';
      echo $output;      
    };  


// Ajout d'un matériel
if( isset( $_POST['Arep_materiel'])){  
  $A_rep_materiel = htmlspecialchars($_POST['Arep_materiel']);
  $A_designation_materiel = htmlspecialchars($_POST['Adesignation_materiel']);
  $A_reference_materiel = htmlspecialchars($_POST['Areference_materiel']);
  $A_mes_materiel = htmlspecialchars($_POST['Ames_materiel']);
  $A_commentaire_materiel = htmlspecialchars($_POST['Acommentaire_materiel']);
  $A_photo_materiel = ""; 
  $A_id_secteur = htmlspecialchars($_POST['Aid_secteur']);
  $A_id_famille = htmlspecialchars($_POST['Aid_famille']);
  $A_id_modele = htmlspecialchars($_POST['Aid_modele']);
  
  
  $db_materiel->enregistrement_materiel($A_rep_materiel, $A_designation_materiel,
                                        $A_reference_materiel, $A_mes_materiel, $A_commentaire_materiel,
                                        $A_photo_materiel, $A_id_secteur, $A_id_famille,
                                        $A_id_modele);    
}


//Recuperation des données pour les insérer dans le formulaire  Afficher un matériel
if(isset($_POST['afficher_id_materiel'])){ 
  $id_materiel =  $_POST['afficher_id_materiel'];  
  $row = $db_materiel->getMaterielById($id_materiel);
  echo json_encode($row);
  $recup = $row['rep_materiel']; 
}  


//Recuperation des données pour les insérer dans le modal Suppression d'un matériel
if(isset($_POST['supp_id_materiel'])){  
  $id_materiel = htmlentities($_POST['supp_id_materiel']);
  $db_materiel->deleteMateriel($id_materiel);
}

// affichage des contrôles pour un matériel
if(isset($_POST['Tid_materiel'])){
  $id_materiel = $_POST['Tid_materiel'];
  voir_controle_par_materiel($id_materiel);
  
}




// Ajout matériel sur le tableau de bord
if(isset($_POST['ajoutMateriel']) && ($_POST['ajoutMateriel']  == 'ajoutMateriel')){
  
  
  // on teste si on est admin pour afficher le bouton "ajouter un matériel"
  if($_SESSION['type'] > 0){
   echo'<script>
   var root = document.querySelector(":root"); 
   root.style.setProperty("--visible", "visible"); 
   </script>';}; 
 
     // affichage du bandeau titre supérieur
     echo'
     <div class="row bg-light border border-dark">
             <h1>Ajouter un matériel</h1> 
         </div>';
         
// Ajouter un matériel
echo'
  <div class="container_affiche container-fluid mt-3 rounded border" id="container_ajout_materiel" >
    <div class="row "> 
      <form  method="post" name="materiel_form_data" id="materiel_form_data" onsubmit="return ajout_materiel()">
         
        <div class="row">

          <div class="col-lg-4 mt-3">
                <div class="form-floating mb-3" >
                  <select class="form-select" id="ajout_id_secteur" required '.$actif.'>
                    <option selected></option>
                  </select>
                <label class="form-label select-label">Sélectionner un secteur*</label>            
                </div>
          

                <div class="form-floating mb-3"  required '.$actif.'>
                  <select class="form-select " id="ajout_id_famille"  required '.$actif.'>
                    <option selected></option>
                  </select>
                  <label class="form-label select-label">Sélectionner une famille*</label>            
                </div>

                <div class="form-floating mb-3" >
                  <select class="form-select " id="ajout_id_modele"  required '.$actif.'>
                    <option selected></option>
                  </select>
                  <label class="form-label select-label">Sélectionner un modèle*</label>            
                </div>        
          </div>      
          <div class="col-lg-4 mt-3">
                <div class="form-floating mb-3" >
                  <input type="text" class="form-control text-uppercase" id="ajout_materiel_rep"   name="ajout_materiel_rep"'.$actif.'  required >
                  <label for="ajout_materiel_rep">Repère*</label>
                </div>
          
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="ajout_materiel_designation"   name="ajout_materiel_designation"'.$actif.' >
                  <label for="ajout_materiel_designation">Désignation</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="ajout_materiel_reference"   name="ajout_materiel_reference" '.$actif.'>
                  <label for="ajout_materiel_reference">Référence</label>
                </div>
                   
          </div>
          <div class="col-lg-4 mt-3">
                <div class="form-floating mb-3">
                  <input type="date" class="form-control" id="ajout_materiel_mes" max="'.date("Y-m-d").'"  name="ajout_materiel_mes" required '.$actif.'>
                  <label for="ajout_materiel_mes">Date de mise en service*</label>
                </div>           

                <div class="form-floating  mb-3">
                  <textarea class="form-control " style="height:130px" id="ajout_materiel_commentaire"   name="ajout_materiel_commentaire" '.$actif.'></textarea>
                  <label for="ajout_materiel_commentaire">Commentaire</label>
                </div>

          </div>
          
          <br>
         
            <div class=" p-1 mb-3 text-center" >      
              <input type="submit" name="ajout_materiel_valider"  id="ajout_materiel_valider" class="btn btn-primary " value="VALIDER" '.$actif.'>              
              <input type="button" name="ajout_materiel_retour"  id="ajout_materiel_retour" class="btn btn-secondary " value="RETOUR A LA LISTE" >
            </div>
            
        </div>        
      </form>
    </div>
      <div class=" p-1 mb-1 text-center" >
        
      </div>
    </div>
    
  </div>  
';
}



// Mise à jour Modification matériel vers la BDD
if(isset($_POST['Mid_materiel'])){
  $Mid_materiel = htmlspecialchars($_POST['Mid_materiel']);
  $Mrep_materiel = htmlspecialchars($_POST['Mrep_materiel']);
  $Mdesignation_materiel = htmlspecialchars($_POST['Mdesignation_materiel']);
  $Mreference_materiel = htmlspecialchars($_POST['Mreference_materiel']);
  $Mmes_materiel = htmlspecialchars($_POST['Mmes_materiel']);
  $Mcommentaire_materiel = htmlspecialchars($_POST['Mcommentaire_materiel']);
  $Mid_secteur = htmlspecialchars($_POST['Mid_secteur']); 
  $Mid_famille = htmlspecialchars($_POST['Mid_famille']);
  $Mid_modele = htmlspecialchars($_POST['Mid_modele']);
  
  $db_materiel->updateMateriel($Mid_materiel,
                               $Mrep_materiel,
                               $Mdesignation_materiel,
                               $Mreference_materiel,
                               $Mmes_materiel,
                               $Mcommentaire_materiel,
                               $Mid_secteur,
                               $Mid_famille,
                               $Mid_modele                              
                              );
  
}

//Recuperation des données pour les insérer dans le modal Suppression d'un matériel
if(isset($_POST['supp_id_materiel'])){
  $id_materiel = htmlentities($_POST['supp_id_materiel']);
  $db_materiel->deleteMateriel($id_materiel);
}


// affichage d'un matériel sur le tableau de bord
if(isset($_POST['afficherMateriel']) && ($_POST['afficherMateriel']  == 'afficherMateriel')){
  $id_materiel = $_POST['titre'];
  $db_controle1 = new Database_controle();

  // requete pour l'affichage du repère matériel dans le titre
  $titre = $db_controle1->affichage_controles($id_materiel);

  //requete pour recupérer le repère pour code barre
  $recup = $db_controle1->getRecupRepereById($id_materiel);
  
  
  
 
     // affichage du bandeau titre supérieur
     echo'
     <div class="row bg-light border border-dark">
             <h1>Matériel N° '.implode("",$titre).'</h1> 
         </div>';
         
// Afficher un matériel
echo'
  <div class="row  p-3 " id="showUsers">
  <div class="container_affiche container-fluid mt-3 rounded border" id="Afficher_un_materiel">
    <div class="row ">
      <form  method="post" name="afficher_materiel_form_data" id="materiel_form_data" onsubmit="return modif_materiel();">
            
        <div class="row">

          <div class="col-lg-3 mt-3">
          
              <div class="form-floating mb-3">
                <select class="form-select" id="afficher_id_secteur" required '.$actif.'>
                  <option selected></option>
                </select>
                <label class="form-label select-label">Sélectionner un secteur*</label>  
              </div>

              <div class="form-floating mb-3" >
                  <select class="form-select" id="afficher_id_famille" required '.$actif.'>
                    <option selected></option> 
                  </select> 
                  <label class="form-label select-label">Sélectionner une famille*</label>                    
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="afficher_type_modele"   name="afficher_materiel_id_modele" '.$actif.' required>
                <label for="afficher_materiel_id">Modèle*</label>
              

              <div class="form-floating mb-3">        
                <input type="hidden" class="form-control" id="afficher_cacher_modele"   name="afficher_cacher_modele">            
                <select class="form-select " id="afficher_id_modele" style="height:8px"  '.$actif.'>
                  <option selected></option>
                </select>
                <label class="form-label select-label">Sélectionner un modèle*</label> 
              </div></div>
          </div>
          <div class="col-lg-3 mt-3">
          

                     
                <input type="hidden" class="form-control" id="afficher_materiel_id"   name="afficher_materiel_id">       
              <div class="form-floating mb-3" >
                <input type="text" class="form-control text-uppercase" id="afficher_materiel_rep"   name="afficher_materiel_rep"'.$actif.'  required >
                <label for="afficher_materiel_rep">Repère*</label>
              </div>
            
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="afficher_materiel_designation"   name="afficher_materiel_designation"'.$actif.' >
                <label for="afficher_materiel_designation">Désignation</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="afficher_materiel_reference"   name="afficher_materiel_reference" '.$actif.'>
                <label for="afficher_materiel_reference">Référence</label>
              </div>

          </div>
             
            
          
          <div class="col-lg-3 mt-3">
            <div class="form-floating mb-3">
              <input type="date" class="form-control" id="afficher_materiel_mes"  max="'.date("Y-m-d").'" name="afficher_materiel_mes" required '.$actif.'>
              <label for="afficher_materiel_mes">Date de mise en service*</label>
            </div>           

            <div class="form-floating  mb-3">
              <textarea class="form-control" style="height:130px" id="afficher_materiel_commentaire"   name="afficher_materiel_commentaire" '.$actif.'></textarea>
              <label for="afficher_materiel_commentaire">Commentaire</label>
            </div>                
                     
          </div>
          <div class="col-lg-3 mt-3 text-center" >
            <div class="bg-light rounded p-4 mb-3">';
              //Recuperation du repère pour afficher son code barres              
             echo '<img height="60" width="170" src="../php/codebarre/barcode.php?string='. htmlentities($recup['rep_materiel'],ENT_QUOTES,"ISO8859-1") . '&amp;control=0"/><br>';
             echo'*'.$recup['rep_materiel'].'*';                           
             echo'</div>
             
             <div class="form-floating mb-3">
             
              <input type="date" class="form-control" id="afficherProchainControle"  name="afficherProchainControle" disabled>
             <label for="afficher_materiel_mes">Prochain contrôle avant le:</label>
           </div>           
          </div>

          <br>
          
            <div class=" p-1 mb-3 text-center" > 
              <input type="button" name="afficher_materiel_controle"  id="afficher_materiel_controle" class="btn btn-primary " value="VOIR LES CONTROLES REALISES">
              <input type="submit" name="afficher_materiel_enregistrer"  id="afficher_materiel_enregistrer" class="btn btn-success " value="ENREGISTRER LES MODIFICATIONS"'.$visible.'>   
              <input type="button" name="afficher_materiel_retour"  id="afficher_materiel_retour" class="btn btn-secondary " value="RETOUR A LA LISTE">
              
            </div>
          
        </div>        
      </form>
    </div>
    
  </div> 
  
';

//mettre control=0 pour ne pas utiliser le caractère de controle
//<img src='php-gd-img-barcode-code39.php?string=" . htmlentities($string_a_coder,ENT_QUOTES,"ISO8859-1") . "&amp;control=0'/>"

    
}

// Visualisation de la table contrôle pour un matériel
function voir_controle_par_materiel($id_materiel){
  $db_controle1 = new Database_controle();

  // requete pour l'affichage du repère matériel dans le titre
  $titre = $db_controle1->affichage_controles($id_materiel);
 
  // on teste si on est admin pour afficher le bouton "ajouter un contrôle"
  if($_SESSION['type'] > 0){
  echo'<script>
  var root = document.querySelector(":root"); 
  root.style.setProperty("--visible", "visible");
  </script>';}; 
  
    // affichage du bandeau titre supérieur
    echo'
    <div class="row bg-light border border-dark">
            <h1>Liste des contrôles du matériel N° '.implode("",$titre).'</h1> 
        </div>';
        
    // affichage dans la page
    $output = '<div id="tablecontroleMat></div>';
  echo'<div class="row  p-3 " id="showUsers">';
    
   $data = $db_controle1->read_controleUnMateriel($id_materiel);
   $toutesLignes = $db_controle1->totalRowCount();
    if($toutesLignes > 0){
    
    
      $output = '';
      $output .= "<script>
      var tabControleMat = $('#tableauControleMat').DataTable(
        
        { 'columnDefs': [ { 'visible': false, 'targets': [0] }],
        
          order: [[0, 'desc']],
          dom: 'Bflrtpi', 
          buttons: [{extend:'colvis', text:'SELECTION COLONNES'},
          {extend:'excel', text: 'EXCEL', title:'Liste des contrôles', filename:'Liste_controles', titleAttr:'Exporter vers Excel'},
          {extend:'csv', text: 'CSV', title:'Liste des contrôles', filename:'Liste_controles', titleAttr:'Exporter vers CSV'},
          {extend:'pdfHtml5', text: 'PDF', title:'Liste des controles', messageTop:'Liste des contrôles des matériels', download:'open', titleAttr:'Exporter en PDF'},
          {extend: 'print', text: 'IMPRIMER', autoPrint: true, title:'Liste des contrôles', message:'Liste des contrôles des matériels', titleAttr:'imprimer la liste des contrôles' },
          'spacer','spacer', 'spacer',
          { text: 'AJOUTER UN CONTROLE', action: function ( e, dt, node, config ) { $('#ajoutControle').modal('show');
             remplissage_select_type('ajout_controle_type'); remplissage_select_rep('ajout_controle_materiel');
              remplissage_select_user('ajout_controle_user');}, titleAttr:'Ajouter un contrôle', className:'ajouterControle'},
          'spacer','spacer', 'spacer',
                   
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
        id="tableauControleMat" 
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
          <th>Date prochain contrôle</th>';
          
        $output .= '</tr>
      </thead>
      <tbody>';
      echo'<div class="row  p-3 " id="showUsers">'; // Pour afficher le tableau au même endroit sur sélection "Visibility Columns"
  
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
        <td>'.$row['prochain_controle']= date_format($dateProchaine, 'd/m/Y').'</td>';
      }
      $output .= '</tbody></table>';
      $output .= '<div class="text-center"><br><input type="button" name="retourAu Materiel" onClick="afficher_Form_materiel('.$id_materiel.') "id="retourAuMateriel" class="btn btn-primary p-1 w-25 mt-3 text-center" value="RETOUR AU MATERIEL" ></div>';
      
      echo $output; 
      return $output;
      
    }  
    
}



?>
