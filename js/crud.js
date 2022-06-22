$(document).ready(function() {
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

    $('[data-toggle="tooltip"]').tooltip();

    getTopPaiements();

    getTopParascolaires();
    
    function login() {
        $.ajax({
            url:'./login.php',
            type:'POST',
        //    dataType:"json",
            data: {email:$("#username").val(), password:$("#password").val()},
            success: function(response) {
                if(response == "KO") {
                    showError("Identifiants incorrectes");
                } else {
                    showInfo("OK : Username= "+$("#username").val());
                 //   window.open('./index.php?auth=ok','_self');
                    window.location.href= "./index.php?auth=ok";

                }
            },
            error:function(response) {
                showError("Error: "+response.responseType);
            }
        });
    }

    $("#form_login").submit(function(e){
        //e.preventDefault();
        //login();
    });

   // Parascolaire
       function createParascolaire() {
        //create_Parascolaire_form
        $.ajax({
            url:"./parascolaires/add.php",
            method:"post",
            data: $("#create_parascolaire_form").serialize(),
            success:function(response) {
                if(response=="OK") {
                    showInfo("Activité parascolaire ajoutée avec succès.");
                    setTimeout(
                        function () {
                            $("#modalCreerParascolaire").hide();
                            window.open('parascolaire.php?add=ok', '_self');
                        }, 2000);
                }
                else {  
                    showError("Echec de l'ajout de l'activité parascolaire: "+response.responseText);
                    setTimeout(
                        function() {
                            $("#modalCreerParascolaire").hide();
                            window.open('parascolaire.php?add=ko','_self');},2000);
                }
            },
            error:function(response) {
                showError("Echec de l'ajout de l'activité parascolaire: "+response);
            }
        });
    }





    // Transport
    function createTransport() {
        //create_transport_form
        $.ajax({
            url:"./transport/add.php",
            method:"post",
            data: $("#create_transport_form").serialize(),
            success:function(response) {
                if(response=="OK") {
                    showInfo("Transport ajouté avec succès.");
                    setTimeout(
                        function () {
                            $("#modalCreerTransport").hide();
                            window.open('transport.php?add=ok', '_self');
                        }, 2000);
                }
                else {
                    showError("Echec de l'ajout du transport: "+response.responseText);
                    setTimeout(
                        function() {
                            $("#modalCreerTransport").hide();
                            window.open('transport.php?add=ko','_self');},2000);
                }
            },
            error:function(response) {
                showError("Echec de l'ajout du transport: "+response);
                /*  setTimeout(
                 function() {
                 $("#modalCreerMedecin").hide();
                 window.open('medecin.php?auth=ko','_self');},2000);*/
                /* setTimeout(
                 function() {
                 $("#modalCreerMedecin").hide();
                 window.open('medecin.php?auth=ko','_self');},2000);*/
            }
        });
    }
    function createMedecin() {
        $.ajax({
           url:"./medecins/add.php",
           method:"post",
            data: $("#create_medecin_form").serialize(),
            success:function(response) {
                if(response=="OK") {
                    showInfo("Médecin ajouté avec succès.");
                    setTimeout(
                        function () {
                            $("#modalCreerMedecin").hide();
                            window.open('medecin.php?add=ok', '_self');
                        }, 2000);
                }
                else {
                    showError("Echec de l'ajout du médecin: "+response.responseText);
                    setTimeout(
                        function() {
                            $("#modalCreerMedecin").hide();
                            window.open('medecin.php?add=ko','_self');},2000);
                }
            },
            error:function(response) {
                showError("Echec de l'ajout du médecin: "+response);
              /*  setTimeout(
                    function() {
                        $("#modalCreerMedecin").hide();
                        window.open('medecin.php?auth=ko','_self');},2000);*/
               /* setTimeout(
                    function() {
                        $("#modalCreerMedecin").hide();
                        window.open('medecin.php?auth=ko','_self');},2000);*/
            }
        });
    }

    function createDossierForTransport() {
        $.ajax({
            url:"./dossiertransport/add.php",
            method:"post",
            data: $("#create_dm_transport_form").serialize(),
            success:function(response) {
                if(response=="OK") {
                    showInfo("Dossier médical ajouté avec succès.");
                    setTimeout(
                        function () {
                            //$("#modalAddDossierMedical_").hide();
                            window.open('transport.php?add=ok', '_self');
                        }, 2000);
                }
                else {
                    showError("Echec de l'ajout du dossier médical: "+response.responseText);
                    setTimeout(
                        function() {
                            //$("#modalCreerTransport").hide();
                            window.open('transport.php?add=ko','_self');},2000);
                }
            },
            error:function(response) {
                showError("Echec de l'ajout du dossier médical: "+response);
                /*  setTimeout(
                 function() {
                 $("#modalCreerMedecin").hide();
                 window.open('medecin.php?auth=ko','_self');},2000);*/
                /* setTimeout(
                 function() {
                 $("#modalCreerMedecin").hide();
                 window.open('medecin.php?auth=ko','_self');},2000);*/
            }
        });
    }

    function  createRendezVous() {
        $.ajax({
            url:"./rendezvous/add.php",
            method:"post",
            data: $("#create_rdv_form").serialize(),
            success:function(response) {
                if(response=="OK") {
                    showInfo("Rendez-vous ajouté avec succès.");
                    setTimeout(
                        function () {
                            //$("#modalAddDossierMedical_").hide();
                            window.open('rendezvous.php?add=ok', '_self');
                        }, 2000);
                }
                else {
                    showError("Echec de l'ajout du rendez-vous: "+response.responseText);
                    setTimeout(
                        function() {
                            //$("#modalCreerTransport").hide();
                            window.open('rendezvous.php?add=ko','_self');},2000);
                }
            },
            error:function(response) {
                showError("Echec de l'ajout du rendez-vous: "+response);
                /*  setTimeout(
                 function() {
                 $("#modalCreerMedecin").hide();
                 window.open('medecin.php?auth=ko','_self');},2000);*/
                /* setTimeout(
                 function() {
                 $("#modalCreerMedecin").hide();
                 window.open('medecin.php?auth=ko','_self');},2000);*/
            }
        });
    }

    function validateRendezVous() {
        $.ajax({
            url:"./rendezvous/validate.php",
            method:"post",
            data: $("#validate_rdv_form").serialize(),
            success:function(response) {
                if(response=="OK") {
                    showInfo("Rendez-vous validé avec succès.");
                    setTimeout(
                        function () {
                            //$("#modalAddDossierMedical_").hide();
                            window.open('rendezvous.php?validate=ok', '_self');
                        }, 2000);
                }
                else {
                    showError("Echec de la validation du rendez-vous: "+response.responseText);
                    setTimeout(
                        function() {
                            //$("#modalCreerTransport").hide();
                            window.open('rendezvous.php?validate=ko','_self');},2000);
                }
            },
            error:function(response) {
                showError("Echec de la validation du rendez-vous: "+response);
                /*  setTimeout(
                 function() {
                 $("#modalCreerMedecin").hide();
                 window.open('medecin.php?auth=ko','_self');},2000);*/
                /* setTimeout(
                 function() {
                 $("#modalCreerMedecin").hide();
                 window.open('medecin.php?auth=ko','_self');},2000);*/
            }
        });
    }

    
    $("#btn_modal_edit_transport").click(function() {
        var tr = $(this).parents("tr");
        var matricule = tr.find('td').data("tr-montant"); 
        var id=tr.find("tr td").data("tr-id");
        console.log(matricule);
    });
    
    function getMedecins() {
        $.ajax({
           url:"medecin.php",
           method:"get",
            dataType:"json",
            success:function(response) {
                $.each(response,function(i,item) {
                    medecins.push(item);
                });
            },
            error:function(response) {

            }
        });
        return medecins;
    }

   function getTopPaiements() {
    $.ajax({
            url:"./paiement/PaiementDAO.php",
            method:"GET",
            dataType:"json",
            success:function(response) {
                $("#t_top_paiement tbody").append("<tr><td></td><td>"+response.date_paiement+"</td><td>"+response.nom_prenom_eleve+"</td></tr>");
               
            },
            error:function(response) {
                showError("Echec du chargement des paiements: "+response);
            }
        });

   }

      function getTopParascolaires() {
    $.ajax({
            url:"./parascolaires/ParascolaireDAO.php",
            method:"GET",
            dataType:"json",
            success:function(response) {
                $.each(response,function(i,item) {
                $("#t_top_parascolaire tbody").append("<tr><td>#</td><td>"+item.type+"</td><td>"+item.somme+"</td></tr>");
               });
            },
            error:function(response) {
                showError("Echec du chargement des paiements: "+response);
            }
        });

   }
    $("#create_medecin_form").submit(function(e) {
        e.preventDefault();
        createMedecin();
    });

    $("#create_transport_form").submit(function(e) {
        e.preventDefault();
        createTransport();
    });

    $("#create_dm_transport_form").submit(function(e) {
        e.preventDefault();
        createDossierForTransport();
    });

   $("#create_parascolaire_form").submit(function(e) {
      e.preventDefault();
      createParascolaire();
   });

    $("#create_rdv_form").submit(function(e) {
        e.preventDefault();
        createRendezVous();
    });

    $("#validate_rdv_form").submit(function(e) {
        e.preventDefault();
        validateRendezVous();
    });

 
    //rdv_validate_form
    //create_dm_transport_form
});