/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
    var gridbit_secondary_container, gridbit_secondary_button, gridbit_secondary_menu, gridbit_secondary_links, gridbit_secondary_i, gridbit_secondary_len;

    gridbit_secondary_container = document.getElementById( 'gridbit-secondary-navigation' );
    if ( ! gridbit_secondary_container ) {
        return;
    }

    gridbit_secondary_button = gridbit_secondary_container.getElementsByTagName( 'button' )[0];
    if ( 'undefined' === typeof gridbit_secondary_button ) {
        return;
    }

    gridbit_secondary_menu = gridbit_secondary_container.getElementsByTagName( 'ul' )[0];

    // Hide menu toggle button if menu is empty and return early.
    if ( 'undefined' === typeof gridbit_secondary_menu ) {
        gridbit_secondary_button.style.display = 'none';
        return;
    }

    gridbit_secondary_menu.setAttribute( 'aria-expanded', 'false' );
    if ( -1 === gridbit_secondary_menu.className.indexOf( 'nav-menu' ) ) {
        gridbit_secondary_menu.className += ' nav-menu';
    }

    gridbit_secondary_button.onclick = function() {
        if ( -1 !== gridbit_secondary_container.className.indexOf( 'gridbit-toggled' ) ) {
            gridbit_secondary_container.className = gridbit_secondary_container.className.replace( ' gridbit-toggled', '' );
            gridbit_secondary_button.setAttribute( 'aria-expanded', 'false' );
            gridbit_secondary_menu.setAttribute( 'aria-expanded', 'false' );
        } else {
            gridbit_secondary_container.className += ' gridbit-toggled';
            gridbit_secondary_button.setAttribute( 'aria-expanded', 'true' );
            gridbit_secondary_menu.setAttribute( 'aria-expanded', 'true' );
        }
    };

    // Get all the link elements within the menu.
    gridbit_secondary_links    = gridbit_secondary_menu.getElementsByTagName( 'a' );

    // Each time a menu link is focused or blurred, toggle focus.
    for ( gridbit_secondary_i = 0, gridbit_secondary_len = gridbit_secondary_links.length; gridbit_secondary_i < gridbit_secondary_len; gridbit_secondary_i++ ) {
        gridbit_secondary_links[gridbit_secondary_i].addEventListener( 'focus', gridbit_secondary_toggleFocus, true );
        gridbit_secondary_links[gridbit_secondary_i].addEventListener( 'blur', gridbit_secondary_toggleFocus, true );
    }

    /**
     * Sets or removes .focus class on an element.
     */
    function gridbit_secondary_toggleFocus() {
        var self = this;

        // Move up through the ancestors of the current link until we hit .nav-menu.
        while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

            // On li elements toggle the class .focus.
            if ( 'li' === self.tagName.toLowerCase() ) {
                if ( -1 !== self.className.indexOf( 'gridbit-focus' ) ) {
                    self.className = self.className.replace( ' gridbit-focus', '' );
                } else {
                    self.className += ' gridbit-focus';
                }
            }

            self = self.parentElement;
        }
    }

    /**
     * Toggles `focus` class to allow submenu access on tablets.
     */
    ( function( gridbit_secondary_container ) {
        var touchStartFn, gridbit_secondary_i,
            parentLink = gridbit_secondary_container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

        if ( 'ontouchstart' in window ) {
            touchStartFn = function( e ) {
                var menuItem = this.parentNode, gridbit_secondary_i;

                if ( ! menuItem.classList.contains( 'gridbit-focus' ) ) {
                    e.preventDefault();
                    for ( gridbit_secondary_i = 0; gridbit_secondary_i < menuItem.parentNode.children.length; ++gridbit_secondary_i ) {
                        if ( menuItem === menuItem.parentNode.children[gridbit_secondary_i] ) {
                            continue;
                        }
                        menuItem.parentNode.children[gridbit_secondary_i].classList.remove( 'gridbit-focus' );
                    }
                    menuItem.classList.add( 'gridbit-focus' );
                } else {
                    menuItem.classList.remove( 'gridbit-focus' );
                }
            };

            for ( gridbit_secondary_i = 0; gridbit_secondary_i < parentLink.length; ++gridbit_secondary_i ) {
                parentLink[gridbit_secondary_i].addEventListener( 'touchstart', touchStartFn, false );
            }
        }
    }( gridbit_secondary_container ) );
} )();


