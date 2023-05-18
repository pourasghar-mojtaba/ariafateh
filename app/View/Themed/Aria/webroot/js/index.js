
$(document).ready(function(){
    $('.main-slider').owlCarousel({
        loop:true,
        rtl:true,
        autoplay:true,
        autoplayTimeout:4500,
        nav:true,
        items : 1, 
      itemsDesktop : false,
      itemsDesktopSmall : false,
      itemsTablet: false,
      itemsMobile : false,
      animateIn: 'fadeIn',
      animateOut: 'fadeOut'
       
    });
  
    $( ".owl-prev").html('<i class="fas fa-angle-double-right slider-nav-btn"></i>');
    $( ".owl-next").html('<i class="fas fa-angle-double-left slider-nav-btn"></i>');
});

// company
$(document).ready(function(){
  $('#company-carousel').owlCarousel({
      loop:false,
      margin:10,
      autoplay:false,
      rtl:true,
      nav:true,
      responsiveClass:true,
      responsive:{
          0:{
              items:1,
              nav:false
          
          },
          360:{
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
 

//   project new carousel
    $('#project-new-carousel').owlCarousel({
        loop:false,
        margin:10,
        rtl:true,
        autoplay:false,
        autoplayTimeout:2500,
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
    

    $('#winner-carousel').owlCarousel({
        loop:true,
        margin:10,
        rtl:true,
        autoplay:true,
        autoplayTimeout:5000,
        nav:false,
       items:1,
    });
    // menu tab link
$(document).ready(function(){
        $('#help-tab .help-item').click(function(){
          $('.help-item').removeClass("active");
          $(this).addClass("active");
      });

      });
    
    $( function() {

        $( "#help-tab" ).tabs();
      });

    


