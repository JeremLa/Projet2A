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
  // var prefix = 'http://client.unamag.local';
  var prefix = 'http://10.0.10.115/projet2a/client.unamag.local/web';

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

    if($(window).scrollTop() + $(window).height() >= $(document).height()-15) {
      if(typeof $('.next-button') !== typeof undefined && $('.next-button').length){
        nextPubli();
      }
    }
  }

  $('#dropDown-button').on('click', function(){

    var $dropDown = $('#dropDown-content');

    if ($dropDown.hasClass('hidden')){
      $dropDown.removeClass('hidden')
    }else{
      $dropDown.addClass('hidden');
    }
  });

  $(".modal-opener").each(function(){
    console.log('test');
    $(this).on('click', function(){
      var modalId = $(this).attr('data-modal-open-id');

      $('#'+modalId).addClass('show');

    });
  }).children().click(function(e) {
    return false;
  });

  $(".modal-closer").each(function(){
    $(this).on('click', function(e){
      if(e.target === $(this)[0]){
        var modalId = $(this).attr('data-modal-close-id');
        $('#'+modalId).removeClass('show');
      }
    });
  });

  // $('.next-button').on('click', function(){
  //   nextPubli();
  // });

  function nextPubli() {
    var elem = $('.next-button');

    if(elem.find('i').hasClass('fa-spinner')){
      return;
    }

    elem.find('i').attr('class', 'fa fa-spinner fa-pulse')

    $.ajax({
      url: prefix + '/publication',
      data: {
        offset: $('.publication-elem').length,
        full: false
      },
      success: function(data){
        $('.next-wrapper').remove();
        $('.publication-wrapper').append(data);
      }
    });
  }

  var scrollTrigger = 100, // px
    backToTop = function () {
      var scrollTop = $(window).scrollTop();
      if (scrollTop > scrollTrigger) {
        $('#back-to-top').addClass('show');
      } else {
        $('#back-to-top').removeClass('show');
      }
    };
  backToTop();
  $(window).on('scroll', function () {
    backToTop();
  });
  $('#back-to-top').on('click', function (e) {
    e.preventDefault();
    $('html,body').animate({
      scrollTop: 0
    }, 700);
  });

  var $elem = $('.search-input');

  //setup before functions
  var typingTimer;                //timer identifier
  var doneTypingInterval = 1000;  //time in ms (5 seconds)
  var data = {
    search: '',
    limit: 3,
    offset: 0,
    full: false
  }

  //on keyup, start the countdown
  $elem.keyup(function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
  });

  //user is "finished typing," do something
  function doneTyping () {
    data.search = $elem.val();

    var url = prefix+'/publication';

    getSearchAjax(url)
  }

  function getSearchAjax(url){
    $.ajax({
      url: url,
      data: data,
      success: function(datas){
        $('.next-wrapper').remove();
        $('.publication-wrapper').empty().append(datas);

      }
    });
  }
})