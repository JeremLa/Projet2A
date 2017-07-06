$(document).ready(function(){
  $('.new-abo-link').each(function(){
    $(this).on('click', function(){
      var title = $(this).attr('data-publication-title');
      var id = $(this).attr('data-publication-id');

      var modal = $('#new-abo');
      modal.find('.publication-title').text(title);
      modal.find('#publication').val(id);
    })
  })

  var $elem = $('#new-abo-search');

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
      url: 'http://gestion.unamag.local/users/search/for-publication',
      data: {
        search: $elem.val(),
        publication: $('#new-abo').find('#publication').val()
      },
      success: function(data){

        // $('.pagination-wrapper').empty().append(data.pagination.view);

        $('.user-list-modal').empty().append(data.users.view);

        $('.add-historical').each(function () {

          $(this).on('click', function () {

            var errorMessage = '<p class="alert alert-warning">Vous ne pouvez selectionner q\'un seul utilisateur pour la création d\'un abonnement</p>';

            if($('#new-abo-search').hasClass('only-one')){
              var count = $('.user-list-final').find('div').length;

              if(count === 1 && $(this).parent().hasClass('user-list-modal')){
                $('#modal-error').empty();
                $('#modal-error').append(errorMessage);
                return;
              }
            }

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
              $('#modal-error').empty();

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
          });
        })
      }
    });
  }

  $('.modal-send').on('click', function(e){
    if(!$('.user-list-final').find('div').length){
      e.preventDefault();

      $('#modal-error').append('<p class="alert alert-warning">Vous ne pouvez selectionner q\'un seul utilisateur pour la création d\'un abonnement</p>');
    }
  })

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
    var ctx = $("#myChart");
    var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: ["-18 ans", "18-25 ans", "25-40 ans", "40-60 ans", "60+"],
            datasets: [{
                label: 'Age des clients',
                    data: $('#chartData').attr('data-chart').split(','),
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
        }
    });


    var depArray = {
        "department-59": {
            value: "0",
            tooltip: {content: "<span style=\"font-weight:bold;\">Nord (59)</span><br />Nb abonnés : 0 "}
            },
        "department-75": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Paris (75)</span><br />Nb abonnés : 0"}
        },
        "department-13": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Bouches-du-Rhône (13)</span><br />Nb abonnés : 0"}
        },
        "department-69": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Rhône (69)</span><br />Nb abonnés : 0"}
        },
        "department-92": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Hauts-de-Seine (92)</span><br />Nb abonnés : 0"}
        },
        "department-93": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Seine-Saint-Denis (93)</span><br />Nb abonnés : 0"}
        },
        "department-62": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Pas-de-Calais (62)</span><br />Nb abonnés : 0"}
        },
        "department-33": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Gironde (33)</span><br />Nb abonnés : 0"}
        },
        "department-78": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Yvelines (78)</span><br />Nb abonnés : 0"}
        },
        "department-77": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Seine-et-Marne (77)</span><br />Nb abonnés : 0"}
        },
        "department-94": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Val-de-Marne (94)</span><br />Nb abonnés : 0"}
        },
        "department-44": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Loire-Atlantique (44)</span><br />Nb abonnés : 0"}
        },
        "department-76": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Seine-Maritime (76)</span><br />Nb abonnés : 0"}
        },
        "department-31": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Haute-Garonne (31)</span><br />Nb abonnés : 0"}
        },
        "department-38": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Isère (38)</span><br />Nb abonnés : 0"}
        },
        "department-91": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Essonne (91)</span><br />Nb abonnés : 0"}
        },
        "department-95": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Val-d'Oise (95)</span><br />Nb abonnés : 0"}
        },
        "department-67": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Bas-Rhin (67)</span><br />Nb abonnés : 0"}
        },
        "department-06": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Alpes-Maritimes (06)</span><br />Nb abonnés : 0"}
        },
        "department-57": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Moselle (57)</span><br />Nb abonnés : 0"}
        },
        "department-34": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Hérault (34)</span><br />Nb abonnés : 0"}
        },
        "department-83": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Var (83)</span><br />Nb abonnés : 0"}
        },
        "department-35": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Ille-et-Vilaine (35)</span><br />Nb abonnés : 0"}
        },
        "department-29": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Finistère (29)</span><br />Nb abonnés : 0"}
        },
        "department-974": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">La Réunion (974)</span><br />Nb abonnés : 0"}
        },
        "department-60": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Oise (60)</span><br />Nb abonnés : 0"}
        },
        "department-49": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Maine-et-Loire (49)</span><br />Nb abonnés : 0"}
        },
        "department-42": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Loire (42)</span><br />Nb abonnés : 0"}
        },
        "department-68": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Haut-Rhin (68)</span><br />Nb abonnés : 0"}
        },
        "department-74": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Haute-Savoie (74)</span><br />Nb abonnés : 0"}
        },
        "department-54": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Meurthe-et-Moselle (54)</span><br />Nb abonnés : 0"}
        },
        "department-56": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Morbihan (56)</span><br />Nb abonnés : 0"}
        },
        "department-30": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Gard (30)</span><br />Nb abonnés : 0"}
        },
        "department-14": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Calvados (14)</span><br />Nb abonnés : 0"}
        },
        "department-45": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Loiret (45)</span><br />Nb abonnés : 0"}
        },
        "department-64": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Pyrénées-Atlantiques (64)</span><br />Nb abonnés : 0"}
        },
        "department-85": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Vendée (85)</span><br />Nb abonnés : 0"}
        },
        "department-63": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Puy-de-Dôme (63)</span><br />Nb abonnés : 0"}
        },
        "department-17": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Charente-Maritime (17)</span><br />Nb abonnés : 0"}
        },
        "department-01": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Ain (01)</span><br />Nb abonnés : 0"}
        },
        "department-22": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Côtes-d'Armor (22)</span><br />Nb abonnés : 0"}
        },
        "department-37": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Indre-et-Loire (37)</span><br />Nb abonnés : 0"}
        },
        "department-27": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Eure (27)</span><br />Nb abonnés : 0"}
        },
        "department-80": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Somme (80)</span><br />Nb abonnés : 0"}
        },
        "department-51": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Marne (51)</span><br />Nb abonnés : 0"}
        },
        "department-72": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Sarthe (72)</span><br />Nb abonnés : 0"}
        },
        "department-71": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Saône-et-Loire (71)</span><br />Nb abonnés : 0"}
        },
        "department-84": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Vaucluse (84)</span><br />Nb abonnés : 0"}
        },
        "department-02": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Aisne (02)</span><br />Nb abonnés : 0"}
        },
        "department-25": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Doubs (25)</span><br />Nb abonnés : 0"}
        },
        "department-21": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Côte-d'Or (21)</span><br />Nb abonnés : 0"}
        },
        "department-50": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Manche (50)</span><br />Nb abonnés : 0"}
        },
        "department-26": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Drôme (26)</span><br />Nb abonnés : 0"}
        },
        "department-66": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Pyrénées-Orientales (66)</span><br />Nb abonnés : 0"}
        },
        "department-28": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Eure-et-Loir (28)</span><br />Nb abonnés : 0"}
        },
        "department-86": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Vienne (86)</span><br />Nb abonnés : 0"}
        },
        "department-73": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Savoie (73)</span><br />Nb abonnés : 0"}
        },
        "department-24": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Dordogne (24)</span><br />Nb abonnés : 0"}
        },
        "department-971": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Guadeloupe (971)</span><br />Nb abonnés : 0"}
        },
        "department-972": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Martinique (972)</span><br />Nb abonnés : 0"}
        },
        "department-40": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Landes (40)</span><br />Nb abonnés : 0"}
        },
        "department-88": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Vosges (88)</span><br />Nb abonnés : 0"}
        },
        "department-81": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Tarn (81)</span><br />Nb abonnés : 0"}
        },
        "department-87": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Haute-Vienne (87)</span><br />Nb abonnés : 0"}
        },
        "department-79": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Deux-Sèvres (79)</span><br />Nb abonnés : 0"}
        },
        "department-11": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Aude (11)</span><br />Nb abonnés : 0"}
        },
        "department-16": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Charente (16)</span><br />Nb abonnés : 0"}
        },
        "department-89": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Yonne (89)</span><br />Nb abonnés : 0"}
        },
        "department-03": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Allier (03)</span><br />Nb abonnés : 0"}
        },
        "department-47": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Lot-et-Garonne (47)</span><br />Nb abonnés : 0"}
        },
        "department-41": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Loir-et-Cher (41)</span><br />Nb abonnés : 0"}
        },
        "department-07": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Ardèche (07)</span><br />Nb abonnés : 0"}
        },
        "department-18": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Cher (18)</span><br />Nb abonnés : 0"}
        },
        "department-53": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Mayenne (53)</span><br />Nb abonnés : 0"}
        },
        "department-10": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Aube (10)</span><br />Nb abonnés : 0"}
        },
        "department-61": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Orne (61)</span><br />Nb abonnés : 0"}
        },
        "department-08": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Ardennes (08)</span><br />Nb abonnés : 0"}
        },
        "department-12": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Aveyron (12)</span><br />Nb abonnés : 0"}
        },
        "department-39": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Jura (39)</span><br />Nb abonnés : 0"}
        },
        "department-19": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Corrèze (19)</span><br />Nb abonnés : 0"}
        },
        "department-82": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Tarn-et-Garonne (82)</span><br />Nb abonnés : 0"}
        },
        "department-70": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Haute-Saône (70)</span><br />Nb abonnés : 0"}
        },
        "department-36": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Indre (36)</span><br />Nb abonnés : 0"}
        },
        "department-65": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Hautes-Pyrénées (65)</span><br />Nb abonnés : 0"}
        },
        "department-43": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Haute-Loire (43)</span><br />Nb abonnés : 0"}
        },
        "department-973": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Guyane (973)</span><br />Nb abonnés : 0"}
        },
        "department-58": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Nièvre (58)</span><br />Nb abonnés : 0"}
        },
        "department-55": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Meuse (55)</span><br />Nb abonnés : 0"}
        },
        "department-32": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Gers (32)</span><br />Nb abonnés : 0"}
        },
        "department-52": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Haute-Marne (52)</span><br />Nb abonnés : 0"}
        },
        "department-46": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Lot (46)</span><br />Nb abonnés : 0"}
        },
        "department-2B": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Haute-Corse (2B)</span><br />Nb abonnés : 0"}
        },
        "department-04": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Alpes-de-Haute-Provence (04)</span><br />Nb abonnés : 0"}
        },
        "department-09": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Ariège (09)</span><br />Nb abonnés : 0"}
        },
        "department-15": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Cantal (15)</span><br />Nb abonnés : 0"}
        },
        "department-90": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Territoire de Belfort (90)</span><br />Nb abonnés : 0"}
        },
        "department-2A": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Corse-du-Sud (2A)</span><br />Nb abonnés : 0"}
        },
        "department-05": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Hautes-Alpes (05)</span><br />Nb abonnés : 0"}
        },
        "department-23": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Creuse (23)</span><br />Nb abonnés : 0"}
        },
        "department-48": {
            value: "0",

            tooltip: {content: "<span style=\"font-weight:bold;\">Lozère (48)</span><br />Nb abonnés : 0"}
        }
    };

