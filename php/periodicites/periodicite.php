<?php
//****  PERIODICITE.PHP */



// Modal ajout périodicité
function ajoutPerio(){
echo'
<div class="modal fade" id="ajoutPerio" tabindex="-1"  >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
          <img src="../IMG/perio/perio.png"/> 
            <h4 class="modal-title mx-auto text-center">Ajouter une périodicité</h4>
            <button type="button" class="btn-close" data-dismiss="modal" id="closePerio"></i></button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body px-4">
          <form method="post" name="perio_form_data" id="perio_form_data" onsubmit="return ajout_perio()">
    
    
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_perio_intitule"   name="ajout_perio_intitule" required >
            <label for="ajout_perio_intitule">Intutilé de la période</label>
          </div>
          
          <div class="form-floating mb-3" >
            <select class="form-select " " id="ajout_perio_type" name="ajout_perio_type" required>
            <option id="option"></option>
            <option id="option">jour</option> 
            <option id="option">semaine</option>
            <option id="option">mois</option>
            <option id="option">année</option>
            </select>
            <label class="form-label select-label">Sélectionner une unité de temps</label>
          </div>          

          <div class="form-floating mb-3">
            <input type="number" min="1" value="1" class="form-control" id="ajout_perio_nb"  name="ajout_perio_nb" required >
            <label for="ajout_perio_nb">Nombre d\'unités</label>
          </div>          

          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ajout_perio_commentaire"  name="ajout_perio_commentaire">
            <label for="ajout_perio_commentaire">Commentaire</label>
          </div>
    
          <br>
    
          <div class="form-group p-3" >      
          <input type="submit" name="ajout_perio_valider"  id="ajout_perio_valider" class="btn btn-outline-primary btn-block form-control" value="VALIDER">
          </div>
    
        </form>
                   
          <hr class="my-4">
                  
          </div>      
        </div>
      </div>
    </div>';
}

// modal Modification d'une périodicité
function modif_perio(){
  echo'
  <!-- Modal Pour Modifier une périodicité  -->
  <div class="modal fade" id="editModal_perio"> 
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
          <img src="../IMG/text-edit.png"/>  
            <h4 class="modal-title mx-auto">Modifier une périodicité</h4>
            <button type="button" class="btn-close" data-dismiss="modal"></i></button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body px-4">
           <form action="" method="POST" id="perio-form-data">
             <input type="hidden" name="modif_perio_id" id="modif_perio_id">
  
                  <div class="form-floating mb-3">  
                    <input type="text" name="modif_perio_intitule" class="form-control" id="modif_perio_intitule" required>
                    <label for="modif_perio_intitule">Intitulé de la période</label>
                  </div>

                  <div class="form-floating mb-3" >
                    <select class="form-select " " id="modif_perio_type" name="modif_perio_type" required>
                      <option id="option"></option>
                      <option id="option">jour</option> 
                      <option id="option">semaine</option>
                      <option id="option">mois</option>
                      <option id="option">année</option>
                    </select>
                    <label class="form-label select-label">Sélectionner une unité de temps</label>
                  </div>  

                  <div class="form-floating mb-3">
                    <input type="number" min="1" class="form-control" id="modif_perio_nb"  name="modif_perio_nb" required >
                    <label for="ajout_perio_nb">Nombre d\'unités</label>
                  </div>   

                  <div class="form-floating mb-3">  
                    <input type="text" name="modif_perio_commentaire" class="form-control" id="modif_perio_commentaire">
                    <label for="modif_perio_commentaire">Commentaire</label>
                  </div>
  
                  <div class="form-group p-2">
                    <input type="submit" name="update_perio" data-dismiss="modal" id="update_perio" value="VALIDER"
                    class="btn btn-outline-primary btn-block form-control">
                  </div>
           </form>
          </div>      
        </div>
      </div>
    </div>';
  }
  


?>