/*
 * @author: Jared Rethman <jared.rethman@24.com>
 */

//////////////
//TFDFPAdSlot
//////////////

var TFDFPAdSlot = function() {
    this.id = '';
    this.name = '';
    this.dimension = '';
    this.setTarget = '';
};

TFDFPAdSlot.prototype.setID = function( id ) {
    this.id = id;
    return this;
};

TFDFPAdSlot.prototype.setName = function( name ) {
    this.name = name;
    return this;
};

TFDFPAdSlot.prototype.setDimensions = function( dimension ) {
    this.dimension = dimension;
    return this;
};

TFDFPAdSlot.prototype.setTargeting = function( setTarget ) {
    this.setTarget = setTarget;
    return this;
};

////////////////
//TFDFPAdRequest
////////////////


var TFDFPAdRequest = function( slots, googletag ) {
    this.slots = slots;
    this.googleTag = googletag;
    this.meta = [];
    this.makeRequest();
    this.display( this.slots );
    this.debug( false );
};

TFDFPAdRequest.prototype.debug = function ( display ) {

};

TFDFPAdRequest.prototype.defineSlots = function ( siteName ) {

    for ( var i = 0, a = this.slots, m = a.length; i < m; i++ ) {

        var slot = a[i],
            dimensions = slot.dimension.toString(),
            definedSlot = this.googleTag,
            adSlot = '';

        if( dimensions.indexOf('x') > -1 ) {

            var wh = dimensions.split("x");
            adSlot = this.googleTag.defineSlot( siteName, [parseInt(wh[0]), parseInt(wh[1])], slot.id.toString() );

        } else if( 'oop' === dimensions ){

            adSlot = this.googleTag.defineOutOfPageSlot( siteName, slot.id.toString());

        } else if( 'fluid' === dimensions ){

            adSlot = this.googleTag.defineSlot( siteName, dimensions, slot.id.toString());

        }

        //If cxense targetting is available, set it up
        if ( typeof tfdfp_cxense_params !== 'undefined' && typeof tfdfp_cxense_params.cxense_persistedqueryid !== 'undefined' && tfdfp_cxense_params.cxense_persistedqueryid !== '' ) {
            //Only setTargeting if its available...
            if ('' !== a[i].setTarget) {
                adSlot.addService(this.googleTag.pubads())
                    .setTargeting(a[i].setTarget)
                    .setTargeting("CxSegments", cX.getUserSegmentIds({persistedQueryId: tfdfp_cxense_params.cxense_persistedqueryid}))
                    .setCollapseEmptyDiv(true, true);
            } else {
                adSlot.addService(this.googleTag.pubads())
                    .setTargeting("CxSegments", cX.getUserSegmentIds({persistedQueryId: tfdfp_cxense_params.cxense_persistedqueryid}))
                    .setCollapseEmptyDiv(true, true);
            }
        }
        else {
            //Only setTargeting if its available...
            if ('' !== a[i].setTarget) {

                adSlot.addService(this.googleTag.pubads()).setTargeting(a[i].setTarget).setCollapseEmptyDiv(true, true);

            } else {

                adSlot.addService(this.googleTag.pubads()).setCollapseEmptyDiv(true, true);
            }
        }

    }
    return this

};

TFDFPAdRequest.prototype.getMeta = function(){

    var element = document.querySelectorAll("meta[name^='ad:']"),
        _that = this;

    for( var i = 0, m = element.length; i < m; i++ ){

        _that.meta.push( element[i].content );

    }
    return this;
};

TFDFPAdRequest.prototype.makeRequest = function() {
    var _this = this,
        meta = this.getMeta(),
        tag = meta.meta[1] !== 'none' ? '/' + meta.meta[1] : ''/*,
        oop = meta.meta[2]*/;

    if( _this.slots.length > 0 ) {
        //console.log( meta.meta[0] );
        this.googleTag.cmd.push(function () {
            _this.defineSlots( meta.meta[0] + tag ); //'/8900/24.com/Web/W24/Homepage'
            _this.googleTag.pubads().collapseEmptyDivs();
            _this.googleTag.pubads().enableAsyncRendering();
            _this.googleTag.pubads().enableSingleRequest();
            _this.googleTag.enableServices();
        });
    }
};

TFDFPAdRequest.prototype.display = function( slots ) {
    var _this = this;
    if ( typeof tfdfp_cxense_params !== 'undefined' && typeof tfdfp_cxense_params.cxense_persistedqueryid !== 'undefined' && tfdfp_cxense_params.cxense_persistedqueryid !== '' ) {
        // Cxense integration
        cX.callQueue.push(['invoke', function () {
            _this.googleTag.cmd.push(function () {
                for (var i = 0, a = slots, m = a.length; i < m; i++) {
                    var slot = a[i];
                    _this.googleTag.display(slot.id.toString());
                }
            });
        }]);
    } else {
        // Regular way
        _this.googleTag.cmd.push(function () {//console.log(slots);
            for (var i = 0, a = slots, m = a.length; i < m; i++) {
                var slot = a[i];
                //console.log( slot.id.toString() );
                _this.googleTag.display(slot.id.toString());
            }
        });
    }
};

//////////////
//Start her up
//////////////

(function ($) {

    'use strict';

    var $targets = $("[data-type='tf-dfp-advert']"),
        slots = [];

    for( var i = 0, m = $targets.length; i < m; i++ ) {

        var slot        = new TFDFPAdSlot(),
            id          = $targets[i].attributes.id.value,
            //Provide fallback for dataset IE twats!
            size        = typeof $targets[i].dataset !== 'undefined' ? $targets[i].dataset.adSize : $targets[i].getAttribute('data-ad-size'),
            setTarget   = typeof $targets[i].dataset !== 'undefined' ? $targets[i].dataset.setTarget : $targets[i].getAttribute('data-set-target');

        
        /*
         if( $targets[i].dataset.adSize !== undefined ){
         size        = $targets[i].dataset.adSize;
         }else{
         size        = $targets[i].dataset.adSize;
         }
         if( $targets[i].dataset.setTarget !== undefined ){
         setTarget   = $targets[i].dataset.setTarget;
         }else{
         setTarget   = $targets[i].dataset.setTarget;
         }
        */
        
        //Set slot configuration
        slot.setID( id ).setDimensions( size ).setTargeting( setTarget );
        //slot.setName( $targets[i].getAttribute('data-ad-id') );

        slots.push(slot);
    }

    //Call to GA
    new TFDFPAdRequest( slots, googletag );

})(jQuery);