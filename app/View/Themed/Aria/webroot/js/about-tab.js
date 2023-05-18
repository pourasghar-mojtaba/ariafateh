$(document).ready(function() {    

$('#about-tab li a:not(:first)').addClass('inactive');
$('.about-tab-container').hide();
$('.about-tab-container:first').show();
    
$('#about-tab  li a').click(function(){
    var t = $(this).attr('id');
  if($(this).hasClass('inactive')){ //this is the start of our condition 
    $('#about-tab li a').addClass('inactive');           
    $(this).removeClass('inactive');
    
    $('.about-tab-container').hide();
    $('#'+ t + 'C').fadeIn('slow');
 }
});

});