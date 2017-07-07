$(document).ready(function() {
  // $('.search-input').on('input', function () {
    var $elem = $('.search-input');

    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 1000;  //time in ms (5 seconds)
    var data = {
      search: '',
      page: 1,
      searchClass: '',
      limit: 8
    }

    //on keyup, start the countdown
    $elem.keyup(function () {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    //user is "finished typing," do something
    function doneTyping () {

      data.searchClass = $elem.attr('data-class-search');
      data.search = $elem.val();

      if(data.searchClass === 'publication'){
        data.limit = 8;
      }

      if(data.searchClass === 'user'){
        data.limit = 10;
      }

      var url = 'http://gestion.unamag.local/tools/search';

      getSearchAjax(url)

    }

    function getSearchAjax(url){
      $.ajax({
        url: url,
        data: data,
        success: function(datas){
          $('.pagination-wrapper').empty().append(datas.paginationView);
          $('.data-list').empty().append(datas.datasView);

          $('.search-link').each(function(){
            $(this).off().on('click', function(e){
              e.preventDefault();

              var url = 'http://gestion.unamag.local' + $(this).attr('href');
              data.page = $(this).attr('data-page');

              getSearchAjax(url);
            })
          })
        }
      });
    }
  // });
});