$ = $ || jQuery;

window.TF_GF_Field_Post_Image = window.TF_GF_Field_Post_Image || {};
TF_GF_Field_Post_Image.drag_and_drop_ajax_url = TF_GF_Field_Post_Image.drag_and_drop_ajax_url || '';

window.TF_UK_Photo_Select_Zone = function(el){
    this.file_input             = $(el).find('input[type=file]');
    this.upload_select          = this.file_input;
    this.overlay_panel          = $(el).find('.uk-overlay-panel');

    this.settings = {

        filelimit:TF_GF_Field_Post_Image.filelimit,
        allow : TF_GF_Field_Post_Image.allow,

        //have to do this so that these values are available in the events below
        overlay_panel_el: this.overlay_panel,

        notallowed: function(file, settings){
            UIkit.notify({
                message : 'Incorrect image file.<br/><br/> Only the following files are permitted:<br/>'+settings.allow, //todo localize this script
                status  : 'info',
                timeout : 5000,
                pos     : 'top-center'
            });

        },

        before: function(settings,files){
            TF_GF_Field_Post_Image.preview_photo_blob( files, settings.overlay_panel_el, 'uk-hidden' );
            return false;
        }
    };

    UIkit.uploadSelect( this.upload_select, this.settings);
};

window.TF_UK_Photo_Drop_Zone = function(el){
    this.form                   = $(el).parents('form');
    this.form_id                = $('[name="gform_submit"]').val();
    this.upload_drop            = $(el).find('.uk-placeholder');
    this.file_input             = $(el).find('input[type=file]');
    this.upload_select          = this.file_input;
    this.overlay_panel          = $(el).find('.uk-overlay-panel');
    this.input_name             = $(this.file_input).attr('name');
    this.dropped_files          = null;

    this.settings = {
        form: this.form,
        allow : TF_GF_Field_Post_Image.allow, // allow only images
        filelimit:TF_GF_Field_Post_Image.filelimit,

        //have to do this so that these values are available in the events below
        overlay_panel_el: this.overlay_panel,
        file_input_el: this.file_input,
        form_el: this.form,

        //drag and drop specific settings
        single: true,
        type: 'json',
        method: 'POST',
        action: TF_GF_Field_Post_Image.ajax_url,
        param: this.input_name,
        params:{
            'action':TF_GF_Field_Post_Image.drag_and_drop_action,
            'form_id':this.form_id,
            'input_name':this.input_name
        },


        notallowed: function(file, settings){
            UIkit.notify({
                message : 'Incorrect image file.<br/><br/> Only the following files are permitted:<br/>'+settings.allow, //todo localize this script
                status  : 'info',
                timeout : 5000,
                pos     : 'top-center'
            });

        },

        before: function(settings,files){
            TF_GF_Field_Post_Image.preview_photo_blob( files, settings.overlay_panel_el, 'uk-hidden' );
        },

        allcomplete: function( response, xhr ){

            if( Object.keys(response).indexOf('data') < 0 ) return false;
            if( Object.keys(response.data).indexOf('url') < 0 ) return false;
            if( response.data.url ) return false;


            $('<input>').attr({
                type: 'file',
                // id: this.input_name,
                // name: this.input_name,
                id: 'craig',
                name: 'craig',
                class: 'uk-hidden',
            }).appendTo(this.form);


            $(this.upload_drop).on('drop',function(e){
                this.dropped_files = e.originalEvent.dataTransfer.files;
            }.bind(this));

            $(this.overlay_panel_el).css('background-image','url(' + response.data.url + ')' );
        }
    };

    UIkit.uploadDrop( this.upload_drop, this.settings);
};

window.TF_GF_Field_Post_Image = $.extend(TF_GF_Field_Post_Image, {

    selector: '.tf-gf-photo-upload',

    filelimit:1,

    allow: '*.(jpg|jpeg|gif|png)',

    preview_photo_blob: function(file, preview_container, toggle_class ){

        if ( file instanceof Array && file.length >= 1 ){
            file = file[0];
        }

        if( ! file instanceof Blob ){
            console.error( "Incorrect file parameter passed..." );
            return;
        }

        toggle_class = toggle_class || '';

        $(preview_container).css( 'background-image','' );

        $(preview_container).addClass( toggle_class );

        var file_reader = new FileReader();

        file_reader.onload = function( file_upload_result ) {
            $(preview_container).css( 'background-image', 'url('+file_upload_result.target.result+')' );
            $(preview_container).removeClass( toggle_class );
        };

        file_reader.readAsDataURL(file);
    },

    prepare_tf_uk_photo_select_drop_zones: function(){
        $(this.selector).each(function(){
            new TF_UK_Photo_Select_Zone( jQuery(this) );
            // new TF_UK_Photo_Drop_Zone( jQuery(this) );
        });
    },

    init:function(){
        this.prepare_tf_uk_photo_select_drop_zones();
    }
});

if( typeof( window.TF_OVERRIDE_IMAGE_DROP_ZONES ) === 'undefined' || window.TF_OVERRIDE_IMAGE_DROP_ZONES === false ){
    $(document).ready(function(){
        TF_GF_Field_Post_Image.init();
    });
}