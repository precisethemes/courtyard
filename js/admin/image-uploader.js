jQuery( document ).ready( function( $ ) {

    var file_frame;

    $( document.body ).on( 'click', '.custom_media_upload', function( event ) {
        var $el = $( this );

        var file_target_input   = $el.parent().find( '.custom_media_input' );
        var file_target_preview = $el.parent().find( '.custom_media_preview' );

        event.preventDefault();

        // Create the media frame.
        file_frame = wp.media.frames.media_file = wp.media({
            // Set the title of the modal.
            title: $el.data( 'choose' ),
            button: {
                text: $el.data( 'update' )
            },
            states: [
                new wp.media.controller.Library({
                    title: $el.data( 'choose' ),
                    library: wp.media.query({ type: 'image' })
                })
            ]
        });

        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            // Get the attachment from the modal frame.
            var attachment = file_frame.state().get( 'selection' ).first().toJSON();

            // Initialize input and preview change.
            if ( attachment.id ) {
                file_target_input.val( attachment.id ).trigger('change');
                file_target_preview.css({ display: 'none' }).find( 'img' ).remove();
                file_target_preview.css({ display: 'block' }).append( '<img src="' + attachment.url + '" style="max-width:100%">' );
            }

        });

        // Finally, open the modal.
        file_frame.open();
    });

    // Remove Media Preview
    $( document.body ).on( 'click', '.delete_media_image', function(){
        var $el = $( this ).closest( '.media-uploader' );
        $el.find( '.custom_media_input' ).val( '' ).trigger('change');
        $el.find( '.custom_media_preview' ).css({ display: 'none' }).find( 'img' ).remove();

        return false;
    });

});