( function() {
    var gridbit_primary_container, gridbit_primary_button, gridbit_primary_menu, gridbit_primary_links, gridbit_primary_i, gridbit_primary_len;

    gridbit_primary_container = document.getElementById( 'gridbit-primary-navigation' );
    if ( ! gridbit_primary_container ) {
        return;
    }

    gridbit_primary_button = gridbit_primary_container.getElementsByTagName( 'button' )[0];
    if ( 'undefined' === typeof gridbit_primary_button ) {
        return;
    }

    gridbit_primary_menu = gridbit_primary_container.getElementsByTagName( 'ul' )[0];

    // Hide menu toggle button if menu is empty and return early.
    if ( 'undefined' === typeof gridbit_primary_menu ) {
        gridbit_primary_button.style.display = 'none';
        return;
    }

    gridbit_primary_menu.setAttribute( 'aria-expanded', 'false' );
    if ( -1 === gridbit_primary_menu.className.indexOf( 'nav-menu' ) ) {
        gridbit_primary_menu.className += ' nav-menu';
    }

    gridbit_primary_button.onclick = function() {
        if ( -1 !== gridbit_primary_container.className.indexOf( 'gridbit-toggled' ) ) {
            gridbit_primary_container.className = gridbit_primary_container.className.replace( ' gridbit-toggled', '' );
            gridbit_primary_button.setAttribute( 'aria-expanded', 'false' );
            gridbit_primary_menu.setAttribute( 'aria-expanded', 'false' );
        } else {
            gridbit_primary_container.className += ' gridbit-toggled';
            gridbit_primary_button.setAttribute( 'aria-expanded', 'true' );
            gridbit_primary_menu.setAttribute( 'aria-expanded', 'true' );
        }
    };

    // Get all the link elements within the menu.
    gridbit_primary_links    = gridbit_primary_menu.getElementsByTagName( 'a' );

    // Each time a menu link is focused or blurred, toggle focus.
    for ( gridbit_primary_i = 0, gridbit_primary_len = gridbit_primary_links.length; gridbit_primary_i < gridbit_primary_len; gridbit_primary_i++ ) {
        gridbit_primary_links[gridbit_primary_i].addEventListener( 'focus', gridbit_primary_toggleFocus, true );
        gridbit_primary_links[gridbit_primary_i].addEventListener( 'blur', gridbit_primary_toggleFocus, true );
    }

    /**
     * Sets or removes .focus class on an element.
     */
    function gridbit_primary_toggleFocus() {
        var self = this;

        // Move up through the ancestors of the current link until we hit .nav-menu.
        while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

            // On li elements toggle the class .focus.
            if ( 'li' === self.tagName.toLowerCase() ) {
                if ( -1 !== self.className.indexOf( 'gridbit-focus' ) ) {
                    self.className = self.className.replace( ' gridbit-focus', '' );
                } else {
                    self.className += ' gridbit-focus';
                }
            }

            self = self.parentElement;
        }
    }

    /**
     * Toggles `focus` class to allow submenu access on tablets.
     */
    ( function( gridbit_primary_container ) {
        var touchStartFn, gridbit_primary_i,
            parentLink = gridbit_primary_container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

        if ( 'ontouchstart' in window ) {
            touchStartFn = function( e ) {
                var menuItem = this.parentNode, gridbit_primary_i;

                if ( ! menuItem.classList.contains( 'gridbit-focus' ) ) {
                    e.preventDefault();
                    for ( gridbit_primary_i = 0; gridbit_primary_i < menuItem.parentNode.children.length; ++gridbit_primary_i ) {
                        if ( menuItem === menuItem.parentNode.children[gridbit_primary_i] ) {
                            continue;
                        }
                        menuItem.parentNode.children[gridbit_primary_i].classList.remove( 'gridbit-focus' );
                    }
                    menuItem.classList.add( 'gridbit-focus' );
                } else {
                    menuItem.classList.remove( 'gridbit-focus' );
                }
            };

            for ( gridbit_primary_i = 0; gridbit_primary_i < parentLink.length; ++gridbit_primary_i ) {
                parentLink[gridbit_primary_i].addEventListener( 'touchstart', touchStartFn, false );
            }
        }
    }( gridbit_primary_container ) );
} )();