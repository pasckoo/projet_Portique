<?php
require_once('fonctions.php');
require_once('Modif.class.php');

function deconnecter(){

    echo'<div class="modal fade" tabindex="-1" id="disconnect" >
    <div class="modal-dialog">
    <div class="modal-content">
      
        <div class="modal-header">
        <img src="../IMG/signout.png"/><h5 class="modal-title">&ensp;  DECONNEXION</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
        <p>Vous allez être déconnecté...</p>
        </div>
        <div class="modal-footer">
        <form method="post">
        <button id="deco" type="submit" name="deco" class="btn btn-danger">Déconnexion</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        
        </form>
        </div>

    </div>
    </div>
    </div> ';
}    

function changeImage(){
// Modal Pour sélectionner une image
echo'<div class="modal fade" id="modalImages" > 
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
        <img src=""/>  
          <h4 class="modal-title mx-auto">Choisir une image</h4>
          <button type="button" class="btn-close" data-dismiss="modal"></i></button>
        </div>
        
        <!-- Modal body -->
        <div class=" modal-body px-4 text-center" id="imageLogo">
        
           <input type="image" class="image" height="50" width="50" id="1" data-toggle="modal"  src="../IMG/PHOTOS/1.png" alt="1" /> 
           <input type="image" class="image" height="50" width="50" id="2" data-toggle="modal"src="../IMG/PHOTOS/2.png" onclick="" alt="2" /> 
           <input type="image" class="image" height="50" width="50" id="3" data-toggle="modal" onClick=""  src="../IMG/PHOTOS/3.png" alt="3" />
           <input type="image" class="image" height="50" width="50" id="4" data-toggle="modal"  src="../IMG/PHOTOS/4.png" alt="4" />     
           <input type="image" class="image" height="50" width="50" id="5" data-toggle="modal"  src="../IMG/PHOTOS/5.png" alt="5" />
           <input type="image" class="image" height="50" width="50" id="6" data-toggle="modal"  src="../IMG/PHOTOS/6.png" alt="6" />
           <input type="image" class="image" height="50" width="50" id="7" data-toggle="modal"  src="../IMG/PHOTOS/7.png" alt="7" />
           <input type="image" class="image" height="50" width="50" id="8" data-toggle="modal"  src="../IMG/PHOTOS/8.png" alt="8" />
           <input type="image" class="image" height="50" width="50" id="9" data-toggle="modal"  src="../IMG/PHOTOS/9.png" alt="9" />
           <input type="image" class="image" height="50" width="50" id="10" data-toggle="modal"  src="../IMG/PHOTOS/10.png" alt="10" />
           
        </div>      
      </div>
    </div>
  </div>';

}

function changeFond(){
  // Modal Pour sélectionner une image
  echo'<div class="modal fade" id="modalFond" > 
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
          <img src=""/>  
            <h4 class="modal-title mx-auto">Choisir une image de fond</h4>
            <button type="button" class="btn-close" data-dismiss="modal"></i></button>
          </div>
          
          <!-- Modal body -->
          <div class=" modal-body px-4 text-center" id="imageFondLogo">
          
             <input type="image" class="imageFond" height="80" width="120" id="0" data-toggle="modal"  src="../IMG/fonds/0.jpg" alt="0" /> 
             <input type="image" class="imageFond" height="80" width="120" id="1" data-toggle="modal"  src="../IMG/fonds/1.jpg" alt="1" /> 
             <input type="image" class="imageFond" height="80" width="120" id="2" data-toggle="modal"  src="../IMG/fonds/2.jpg" alt="2" />
             <input type="image" class="imageFond" height="80" width="120" id="3" data-toggle="modal"  src="../IMG/fonds/3.jpg" alt="3" />     
             <input type="image" class="imageFond" height="80" width="120" id="4" data-toggle="modal"  src="../IMG/fonds/4.jpg" alt="4" />
             <input type="image" class="imageFond" height="80" width="120" id="5" data-toggle="modal"  src="../IMG/fonds/5.jpg" alt="5" />
             <input type="image" class="imageFond" height="80" width="120" id="6" data-toggle="modal"  src="../IMG/fonds/6.jpg" alt="6" />
             <input type="image" class="imageFond" height="80" width="120" id="7" data-toggle="modal"  src="../IMG/fonds/7.jpg" alt="7" />
             <input type="image" class="imageFond" height="80" width="120" id="8" data-toggle="modal"  src="../IMG/fonds/8.jpg" alt="8" />
             
          </div>      
        </div>
      </div>
    </div>';
  
  }

 
  
?>