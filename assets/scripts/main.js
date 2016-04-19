/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        $(document).ready(function(){
          //cache DOM elements
          var mainContent = $('.cd-main-content'),
            header = $('.cd-main-header'),
            sidebar = $('.cd-side-nav'),
            sidebarTrigger = $('.cd-nav-trigger'),
            topNavigation = $('.cd-top-nav'),
            searchForm = $('.cd-search'),
            accountInfo = $('.account');

          //on resize, move search and top nav position according to window width
          var resizing = false;
          moveNavigation();
          $(window).on('resize', function(){
            if( !resizing ) {
              (!window.requestAnimationFrame) ? setTimeout(moveNavigation, 300) : window.requestAnimationFrame(moveNavigation);
              resizing = true;
            }
          });

          //on window scrolling - fix sidebar nav
          var scrolling = false;
          checkScrollbarPosition();
          $(window).on('scroll', function(){
            if( !scrolling ) {
              (!window.requestAnimationFrame) ? setTimeout(checkScrollbarPosition, 300) : window.requestAnimationFrame(checkScrollbarPosition);
              scrolling = true;
            }
          });

          //mobile only - open sidebar when user clicks the hamburger menu
          sidebarTrigger.on('click', function(event){
            event.preventDefault();
            $([sidebar, sidebarTrigger]).toggleClass('nav-is-visible');
          });

          //click on item and show submenu
          $('.has-children > a').on('click', function(event){
            var mq = checkMQ(),
              selectedItem = $(this);
            if( mq == 'mobile' || mq == 'tablet' ) {
              event.preventDefault();
              if( selectedItem.parent('li').hasClass('selected')) {
                selectedItem.parent('li').removeClass('selected');
              } else {
                sidebar.find('.has-children.selected').removeClass('selected');
                accountInfo.removeClass('selected');
                selectedItem.parent('li').addClass('selected');
              }
            }
          });

          //click on account and show submenu - desktop version only
          accountInfo.children('a').on('click', function(event){
            var mq = checkMQ(),
              selectedItem = $(this);
            if( mq == 'desktop') {
              event.preventDefault();
              accountInfo.toggleClass('selected');
              sidebar.find('.has-children.selected').removeClass('selected');
            }
          });

          $(document).on('click', function(event){
            if( !$(event.target).is('.has-children a') ) {
              sidebar.find('.has-children.selected').removeClass('selected');
              accountInfo.removeClass('selected');
            }
          });

          //on desktop - differentiate between a user trying to hover over a dropdown item vs trying to navigate into a submenu's contents
          sidebar.children('ul').menuAim({
                activate: function(row) {
                  $(row).addClass('hover');
                },
                deactivate: function(row) {
                  $(row).removeClass('hover');
                },
                exitMenu: function() {
                  sidebar.find('.hover').removeClass('hover');
                  return true;
                },
                submenuSelector: ".has-children",
            });

          function checkMQ() {
            //check if mobile or desktop device
            return window.getComputedStyle(document.querySelector('.cd-main-content'), '::before').getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
          }

          function moveNavigation(){
              var mq = checkMQ();
                
                if ( mq == 'mobile' && topNavigation.parents('.cd-side-nav').length == 0 ) {
                  detachElements();
              topNavigation.appendTo(sidebar);
              searchForm.removeClass('is-hidden').prependTo(sidebar);
            } else if ( ( mq == 'tablet' || mq == 'desktop') &&  topNavigation.parents('.cd-side-nav').length > 0 ) {
              detachElements();
              searchForm.insertAfter(header.find('.cd-logo'));
              topNavigation.appendTo(header.find('.cd-nav'));
            }
            checkSelected(mq);
            resizing = false;
          }

          function detachElements() {
            topNavigation.detach();
            searchForm.detach();
          }

          function checkSelected(mq) {
            //on desktop, remove selected class from items selected on mobile/tablet version
            if( mq == 'desktop' ) $('.has-children.selected').removeClass('selected');
          }

          function checkScrollbarPosition() {
            var mq = checkMQ();
            
            if( mq != 'mobile' ) {
              var sidebarHeight = sidebar.outerHeight(),
                windowHeight = $(window).height(),
                mainContentHeight = mainContent.outerHeight(),
                scrollTop = $(window).scrollTop();

              ( ( scrollTop + windowHeight > sidebarHeight ) && ( mainContentHeight - sidebarHeight != 0 ) ) ? sidebar.addClass('is-fixed').css('bottom', 0) : sidebar.removeClass('is-fixed').attr('style', '');
            }
            scrolling = false;
          }
        });
        
        
        $(document).ready(function(){
          $(".owl-carousel").owlCarousel();
        });
        $('.owl-carousel').owlCarousel({
            animateIn: 'fadeIn', 
            margin:30,
            loop:true,
            autoWidth:true,
            items:2,
            nav:true,
            navSpeed:3000,
            navText: [
            "<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>" 
            ],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:2
                }
            }
        });

      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
        
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
