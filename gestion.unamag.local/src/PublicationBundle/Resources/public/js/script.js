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

  //setup before functions
  var typingTimer;                //timer identifier
  var doneTypingInterval = 1000;  //time in ms (5 seconds)

  //on keyup, start the countdown
  $elem.keyup(function () {
    clearTimeout(typingTimer);

    if(!$elem.val()){
      $('.user-list-modal').empty();
      return;
    }

    typingTimer = setTimeout(doneTyping, doneTypingInterval);
  });

  //user is "finished typing," do something
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
          // if($('.remove-'+$(this).attr('data-user-id')).length){
          //     $(this).addClass("hidden");
          // }

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
            // $('.user-list-final').append('<div class="btn glyphicon glyphicon-minus remove-historical remove-'+ $(this).attr('data-user-id') +'" data-user-id="'+$(this).attr('data-user-id')+'">'+$(this).attr('data-user-name')+'</div>');

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
});