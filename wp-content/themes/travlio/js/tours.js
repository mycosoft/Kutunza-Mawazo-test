(function($) {
    "use strict";
    
    $.extend($.apusThemeCore, {
        /**
         *  Initialize scripts
         */
        tour_init: function() {
            var self = this;

            self.favorite();
        },
        favorite: function() {
            var self = this;

            var self = this;
            // favorite
            $( "body" ).on( "click", ".apus-favorite-add", function( e ) {
                e.preventDefault();

                var post_id = $(this).data('id');
                var url = travlio_tour_opts.ajaxurl + '?action=travlio_add_favorite&post_id=' + post_id + '&security=' + travlio_tour_opts.ajax_nonce;
                var $self = $(this);
                $self.addClass('loading');
                $.ajax({
                    url: url,
                    type:'POST',
                    dataType: 'json',
                }).done(function(reponse) {
                    if (reponse.status === 'success') {
                        $self.addClass('apus-favorite-added').removeClass('apus-favorite-add');
                    }
                    $self.removeClass('loading');
                    self.showMessage(reponse.msg, reponse.status);
                });
            });
            $(document).on('click', '.apus-favorite-not-login', function(e){
                e.preventDefault();
                
                $('.apus-user-login').trigger('click');
                return false;
            });

            // favorite remove
            $( "body" ).on( "click", ".apus-favorite-added", function( e ) {
                e.preventDefault();

                var post_id = $(this).data('id');
                var url = travlio_tour_opts.ajaxurl + '?action=travlio_remove_favorite&post_id=' + post_id + '&security=' + travlio_tour_opts.ajax_nonce;
                var $self = $(this);
                $self.addClass('loading');
                $.ajax({
                    url: url,
                    type:'POST',
                    dataType: 'json',
                }).done(function(reponse) {
                    if (reponse.status === 'success') {
                        $self.removeClass('apus-favorite-added').addClass('apus-favorite-add');
                    }
                    $self.removeClass('loading');
                    self.showMessage(reponse.msg, reponse.status);
                });
            });
            $( "body" ).on( "click", ".apus-favorite-remove", function( e ) {
                e.preventDefault();

                var post_id = $(this).data('id');
                var url = travlio_tour_opts.ajaxurl + '?action=travlio_remove_favorite&post_id=' + post_id + '&security=' + travlio_tour_opts.ajax_nonce;
                $(this).addClass('loading');
                $.ajax({
                    url: url,
                    type:'POST',
                    dataType: 'json',
                }).done(function(reponse) {
                    if (reponse.status === 'success') {
                        var parent = $('#favorite-listing-' + post_id).parent();
                        if ( $('.my-favorite-item-wrapper', parent).length <= 1 ) {
                            location.reload();
                        } else {
                            $('#favorite-listing-' + post_id).remove();
                        }
                    }
                    self.showMessage(reponse.msg, reponse.status);
                });
            });
        },
        showMessage: function(msg, status) {
            if ( msg ) {
                var classes = 'alert alert-warning';
                if ( status == 'success' ) {
                    classes = 'alert alert-info';
                }
                var $html = '<div id="travlio-popup-message" class="animated fadeInRight"><div class="message-inner '+ classes +'">'+ msg +'</div></div>';
                $('body').find('#travlio-popup-message').remove();
                $('body').append($html).fadeIn(500);
                setTimeout(function() {
                    $('body').find('#travlio-popup-message').removeClass('fadeInRight').addClass('delay-1s fadeOutRight');
                }, 2500);
            }
        }
    });

    $.apusThemeExtensions.tour = $.apusThemeCore.tour_init;

    
})(jQuery);