(function ($) {
    "use strict";

    if (!$.apusThemeExtensions)
        $.apusThemeExtensions = {};
    
    function ApusThemeCore() {
        var self = this;
        // self.init();
    };

    ApusThemeCore.prototype = {
        /**
         *  Initialize
         */
        init: function() {
            var self = this;
            
            self.preloadSite();

            // slick init
            self.initSlick($("[data-carousel=slick]"));

            // Unveil init
            setTimeout(function(){
                self.layzyLoadImage();
            }, 200);
            
            // isoto
            self.initIsotope();
            
            self.popupImageTeam();

            // Sticky Header
            self.initHeaderSticky('main-sticky-header');
            
            // back to top
            self.backToTop();

            // popup image
            self.popupImage();

            $('[data-toggle="tooltip"]').tooltip();

            self.initMobileMenu();

            self.initHeaderSidebar();

            self.mainMenuInit();

            self.loadExtension();

            $(document.body).on('click', '.nav [data-toggle="dropdown"]' ,function(){
                if ( this.href && this.href != '#'){
                    window.location.href = this.href;
                }
            });
        },
        /**
         *  Extensions: Load scripts
         */
        loadExtension: function() {
            var self = this;
            
            if ($.apusThemeExtensions.tour) {
                $.apusThemeExtensions.tour.call(self);
            }
        },
        initSlick: function(element) {
            var self = this;
            element.each( function(){
                var config = {
                    infinite: false,
                    arrows: $(this).data( 'nav' ),
                    dots: $(this).data( 'pagination' ),
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    prevArrow:"<button type='button' class='slick-arrow slick-prev pull-left'><i class='flaticon-left-arrow-3' aria-hidden='true'></i></span><span class='textnav'>"+ travlio_ajax.previous +"</span></button>",
                    nextArrow:"<button type='button' class='slick-arrow slick-next pull-right'><span class='textnav'>"+ travlio_ajax.next +"</span><i class='flaticon-right-arrow-1' aria-hidden='true'></i></button>",
                };
            
                var slick = $(this);
                if( $(this).data('items') ){
                    config.slidesToShow = $(this).data( 'items' );
                    config.slidesToScroll = $(this).data( 'items' );
                }
                if( $(this).data('infinite') ){
                    config.infinite = true;
                }
                if( $(this).data('centermode') ){
                    config.centerMode = true;
                }

                if( $(this).data('centerpadding') ){
                    config.centerPadding = $(this).data( 'centerpadding' );
                }
                if( $(this).data('lgcenterpadding') ){
                    var lgcenterpadding = $(this).data( 'lgcenterpadding' );
                } else{
                    var lgcenterpadding = 0;
                }

                if( $(this).data('vertical') ){
                    config.vertical = true;
                }
                if( $(this).data('rows') ){
                    config.rows = $(this).data( 'rows' );
                }
                if( $(this).data('asnavfor') ){
                    config.asNavFor = $(this).data( 'asnavfor' );
                }
                if( $(this).data('slidestoscroll') ){
                    config.slidesToScroll = $(this).data( 'slidestoscroll' );
                }
                if( $(this).data('focusonselect') ){
                    config.focusOnSelect = $(this).data( 'focusonselect' );
                }
                if ($(this).data('large')) {
                    var desktop = $(this).data('large');
                } else {
                    var desktop = config.items;
                }
                if ($(this).data('smalldesktop')) {
                    var smalldesktop = $(this).data('smalldesktop');
                } else {
                    if ($(this).data('large')) {
                        var smalldesktop = $(this).data('large');
                    } else{
                        var smalldesktop = config.items;
                    }
                }
                if ($(this).data('medium')) {
                    var medium = $(this).data('medium');
                } else {
                    var medium = config.items;
                }
                if ($(this).data('smallmedium')) {
                    var smallmedium = $(this).data('smallmedium');
                } else {
                    var smallmedium = 2;
                }
                if ($(this).data('extrasmall')) {
                    var extrasmall = $(this).data('extrasmall');
                } else {
                    var extrasmall = 2;
                }
                if ($(this).data('smallest')) {
                    var smallest = $(this).data('smallest');
                } else {
                    var smallest = 1;
                }
                config.responsive = [
                    {
                        breakpoint: 321,
                        settings: {
                            slidesToShow: smallest,
                            slidesToScroll: smallest,
                            centerPadding: 0,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: extrasmall,
                            slidesToScroll: extrasmall,
                            centerPadding: 0,
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: smallmedium,
                            slidesToScroll: smallmedium,
                            centerPadding: '30px',
                        }
                    },
                    {
                        breakpoint: 981,
                        settings: {
                            slidesToShow: medium,
                            slidesToScroll: medium,
                            centerPadding: lgcenterpadding,
                        }
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: smalldesktop,
                            slidesToScroll: smalldesktop,
                            centerPadding: lgcenterpadding,
                        }
                    },
                    {
                        breakpoint: 1501,
                        settings: {
                            slidesToShow: desktop,
                            slidesToScroll: desktop
                        }
                    }
                ];
                if ( $('html').attr('dir') == 'rtl' ) {
                    config.rtl = true;
                }

                slick.slick( config );
            } );

            // Fix owl in bootstrap tabs
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href");
                var $slick = $("[data-carousel=slick]", target);

                if ($slick.length > 0 && $slick.hasClass('slick-initialized')) {
                    $slick.slick('refresh');
                }
                
                self.layzyLoadImage();
            });
        },
        layzyLoadImage: function() {
            $(window).off('scroll.unveil resize.unveil lookup.unveil');
            var $images = $('.image-wrapper:not(.image-loaded) .unveil-image'); // Get un-loaded images only
            if ($images.length) {
                $images.unveil(1, function() {
                    $(this).load(function() {
                        $(this).parents('.image-wrapper').first().addClass('image-loaded');
                        $(this).removeAttr('data-src');
                        $(this).removeAttr('data-srcset');
                        $(this).removeAttr('data-sizes');
                    });
                });
            }

            var $images = $('.product-image:not(.image-loaded) .unveil-image'); // Get un-loaded images only
            if ($images.length) {
                $images.unveil(1, function() {
                    $(this).load(function() {
                        $(this).parents('.product-image').first().addClass('image-loaded');
                    });
                });
            }
        },
        initIsotope: function() {
            $('.isotope-items').each(function(){  
                var $container = $(this);
                
                $container.imagesLoaded( function(){
                    $container.isotope({
                        itemSelector : '.isotope-item',
                        transformsEnabled: true,         // Important for videos
                        masonry: {
                            columnWidth: $container.data('columnwidth')
                        }
                    }); 
                });
            });

            /*---------------------------------------------- 
             *    Apply Filter        
             *----------------------------------------------*/
            $('.isotope-filter li a').on('click', function(){
               
                var parentul = $(this).parents('ul.isotope-filter').data('related-grid');
                $(this).parents('ul.isotope-filter').find('li').removeClass('active');
                $(this).parents('li').addClass('active');
                var selector = $(this).attr('data-filter'); 
                $('#'+parentul).isotope({ filter: selector }, function(){ });
                
                return(false);
            });
        },
        initHeaderSticky: function(main_sticky_class) {
            if ( typeof Waypoint !== 'undefined' ) {
                if ( $('.' + main_sticky_class) && typeof Waypoint.Sticky !== 'undefined' ) {
                    var opts = {
                        element: $('.' + main_sticky_class)[0],
                        wrapper: '<div class="main-sticky-header-wrapper">',
                        offset: '-10px',
                        stuckClass: 'sticky-header'
                    };
                    var sticky = new Waypoint.Sticky(opts);
                }
            }
        },
        backToTop: function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 400) {
                    $('#back-to-top').addClass('active');
                } else {
                    $('#back-to-top').removeClass('active');
                }
            });
            $('#back-to-top').on('click', function () {
                $('html, body').animate({scrollTop: '0px'}, 800);
                return false;
            });
        },
        popupImage: function() {
            // popup
            $(".popup-image").magnificPopup({type:'image'});
            $('.popup-video').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            });

            $('.widget-gallery').each(function(){
                var tagID = $(this).attr('id');
                $('#' + tagID).magnificPopup({
                    delegate: '.popup-image-gallery',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    mainClass: 'mfp-img-mobile',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                    }
                });
            });
        },

        popupImageTeam: function() {
            var self = this;
            $(document).on('click', '.team-popup-btn', function(){
                var container = $(this).closest('.widget-team');
                $.magnificPopup.open({
                    mainClass: 'schedule-mfp-wrapper',
                    closeBtnInside:false,
                    closeMarkup:'<button title="%title%" type="button" class="mfp-close"><i class="ti-close"></i></button>',
                    items    : {
                        src : container.find('.team-popup-wrapper').html(),
                        type: 'inline'
                    },
                    callbacks: {
                        open: function() {
                            self.layzyLoadImage();
                        }
                    }
                });
            });
        },

        preloadSite: function() {
            // preload page
            if ( $('body').hasClass('apus-body-loading') ) {
                $('body').removeClass('apus-body-loading');
                $('.apus-page-loading').fadeOut(100);
            }
        },
        initHeaderSidebar: function() {
            $('.header-sidebar-btn,.close-header-sidebar').on('click', function (e) {
                e.stopPropagation();
                $('.header-sidebar-wrapper').toggleClass('active');           
            });
        },
        
        initMobileMenu: function() {

            // mobile menu
            $('.btn-toggle-canvas,.btn-showmenu').on('click', function (e) {
                e.stopPropagation();
                $('.apus-offcanvas').toggleClass('active');           
                $('.over-dark').toggleClass('active');        
            });
            $('body').on('click', function() {
                if ($('.apus-offcanvas').hasClass('active')) {
                    $('.apus-offcanvas').toggleClass('active');
                    $('.over-dark').toggleClass('active');
                }
            });
            $('.apus-offcanvas').on('click', function(e) {
                e.stopPropagation();
            });

            $(".main-mobile-menu .icon-toggle").on('click', function(){
                $(this).parent().find('> .sub-menu').slideToggle();
                if ( $(this).find('i').hasClass('ti-plus') ) {
                    $(this).find('i').removeClass('ti-plus').addClass(' ti-minus ');
                } else {
                    $(this).find('i').removeClass(' ti-minus ').addClass('ti-plus');
                }
                return false;
            } );

            // sidebar mobile

            if ($(window).width() < 1200) {
                $('.sidebar-right, .sidebar-left').perfectScrollbar();
            }
            
            $('body').on('click', '.mobile-sidebar-btn', function(){
                if ( $('.sidebar-left').length > 0 ) {
                    $('.sidebar-left').toggleClass('active');
                } else if ( $('.sidebar-right').length > 0 ) {
                    $('.sidebar-right').toggleClass('active');
                }
                $('.mobile-sidebar-panel-overlay').toggleClass('active');
            });
            $('body').on('click', '.mobile-sidebar-panel-overlay, .close-sidebar-btn', function(){
                if ( $('.sidebar-left').length > 0 ) {
                    $('.sidebar-left').removeClass('active');
                } else if ( $('.sidebar-right').length > 0 ) {
                    $('.sidebar-right').removeClass('active');
                }
                $('.mobile-sidebar-panel-overlay').removeClass('active');
            });
            $('.box-search .btn-search-icon').on('click', function(e) {
                e.preventDefault();
                $(this).closest('.box-search').toggleClass('active');
            });

            $(window).scroll(function () {
                if ($(window).width() <= 600) {
                    if ( $('#wpadminbar').length ) {
                        var admin_bar_h = $('#wpadminbar').outerHeight();
                        var scroll_h = $(this).scrollTop();
                        if (scroll_h > admin_bar_h) {
                            $('.admin-bar .header-mobile').css({'top': 0});
                        } else {
                            var top = admin_bar_h - scroll_h;
                            $('.admin-bar .header-mobile').css({'top': top});
                        }
                    }
                }
            });
        },
        mainMenuInit: function() {
            $('.apus-megamenu .megamenu .has-mega-menu.aligned-fullwidth').each(function(e){
                var $this = $(this),
                    i = $this.closest(".elementor-container"),
                    a = $this.closest('.apus-megamenu');
                $this.on('hover', function(){
                    var m = $(this).find('> .dropdown-menu .dropdown-menu-inner'),
                        w = i.width();

                    m.css({
                        width: w,
                        marginLeft: i.offset().left - a.offset().left
                    });
                });

                $this.find('.elementor-element').addClass('no-transparent');
            });
        },
        headerSidebar: function() {
            $('.header-sidebar-btn').on('click', function() {
                $(this).closest('.widget-header-sidebar').toggleClass('active');
            });
        },
        setCookie: function(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires+";path=/";
        },
        getCookie: function(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
            }
            return "";
        }
    }

    $.apusThemeCore = ApusThemeCore.prototype;
    
    
    $.fn.wrapStart = function(numWords){
        return this.each(function(){
            var $this = $(this);
            var node = $this.contents().filter(function(){
                return this.nodeType == 3;
            }).first(),
            text = node.text().trim(),
            first = text.split(' ', 1).join(" ");
            if (!node.length) return;
            node[0].nodeValue = text.slice(first.length);
            node.before('<b>' + first + '</b>');
        });
    };

    $(document).ready(function() {
        // Initialize script
        var apusthemecore_init = new ApusThemeCore();

        apusthemecore_init.init();

        $('.mod-heading .widget-title > span').wrapStart(1);
    });

    jQuery(window).on("elementor/frontend/init", function() {
        
        var apusthemecore_init = new ApusThemeCore();

        // General element
        elementorFrontend.hooks.addAction( "frontend/element_ready/apus_element_apartments.default",
            function($scope) {
                apusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elementorFrontend.hooks.addAction( "frontend/element_ready/apus_element_amenities.default",
            function($scope) {
                apusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elementorFrontend.hooks.addAction( "frontend/element_ready/apus_element_features_box.default",
            function($scope) {
                apusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elementorFrontend.hooks.addAction( "frontend/element_ready/apus_element_brands.default",
            function($scope) {
                apusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elementorFrontend.hooks.addAction( "frontend/element_ready/apus_element_booking_tours.default",
            function($scope) {
                apusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elementorFrontend.hooks.addAction( "frontend/element_ready/apus_element_instagram.default",
            function($scope) {
                apusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elementorFrontend.hooks.addAction( "frontend/element_ready/apus_element_posts.default",
            function($scope) {
                apusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elementorFrontend.hooks.addAction( "frontend/element_ready/apus_element_testimonials.default",
            function($scope) {
                apusthemecore_init.initSlick($scope.find('.slick-carousel'));
            }
        );

        elementorFrontend.hooks.addAction( "frontend/element_ready/apus_element_header_sidebar.default",
            function($scope) {
                apusthemecore_init.headerSidebar();
            }
        );

    });

})(jQuery);

