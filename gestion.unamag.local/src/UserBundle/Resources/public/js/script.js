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

    var $elem = $('#recherche');

    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 1000;  //time in ms (5 seconds)

    //on keyup, start the countdown
    $elem.keyup(function () {
        clearTimeout(typingTimer);

        // if ($elem.val()) {
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    //user is "finished typing," do something
    function doneTyping () {
        $.ajax({
            url: 'http://gestion.unamag.local/users/search',
            data: {
                search: $elem.val(),
                page: 1,
                view: '@User/User/historical-partial/search-user-list.html.twig'
            },
            success: function(data){

                // $('.pagination-wrapper').empty().append(data.pagination.view);

                $('.user-list-modal').empty().append(data.users.view);

                $('.add-historical').each(function () {
                    if($('.remove-'+$(this).attr('data-user-id')).length){

                        $(this).addClass("hidden");
                    }

                    $(this).on('click', function () {
                        if($('.send-user-list').val() == ""){
                            $('.send-user-list').val($(this).attr('data-user-id'));
                        }else {
                            $('.send-user-list').val($('.send-user-list').val() + ',' + $(this).attr('data-user-id'));
                        }
                        $('.user-list-final').append('<div class="btn glyphicon glyphicon-minus remove-historical remove-'+ $(this).attr('data-user-id') +'" data-user-id="'+$(this).attr('data-user-id')+'">'+$(this).attr('data-user-name')+'</div>');
                        $('.remove-historical').each(function () {
                            $(this).on('click', function () {
                                $('.add-'+$(this).attr('data-user-id')).removeClass('hidden');
                                var tab = $('.send-user-list').val().split(',');
                                var first = true;
                                for(var i in tab){
                                    if(tab[i] != $(this).attr('data-user-id')){
                                        if(first){
                                            $('.send-user-list').val(tab[i]);
                                            first = false;
                                        }else{
                                            $('.send-user-list').val($('.send-user-list').val() +','+tab[i]);
                                        }
                                    }else{
                                        if(tab.length == 1){
                                            $('.send-user-list').val('');
                                        }
                                    }
                                }
                                $(this).remove();
                            })
                        });
                      $(this).addClass("hidden");
                    });

                })
            },
            complete: function(){

            },
            error: function(){
                alert('error');
            }
        });
    }



});
