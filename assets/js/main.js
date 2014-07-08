$(document).ready(function(){
    //setup height of menu
    var menuHeight = $(document).height() - $('#topNavigation').height() - 2;
    if(appOptions.isMobile){
        menuHeight = 'auto';
    }

    //setup pushMenu if available
    $( '#menu' ).multilevelpushmenu({
        collapsed:          admin.isPushMenuCollapsed,
        preventItemClick:   false,
        swipe:              'touchscreen',
        fullCollapse:       appOptions.isMobile,
        menuHeight:         menuHeight,
        onMenuReady:        function(){
                                $('#menu').css({
                                    'top':   52//$('#topNavigation').height() + $('#topNavigation').css('border-width')
                                });
                                $('#pushobj').css({
                                    'padding-left':   $('#menu').width()
                                });
                                if(!admin.isPushMenuCollapsed){
                                    $('#menu_multilevelpushmenu').find('.fa-reorder').addClass('hidden');
                                } else {
                                    $('#menu').multilevelpushmenu('expand');
                                    $('#menu').multilevelpushmenu('collapse');
                                }
                            }
    });

    //make menu scrollable
    if(appOptions.isScrollableMenu && appOptions.isMobile){
        $('#menu').jScroll();
    }

    //initiate touch gestures to show and hide pushMenu
    if(appOptions.isMobile){
        $.ajax({
            url      : appOptions.baseURL + 'assets/js/jquery.touchswipe.min.js',
            dataType : 'script',
            success  : function(data){
                            $('#pushobj').swipe({
                                swipeLeft : function(event, direction, distance, duration, fingerCount) {
                                                $('#menu').multilevelpushmenu('collapse');
                                            },
                                swipeRight: function(event, direction, distance, duration, fingerCount) {
                                                $('#menu').multilevelpushmenu('expand');
                                            },
                                threshold : 30
                            });
                        }
        });
    }

    //initiate timer to redirect to login page after specific time
    window.setTimeout(function(){location.href = appOptions.baseURL + "index.php/login/logout"}, admin.inactivityTimeout);

    //collapse menu if navigation is shown
    $('.navbar-toggle').click(function(){
        $('#menu').multilevelpushmenu('collapse');
    });
});