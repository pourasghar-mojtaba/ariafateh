$(document).ready(function(){
	
$('.pagination-main .page-item').click(function(e){
	e.preventDefault();
	$('.pagination-main .page-item').removeClass('active');
	if($(this).hasClass("active")){
		$('.pagination-main .page-item').removeClass('active');
	}
	else{
		$(this).addClass('active');
	}
});
});