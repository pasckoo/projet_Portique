<?php




// Modal ajout ligne planning
function ajoutPlanning(){
echo'
<div class="modal fade" id="ajoutPlanning" tabindex="-1"  >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
          <img src="../IMG/planning/add_planning.png"/> 
            <h4 class="modal-title mx-auto text-center">Ajouter une ligne</h4>
            <button type="button" class="btn-close" data-dismiss="modal" id="closePlanning"></i></button>
          </div>
          
          <!-- Modal body -->
            <div class="modal-body px-4">

          <form method="post" name="planning_form_data" id="planning_form_data" onsubmit="return ajout_planning()">
        
            <div class="form-floating mb-3" >
                <select class="form-select " " id="ajout_planning_id_modele"  required>
                <option selected></option>
                </select>
                <label class="form-label select-label">Sélectionner un modèle</label>            
            </div>

            <div class="form-floating mb-3" >
                <select class="form-select " " id="ajout_planning_id_perio"  required>
                <option selected></option>
                </select>
                <label class="form-label select-label">Sélectionner une périodicité</label>            
            </div>

            <br>
        
            <div class="form-group p-3" >      
            <input type="submit" name="ajout_planning_valider"  id="ajout_planning_valider" class="btn btn-outline-primary btn-block form-control" value="VALIDER">
            </div>
    
          </form>
                   
          <hr class="my-4">
                  
          </div>      
        </div>
      </div>
    </div>';
}

// Modal modification ligne planning
function modifPlanning(){
    echo'
    <div class="modal fade" id="modifPlanning" tabindex="-1"  >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
              <!-- Modal Header -->
              <div class="modal-header">
              <img src="../IMG/planning/update.png"/> 
                <h4 class="modal-title mx-auto text-center">Modifier une ligne</h4>
                <button type="button" class="btn-close" data-dismiss="modal" id="closeModifPlanning"></i></button>
              </div>
              
              <!-- Modal body -->
                <div class="modal-body px-4">
    
              <form method="post" name="modif_planning_form_data" id="modif_planning_form_data" onsubmit="return modif_planning()">
            
                <div class="form-floating mb-3" >
                    <select class="form-select " " id="modif_planning_id_modele"  required>
                    <option selected></option>
                    </select>
                    <label class="form-label select-label">Sélectionner un modèle</label>            
                </div>
    
                <div class="form-floating mb-3" >
                    <select class="form-select " " id="modif_planning_id_perio"  required>
                    <option selected></option>
                    </select>
                    <label class="form-label select-label">Sélectionner une périodicité</label>            
                </div>
    
                <br>
            
                <div class="form-group p-3" >      
                <input type="submit" name="modif_planning_valider"  id="modif_planning_valider" class="btn btn-outline-primary btn-block form-control" value="VALIDER">
                </div>
        
              </form>
                       
              <hr class="my-4">
                      
              </div>      
            </div>
          </div>
        </div>';
    }
    
    

?>