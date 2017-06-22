$(document).ready(function(){
  $('#open-login').on('click', function(){
    $('#modal-login').show();
  })

  $('#close-login').on('click', function(){
    $('#modal-login').hide();
  })

  $('#open-register').on('click', function(){
    $('#modal-register').show();
  })

  $('#close-register').on('click', function(){
    $('#modal-register').hide();
  })
});