var domtom = 0;
    var depData = $("#chartData").attr('data-Hdep-chart');
    var arrDep = depData.split(',');
    console.log(typeof arrDep);
    for(var i=0 ; i< arrDep.length; i++){
        console.log(arrDep[i]);
        var depElem = arrDep[i].split(':');
        if(depElem[0] == 'department-97'){
            domtom = depElem[1];
        }else{
            console.log('avant',depArray[depElem[0]]);
            depArray[depElem[0]]['value'] = depElem[1];
            depArray[depElem[0]]['tooltip']['content'] = depArray[depElem[0]]['tooltip']['content'].slice(0,-1);
            depArray[depElem[0]]['tooltip']['content'] += depElem[1];
            console.log('apres',depArray[depElem[0]]);
            console.log('apres',depArray[depElem[0]]['tooltip']['content']);
        }


    }
    $(".mapContainer").mapael({
        map: {
            name: "france_departments",
            defaultArea: {
                attrs: {
                    stroke: "#fff",
                    "stroke-width": 1
                },
                attrsHover: {
                    "stroke-width": 2
                }
            }
        },
        legend: {
            area: {
                title: "Nb abonnés par département",
                slices: [
                    {
                        max: 0,
                        label: "0 abonné",
                    },
                    {
                        min: 1,
                        max: 5,
                        attrs: {
                            fill: "#CFA0E9"
                        },
                        label: "Moins de 5 abonnés"
                    },
                    {
                        min: 5,
                        max: 10,
                        attrs: {
                            fill: "#B666D2"
                        },
                        label: "Entre 5 et 10 abonnés"
                    },
                    {
                        min: 10,
                        max: 20,
                        attrs: {
                            fill: "#884DA7"
                        },
                        label: "Entre 10 et 20 abonnés"
                    },
                    {
                        min: 20,
                        attrs: {
                            fill: "#800080"
                        },
                        label: "Plus de 20 abonnés"
                    },
                    {
                      label: domtom + " Abonnés DOM-TOM"
                    }
                ]
            }
        },
        areas: depArray
    });
});