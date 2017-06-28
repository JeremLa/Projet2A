// Change style of navbar on scroll
window.onscroll = function() {navChange()};

function navChange() {
  // var navbar = document.getElementById("myNavbar");
  var navbar = $("#myNavbar");
  if(navbar){
    if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
      navbar.removeClass().addClass('w3-white w3-bar');
      navbar.find('')
    } else {
      navbar.removeClass().addClass('w3-text-white w3-bar');
    }
  }
}

// Used to toggle the menu on small screens when clicking on the menu button
function toggleFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") === -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}

$(document).ready(function(){
  $('#dropDown-button').on('click', function(){

    var $dropDown = $('#blabla');

    if ($dropDown.hasClass('hidden')){
      $dropDown.removeClass('hidden')
    }else{
      $dropDown.addClass('hidden');
    }
  });
})