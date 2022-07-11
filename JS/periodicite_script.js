/////// JS PERIODICITE  ////////


function voirPerios() {
    
    $.ajax({
      url: "../php/periodicites/controle_periodicite.php",
      type: "POST",
      data: {
        listingPerio: "voirPerio"
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

// Ajout d'une périodicité
function ajout_perio(){
  var Aintitule_perio = document.getElementById("ajout_perio_intitule").value;
  var Atype_perio = document.getElementById("ajout_perio_type").value;  
  var Anb_perio = document.getElementById("ajout_perio_nb").value;
  var Acommentaire_perio = document.getElementById("ajout_perio_commentaire").value; 

  $.ajax({
    type: "POST",
    url: "../php/periodicites/controle_periodicite.php",
    
    data: {
      Aintitule_perio: Aintitule_perio,
      Atype_perio: Atype_perio,
      Anb_perio: Anb_perio,
      Acommentaire_perio: Acommentaire_perio     
    },
    
    success: function (response) {
      Swal.fire({title: 'Périodicité ajoutée avec succès !', icon: 'success'})

      document.getElementById("ajout_perio_intitule").value = "";
      document.getElementById("ajout_perio_type").value = "";
      document.getElementById("ajout_perio_nb").value = "";
      document.getElementById("ajout_perio_commentaire").value = "";
      
      $("#ajoutPerio").modal('hide');

      voirPerios();
    }
  });
    
  return false; 
}

$(function () {

    $("body").on("click", "#menu_perios", function (e) {
        voirPerios();
        });

    //fermeture modal ajout périodicité    
    $("#closePerio").click(function (e) {
      // on vide les champs du formulaire
     document.getElementById("ajout_perio_intitule").value = '';
     document.getElementById("ajout_perio_type").value = '';
     document.getElementById("ajout_perio_type").value = '';
     document.getElementById("ajout_perio_nb").value = '';
     document.getElementById("ajout_perio_commentaire").value = '';
    
     // on cache le formulaire
     $("#ajoutPerio").modal('hide');
     });

    // suppression d'une périodicité
    $("body").on("click", ".suppBtn_Perio", function (e) { 
      e.preventDefault();
      swal({
        title: "Supprimer la périodicité N°="+$(this).attr('id')+" ?",
        text: "Cette action est définitive !!",
        icon: "warning",
        buttons: ["Annuler", "Supprimer"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          supp_id_perio = $(this).attr('id');
          $.ajax({
            url: "../php/periodicites/controle_periodicite.php",
            type: "POST",
            data: {
              supp_id_perio: supp_id_perio
            }},           
          swal("La périodicité a été supprimée", {
            icon: "success",
          }));        
          voirPerios();  
        }         
      }); 
             
    });

     // modification d'une périodicité (Affichage des données dans le modal de modification)
     $("body").on("click", ".editBtn_perio", function (e) {
      e.preventDefault();
      edit_id_perio = $(this).attr('id');
      $.ajax({
        url: "../php/periodicites/controle_periodicite.php",
        type: "POST",
        data: {
          edit_id_perio: edit_id_perio
        },
        success: function (response) {//console.log(response);   // si OK, on rempli les inputs avec les données en retour
          
          data = JSON.parse(response);
          //console.log(data);
          $("#modif_perio_id").val(data.id_perio); // à ce niveau data est sous forme de clef:valeur
          $("#modif_perio_intitule").val(data.intitule_perio);
          $("#modif_perio_type").val(data.type_perio);
          $("#modif_perio_nb").val(data.nb_perio); 
          $("#modif_perio_commentaire").val(data.commentaire_perio);            
        },
      });
    });

    // mise à jour après modif d'une périodicité
    $("#update_perio").click(function (e) {
    var Mid_perio = document.getElementById("modif_perio_id").value;
    var Mintitule_perio = document.getElementById("modif_perio_intitule").value;
    var Mtype_perio = document.getElementById("modif_perio_type").value;
    var Mnb_perio = document.getElementById("modif_perio_nb").value;
    var Mcommentaire_perio = document.getElementById("modif_perio_commentaire").value;
    
    e.preventDefault();
    $.ajax({
      url: "../php/periodicites/controle_periodicite.php",
      type: "POST",
      data: {
            Mid_perio: Mid_perio,
            Mintitule_perio: Mintitule_perio,
            Mtype_perio: Mtype_perio,
            Mnb_perio: Mnb_perio, 
            Mcommentaire_perio: Mcommentaire_perio,
      },
    success: function (response) { //console.log(response);
      Swal.fire({title: 'Périodicité modifiée avec succès !', icon: 'success'})

      $("#editModal_perio").modal('hide');
      voirPerios();
      
      
    },
    error: function(response){
      Swal.fire({title: 'Périodicité non modifiée !', icon: 'danger'})
    } 
  })

});


// mettre au-dessus pour $(function)    
});