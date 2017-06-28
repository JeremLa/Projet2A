$(document).ready(function () {

  $('#subscribe-validate').on('click', function(){
    var url = 'http://client.unamag.local/abonnement/new';

    // $(this).addClass('disabled');

    $.ajax({
      url: url,
      data: {
        publication: $(this).attr('data-publication-id')
      },
      success: function(data){
        console.log(data);
      }
    })
  });

});