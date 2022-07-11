<?php

// Modal ajout famille
function ajoutFamille(){
echo'
<div class="modal fade" id="ajoutFamille" tabindex="-1" >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
          <img src="../IMG/famille/ajout.png"/> 
            <h4 class="modal-title mx-auto">Ajouter une famille de matériel</h4>
            <button type="button" class="btn-close" data-dismiss="modal" id="closeEditFamille"></i></button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body px-4">
          <form method="post" name="famille_form_data" id="famille_form_data" onsubmit="return ajout_famille()">
    
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_famille_categorie" placeholder=""  name="ajout_famille_categorie" required >
            <label for="ajout_famille_categorie">Catégorie</label>
          </div>
          
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_famille_designation" placeholder=""  name="ajout_famille_designation" required >
            <label for="ajout_famille_designation">Désignation</label>
          </div>
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_famille_perio1" placeholder=""  name="ajout_famille_perio2">
            <label for="ajout_famille_perio3">Périodicité 1</label>
          </div>
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_famille_perio2" placeholder=""  name="ajout_famille_perio2">
            <label for="ajout_famille_perio2">Périodicité 2</label>
          </div>
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_famille_perio3" placeholder="" name="ajout_famille_perio3">
            <label for="ajout_famille_perio3">Périodicité 3</label>            
          </div>

          <br>
    
          <div class="form-group p-3" >      
          <input type="submit" name="ajout_famille_valider"  id="ajout_famille_valider" class="btn btn-outline-primary btn-block form-control" value="VALIDER">
          </div>
    
        </form>
                   
          <hr class="my-4">
                  
          </div>      
        </div>
      </div>
    </div>';
}

// modal Modification d'une famille
function modif_famille(){
echo'
<!-- Modal Pour Modifier une famille  -->
<div class="modal fade" id="editModal_famille"> 
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
        <img src="../IMG/text-edit.png"/>  
          <h4 class="modal-title mx-auto">Modifier une famille de matériel</h4>
          <button type="button" id="CloseEditFamille" class="btn-close" data-dismiss="modal"></i></button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body px-4">
         <form action="" method="POST" id="famille-form-data">
           <input type="hidden" name="modif_famille_id" id="modif_famille_id">

                <div class="form-floating mb-3">  
                  <input type="text" name="modif_famille_categorie" class="form-control" id="modif_famille_categorie" required>
                  <label for="modif_famille_categorie">Catégorie</label>
                </div>
                <div class="form-floating mb-3">  
                  <input type="text" name="modif_famille_designation" class="form-control" id="modif_famille_designation" required>
                  <label for="modif_famille_designation">Désignation</label>
                </div>

                <div class="form-floating mb-3">                  
                  <input type="text"  name="modif_famille_perio1" class="form-control" id="modif_famille_perio1">
                  <label for="modif_famille_perio1">Périodicité 1</label>
                </div>

                <div class="form-floating mb-3">                  
                  <input type="text"  name=modif_famille_perio2" class="form-control" id="modif_famille_perio2">
                  <label for="modif_famille_perio1">Périodicité 2</label>
                </div>

                <div class="form-floating mb-3">                  
                  <input type="text" name="modif_famille_perio3" class="form-control" id="modif_famille_perio3">
                  <label for="modif_famille_perio3">Périodicité 3</label>
                </div>

                <div class="form-group p-2">
                  <input type="submit" name="update_famille" data-dismiss="modal" id="update_famille" value="VALIDER"
                  class="btn btn-outline-primary btn-block form-control">
                </div>
         </form>
        </div>      
      </div>
    </div>
  </div>';
}

?>