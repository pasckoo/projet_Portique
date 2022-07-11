//----- JS MATERIEL_SCRIPT ------

var secteur = "";
var famille = "";
var modele = "";

// Affichage de la table contrôle pour 1 matériel
function affichage_controles_materiel(id_materiel){  
  var affichage_id = id_materiel;
      
  $.ajax({ 
    type: "POST",
    url: "../php/materiels/controle_materiel.php",    
    data: {
          Tid_materiel:  affichage_id

    },
    success: function (response){ //console.log(response);
      $("#showUsers").html(response);  
      //Swal.fire({title: 'Matériel modifié avec succès !', icon: 'success'})
     
    }
     
  })
}


// mise à jour après modif d'un matériel
function modif_materiel(){
  var Mid_materiel = document.getElementById("afficher_materiel_id").value;
  var Mrep_materiel = document.getElementById("afficher_materiel_rep").value;
  var Mdesignation_materiel = document.getElementById("afficher_materiel_designation").value;
  var Mreference_materiel = document.getElementById("afficher_materiel_reference").value;
  var Mmes_materiel = document.getElementById("afficher_materiel_mes").value;
  var Mcommentaire_materiel = document.getElementById("afficher_materiel_commentaire").value;
  var Mid_secteur = document.getElementById("afficher_id_secteur").value;
  var Mid_famille = document.getElementById("afficher_id_famille").value;
  var Mid_modele = document.getElementById("afficher_cacher_modele").value;
  //alert(Mid_modele);
  $.ajax({ 
    type: "POST",
    url: "../php/materiels/controle_materiel.php",    
    data: {
          Mid_materiel:  Mid_materiel,
          Mrep_materiel: Mrep_materiel,
          Mdesignation_materiel: Mdesignation_materiel,
          Mreference_materiel: Mreference_materiel,
          Mmes_materiel: Mmes_materiel,
          Mcommentaire_materiel: Mcommentaire_materiel,
          Mid_secteur: Mid_secteur,
          Mid_famille: Mid_famille,
          Mid_modele: Mid_modele

    },
  success: function (response){ //console.log(response);
     
    Swal.fire({title: 'Matériel modifié avec succès !', icon: 'success'})
    voirMateriels(); 
           
  },
  error: function(response){
    Swal.fire({title: 'Matériel non modifié !', icon: 'warning'})
  } 
});
return false; 

};

 

  // (Affichage des données d'un matériel dans le formulaire Afficher matériel)   
  function remplissage_form_materiel(id_materiel){   
    var afficher_id_materiel = id_materiel;       
    $.ajax({
      url: "../php/materiels/controle_materiel.php",
      type: "POST",
      
      data: {
        afficher_id_materiel: afficher_id_materiel
      },
      success: function (response) {
        data = JSON.parse(response);
        
        $("#afficher_materiel_id").val(data.id_materiel); // à ce niveau data est sous forme de cle:valeur
        $("#afficher_materiel_rep").val(data.rep_materiel);
        $("#afficher_materiel_designation").val(data.designation_materiel);
        $("#afficher_materiel_reference").val(data.reference_materiel);
        $("#afficher_materiel_mes").val(data.date_mes_materiel);
        $("#afficher_materiel_commentaire").val(data.commentaire_materiel);
        $("#afficher_id_secteur").val(data.id_secteur);
        $("#afficher_id_famille").val(data.id_famille);
        remplissage_modele("afficher_id_modele", "afficher_id_famille");
        $("#afficher_cacher_modele").val(data.id_modele);
        $("#afficher_type_modele").val(data.type_modele);
        $("#afficherProchainControle").val(data.controleAvantLe);

      }
    });
    
  };


// Remplissage du select Famille
function remplissage_select(emplacement){
  
  $.ajax({
    url: "../php/modeles/controle_modele.php",
    type: "POST",
    data: {
      remplissage: "remplissage"
    },
    success: function (response) { 
      famille = response; 
      $("#"+emplacement).html(response);    
     return true;
    },
     
  });
  
}

