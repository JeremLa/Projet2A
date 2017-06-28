$(document).ready(function() {
  // $('.search-input').on('input', function () {
    var $elem = $('.search-input');

    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 1000;  //time in ms (5 seconds)

    //on keyup, start the countdown
    $elem.keyup(function () {
      clearTimeout(typingTimer);
      // if ($elem.val()) {
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
      // }else{
      //   $.ajax({
      //     url:''
      //   })
      // }
    });

    //user is "finished typing," do something
    function doneTyping () {
      $.ajax({
        url: 'http://gestion.unamag.local/users/search',
        data: {
          search: $elem.val(),
          page: 1,
          view: '@User/User/index-partial/user-list.html.twig'
        },
        success: function(data){
          $('.pagination-wrapper').empty().append(data.pagination.view);
          $('.user-list').empty().append(data.users.view);
        },
        complete: function(){

        },
        error: function(){

        }
      });
    }
  // });
});