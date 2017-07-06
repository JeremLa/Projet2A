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
        type: 'doughnut',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
    var ctx2 = $("#myChart2");
    var myChart2 = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
});