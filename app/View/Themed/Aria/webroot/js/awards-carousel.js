//   project new carousel
$(document).ready(function(){
$('#awards-carousel').owlCarousel({
    loop:false,
    margin:10,
    rtl:true,
    autoplay:false,
    autoplayTimeout:3000,
    nav:true,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        
        },
     368:{
        	 items:2,
            nav:false
        },

        650:{
            items:3,
            nav:false
  
        },
        992:{
            items:4,
            nav:true
  
        },
        1200:{
            items:5,
            nav:true

          
        }
    }
});
$( ".owl-prev").html('<i class="fas fa-angle-double-right slider-nav-btn"></i>');
$( ".owl-next").html('<i class="fas fa-angle-double-left slider-nav-btn"></i>');

});
 const lb = lightbox();