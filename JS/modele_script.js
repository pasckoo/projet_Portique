// JS MODELE


function voirModeles() {
  remplissage_select("ajout_modele_id_famille");
    $.ajax({
      url: "../php/modeles/controle_modele.php",
      type: "POST",
      data: {
        listingModele: "voirModele"
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

// Ajout d'un modèle à une famille de matériel
function ajout_modele(){
    
    var Atype_modele = document.getElementById("ajout_modele_type").value;
    var Adesignation_modele = document.getElementById("ajout_modele_designation").value;
    var Aid_famille_modele = document.getElementById("ajout_modele_id_famille").value;
     
    $.ajax({
      type: "POST",
      url: "../php/modeles/controle_modele.php",
      
      data: {
        Atype_modele: Atype_modele,
        Adesignation_modele: Adesignation_modele,
        Aid_famille_modele: Aid_famille_modele,    
      },
      
      success: function (response) {
        Swal.fire({title: 'Pensez à ajouter tout de suite des périodicités pour ce nouveau modèle dans la table Planning', icon: 'success'})
  
        document.getElementById("ajout_modele_type").value = '';
        document.getElementById("ajout_modele_designation").value = '';
        document.getElementById("ajout_modele_id_famille").value = '4';
        
        
        $("#ajoutModele").modal('hide');
  
        voirModeles();
      }
    });
      
    return false; 
  }
  

$(function () {
    // voir modèles via le menu vertical
    $("body").on("click", "#menu_modeles", function (e) {
        voirModeles();
        });

    

    //fermeture modal ajout modèle    
    $("#closeModele").click(function (e) {
        
         // on vide les champs du formulaire
        document.getElementById("ajout_modele_type").value = '';
        document.getElementById("ajout_modele_designation").value = '';
        document.getElementById("ajout_modele_id_famille").value = '';
        
        // on cache le formulaire
        $("#ajoutModele").modal('hide');
        });

       
        
    // suppression d'un modèle
    $("body").on("click", ".suppBtn_Modele", function (e) { 
      e.preventDefault();
      swal({
        title: "Supprimer le modèle N°="+$(this).attr('id')+" ?",
        text: "Cette action est définitive !!",
        icon: "warning",
        buttons: ["Annuler", "Supprimer"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          supp_id_modele = $(this).attr('id');
          
          $.ajax({
            url: "../php/modeles/controle_modele.php",
            type: "POST",
            data: {
              supp_id_modele: supp_id_modele
            }},           
          swal("Le modèle  a été supprimé", {
            icon: "success",
          }));        
          voirModeles();  
        }         
      }); 
             
    });
    
    // modification d'un modèle (Affichage des données dans le modal de modification)     
    $("body").on("click", ".editBtn_modele", function (e) {     
      e.preventDefault();
      edit_id_modele = $(this).attr('id');
      remplissage_select("modif_modele_id_famille");
      $.ajax({
        url: "../php/modeles/controle_modele.php",
        type: "POST",
        data: {
          edit_id_modele: edit_id_modele
        },
        success: function (response) { //console.log(response);   // si OK, on rempli les inputs avec les données en retour
          data = JSON.parse(response);
          //console.log(data);
          $("#modif_modele_id").val(data.id_modele); // à ce niveau data est sous forme de cle:valeur
          $("#modif_modele_type").val(data.type_modele);
          $("#modif_modele_designation").val(data.designation_modele);
          $("#modif_modele_id_famille").val(data.id_famille);
        },
      });
      
    });


    // mis à jour après modif d'une famille de matériel
    $("#update_modele").click(function (e) {
      var Mid_modele = document.getElementById("modif_modele_id").value;
      var Mtype_modele = document.getElementById("modif_modele_type").value;
      var Mdesignation_modele = document.getElementById("modif_modele_designation").value;
      var Mid_famille_modele = document.getElementById("modif_modele_id_famille").value;
      
    e.preventDefault();
    $.ajax({
      url: "../php/modeles/controle_modele.php",
      type: "POST",
      data: {
            Mid_modele: Mid_modele,
            Mtype_modele: Mtype_modele,
            Mdesignation_modele: Mdesignation_modele,
            Mid_famille_modele: Mid_famille_modele,
      },
      success: function (response) { //console.log(response);
        Swal.fire({title: 'Modèle modifié avec succès !', icon: 'success'})

        $("#editModal_modele").modal('hide');
        voirModeles();        
      },
      error: function(response){
        Swal.fire({title: 'Modèle non modifié !', icon: 'danger'})
      } 
    })
  
});




    
// mettre au-dessus pour $(function)
})
