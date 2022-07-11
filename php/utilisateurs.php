<?php
require_once('Insertion.class.php');
require_once('fonctions.php');

// modal Modification d'un utilisateur
echo'
<!-- Modal Pour Modifier un  utilisateur  -->
<div class="modal fade" id="editModal"> 
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
        <img src="../IMG/user_modif.png"/>  
          <h3 class="modal-title mx-auto">Modifier un  utilisateur</h3>
          <button type="button" class="btn-close" data-dismiss="modal"></i></button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body px-4">
         <form action="" method="POST" id="edit-form-data">
           <input type="hidden" name="id" id="id">

                <div class="form-floating mb-3">  
                  <input type="text" name="nom" class="form-control" id="nom" placeholder="nom" required>
                  <label for="nom">nom</label>
                </div>
                <div class="form-floating mb-3">  
                  <input type="text" name="prenom" class="form-control" id="prenom" required>
                  <label for="prenom">prénom</label>
                </div>

                <div class="form-floating mb-3">                  
                  <input type="text"  name="login" class="form-control" id="login" required>
                  <label for="login">login</label>
                </div>

                <div class="form-floating mb-3">                  
                  <input type="text"  name="fonction" class="form-control" id="fonction" required>
                  <label for="fonction">fonction</label>
                </div>

                <div class="form-floating mb-3">                  
                  <input type="date" name="date" class="form-control" id="date" required>
                  <label for="date">date de création</label>
                </div>

                <div class="form-floating p-2">
                  <input type="hidden" name="type" class="form-control" id="type" required>
                </div>

                <div class="form-group p-2">
                  <input type="submit" name="update" data-dismiss="modal" id="update" value="VALIDER"
                  class="btn btn-outline-primary btn-block form-control">
                </div>
         </form>
        </div>      
      </div>
    </div>
  </div>';

  
// modal modification des droits Utilisateurs
  echo'<!-- Modal Pour Modifier les droits  -->
  <div class="modal fade" id="permModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
          <img src="../IMG/cadenas.png"/>
            <h4 class="modal-title mx-auto" id="id_droits">Modifier les droits</h4>
            <button type="button" class="btn-close" data-dismiss="modal"></i></button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body px-4">
           <form action="" method="POST" id="editperm-form-data">
             <input type="hidden" name="idperm" id="idperm">
                  
                  <div class="form-group p-2">
                          <select type="select" name="typeperm" class="form-select" id="typeperm" required>
                          <option value="0">Utilisateur</option>                          
                          <option value="1">Administrateur</option>
                          </select>
                        </div>
                
  
                  <div class="form-group p-2">
                    <input type="submit" name="updateperm" id="updateperm" data-dismiss="modal" value="VALIDER"
                    class="btn btn-outline-primary btn-block form-control">
                  </div>
           </form>
          </div>      
        </div>
      </div>
    </div>';

  
   
    


?>