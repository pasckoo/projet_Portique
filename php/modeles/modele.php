<?php




// Modal ajout modèle
function ajoutModele(){
echo'
<div class="modal fade" id="ajoutModele" tabindex="-1"  >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
          <img src="../IMG/famille/ajout.png"/> 
            <h4 class="modal-title mx-auto text-center">Ajouter un modèle dans une famille</h4>
            <button type="button" class="btn-close" data-dismiss="modal" id="closeModele"></i></button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body px-4">
          <form method="post" name="modele_form_data" id="modele_form_data" onsubmit="return ajout_modele()">
    
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_modele_type"   name="ajout_modele_type" required >
            <label for="ajout_modele_type">Type</label>
          </div>
          
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_modele_designation"  name="ajout_modele_designation" required >
            <label for="ajout_modele_designation">Désignation</label>
          </div>
    
          <div class="form-floating mb-3" >
            <select class="form-select " " id="ajout_modele_id_famille"  required>
              <option selected>Famille</option>
            </select>
            <label class="form-label select-label">Sélectionner une famille</label>
            
          </div>

          <br>
    
          <div class="form-group p-3" >      
          <input type="submit" name="ajout_modele_valider"  id="ajout_modele_valider" class="btn btn-outline-primary btn-block form-control" value="VALIDER">
          </div>
    
        </form>
                   
          <hr class="my-4">
                  
          </div>      
        </div>
      </div>
    </div>';
}

// modal Modification d'un modèle
function modif_modele(){
echo'
<!-- Modal Pour Modifier un modele  -->
<div class="modal fade" id="editModal_modele"> 
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
        <img src="../IMG/text-edit.png"/>  
          <h4 class="modal-title mx-auto">Modifier un modèle</h4>
          <button type="button" class="btn-close" data-dismiss="modal"></i></button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body px-4">
         <form action="" method="POST" id="famille-form-data">
           <input type="hidden" name="modif_modele_id" id="modif_modele_id">

                <div class="form-floating mb-3">  
                  <input type="text" name="modif_modele_type" class="form-control" id="modif_modele_type" required>
                  <label for="modif_modele_type">Type</label>
                </div>
                <div class="form-floating mb-3">  
                  <input type="text" name="modif_modele_designation" class="form-control" id="modif_modele_designation" required>
                  <label for="modif_modele_designation">Désignation</label>
                </div>

                <div class="form-floating mb-3" >
                  <select class="form-select " " id="modif_modele_id_famille"  required>
                    <option id="option"></option>
                  </select>
                  <label class="form-label select-label">Sélectionner une famille</label>
                </div>

                <div class="form-group p-2">
                  <input type="submit" name="update_modele" data-dismiss="modal" id="update_modele" value="VALIDER"
                  class="btn btn-outline-primary btn-block form-control">
                </div>
         </form>
        </div>      
      </div>
    </div>
  </div>';
}

?>