// Remplissage du select modele
function remplissage_modele(emplacement, emplacementFamille){
  
  var id_famille = document.getElementById(emplacementFamille).value;
  $.ajax({
    url: "../php/modeles/controle_modele.php",
    type: "POST",
    data: {
      remplissage_modele: "remplissage_modele",
      id_famille: id_famille,
    },
    success: function (response) {    
      $("#"+emplacement).html(response);
      modele = response;
    
      return true;
      
    },
    // La fonction à appeler si la requête n'a pas abouti
    error: function() {
      // J'affiche un message d'erreur
      }  
  });
  
}

// Remplissage du select secteur
function remplissage_select_secteur(emplacement){
  $.ajax({
    url: "../php/modeles/controle_modele.php",
    type: "POST",
    data: {
      remplissage_secteur: "remplissage_secteur"
    },
    success: function (response){ 
     secteur = response;  
     
     
      return true;
    },
    // La fonction à appeler si la requête n'a pas abouti
    error: function() {
      // J'affiche un message d'erreur
      }  
  });
  
}

// affichage de la page d'un matériel sur le tableau de bord
function voir_ajout_materiel(){
  $.ajax({
    url: "../php/materiels/controle_materiel.php",
    type: "POST",
    data: {
      ajoutMateriel: "ajoutMateriel"
    },
    success: function (response) {          
      $("#showUsers").html(response);
      $("#ajout_id_secteur").html(secteur);
      $("#ajout_id_famille").html(famille);
      
    },
    // La fonction à appeler si la requête n'a pas abouti
    error: function() {
      // J'affiche un message d'erreur
      }  
  });

}


// affichage de la page d'un matériel sur le tableau de bord
function afficher_Form_materiel(id_materiel){
  var titre = id_materiel;
  $.ajax({
    url: "../php/materiels/controle_materiel.php",
    type: "POST",
    data: {
      afficherMateriel: "afficherMateriel",
      titre: titre,
    },
    success: function (response) {   
      $("#showUsers").html(response);
      $("#afficher_id_secteur").html(secteur);
      $("#afficher_id_famille").html(famille);
      remplissage_form_materiel(id_materiel);    
    },
    // La fonction à appeler si la requête n'a pas abouti
    error: function() {
      // J'affiche un message d'erreur
      }  
  });

}

