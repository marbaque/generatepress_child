( function() {
    var nav = document.getElementById( 'responsive-navigation' ), button, menu;
    if ( ! nav ) {
        return;
    }
 
    button = nav.getElementsByTagName( 'button' )[0];
    menu   = nav.getElementsByTagName( 'ul' )[0];
    if ( ! button ) {
        return;
    }
 
    // Hide button if menu is missing or empty.
    if ( ! menu || ! menu.childNodes.length ) {
        button.style.display = 'none';
        return;
    }
 
    button.onclick = function() {
        if ( -1 === menu.className.indexOf( 'nav-submenu' ) ) {
            menu.className = 'nav-submenu';
        }
 
        if ( -1 !== button.className.indexOf( 'submenuToggled-on' ) ) {
            button.className = button.className.replace( ' submenuToggled-on', '' );
            menu.className = menu.className.replace( ' submenuToggled-on', '' );
            menu.slideDown();
        } else {
            button.className += ' submenuToggled-on';
            menu.className += ' submenuToggled-on';
        }
    };
} )(jQuery);