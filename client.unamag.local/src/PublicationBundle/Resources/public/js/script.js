$(document).ready(function () {
// var prefix = "http://client.unamag.local";
var prefix = "http://10.0.10.115/projet2a/client.unamag.local/web";

  $('#subscribe-validate').on('click', function(){
    var url = prefix + '/abonnement/new';

    // $(this).addClass('disabled');

    $.ajax({
      url: url,
      data: {
        publication: $(this).attr('data-publication-id')
      },
      success: function(data){
      }
    })
  });

});