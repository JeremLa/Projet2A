/**
 * Created by BabyRoger on 23/06/2017.
 */
$(document).ready(function () {
    var activationAjax = null;
    $(".user-activation-button").each(function () {
        $(".user-activation-button").on("click", function () {
            if(activationAjax){
                return;
            }
            var elem = $(this);
            activationAjax = $.ajax({
                url: "http://gestion.unamag.local/users/changeActif",
                method: "POST",
                data: {
                    id: elem.attr("data-id")
                },
                success: function (data) {
                    if(elem.hasClass("btn-danger")){
                        elem.removeClass('btn-danger').addClass('btn-success');
                        elem.html("Activer le compte");
                    }else{
                        elem.removeClass('btn-success').addClass('btn-danger');
                        elem.html("Désactiver le compte");
                    }
                },
                complete: function (data) {
                    activationAjax = null;
                },
                error: function (data) {
                    var error = "Une erreur est survenu, merci de re essayer";
                    var $errors = $(".errors");
                    $errors.html(error);
                    $errors.show();
                    setTimeout(function () {
                        $errors.hide();
                        $errors.empty();
                    },3000)
                }

            })

        })
    });

    $('#recherche').type({

        source : 'http://gestion.unamag.local/users',
        select: function (event, ui) {
            $('#recherche').val(ui.item.value);
        }

    });
});
