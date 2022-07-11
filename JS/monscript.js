// JS Utilisateur

// mise à jour des images
function updateImage(image){
  newImage = image;
 $.ajax({
   url: "controle.php",
   type: "POST",
   data: {
    image_user: newImage
   },
   
   success: function (response) {     
     $("#modalImages").modal('hide');
     location.reload();
     
   },
   error: function(response){
     
   } 
 });  
}

// mise à jour des images de fond
function updateImage(imageFond){
  newImageFond = imageFond;
 $.ajax({
   url: "controle.php",
   type: "POST",
   data: {
    imageFond_user: newImageFond
   },
   
   success: function (response) {     
     $("#modalFond").modal('hide');
     location.reload();
     
   },
   error: function(response){
     
   } 
 });  
}


// Ajout d'un utilisateur
function ajout_user(){
  var Anom = document.getElementById("ajout_nom").value;
  var Aprenom = document.getElementById("ajout_prenom").value;
  var Alogin = document.getElementById("ajout_login").value;
  var Amdp = document.getElementById("ajout_mdp").value;
  var Afonction = document.getElementById("ajout_fonction").value;
   
  $.ajax({
    type: "post",
    url: "controle.php",
    
    data: {
      Aname: Anom,
      Aprenom: Aprenom,
      Alogin: Alogin,
      Amdp: Amdp,
      Afonction: Afonction      
    },
    
    success: function (response) {
      Swal.fire({title: 'Utilisateur ajouté avec succès !', icon: 'success'})
      alert(response);
      document.getElementById("ajout_nom").value = '';
      document.getElementById("ajout_prenom").value = '';
      document.getElementById("ajout_login").value = '';
      document.getElementById("ajout_fonction").value = '';
      document.getElementById("ajout_mdp").value = '';
      document.getElementById("ajout_confirm_mdp").value = '';
      
      $("#ajoutUser").modal('hide');

      showAllUsers();
    }
  });
    
  return false; 
}

function voirTdb(){
  $.ajax({
    url: "controle.php",
    type: "POST",
    data: {
      tdb: "voir"
    },
    success: function (response) { // console.log(response);
      
      $("#showUsers").html(response);
    },
    // La fonction à appeler si la requête n'a pas abouti
    error: function() {
      // J'affiche un message d'erreur
      }  
  });
}

function voirJournalUsers(){
  $.ajax({
    url: "controle.php",
    type: "POST",
    data: {
    journalusers: "voirjournal"
    },
    success: function (response) { // console.log(response);
      
      $("#showUsers").html(response);
    },
    // La fonction à appeler si la requête n'a pas abouti
    error: function() {
      // J'affiche un message d'erreur
      }  
  });
}

function showAllUsers() {
  // on teste si le user est admin pour afficher le bouton "ajouter"
  /*if(typeUtilisateur > 0){
      var root = document.querySelector(':root');
      root.style.setProperty('--visible', 'visible');};*/

  $.ajax({
    url: "controle.php",
    type: "POST",
    data: {
      listingBtn: "view"
    },
    success: function (response) { // console.log(response);
      
      $("#showUsers").html(response);
    },
    // La fonction à appeler si la requête n'a pas abouti
    error: function() {
      // J'affiche un message d'erreur
      }  
  });
}




