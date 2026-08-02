jQuery(document).ready(function($) {
    'use strict';

    if(gridbit_ajax_object.secondary_menu_active){

        $(".gridbit-nav-secondary .gridbit-secondary-nav-menu").addClass("gridbit-secondary-responsive-menu");

        $( ".gridbit-secondary-responsive-menu-icon" ).on( "click", function() {
            $(this).next(".gridbit-nav-secondary .gridbit-secondary-nav-menu").slideToggle();
        });

        $(window).on( "resize", function() {
            if(window.innerWidth > 1112) {
                $(".gridbit-nav-secondary .gridbit-secondary-nav-menu, nav .sub-menu, nav .children").removeAttr("style");
                $(".gridbit-secondary-responsive-menu > li").removeClass("gridbit-secondary-menu-open");
            }
        });

        $( ".gridbit-secondary-responsive-menu > li" ).on( "click", function(event) {
            if (event.target !== this)
            return;
            $(this).find(".sub-menu:first").toggleClass('gridbit-submenu-toggle').parent().toggleClass("gridbit-secondary-menu-open");
            $(this).find(".children:first").toggleClass('gridbit-submenu-toggle').parent().toggleClass("gridbit-secondary-menu-open");
        });

        $( "div.gridbit-secondary-responsive-menu > ul > li" ).on( "click", function(event) {
            if (event.target !== this)
                return;
            $(this).find("ul:first").toggleClass('gridbit-submenu-toggle').parent().toggleClass("gridbit-secondary-menu-open");
        });

    }

    if(gridbit_ajax_object.primary_menu_active){

        $(".gridbit-nav-primary .gridbit-primary-nav-menu").addClass("gridbit-primary-responsive-menu");

        $( ".gridbit-primary-responsive-menu-icon" ).on( "click", function() {
            $(this).next(".gridbit-nav-primary .gridbit-primary-nav-menu").slideToggle();
        });

        $(window).on( "resize", function() {
            if(window.innerWidth > 1112) {
                $(".gridbit-nav-primary .gridbit-primary-nav-menu, nav .sub-menu, nav .children").removeAttr("style");
                $(".gridbit-primary-responsive-menu > li").removeClass("gridbit-primary-menu-open");
            }
        });

        $( ".gridbit-primary-responsive-menu > li" ).on( "click", function(event) {
            if (event.target !== this)
            return;
            $(this).find(".sub-menu:first").toggleClass('gridbit-submenu-toggle').parent().toggleClass("gridbit-primary-menu-open");
            $(this).find(".children:first").toggleClass('gridbit-submenu-toggle').parent().toggleClass("gridbit-primary-menu-open");
        });

        $( "div.gridbit-primary-responsive-menu > ul > li" ).on( "click", function(event) {
            if (event.target !== this)
                return;
            $(this).find("ul:first").toggleClass('gridbit-submenu-toggle').parent().toggleClass("gridbit-primary-menu-open");
        });

    }

    if($(".gridbit-header-social-icon-search").length){
        $(".gridbit-header-social-icon-search").on('click', function (e) {
            e.preventDefault();
            //document.getElementById("gridbit-search-overlay-wrap").style.display = "block";
            $("#gridbit-search-overlay-wrap").fadeIn();
            const gridbit_focusableelements = 'button, [href], input';
            const gridbit_search_modal = document.querySelector('#gridbit-search-overlay-wrap');
            const gridbit_firstfocusableelement = gridbit_search_modal.querySelectorAll(gridbit_focusableelements)[0];
            const gridbit_focusablecontent = gridbit_search_modal.querySelectorAll(gridbit_focusableelements);
            const gridbit_lastfocusableelement = gridbit_focusablecontent[gridbit_focusablecontent.length - 1];
            document.addEventListener('keydown', function(e) {
              let isTabPressed = e.key === 'Tab' || e.keyCode === 9;
              if (!isTabPressed) {
                return;
              }
              if (e.shiftKey) {
                if (document.activeElement === gridbit_firstfocusableelement) {
                  gridbit_lastfocusableelement.focus();
                  e.preventDefault();
                }
              } else {
                if (document.activeElement === gridbit_lastfocusableelement) {
                  gridbit_firstfocusableelement.focus();
                  e.preventDefault();
                }
              }
            });
            gridbit_firstfocusableelement.focus();
        });
    }

    if($(".gridbit-search-closebtn").length){
        $(".gridbit-search-closebtn").on('click', function (e) {
            e.preventDefault();
            //document.getElementById("gridbit-search-overlay-wrap").style.display = "none";
            $("#gridbit-search-overlay-wrap").fadeOut();
        });
    }

    if($(".gridbit-header-icon-search").length){
        $(".gridbit-header-icon-search").on('click', function (e) {
            e.preventDefault();
            //document.getElementById("gridbit-header-search-overlay-wrap").style.display = "block";
            $("#gridbit-header-search-overlay-wrap").fadeIn();
            const gridbit_fableitems = 'button, [href], input';
            const gridbit_searchwrap = document.querySelector('#gridbit-header-search-overlay-wrap');
            const gridbit_firstfableelement = gridbit_searchwrap.querySelectorAll(gridbit_fableitems)[0];
            const gridbit_fablecontent = gridbit_searchwrap.querySelectorAll(gridbit_fableitems);
            const gridbit_lastfableelement = gridbit_fablecontent[gridbit_fablecontent.length - 1];
            document.addEventListener('keydown', function(e) {
              let isTabPressed = e.key === 'Tab' || e.keyCode === 9;
              if (!isTabPressed) {
                return;
              }
              if (e.shiftKey) {
                if (document.activeElement === gridbit_firstfableelement) {
                  gridbit_lastfableelement.focus();
                  e.preventDefault();
                }
              } else {
                if (document.activeElement === gridbit_lastfableelement) {
                  gridbit_firstfableelement.focus();
                  e.preventDefault();
                }
              }
            });
            gridbit_firstfableelement.focus();
        });
    }

    if($(".gridbit-header-search-close").length){
        $(".gridbit-header-search-close").on('click', function (e) {
            e.preventDefault();
            //document.getElementById("gridbit-header-search-overlay-wrap").style.display = "none";
            $("#gridbit-header-search-overlay-wrap").fadeOut();
        });
    }

    if(gridbit_ajax_object.fitvids_active){
        $(".entry-content, .widget").fitVids();
    }

    if(gridbit_ajax_object.backtotop_active){
        if($(".gridbit-scroll-top").length){
            var gridbit_scroll_button = $( '.gridbit-scroll-top' );
            gridbit_scroll_button.hide();

            $( window ).on( "scroll", function() {
                if ( $( window ).scrollTop() < 20 ) {
                    $( '.gridbit-scroll-top' ).fadeOut();
                } else {
                    $( '.gridbit-scroll-top' ).fadeIn();
                }
            } );

            gridbit_scroll_button.on( "click", function() {
                $( "html, body" ).animate( { scrollTop: 0 }, 300 );
                return false;
            } );
        }
    }

});