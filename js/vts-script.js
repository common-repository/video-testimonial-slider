var mySwiper = new Swiper('.swiper-container', {
  pagination: '.swiper-pagination',
  slidesPerView: 5,
  centeredSlides: true,
  spaceBetween: 30,
  slideToClickedSlide: true,
  autoplay: {
    delay: 3000,
  },
  speed: 3000,
  loop: true,
  paginationClickable: true,
  breakpoints: {
    480: {
      slidesPerView: 1,
      spaceBetween: 24,
      resistanceRatio: 0.85,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 28,
      resistanceRatio: 0.85,
    },
    980: {
      slidesPerView: 5,
      spaceBetween: 28,
      resistanceRatio: 0.85,
    },
    1280: {
      slidesPerView: 5,
      spaceBetween: 32,
      resistanceRatio: 0,
    },
  },
});


//Stop & play slider on mouser in out event
jQuery('.swiper-container').on('mouseenter', function(e){
    
    mySwiper.stopAutoplay();
   
  })
jQuery('.swiper-container').on('mouseleave', function(e){
    
    mySwiper.startAutoplay();
  })
  
//YOUTUBE VIDEO
jQuery(document).on('hidden.bs.modal','#myModal', function () {
    jQuery('#youtubevideo').attr('src', '');
});
  
jQuery('.video-play-button').click(function(e){
  
  jQuery('#youtubevideo').attr('src', jQuery(this).data('url'));

})
  