$(function () {

  $("body").on("click", "#utilisateurs", function (e) {
  showAllUsers();
  });

  $("body").on("click", "#tdb", function (e) {
    voirTdb();
    });

  $("body").on("click", "#menuLoginTitre", function (e) {
    voirTdb();
    });

  $("body").on("click", "#idJournalUsers", function (e) {
    voirJournalUsers();
    });

  $("body").on("click", ".image", function (e) {
    image = $(this).attr('id');
    updateImage(image);
    });

  $("body").on("click", ".imageFond", function (e) {
    imageFond = $(this).attr('id');
    updateImage(imageFond);
    });

  // modification d'un utilisateur (Affichage des données dans le modal de modification)
  $("body").on("click", ".editBtn", function (e) {
    e.preventDefault();
    edit_id = $(this).attr('id');
    $.ajax({
      url: "controle.php",
      type: "POST",
      data: {
        edit_id: edit_id
      },
      success: function (response) { //console.log(response);   // si OK, on rempli les inputs avec les données en retour
        data = JSON.parse(response);
         //console.log(data);
        $("#id").val(data.id_user); // à ce niveau data est sous forme de clef:valeur
        $("#nom").val(data.nom_user);
        $("#prenom").val(data.prenom_user);
        $("#login").val(data.login_user);
        $("#fonction").val(data.fonction_user);
        $("#date").val(data.date_crea_user);
        $("#type").val(data.type_user);
        
      },
    });
  });

  
  // mis à jour après modif d'un utilisateur
 $("#update").click(function (e) {
   if ($("#edit-form-data")[0].checkValidity()){
  e.preventDefault();
  $.ajax({
    url: "controle.php",
    type: "POST",
    data: $("#edit-form-data").serialize() + "&action=update",
    
    success: function (response) { //console.log(response);
      Swal.fire({title: 'Utilisateur modifié avec succès !', icon: 'success'})

      $("#editModal").modal('hide');
      $("#edit-form-data")[0].reset();
      showAllUsers();
      
    },
    error: function(response){
      Swal.fire({title: 'Utilisateur non modifié !', icon: 'danger'})
    } 
  })
}
})

// modification des droits (Affichage des données dans le modal des droits)
$("body").on("click", ".permBtn", function (e) {
  e.preventDefault();
  perm_id = $(this).attr('id');
  $.ajax({
    url: "controle.php",
    type: "POST",
    data: {
      perm_id: perm_id
    },
    success: function (response) { //console.log(response);   // si OK, on rempli les inputs avec les données en retour
      data = JSON.parse(response);
       //console.log(data);
       $("#idperm").val(data.id_user); // à ce niveau data est sous forme de clef:valeur
       $("#id_droits").val(data.id_login);
       $("#typeperm").val(data.type_user);
      
    },
  });
});


 // mise à jour des droits
 $("#updateperm").click(function (e) {
  e.preventDefault();
  if ($("#editperm-form-data")[0].checkValidity()){
 
 
 $.ajax({
   url: "controle.php",
   type: "POST",
   data: $("#editperm-form-data").serialize() + "&action=updateperm",
   
   success: function (response) { //console.log(response);
    
     Swal.fire({title: 'Utilisateur modifié avec succès !', icon: 'success'});
     
     $("#permModal").modal('hide');
     $("#editperm-form-data")[0].reset();
     showAllUsers();
     
   },
   error: function(response){
     Swal.fire({title: 'Utilisateur non modifié !', icon: 'danger'})
   } 
 })
}
  
})


   // suppression d'un utilisateur 
   $("body").on("click", ".suppBtn", function (e) {
    e.preventDefault();
    swal({
      title: "Supprimer cet utilisateur: ID="+$(this).attr('id')+" ? Cette action est définitive !!",
      text: "Cette action est définitive !!",
      icon: "warning",
      buttons: ["Annuler", "Supprimer"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        supp_id = $(this).attr('id');
        $.ajax({
          url: "controle.php",
          type: "POST",
          data: {
            supp_id: supp_id
          }},
                  
           
        swal("L'utilisateur a été supprimé", {
          icon: "success",
        }));
        showAllUsers();
        
      }
      
    });  
  });


// fermeture du modal ajout_utilisateur
$("#closeUser").click(function (e) {
  // on vide les champs du formulaire
  document.getElementById("ajout_nom").value = '';
  document.getElementById("ajout_prenom").value = '';
  document.getElementById("ajout_login").value = '';
  document.getElementById("ajout_fonction").value = '';
  document.getElementById("ajout_mdp").value = '';
  document.getElementById("ajout_confirm_mdp").value = '';
  
  // on cache le formulaire
  $("#ajoutUser").modal('hide');
})

 // Vider le journal des connexions
 $("body").on("click", "#btneffacer", function (e) {
  e.preventDefault();
  swal({
    title: "Effacer le journal ?",
    text: "Cette action est définitive !!",
    icon: "warning",
    buttons: ["Annuler", "Effacer"],
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
        url: "controle.php",
        type: "POST",
        data: {
          effacer: 'viderjournal'
        }},
              
         
      swal("Le journal a été effacé", {
        icon: "success",
      }));
      voirJournalUsers();
    }
    
  });
   
});

  

// ajouter au-dessus pour ajax
});
 












