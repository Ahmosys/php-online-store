$(document).ready(function () {
    var formValide;

    //--------------------------------------------------------
    //TRAITEMENT DATABLES - https://datatables.net/
    //--------------------------------------------------------
    $('#myTable').DataTable({
        ordering: true,
        paging: true,
    });

    //--------------------------------------------------------
    //TRAITEMENT LORSQUE CLIC SUR BOUTON SUBMIT
    //--------------------------------------------------------
    $("#submit").click(function () {
        formValide = true;

        //Traitements de toutes les zones de saisies
        $("#registerUser input[type=text], #registerUser input[type=password] ").each(function () {
            controleSaisie($(this).prop("id"));
        });

        return formValide;
    });

    //--------------------------------------------------------
    //TRAITEMENT LORSQUE LES ZONES DE SAISIES PERDENT LE FOCUS
    //--------------------------------------------------------
    $("#registerUser input[type=text], #registerUser input[type=password]").blur(
            function () {
                controleSaisie($(this).prop("id"));
            }
    );

    //---------------------------------------------
    // TRAITEMENT CHECKBOX NEWSLETTER CHANGE D'ETAT
    //---------------------------------------------
    $("#checkbox_newsletter").click(function () {
        if ($("#checkbox_newsletter").is(":checked")) {
            $("#checkbox_newsletter").val("yes");
        } else {
            $("#checkbox_newsletter").val("no");
        };
    });
    
    //---------------------------------------------
    // TRAITEMENT BOUTON VOIR MOT DE PASSE CLICK
    //---------------------------------------------
    $("#btn_view_password").click(function() {
       if($("#login_password").attr("type") == "password") {
           $("#btn_view_password").children().removeClass("fa-eye").addClass("fa-eye-slash");
           $("#login_password").attr("type", "text");
       } else {
           $("#btn_view_password").children().removeClass("fa-eye-slash").addClass("fa-eye");
           $("#login_password").attr("type", "password");
       }
    });
    
    //---------------------------------------------
    // TRAITEMENT INPUT - SHOW TABLE
    //---------------------------------------------
    $("#searchOccurrence").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

});

//-------------------------------------
// TRAITEMENT DES CONTRÔLES DE SAISIES
//-------------------------------------
function controleSaisie(idchamp) {
    switch (idchamp) {
        case "register_password":
            traiterMotDePasse();
            break;
        case "register_confirm_password":
            traiterMotDePasse();
            break;
        case "register_username":
            cherchePseudoBD();
            break;
        default:
    }
}

//--------------------------------------------------------
// TRAITEMENT POUR LE MOT DE PASSE
//--------------------------------------------------------
function traiterMotDePasse() {
    var pass1 = $("#register_password").val();
    var pass2 = $("#register_confirm_password").val();
    if (pass1 != "" && pass2 != "" && pass1 == pass2) {
        $("#alert_placeholder_password")
                .removeClass("text font-italic text-danger")
                .addClass("text font-italic text-success")
                .text("The two passwords are the same ! ✔️")
                .fadeIn();
        formValide = true;
    } else {
        $("#alert_placeholder_password")
                .removeClass("text font-italic text-success")
                .addClass("text font-italic text-danger")
                .text("The two passwords are not the same ! 🚫")
                .fadeIn();
        formValide = false;
    }
}

//----------------------------------------
// TRAITEMENT VERIFICATION PSEUDO EXISTANT
//----------------------------------------
function cherchePseudoBD() {
    $.ajax({
        async: true, // Mode asynchrone non utilisé (false)
        type: "POST",
        url: "../../libs/username_search.php", // Nom du script PHP exécuté
        data: "pseudo=" + $("#register_username").val(), // Données envoyés au script PHP
        success: function (reponse) {
            // Réponse = 1 donc pseudo trouvé en base nbResultat = 1
            if (reponse == 1) {
                $("#alert_placeholder_username")
                        .removeClass("text font-italic text-success")
                        .addClass("text font-italic text-danger")
                        .text("And no! The username already exists 🚫")
                        .show();
                formValide = false;
                pseudoExistant = true;
            } else {
                $("#alert_placeholder_username")
                        .removeClass("text font-italic text-danger")
                        .addClass("text font-italic text-success")
                        .text("This username is available ! ✔️")
                        .show();
                formValide = true;
                pseudoExistant = false;
            }
        },
    });
}
