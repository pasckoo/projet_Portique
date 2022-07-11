// JS Famille


function voirFamilles() {
    // on teste si le user est admin pour afficher le bouton "ajouter"
    /*if(typeUtilisateur > 0){
      var root = document.querySelector(':root');
      root.style.setProperty('--visible', 'visible');};*/

    $.ajax({
      url: "../php/familles/controle_famille.php",
      type: "POST",
      data: {
        listingFamille: "voirFamille"
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

// Ajout d'une famille de matériel
function ajout_famille(){
    var Acategorie = document.getElementById("ajout_famille_categorie").value;
    var Adesignation = document.getElementById("ajout_famille_designation").value;
    var Aperio1 = document.getElementById("ajout_famille_perio1").value;
    var Aperio2 = document.getElementById("ajout_famille_perio2").value;
    var Aperio3 = document.getElementById("ajout_famille_perio3").value;
     
    $.ajax({
      type: "POST",
      url: "../php/familles/controle_famille.php",
      
      data: {
        Acategorie: Acategorie,
        Adesignation: Adesignation,
        Aperio1: Aperio1,
        Aperio2: Aperio2,
        Aperio3: Aperio3      
      },
      
      success: function (response) {
        Swal.fire({title: 'Famille ajoutée avec succès !', icon: 'success'})
  
        document.getElementById("ajout_famille_categorie").value = '';
        document.getElementById("ajout_famille_designation").value = '';
        document.getElementById("ajout_famille_perio1").value = '';
        document.getElementById("ajout_famille_perio2").value = '';
        document.getElementById("ajout_famille_perio3").value = '';
        
        $("#ajoutFamille").modal('hide');
  
        voirFamilles();
      }
    });
      
    return false; 
  }
  

$(function () {

    $("body").on("click", "#menu_familles", function (e) {
        voirFamilles();
        });

    //fermeture modal ajout famille    
    $("#closeFamille").click(function (e) {
      
         // on vide les champs du formulaire
        document.getElementById("ajout_famille_categorie").value = '';
        document.getElementById("ajout_famille_designation").value = '';
        document.getElementById("ajout_famille_perio1").value = '';
        document.getElementById("ajout_famille_perio2").value = '';
        document.getElementById("ajout_famille_perio3").value = '';
        
        // on cache le formulaire
        $("#ajoutFamille").modal('hide');
        });


    //fermeture modal edit famille    
    $("#closeEditFamille").click(function (e) {
      
    /*  // on vide les champs du formulaire
     document.getElementById("ajout_famille_categorie").value = '';
     document.getElementById("ajout_famille_designation").value = '';
     document.getElementById("ajout_famille_perio1").value = '';
     document.getElementById("ajout_famille_perio2").value = '';
     document.getElementById("ajout_famille_perio3").value = '';*/
     
     // on cache le formulaire
     $("#editModal_famille").modal('hide');
     });    
        
    // suppression d'une famille de matériel
    $("body").on("click", ".suppBtn_Famille", function (e) { 
      e.preventDefault();
      swal({
        title: "Supprimer la famille N°="+$(this).attr('id')+" ?",
        text: "Cette action est définitive !!",
        icon: "warning",
        buttons: ["Annuler", "Supprimer"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          supp_id_famille = $(this).attr('id');
          $.ajax({
            url: "../php/familles/controle_famille.php",
            type: "POST",
            data: {
              supp_id_famille: supp_id_famille
            }},           
          swal("La famille  a été supprimée", {
            icon: "success",
          }));        
          voirFamilles();  
        }         
      }); 
             
    });
    
    // modification d'une famille (Affichage des données dans le modal de modification)
    $("body").on("click", ".editBtn_famille", function (e) {
      e.preventDefault();
      edit_id_famille = $(this).attr('id');
      $.ajax({
        url: "../php/familles/controle_famille.php",
        type: "POST",
        data: {
          edit_id_famille: edit_id_famille
        },
        success: function (response) { //console.log(response);   // si OK, on rempli les inputs avec les données en retour
          data = JSON.parse(response);
          //console.log(data);
          $("#modif_famille_id").val(data.id_famille); // à ce niveau data est sous forme de clef:valeur
          $("#modif_famille_categorie").val(data.categorie_famille);
          $("#modif_famille_designation").val(data.designation_famille);
          $("#modif_famille_perio1").val(data.periodicite1_famille);
          $("#modif_famille_perio2").val(data.periodicite2_famille);
          $("#modif_famille_perio3").val(data.periodicite3_famille);
          
        },
      });
    });


    // mis à jour après modif d'une famille de matériel
    $("#update_famille").click(function (e) {
      var Mid = document.getElementById("modif_famille_id").value;
      var Mcategorie = document.getElementById("modif_famille_categorie").value;
      var Mdesignation = document.getElementById("modif_famille_designation").value;
      var Mperio1 = document.getElementById("modif_famille_perio1").value;
      var Mperio2 = document.getElementById("modif_famille_perio2").value;
      var Mperio3 = document.getElementById("modif_famille_perio3").value;
      
    e.preventDefault();
    $.ajax({
      url: "../php/familles/controle_famille.php",
      type: "POST",
      data: {
            Mid: Mid,
            Mcategorie: Mcategorie,
            Mdesignation: Mdesignation,
            Mperio1: Mperio1,
            Mperio2: Mperio2,
            Mperio3: Mperio3 
      },
      success: function (response) { //console.log(response);
        Swal.fire({title: 'Utilisateur modifié avec succès !', icon: 'success'})

        $("#editModal_famille").modal('hide');
        voirFamilles();
        
        
      },
      error: function(response){
        Swal.fire({title: 'Utilisateur non modifié !', icon: 'danger'})
      } 
    })
  
});




    
// mettre au-dessus pour $(function)
})
