//    PLANNING_SCRIPT.JS

function voirPlanning(id_modele) {
    
    $.ajax({
      url: "../php/planning/controle_planning.php",
      type: "POST",
      data: {
        listingPlanning: "voirPlanning",
        id_modele: id_modele
      },
      success: function (response) {
         
        $("#showUsers").html(response);
      },
      // La fonction à appeler si la requête n'a pas abouti
      error: function() {
        // J'affiche un message d'erreur
        }  
    });
}

// Remplissage du select modele planning
function remplissage_modele_planning(emplacement){
    
    $.ajax({
      url: "../php/planning/controle_planning.php",
      type: "POST",
      data: {
        remplissage_modele_planning: "remplissageModele"
      },
      success: function (response) {  
        $("#"+emplacement).html(response);     
       return true;
      },
       
    });
    
}

// Ajout d'une ligne planning
function ajout_planning(){
    
    var Aid_modele_planning = document.getElementById("ajout_planning_id_modele").value;
    var Aid_perio_planning = document.getElementById("ajout_planning_id_perio").value;
      
    $.ajax({
      type: "POST",
      url: "../php/planning/controle_planning.php",
      
      data: {
        Aid_modele_planning: Aid_modele_planning,
        Aid_perio_planning: Aid_perio_planning         
      },
      
      success: function (response) {
        Swal.fire({title: 'Contrôle ajouté avec succès !', icon: 'success'})
  
        document.getElementById("ajout_planning_id_modele").value = '';
        document.getElementById("ajout_planning_id_perio").value = '';
        
        
        $("#ajoutPlanning").modal('hide');
  
        voirPlanning();
      }
    });
      
    return false; 
  }
  

// Remplissage du select modele planning
function remplissage_perio_planning(emplacement){
    
    $.ajax({
      url: "../php/planning/controle_planning.php",
      type: "POST",
      data: {
        remplissage_perio_planning: "remplissagePerio"
      },
      success: function (response) {  
        $("#"+emplacement).html(response);     
       return true;
      },
       
    });
    
}

// Sur validation modal modification planning
function modif_planning(){
    var Mid_modele_planning = document.getElementById("modif_planning_id_modele").value;  
    var Mid_perio_planning = document.getElementById("modif_planning_id_perio").value;
    
    
  
    $.ajax({
      type: "POST",
      url: "../php/planning/controle_planning.php",
      
      data: {
        Mid_modele: Mid_modele_planning,
        Mid_perio: Mid_perio_planning
        
        
          
      },
      
      success: function (response) {
        Swal.fire({title: 'Planning modifié avec succès !', icon: 'success'})
  
        voirPlanning();
      }
    });
      
    return false; 
  }


//////////////////////////////////////////////////////////////////////
$(function () {

    $("body").on("click", "#menu_planning", function (e) {
        voirPlanning();
    });

    // voir planning via le bouton "réveil" liste modèles    
    $("body").on("click", ".periodicites_modele", function (e) {
      
      voirPlanning($(this).attr('id'));
      });
    
    //fermeture modal ajout planning    
    $("#closePlanning").click(function (e) {
        
        // on vide les champs du formulaire
       document.getElementById("ajout_planning_id_modele").value = '';
       document.getElementById("ajout_planning_id_perio").value = '';
       
       // on cache le formulaire
       $("#ajoutPlanning").modal('hide');
    });

    //fermeture modal modif planning    
    $("#closeModifPlanning").click(function (e) {
        
        // on vide les champs du formulaire
       document.getElementById("modif_planning_id_modele").value = '';
       document.getElementById("modif_planning_id_perio").value = '';
       
       // on cache le formulaire
       $("#modifPlanning").modal('hide');
    });

    $("body").on("click", ".ajouterPlanning", function (e) {
        remplissage_modele_planning("ajout_planning_id_modele");
        remplissage_perio_planning("ajout_planning_id_perio");
    });

      // modification d'une ligne planning (Affichage des données dans le modal de modification)     
      $("body").on("click", ".editBtn_planning", function (e) {     
        e.preventDefault();
        $('#modifPlanning').modal('show');
        remplissage_modele_planning('modif_planning_id_modele');
        remplissage_perio_planning('modif_planning_id_perio');
        
        edit_id_planning = $(this).attr('id');
        tab = edit_id_planning.split("-");
        
        
        
        $.ajax({
          url: "../php/planning/controle_planning.php",
          type: "POST",
          data: {
            edit_modele: tab[0],
            edit_perio: tab[1]
          },
          success: function (response) { //console.log(response);   // si OK, on rempli les inputs avec les données en retour
            data = JSON.parse(response);
            $("#modif_planning_id_modele").val(data.id_modele);
            $("#modif_planning_id_perio").val(data.id_perio);
            
          },
        });
        
    });

    // suppression d'un contrôle
    $("body").on("click", ".suppBtn_planning", function (e) { 
        e.preventDefault();
        swal({
            title: "Supprimer la ligne ?",
            text: "Cette action est définitive !!",
            icon: "warning",
            buttons: ["Annuler", "Supprimer"],
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {           
            supp_id_planning = $(this).attr('id')
            tab = supp_id_planning.split("-");
            
            $.ajax({
                url: "../php/planning/controle_planning.php",
                type: "POST",
                data: {
                    supp_modele: tab[0],
                    supp_perio: tab[1],
                }},           
            swal("La ligne a été supprimée", {
                icon: "success",
            }));        
                voirPlanning();    
            }         
        }); 
               
    });
      

    






})