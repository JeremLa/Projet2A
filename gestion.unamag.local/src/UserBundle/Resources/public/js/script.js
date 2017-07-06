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

    $(".user-payment-button").each(function () {
        var elem = $(this);
        elem.on("click", function () {

                $("#modalMaxRefund").html('Prix total de l\'abonnement : ' + $(this).attr('data-amount') +' €<br>Remboursement effectué : '
                    + ($(this).attr('data-amount') - $(this).attr('data-price')) +' €<br>Remboursement possible : '
                    + $(this).attr('data-price') + ' €');


            $("#amount").attr('max',$(this).attr('data-price'));
            $("#amount").val(0);
            $("#transaction_Id").val($(this).attr('data-id'));
            $("#max").off().on("click",function () {
                $("#amount").val(elem.attr('data-price'));
            });
        });

    });

    $('.user-payment-mail').each(function () {
        var elem = $(this);
        elem.on('click', function () {
            if(activationAjax){
                return;
            }
            var element = $(this);
            activationAjax = $.ajax({
                url: "http://gestion.unamag.local/remboursement/mail",
                method: "POST",
                data: {
                    id: elem.attr("data-id")
                },
                success: function (data) {
                    var succes = "Le mail a bien été envoyé";
                    var $success = $(".success");

                    $success.html(succes);
                    $success.removeClass('hidden');
                    $success.show();

                    setTimeout(function () {
                        $success.fadeOut(1000);
                        setTimeout(function () {
                            $success.empty();
                        },1000);
                        },3000);

                },
                complete: function (data) {
                    activationAjax = null;
                },
                error: function (data) {
                    var error = "Une erreur est survenu, merci de re essayer";
                    var $errors = $(".errors");
                    $errors.html(error);
                    $errors.removeClass('hidden');
                    setTimeout(function () {
                        $errors.fadeOut(1000);
                        setTimeout(function () {
                            $errors.empty();
                        },1000);
                    },3000);
                }

            })
        })
    });

    $(".abo-activation-button").each(function () {
        $(".abo-activation-button").on("click", function () {
            if(activationAjax){
                return;
            }
            var elem = $(this);
            activationAjax = $.ajax({
                url: "http://gestion.unamag.local/abonnement/changeActif",
                method: "POST",
                data: {
                    id: elem.attr("data-id")
                },
                success: function (data) {
                    if(elem.hasClass("btn-danger")){
                        elem.removeClass('btn-danger').addClass('btn-success');
                        elem.html("Redemarrer");
                        if($(".abo-status-"+elem.attr("data-id")).length) {
                            $(".abo-status-" + elem.attr("data-id")).html("Arrêté");
                        }
                    }else{
                        elem.removeClass('btn-success').addClass('btn-danger');
                        elem.html("Arrêter");
                        if($(".abo-status-"+elem.attr("data-id")).length){
                            $(".abo-status-"+elem.attr("data-id")).html("En cours");
                        }
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

    var typingTimer;                //timer identifier
    var doneTypingInterval = 1000;  //time in ms (5 seconds)

    $elem.keyup(function () {
        clearTimeout(typingTimer);

        if(!$elem.val()){
          $('.user-list-modal').empty();
          return;
        }

        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    function doneTyping () {
        $.ajax({
            url: 'http://gestion.unamag.local/users/search',
            data: {
                search: $elem.val(),
                page: 1,
                view: '@User/User/historical-partial/search-user-list.html.twig'
            },
            success: function(data){

                $('.user-list-modal').empty().append(data.users.view);

                $('.add-historical').each(function () {
                    $(this).on('click', function () {

                        if($(this).parent().hasClass('user-list-modal')){
                          $(this).prependTo('.user-list-final');
                          $(this).find('i').attr('class', 'glyphicon glyphicon-minus');

                          if($('.send-user-list').val() == ""){
                            $('.send-user-list').val($(this).attr('data-user-id'));
                          }else {
                            $('.send-user-list').val($('.send-user-list').val() + ',' + $(this).attr('data-user-id'));
                          }
                        }
                        else if($(this).parent().hasClass('user-list-final')){
                          $(this).appendTo('.user-list-modal');
                          $(this).find('i').attr('class', 'glyphicon glyphicon-plus');

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
                        }

                      $(this).addClass("hidden");
                    });

                })
            }
        });
    }

    $('#onglets').css('display', 'block');
    $('#onglets').click(function(event) {
        var actuel = event.target;
        if (!/li/i.test(actuel.nodeName) || actuel.className.indexOf('actif') > -1) {
            return;
        }
        $(actuel).addClass('actif').siblings().removeClass('actif');
        setDisplay();
    });
    function setDisplay() {
        var modeAffichage;
        $('#onglets li').each(function(rang) {
            modeAffichage = $(this).hasClass('actif') ? '' : 'none';
            $('.item').eq(rang).css('display', modeAffichage);
        });
    }
    setDisplay();



    function pagination(nbParPage,divSelect,divPager,model)
    {
        //Initialisation
        var nbElem = $(divSelect).length;
        var nbPage = Math.ceil(nbElem / nbParPage);
        var pageLoad = 1;

        $(divSelect).each(function(index) {
            if (index < nbParPage)
                $(divSelect).eq(index).show();
            else
                $(divSelect).eq(index).hide();
        });

        //Reset & vérification
        function reset() {
            if (nbPage < 2) $(divPager).hide();
            if (pageLoad == nbPage) $(divPager + ' span.suivant').hide(); else $(divPager + ' span.suivant').show();
            if (pageLoad == 1) $(divPager + ' span.precedent').hide(); else $(divPager + ' span.precedent').show();
            $(divPager + ' ul li').removeClass('selected');
            $(divPager + ' ul li').eq(pageLoad -1).addClass('selected');
        }

        //Pagination génération
        if (model != 1) {
            $(divPager).html('<ul></ul>');
            for(i = 1; i <= nbPage; i++) $(divPager + ' ul').append('<li>' + i + '</li>');

            //Changement click page
            $(divPager + ' ul li').click(function() {
                if ($(this).index() + 1 != pageLoad) {
                    pageLoad = $(this).index() + 1;
                    $(divSelect).hide();

                    $(divSelect).each(function(i) {
                        if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).show();
                    });

                    reset();
                }
            });
        }

        //Suivant Précédent
        if (model == 1) {
            $(divPager).prepend('<span class="precedent">Precedent</span>');
            $(divPager).append('<span class="suivant">Suivant></span>');
        } else if (model == 3) {
            $(divPager + ' ul').before('<span class="precedent">Precedent</span>');
            $(divPager + ' ul').after('<span class="suivant">Suivant</span>');
        }

        //Evènement click sur suivant
        $(divPager + ' span.suivant').click(function() {
            if (pageLoad < nbPage) {
                pageLoad += 1;
                $(divSelect).hide();

                $(divSelect).each(function(i) {
                    if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).show();
                });

                reset();
            }
        });

        //Evènement click sur précédent
        $(divPager + ' span.precedent').click(function() {
            if (pageLoad -1 >= 1) {
                pageLoad -= 1;
                $(divSelect).hide();

                $(divSelect).each(function(i) {
                    if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).show();
                });

                reset();
            }
        });

        reset();
    }
    pagination(10,'.histo','.paginator',3);
    pagination(10,'.abolist','.abopaginator',3);
    pagination(10,'.sublist','.subpaginator',3);
    pagination(10,'.paylist','.paymentpaginator',3);

});
