(function ($) {
  "use strict";

  var WidgetDefaultHandler = function () {
    // swiper slider
    const swiperElm = document.querySelectorAll(".thm-swiper__slider");
    swiperElm.forEach(function (swiperelm) {
      const swiperOptions = JSON.parse(swiperelm.dataset.swiperOptions);
      let thmSwiperSlider = new Swiper(swiperelm, swiperOptions);
    });


    if ($(".odometer").length) {
      var odo = $(".odometer");
      odo.each(function () {
        $(this).appear(function () {
          var countNumber = $(this).attr("data-count");
          $(this).html(countNumber);
        });
      });
    }

  // Popular Causes Progress Bar
  if ($('.count-bar').length) {
    $('.count-bar').appear(function () {
      var el = $(this);
      var percent = el.data('percent');
      $(el).css('width', percent).addClass('counted');
    }, {
      accY: -50
    });
  }

  };


  //portfolio slider
  var WidgetPortfolioSliderHandler = function () {
        // Projects One Carousel
      if ($(".projects-one__carousel").length) {
        $(".projects-one__carousel").owlCarousel({
          loop: true,
          margin: 30,
          nav: false,
          smartSpeed: 500,
          autoHeight: false,
          autoplay: true,
          dots: true,
          autoplayTimeout: 10000,
          navText: [
            '<span class="icon-right-arrow left"></span>',
            '<span class="icon-right-arrow"></span>',
          ],
          responsive: {
            0: {
              items: 1,
            },
            600: {
              items: 1,
            },
            700: {
              items: 2,
            },
            1024: {
              items: 3,
            },
            1200: {
              items: 4,
            },
          },
        });
      }

        // Projects Two Carousel
        if ($(".projects-two__carousel").length) {
          $(".projects-two__carousel").owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            smartSpeed: 500,
            autoHeight: false,
            autoplay: true,
            dots: true,
            autoplayTimeout: 10000,
            navText: [
              '<span class="icon-right-arrow left"></span>',
              '<span class="icon-right-arrow"></span>',
            ],
            responsive: {
              0: {
                items: 1,
              },
              600: {
                items: 1,
              },
              750: {
                items: 2,
              },
              1024: {
                items: 3,
              },
              1200: {
                items: 3,
              },
            },
          });
        }

  };

  var WidgetTestimonialSliderHandler = function () {
      // Testimonial One Carousel
    if ($(".testimonials-one__carousel").length) {
      $(".testimonials-one__carousel").owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
        smartSpeed: 500,
        autoHeight: false,
        autoplay: true,
        dots: true,
        autoplayTimeout: 10000,
        navText: [
          '<span class="icon-right-arrow-1 left"></span>',
          '<span class="icon-right-arrow-1"></span>',
        ],
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 1,
          },
          800: {
            items: 1,
          },
          1024: {
            items: 1,
          },
          1200: {
            items: 2,
          },
        },
      });
    }

  };

  var WidgetBlogSliderHandler = function () {
    
    // News Two Carousel
  if ($(".blog-two__carousel").length) {
    var blogCarousel = $(".blog-two__carousel");
    var nextBtn = $('.blog-two__carousel__custom-nav .left-btn');
    var prevBtn = $('.blog-two__carousel__custom-nav .right-btn');
    blogCarousel.owlCarousel({
      loop: true,
      margin: 30,
      nav: true,
      smartSpeed: 500,
      autoHeight: false,
      autoplay: true,
      dots: false,
      autoplayTimeout: 10000,
      navText: [
        '<span class="icon-left"></span>',
        '<span class="icon-right"></span>',
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 1,
        },
        992: {
          items: 3,
        },
        1024: {
          items: 3,
        },
        1200: {
          items: 3,
        },
      },
    });
    nextBtn.on('click', function (e) {
      e.preventDefault();
      blogCarousel.trigger('next.owl.carousel', [500]);
    });
    prevBtn.on('click', function (e) {
      e.preventDefault();
      blogCarousel.trigger('prev.owl.carousel', [500]);
    });
  }

}

  var WidgetFaqHandler = function () {
    if ($(".accrodion-grp").length) {
      var accrodionGrp = $(".accrodion-grp");
      accrodionGrp.each(function () {
        var accrodionName = $(this).data("grp-name");
        var Self = $(this);
        var accordion = Self.find(".accrodion");
        Self.addClass(accrodionName);
        Self.find(".accrodion .accrodion-content").hide();
        Self.find(".accrodion.active").find(".accrodion-content").show();
        accordion.each(function () {
          $(this)
            .find(".accrodion-title")
            .on("click", function () {
              if ($(this).parent().hasClass("active") === false) {
                $(".accrodion-grp." + accrodionName)
                  .find(".accrodion")
                  .removeClass("active");
                $(".accrodion-grp." + accrodionName)
                  .find(".accrodion")
                  .find(".accrodion-content")
                  .slideUp();
                $(this).parent().addClass("active");
                $(this)
                  .parent()
                  .find(".accrodion-content")
                  .slideDown();
              }
            });
        });
      });
    }
  };
 

  //elementor front start
  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/widget",
      WidgetDefaultHandler
    );

    elementorFrontend.hooks.addAction(
      "frontend/element_ready/agriox-portfolio.default",
      WidgetPortfolioSliderHandler
    );

    elementorFrontend.hooks.addAction(
      "frontend/element_ready/agriox-testimonials.default",
      WidgetTestimonialSliderHandler
    );
  
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/agriox-blog.default",
      WidgetBlogSliderHandler
    );
 
 
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/agriox-faq.default",
      WidgetFaqHandler
    );



  });
})(jQuery);