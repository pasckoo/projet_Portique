<?php
/*---CONTROLE.PHP---*/


// Modal ajout contrôle
function ajoutControle(){
    echo'
    <div class="modal fade" id="ajoutControle" tabindex="-1"  >
          <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
            
              <!-- Modal Header -->
              <div class="modal-header">
              <img src="../IMG/controle/controle.png"/> 
                <h3 class="modal-title mx-auto text-center">Ajouter un contrôle</h3>
                <button type="button" class="btn-close" data-dismiss="modal" id="closeControle"></i></button>
              </div>
              
              <!-- Modal body -->
              <div class="modal-body px-4">
              <form method="post" name="controle_form_data" id="controle_form_data" onsubmit="return ajout_controle()">
        
        
              <div class="form-floating mb-3">
                <input type="date" class="form-control" id="ajout_controle_date"   name="ajout_controle_date"
                value="" max="'.date("Y-m-d").'"   required >
                <label for="ajout_controle_date">Date du contrôle</label>

              </div>
              
        
              <div class="form-floating mb-3">
                <select class="form-select " " id="ajout_controle_materiel"  required>
                
                </select>
                <label class="form-label select-label">Repère matériel</label> 
              </div>
        
              <div class="form-floating mb-3" >
                <select class="form-select " " id="ajout_controle_type"  required>
                  
                </select>
                <label class="form-label select-label">Périodicité</label>                
              </div>

              <div class="form-floating mb-3">
                <select class="form-select " " id="ajout_controle_user"  required>
                
                </select>
                <label class="form-label select-label">Contrôleur</label>
              </div>

              <div class="form-floating mb-3">
                <textarea class="form-control" id="ajout_controle_commentaire"  name="ajout_controle_commentaire"></textarea>
                <label for="ajout_controle_commentaire">Commentaire</label>
              </div>
                            
          </div>
                  
              <br>
        
              <div class="form-group p-3" >      
              <input type="submit" name="ajout_controle_valider"  id="ajout_controle_valider" class="btn btn-primary btn-block form-control" value="VALIDER">
              </div>
        
            </form>
                       
              <hr class="my-4">
                      
              </div>      
            </div>
          </div>
        </div>
        ';
        
}

// Modal modification contrôle
function modifControle(){
  echo'
  <div class="modal fade" id="modifControle" tabindex="-1"  >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
            <img src="../IMG/controle/controle.png"/> 
              <h4 class="modal-title mx-auto text-center">Modifier un contrôle</h4>
              <button type="button" class="btn-close" data-dismiss="modal" id="closeModifControle"></i></button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body px-4">
            <form method="post" name="controle_form_data" id="controle_form_data" onsubmit="return modif_controle()">
             <input type="hidden" class="form-control" id="modif_controle_id"   name="modif_controle_id" required > 
      
            <div class="form-floating mb-3">
              <input type="date" class="form-control" id="modif_controle_date" max="'.date("Y-m-d").'"  name="modif_controle_date" required >
              <label for="ajout_controle_date">Date du contrôle</label>

            </div>
            
      
            <div class="form-floating mb-3">
              <select class="form-select " " id="modif_controle_materiel"  required>
              
              </select>
              <label class="form-label select-label">Repère matériel</label> 
            </div>
      
            <div class="form-floating mb-3" >
              <select class="form-select " " id="modif_controle_type"  required>
                
              </select>
              <label class="form-label select-label">Périodicité</label>                
            </div>

            <div class="form-floating mb-3">
              <select class="form-select " " id="modif_controle_user"  required>
              
              </select>
              <label class="form-label select-label">Contrôleur</label>
            </div>

            <div class="form-floating mb-3">
              <textarea class="form-control" id="modif_controle_commentaire"  name="modif_controle_commentaire"></textarea>
              <label for="ajout_controle_commentaire">Commentaire</label>
            </div>
                          
        </div>
                
            <br>
      
            <div class="form-group p-3" >      
            <input type="submit" name="modif_controle_valider"  id="modif_controle_valider" class="btn btn-primary btn-block form-control" value="MODIFIER">
            </div>
      
          </form>
                     
            <hr class="my-4">
                    
            </div>      
          </div>
        </div>
      </div>
      ';
      
}


?>