<?php
//****  SECTEUR.PHP */



// Modal ajout secteur
function ajoutSecteur(){
echo'
<div class="modal fade" id="ajoutSecteur" tabindex="-1"  >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
          <img src="../IMG/secteur/secteur.png"/> 
            <h4 class="modal-title mx-auto text-center">Ajouter un secteur</h4>
            <button type="button" class="btn-close" data-dismiss="modal" id="closeSecteur"></i></button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body px-4">
          <form method="post" name="secteur_form_data" id="secteur_form_data" onsubmit="return ajout_secteur()">
    
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_secteur_designation"   name="ajout_secteur_designation" required >
            <label for="ajout_secteur_designation">Désignation</label>
          </div>
          
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_secteur_commentaire"  name="ajout_secteur_commentaire" required >
            <label for="ajout_secteur_commentaire">Commentaire</label>
          </div>
    
          <br>
    
          <div class="form-group p-3" >      
          <input type="submit" name="ajout_secteur_valider"  id="ajout_secteur_valider" class="btn btn-outline-primary btn-block form-control" value="VALIDER">
          </div>
    
        </form>
                   
          <hr class="my-4">
                  
          </div>      
        </div>
      </div>
    </div>';
}

// modal Modification d'un secteur
function modif_secteur(){
echo'
<!-- Modal Pour Modifier un secteur  -->
<div class="modal fade" id="editModal_secteur"> 
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
        <img src="../IMG/text-edit.png"/>  
          <h4 class="modal-title mx-auto">Modifier un secteur</h4>
          <button type="button" class="btn-close" data-dismiss="modal"></i></button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body px-4">
         <form action="" method="POST" id="secteur-form-data">
           <input type="hidden" name="modif_secteur_id" id="modif_secteur_id">

                <div class="form-floating mb-3">  
                  <input type="text" name="modif_secteur_designation" class="form-control" id="modif_secteur_designation" required>
                  <label for="modif_secteur_designation">Désignation</label>
                </div>
                <div class="form-floating mb-3">  
                  <input type="text" name="modif_secteur_commentaire" class="form-control" id="modif_secteur_commentaire" required>
                  <label for="modif_secteur_commentaire">Commentaire</label>
                </div>

                <div class="form-group p-2">
                  <input type="submit" name="update_secteur" data-dismiss="modal" id="update_secteur" value="VALIDER"
                  class="btn btn-outline-primary btn-block form-control">
                </div>
         </form>
        </div>      
      </div>
    </div>
  </div>';
}

?>