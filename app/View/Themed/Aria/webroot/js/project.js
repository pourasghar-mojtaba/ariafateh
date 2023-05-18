//project effect
$(document).ready(function(){
$(".column-frame-box").mouseenter(function(){
$(this).find('.column-gray-box').fadeIn(350);
});
$(".column-frame-box").mouseleave(function(){
    $(this).find('.column-gray-box').fadeOut(350);
    });
});