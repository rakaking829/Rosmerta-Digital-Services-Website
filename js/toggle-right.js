$(document).ready(function() {
  $(".homeslider").slick({
  arrows: true,
  dots: false,
  slidesToShow: 3,
  autoplay: true,
  speed: 900,
  autoplaySpeed: 700,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 550,
      settings: {
        slidesToShow: 1
      }
    }
  ]
 });
 });