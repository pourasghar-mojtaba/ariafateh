// menu active link
$(document).ready(function(){
    $(document).ready(function(){
        $('ul.navbar-nav li').click(function(){
          $('li').removeClass("active");
          $(this).addClass("active");
      });
      });

// menu dropdown
$('ul.navbar-nav li.dropdown').hover(function() {
	$(this).find('.megamenu-caret').stop(true, true).delay(200).fadeIn(300);
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(300);
  }, function() {
  	$(this).find('.megamenu-caret').stop(true, true).delay(200).fadeOut(300);
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(300);
  });
// menu dropdown end
});