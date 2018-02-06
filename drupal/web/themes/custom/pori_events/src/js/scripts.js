(function ($, Drupal) {

  'use strict';

  // Drupal.behaviors.exampleBehavior = {
  //   attach: function (context) {
  //     $('.example', context).once('exampleBehavior').each(function () {
  //       // Do things.
  //     });
  //   }
  // };

  Drupal.behaviors.slickSlider = {
    attach: function (context) {
      $('.slide-container__content .field__items', context).once('slickSlider').slick({
        autoplay: true,
        autoplaySpeed: 6000,
        pauseOnHover: true,
        infinite: true,
        slidesToShow: 1,
        customPaging: function (slick, index) {
          return '<a>' + index + '</a>';
        },
        dots: true,
        dotsClass: 'slick-dots',
        prevArrow: '<a data-role="none" class="slide__arrow-prev" ></a>',
        nextArrow: '<a data-role="none" class="slide__arrow-next" ></a>',
        appendArrows: $('.slide-container__arrows'),
        appendDots: $('.slide-container__dots')
      });
    }
  }

})(jQuery, Drupal);