// affichage tableau Matériel
function voirMateriels() {
  $.ajax({
    url: "../php/materiels/controle_materiel.php",
    type: "POST",
    data: {
      listingMateriels: "voirMateriels"
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
 
  // Ajout d'un matériel
function ajout_materiel(){
  var Arep_materiel = document.getElementById("ajout_materiel_rep").value;
  var Adesignation_materiel = document.getElementById("ajout_materiel_designation").value;
  var Areference_materiel = document.getElementById("ajout_materiel_reference").value;
  var Ames_materiel = document.getElementById("ajout_materiel_mes").value;
  var Acommentaire_materiel = document.getElementById("ajout_materiel_commentaire").value;
  var Aid_secteur = document.getElementById("ajout_id_secteur").value;
  var Aid_modele = document.getElementById("ajout_id_modele").value;
  var Aid_famille = document.getElementById("ajout_id_famille").value;
   
  $.ajax({
    type: "POST",
    url: "../php/materiels/controle_materiel.php",    
    data: {
      Arep_materiel: Arep_materiel,
      Adesignation_materiel: Adesignation_materiel,
      Areference_materiel: Areference_materiel,
      Ames_materiel: Ames_materiel,
      Acommentaire_materiel: Acommentaire_materiel,
      Aid_secteur: Aid_secteur,
      Aid_modele: Aid_modele,
      Aid_famille: Aid_famille,         
    },
    
    success: function (response) {
      Swal.fire({title: 'Matériel ajouté avec succès !', icon: 'success'})
      // on vide les champs du formulaire
      document.getElementById("ajout_materiel_rep").value = '';
      document.getElementById("ajout_materiel_designation").value = '';
      document.getElementById("ajout_materiel_reference").value = '';
      document.getElementById("ajout_materiel_mes").value = '';
      document.getElementById("ajout_materiel_commentaire").value = '';
      document.getElementById("ajout_id_secteur").value = '';
      document.getElementById("ajout_id_famille").value = '';
      document.getElementById("ajout_id_modele").value = '';

      voirMateriels();
    }
  });
    
  return false; 
}



remplissage_select_secteur();
remplissage_select();

/////////////////////////////////////////////////////////////////////////////////

  $(function () {

    // afficher la table matériel via le menu vertical gauche 
    $("body").on("click", "#menu_listeMateriel", function (e) {
        
        voirMateriels();

        
    });


    // afficher la table matériel via le bouton retour de la page "Afficher un matériel"
    $("body").on("click", "#afficher_materiel_retour", function (e) {
        voirMateriels();
      
    });

    // afficher la table matériel via le bouton retour de la page "Ajouter un matériel"
    $("body").on("click", "#ajout_materiel_retour", function (e) {

      voirMateriels();
    
  });

    // afficher la table matériel via le bouton retour de la page "Modification d'un matériel"
    $("body").on("click", "#modif_materiel_retour", function (e) {

        voirMateriels();
      
      
    });

    // click sur bouton "ajouter matériel" 
    $("body").on("click", ".ajouterMateriel", function (e) {
      voir_ajout_materiel();
      $("#ajout_id_secteur").html(secteur);
      $("#ajout_id_famille").html(famille);

      });

      // remplissage du select modèle sur changement du select famille pour ajout matériel
    $("body").on("change", "#ajout_id_famille", (e) => {
        remplissage_modele("ajout_id_modele", "ajout_id_famille");
      }); 

    $("body").on("change", "#afficher_id_famille", (e) => {
      remplissage_modele("afficher_id_modele", "afficher_id_famille");     
      $("#afficher_cacher_modele").val("");
      $("#afficher_type_modele").val("");
    }); 

    $("body").on("change", "#afficher_id_modele", (e) => {
      remplissage_modele("afficher_id_modele", "afficher_id_famille");
      $("#afficher_type_modele").val($("#afficher_id_modele option:selected").text());
      $("#afficher_cacher_modele").val($("#afficher_id_modele option:selected").val());
      
    });

    // suppression d'un matériel
    $("body").on("click", ".suppBtn_materiel", function (e) { 
      idMateriel = $(this).attr('id');
      e.preventDefault();
      swal({
        title: "Supprimer le matériel N°="+idMateriel+" ?",
        text: "Cette action est définitive !!",
        icon: "warning",
        buttons: ["Annuler", "Supprimer"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          supp_id_materiel = idMateriel;
          
          $.ajax({
            url: "../php/materiels/controle_materiel.php",
            type: "POST",
            data: {
              supp_id_materiel: supp_id_materiel
            }},           
          swal("Le matériel  a été supprimé", {
            icon: "success",
          }));        
        voirMateriels();    
        }         
      }); 
            
    });

     // (Affichage du formulaire Afficher matériel)  
    $("body").on("click", ".voirBtn_materiel", function (e) {   
      e.preventDefault(); 
      var afficher_id_materiel = $(this).attr('id');       
      afficher_Form_materiel(afficher_id_materiel); 
              
    });

     // (Affichage du formulaire Afficher matériel)  
     $("body").on("click", "#afficher_materiel_controle", function (e) {   
      e.preventDefault(); 
      
      var controle_id_materiel = document.getElementById("afficher_materiel_id").value; 
      affichage_controles_materiel(controle_id_materiel);      
      
              
    });

    // (Affichage du formulaire Ajout matériel)  
    $("body").on("click", "#menu_ajout_materiel", function (e) { 
      e.preventDefault();     
      voir_ajout_materiel();
              
    });
    
  
  
  


//Mettre code ajax au-dessus        
});
