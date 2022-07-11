/////// JS SECTEUR  ////////


function voirSecteurs() {
    
    $.ajax({
      url: "../php/secteurs/controle_secteur.php",
      type: "POST",
      data: {
        listingSecteur: "voirSecteur"
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
 
// Ajout d'un secteur
function ajout_secteur(){
  var Adesignation_secteur = document.getElementById("ajout_secteur_designation").value;
  var Acommentaire_secteur = document.getElementById("ajout_secteur_commentaire").value;  
  $.ajax({
    type: "POST",
    url: "../php/secteurs/controle_secteur.php",
    
    data: {
      Adesignation_secteur: Adesignation_secteur,
      Acommentaire_secteur: Acommentaire_secteur     
    },
    
    success: function (response) {
      Swal.fire({title: 'Secteur ajouté avec succès !', icon: 'success'})

      document.getElementById("ajout_secteur_designation").value = '';
      document.getElementById("ajout_secteur_commentaire").value = '';
      
      
      $("#ajoutSecteur").modal('hide');

      voirSecteurs();
    }
  });
    
  return false; 
}


$(function () {

    $("body").on("click", "#menu_secteurs", function (e) {
        voirSecteurs();
        });

    
    //fermeture modal ajout secteur    
    $("#closeSecteur").click(function (e) {
      // on vide les champs du formulaire
     document.getElementById("ajout_secteur_designation").value = '';
     document.getElementById("ajout_secteur_commentaire").value = '';
     
     // on cache le formulaire
     $("#ajoutSecteur").modal('hide');
     });    

     // suppression d'un secteur
    $("body").on("click", ".suppBtn_Secteur", function (e) { 
      e.preventDefault();
      swal({
        title: "Supprimer le secteur N°="+$(this).attr('id')+" ?",
        text: "Cette action est définitive !!",
        icon: "warning",
        buttons: ["Annuler", "Supprimer"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          supp_id_secteur = $(this).attr('id');
          $.ajax({
            url: "../php/secteurs/controle_secteur.php",
            type: "POST",
            data: {
              supp_id_secteur: supp_id_secteur
            }},           
          swal("Le secteur a été supprimée", {
            icon: "success",
          }));        
          voirSecteurs();  
        }         
      }); 
             
    });

     // modification d'un secteur (Affichage des données dans le modal de modification)
     $("body").on("click", ".editBtn_secteur", function (e) {
      e.preventDefault();
      edit_id_secteur = $(this).attr('id');
      $.ajax({
        url: "../php/secteurs/controle_secteur.php",
        type: "POST",
        data: {
          edit_id_secteur: edit_id_secteur
        },
        success: function (response) { //console.log(response);   // si OK, on rempli les inputs avec les données en retour
          data = JSON.parse(response);
          //console.log(data);
          $("#modif_secteur_id").val(data.id_secteur); // à ce niveau data est sous forme de clef:valeur
          $("#modif_secteur_designation").val(data.designation_secteur);
          $("#modif_secteur_commentaire").val(data.commentaire_secteur);         
        },
      });
    });

     // mise à jour après modif d'un secteur
     $("#update_secteur").click(function (e) {
      var Mid_secteur = document.getElementById("modif_secteur_id").value;
      var Mdesignation_secteur = document.getElementById("modif_secteur_designation").value;
      var Mcommentaire_secteur = document.getElementById("modif_secteur_commentaire").value;
      
    e.preventDefault();
    $.ajax({
      url: "../php/secteurs/controle_secteur.php",
      type: "POST",
      data: {
            Mid_secteur: Mid_secteur,
            Mdesignation_secteur: Mdesignation_secteur,
            Mcommentaire_secteur: Mcommentaire_secteur
      },
      success: function (response) { //console.log(response);
        Swal.fire({title: 'Secteur modifié avec succès !', icon: 'success'})

        $("#editModal_secteur").modal('hide');
        voirSecteurs();
        
        
      },
      error: function(response){
        Swal.fire({title: 'Secteur non modifié !', icon: 'danger'})
      } 
    })
  
  });
    
// mettre au-dessus pour $(function)
})
