//    CONTROLE_SCRIPT.JS

// remplissage de l'input "materiel" dans modal ajout contrôle
function remplissage_ModalAjoutControle(rep_materiel){
  repere_materiel = rep_materiel;
  remplissage_select_rep('ajout_controle_materiel');
  remplissage_perio_planning('ajout_controle_type');
  remplissage_select_user('ajout_controle_user');
  $.ajax({
    type: "POST",
    url: "../php/controles/controle_controle.php",
    
    data: {
      rep_materiel: rep_materiel,
              
    },
    
    success: function (response) {
      
      data = JSON.parse(response);
      $("#ajout_controle_materiel").val(data.id_materiel);        
      $("#ajout_controle_type").val(data.id_perio);
      
      voirControles();
    }
  });
    
  return false; 
}



// voir table des contrôles planifiés
function voirControlesPlanifies(){
  $.ajax({
    url: "../php/controles/controle_controle.php",
    type: "POST",
    data: {
      listingPlanifies: "voirPlanifies"
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

// voir table des retards
function voirRetards(){
  $.ajax({
    url: "../php/controles/controle_controle.php",
    type: "POST",
    data: {
      listingRetards: "voirRetards"
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

// voir table des des contrôles dans les 30 prochains jours
function voir30Jours(){
  $.ajax({
    url: "../php/controles/controle_controle.php",
    type: "POST",
    data: {
      listing30Jours: "voir30Jours"
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

// Ajout d'un contrôle
function ajout_controle(){
    
  var Adate_controle = document.getElementById("ajout_controle_date").value;
  var Arep_controle = document.getElementById("ajout_controle_materiel").value;
  var Atype_controle = document.getElementById("ajout_controle_type").value;
  var Auser_controle = document.getElementById("ajout_controle_user").value;
  var Acommentaire_controle = document.getElementById("ajout_controle_commentaire").value;
  

  $.ajax({
    type: "POST",
    url: "../php/controles/controle_controle.php",
    
    data: {
      Adate_controle: Adate_controle,
      Arep_controle: Arep_controle,
      Atype_controle: Atype_controle,
      Auser_controle: Auser_controle,
      Acommentaire_controle: Acommentaire_controle
      
        
    },
    
    success: function (response) {
      Swal.fire({title: 'Contrôle ajouté avec succès !', icon: 'success'})

      document.getElementById("ajout_controle_date").value = '';
      document.getElementById("ajout_controle_materiel").value = '';
      document.getElementById("ajout_controle_type").value = '';
      document.getElementById("ajout_controle_user").value = '';
      document.getElementById("ajout_controle_commentaire").value = '';
      
      $("#ajoutControle").modal('hide');

      voirControles();
    }
  });
    
  return false; 
}

function modif_controle(){
  var Mid_controle = document.getElementById("modif_controle_id").value;  
  var Mdate_controle = document.getElementById("modif_controle_date").value;
  var Mrep_controle = document.getElementById("modif_controle_materiel").value;
  var Mtype_controle = document.getElementById("modif_controle_type").value;
  var Muser_controle = document.getElementById("modif_controle_user").value;
  var Mcommentaire_controle = document.getElementById("modif_controle_commentaire").value;
  

  $.ajax({
    type: "POST",
    url: "../php/controles/controle_controle.php",
    
    data: {
      Mid_controle: Mid_controle,
      Mdate_controle: Mdate_controle,
      Mrep_controle: Mrep_controle,
      Mtype_controle: Mtype_controle,
      Muser_controle: Muser_controle,
      Mcommentaire_controle: Mcommentaire_controle
      
        
    },
    
    success: function (response) {
      Swal.fire({title: 'Contrôle ajouté avec succès !', icon: 'success'})

      voirControles();
    }
  });
    
  return false; 
}


function voirControles() {
    
      $.ajax({
        url: "../php/controles/controle_controle.php",
        type: "POST",
        data: {
          listingControle: "voirControle"
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

  // Remplissage du select user controle
    function remplissage_select_user(emplacement){
    
    $.ajax({
      url: "../php/controles/controle_controle.php",
      type: "POST",
      data: {
        remplissage_controleur: "remplissageControleur"
      },
      success: function (response) { 
         
        $("#"+emplacement).html(response);     
       return true;
      },
       
    });
    
  }


  // Remplissage du select repere controle
  function remplissage_select_rep(emplacement){
    
    $.ajax({
      url: "../php/controles/controle_controle.php",
      type: "POST",
      data: {
        remplissage_rep: "remplissageRep"
      },
      success: function (response) { 
        
        $("#"+emplacement).html(response);     
       return true;
      },
       
    });
    
  }

  // Remplissage du select type controle
  function remplissage_select_type(emplacement){
    
    $.ajax({
      url: "../php/controles/controle_controle.php",
      type: "POST",
      data: {
        remplissage_type: "remplissageType"
      },
      success: function (response) { 
        
        $("#"+emplacement).html(response);     
       return true;
      },
       
    });
    
  }

  // Remplissage du select type controle avec le planning/matériel
  function remplissage_planning(emplacement, planningIdMateriel){
    $.ajax({
      url: "../php/controles/controle_controle.php",
      type: "POST",
      data: {
        remplissage_planning: "remplissagePlanning",
        planning_id_materiel: planningIdMateriel
      },
      success: function (response) { 
        
        $("#"+emplacement).html(response);     
       return true;
      },
       
    });
    
  }

  
////////////////////////////////////////////////////////////////////////////////
  $(function () {

    $("body").on("click", "#menu_listeControle", function (e) {
        
        voirControles();
    });

    // modal ajout contrôle on change select repère matériel 
    $("body").on("change", "#ajout_controle_materiel", function (e) {        
      var idMateriel = document.getElementById('ajout_controle_materiel').value;
      remplissage_planning("ajout_controle_type", idMateriel);
  });

    //fermeture modal ajout contrôle    
    $("#closeControle").click(function (e) {
        
        // on vide les champs du formulaire
       document.getElementById("ajout_controle_date").value = '';
       document.getElementById("ajout_controle_materiel").value = '';
       document.getElementById("ajout_controle_type").value = '';
       document.getElementById("ajout_controle_user").value = '';
       document.getElementById("ajout_controle_commentaire").value = '';
       
       // on cache le formulaire
       $("#ajoutControle").modal('hide');
    });

    //fermeture modal modif contrôle    
    $("#closeModifControle").click(function (e) {
        
      // on vide les champs du formulaire
     document.getElementById("modif_controle_date").value = '';
     document.getElementById("modif_controle_materiel").value = '';
     document.getElementById("modif_controle_type").value = '';
     document.getElementById("modif_controle_user").value = '';
     document.getElementById("modif_controle_commentaire").value = '';
     
     // on cache le formulaire
     $("#modifControle").modal('hide');
  });

    // modification d'un contrôle (Affichage des données dans le modal de modification)     
    $("body").on("click", ".editBtn_controle", function (e) {     
      e.preventDefault();
      $('#modifControle').modal('show');
      remplissage_select_rep('modif_controle_materiel');
      remplissage_select_user('modif_controle_user');
      remplissage_select_type('modif_controle_type');
      edit_id_controle = $(this).attr('id');
      
      $.ajax({
        url: "../php/controles/controle_controle.php",
        type: "POST",
        data: {
          edit_id_controle: edit_id_controle
        },
        success: function (response) { //console.log(response);   // si OK, on rempli les inputs avec les données en retour
          data = JSON.parse(response);
          
          $("#modif_controle_id").val(data.id_controle);
          $("#modif_controle_date").val(data.date_controle);
          $("#modif_controle_materiel").val(data.id_materiel);
          $("#modif_controle_type").val(data.id_perio);
          $("#modif_controle_user").val(data.id_user);
          $("#modif_controle_commentaire").val(data.comment_controle);
          
        },
      });
      
    });

    // suppression d'un contrôle
    $("body").on("click", ".suppBtn_Controle", function (e) { 
      e.preventDefault();
      swal({
        title: "Supprimer le contrôle N°="+$(this).attr('id')+" ?",
        text: "Cette action est définitive !!",
        icon: "warning",
        buttons: ["Annuler", "Supprimer"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          supp_id_controle = $(this).attr('id');
          
          $.ajax({
            url: "../php/controles/controle_controle.php",
            type: "POST",
            data: {
              supp_id_controle: supp_id_controle
            }},           
          swal("Le contrôle  a été supprimé", {
            icon: "success",
          }));        
           
        }         
      }); 
      voirControles();       
    });

    $("body").on("click", "#menu_listeRetard", function (e) {
      voirRetards();
    });

    $("body").on("click", "#indicateurRetards", function (e) {
      voirRetards();
    });

    $("body").on("click", "#menu_listeMois", function (e) {
    voir30Jours();
    });

    $("body").on("click", "#indicateur30Jours", function (e) {
      voir30Jours();
    });

    $("body").on("click", "#menu_planifies", function (e) {
      voirControlesPlanifies();
      });

    $("body").on("click", ".FaireBtn_controle", function (e) {
      $("#AjoutControle").modal("show");
      remplissage_ModalAjoutControle($(this).attr('id'));
      
      });

    $("body").on("click", ".FaireBtn_controle", function (e) {
      $("#AjoutControle").modal("show");
      remplissage_ModalAjoutControle($(this).attr('id'));
      
      });  

       
    //Pour ajax écrire ci-dessus 

  });