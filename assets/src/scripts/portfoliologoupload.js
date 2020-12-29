/*====================
#Scripts for uploading a project logo in the portfolio
post type meta box
======================*/
jQuery(function($){
    /*
     * Select/Upload image(s) event
     */
    $('body').on('click', '.portfolio_upload_image_button', function(e){
        e.preventDefault();

            var button = $(this),
                custom_uploader = wp.media({
            title: 'Insert image',
            library : {
                // comment the next line if you want not to attach image to the current post
                uploadedTo : wp.media.view.settings.post.id, 
                type : 'image'
            },
            button: {
                text: 'Use this image' // button label text
            },
            multiple: false // for multiple image selection set to true
        }).on('select', function() { // it also has "open" and "close" events 
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:95%;display:block;" />').next().val(attachment.id).next().show();
            /* if you set multiple to true, here is some code for getting the image IDs
            var attachments = frame.state().get('selection'),
                attachment_ids = new Array(),
                i = 0;
            attachments.each(function(attachment) {
                attachment_ids[i] = attachment['id'];
                console.log( attachment );
                i++;
            });
            */
        })
        .open();
    });

     /*
     * Remove image event
     */
    $('body').on('click', '.portfolio_remove_image_button', function(e){
        e.preventDefault();
        $(this).hide().prev().val('').prev().addClass('button').html('Upload image');
        return true;
    });

});

