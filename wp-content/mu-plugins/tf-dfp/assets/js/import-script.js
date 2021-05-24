
var TF_CSVHandler = function( $ ) {
    this.fileInput();
    this.form = document.getElementById('tf-dfp-admin-post');
    this.status = document.getElementById('import_status');
    this.$ = $;
    this.localVars = dfp24Vars;
    this.addEvents( this.form );
    this.uploadedData = null;
};

TF_CSVHandler.prototype.fileInput = function () {
    var inputs = document.querySelectorAll( '.inputfile' );
    Array.prototype.forEach.call( inputs, function( input )
    {
        var label	 = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.querySelector( 'span' ).innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });

        // Firefox bug fix
        input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
        input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
    });
};

TF_CSVHandler.prototype.addEvents = function ( form ) {
    var _this = this;
    _this.form.addEventListener( "change", _this.$.proxy( this.csvFormatUpload, _this ), false );
    _this.form.addEventListener( "submit", _this.$.proxy( this.processUpload, _this ), false );
};

TF_CSVHandler.prototype.csvFormatUpload = function ( e ) {
    console.log(this.localVars, e);
    if( window.File && window.FileReader && window.FileList && window.Blob ){
        var file = typeof e.target.files[0] !== "undefined" ? e.target.files[0]: null,
            reader = new FileReader(),
            status = this.$( this.status ),
            _that = this;
        reader.readAsText(file);
        reader.onload = function ( event ) {
            var csvData = event.target.result;
            _that.uploadedData = csvData.split( "\n" );
            _that.incrementCount( 1, _that.uploadedData.length, 20, status );
        };
        reader.onerror = function () {
            alert( 'Unable to read ' + file.fileName );
        };
    } else {
        alert( 'The File APIs are not fully supported in this browser!' );
    }
};

TF_CSVHandler.prototype.incrementCount = function( s, f, d, e ){ //start, finish, delay, element

    var _that = this,
        status = _that.localVars.statusMessages.fileUpload;

    setTimeout( function () {
        e.text( s + status );
        s++;
        if (s < f) {
            _that.incrementCount( s, f, d, e );
        }
    }, d)

}

TF_CSVHandler.prototype.processUpload = function( e ){
    e.preventDefault();
};

jQuery(document).ready(function ($) {

    'use strict';
    var csvHandler = document.getElementById('tf-dfp-admin-post');
    new TF_CSVHandler( $ );

});