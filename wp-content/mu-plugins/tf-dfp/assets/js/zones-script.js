jQuery(document).ready(function ($) {
    'user strict';

    /*----------------------------------------------*/
    /*---------------INITIAL VARS-------------------*/
    /*----------------------------------------------*/

    var localVars = dfp24Vars,
        appName = localVars.appName,
        errorMessages = localVars.errorMessages,
        unsavedChanges = false,
        pageName = localVars.pageNow,
        $form = $(document.getElementById(appName + '-admin-post')),
        $infoNotice = $form.find('.status-box'),
        $security = $form.find('input[name=security]').val(),
        addSlotBtn = document.getElementById('add-slot'),
        $removeSlotBtn = $form.find('.remove-slot'),
        $sortable = $(document.getElementById(appName + '-repeater-wrap')),
        $activateBtns = $sortable.find('.' + appName + '-i-toggle'),
        $select2Fields = $sortable.find('.select2_field select'),
        $slotsToValidate = $form.find( '.' + appName + '-slot').not('.clone' ),
        $radioFields = $form.find('input:radio'),
        itemsCount = $slotsToValidate.length,
        codesStorage = {};

        // DM: Good practices! WHOO!

    /*----------------------------------------------*/
    /*-----------------ADD CLICK--------------------*/
    /*----------------------------------------------*/

    $( addSlotBtn ).on('click', function () {
        var currentItem = $form.find('.' + appName + '-slot:last'),
            $clonedItem = $form.find('.clone').clone(true),
            $cloneRadioFields = $clonedItem.find('input:radio'),
            $cloneSelect2Field = $clonedItem.find('.select2_field select');

        $slotsToValidate = $form.find('.' + appName + '-slot').not('.clone');

        for(var i = 0, m = $cloneRadioFields.length; i < m; i++){
            $cloneRadioFields[i].name = appName + '-content-select-' +  $slotsToValidate.length;
        }

        itemsCount = itemsCount + 1;

        if (!currentItem.hasClass(appName + '-not-valid')) {

            $clonedItem.insertAfter(currentItem).removeClass('clone');
            $($cloneSelect2Field[2]).closest('.field-set').addClass('select2_display');

            console.log($($cloneSelect2Field[2]));

            for( var i = 0, m = $cloneSelect2Field.length; i < m; i++ ){
                var cpt = $cloneSelect2Field[i].getAttribute('data-post-type');
                select2Init( $($cloneSelect2Field[i]), 'Find a ' + cpt, cpt );
            }
        }
    });

    // Im being precautios here, but may be better to run the .on() method on document, may not make much of a difference but it is a performance enhancement:
    /*
    *
    *   $(document).on('click', addSlotBtn, function(){
    *   
    *   });
    *
    * */

    /*
     * @DM - Gave really undesired results.
     */

    /*----------------------------------------------*/
    /*-----------------REMOVE CLICK-----------------*/
    /*----------------------------------------------*/

    $removeSlotBtn.each(function (k, v) {
        var $this = $(v);
        $this.on('click', function (e) {
            $removeSlotBtn = $form.find('.remove-slot');
            var currentItem = $(this).closest('.' + appName + '-slot');

            $slotsToValidate = $form.find('.' + appName + '-slot').not('.clone');
            itemsCount = $slotsToValidate.length;

            if ($removeSlotBtn.length > 1) {
                currentItem.remove();
            }
        });
    });

    /*----------------------------------------------*/
    /*----------------ACTIVATE CLICK----------------*/
    /*----------------------------------------------*/

    $activateBtns.on('click', function (e) {
        var $that = $(this),
            $input = $that.next('input[type=hidden]');

        $(this).toggleClass(appName + '-i-toggle-on ' + appName + '-i-toggle-off');

        if ($input[0].value === '0') {
            $input[0].value = '1';
        } else {
            $input[0].value = '0';
        }
    });

    /*----------------------------------------------*/
    /*---------------------UNSAVED------------------*/
    /*----------------------------------------------*/


    $form.on('change', inputChange);

    function inputChange(){
        if( !unsavedChanges ) {
            unsavedChanges = true;
            $form.off('change', inputChange);
            console.log("first change");
        }
    }

    function onclose(){
        if(unsavedChanges){
            return errorMessages.unsavedChanges;
        }
    };

    /*----------------------------------------------*/
    /*-----------------CTRL+S CLICK-----------------*/
    /*----------------------------------------------*/

    var isCtrl = false;
    document.onkeyup=function(e){
        if(e.keyCode == 17) isCtrl=false;
    }

    document.onkeydown=function(e){
        if(e.keyCode == 17) isCtrl=true;
        if(e.keyCode == 83 && isCtrl == true) {
            //run code for CTRL+S -- ie, save!
            console.log("Saving!...");
            $form.trigger('submit');
            return false;
        }
    }

    /*----------------------------------------------*/
    /*----------RADIO-DISPLAY-SELECT2---------------*/
    /*----------------------------------------------*/

    $radioFields.each( function(k,v){
        var $radio = $(this);
        $radio.on('change', function (e) {

            var $target = $( e.target),
                $activeSlot = $target.closest('li'),
                $activeItem = $target.closest('.field-set'),
                isDisplaying = $activeSlot.find('.select2_display');

            //Hide if aleady displaying
            if( isDisplaying.length >= 1 ){
                $(isDisplaying).removeClass('select2_display');
            }

            $activeItem.next().toggleClass('select2_display');

        });
    });

    /*----------------------------------------------*/
    /*-----------------AJAX-SUBMIT------------------*/
    /*----------------------------------------------*/

    $form.on('submit', function (e) {

        e.preventDefault();
        var storage = '',
            errorItems = [],
            $slotsToValidate = $form.find('.' + appName + '-slot').not('.clone'),
            $dataFields = $slotsToValidate.find('input[name=' + pageName + '_field]'),
            errorMessage = localVars.errorMessages.default;

        //Validate
        for( var i = 0, m = $slotsToValidate.length; i < m; i++ ) {
            if ($($slotsToValidate[i]).hasClass(appName + '-not-valid')) {
                $($slotsToValidate[i]).removeClass(appName + '-not-valid');
            }
            var isValid = validateSlot($slotsToValidate[i]);

            for (var validItem in isValid[0]) {
                codesStorage[validItem] = isValid[0][validItem];
            }
            if ( !isValid[1] ) {
                errorItems.push(i);
                errorMessage = isValid[3];
            }
            $dataFields[i].value = $.param(codesStorage);
        }

        //Prepare data
        for( var i = 0, m = $dataFields.length, s = m - 1; i < m ; i++ ) {
            var isClone = $($dataFields[i]).closest('li').hasClass('clone');
            if(!isClone) {
                if (i < s) {
                    storage += $dataFields[i].value + '&';
                } else {
                    storage += $dataFields[i].value;
                }
            }
        }

        //Fire Notice
        $infoNotice.removeClass('notice-error').addClass('notice-info').fadeIn(200).html('<p>' + localVars.loadingMessage + '</p>');

        //Last validation
        var validated = errorItems.length <= 0;

        if ( validated ) {
            unsavedChanges = false; $form.on('change', inputChange);
            //Empty error object
            errorItems = [];

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: localVars.ajaxUrl,
                data: {
                    action: 'tf_dfp_update',
                    page: pageName,
                    security: $security,
                    post_request: 'default',
                    field_data: storage
                },
                success: function (data) {
                    console.log(storage);
                    $infoNotice.html('<p>' + data.notice + '</p>');
                    setTimeout(function () {
                        $infoNotice.fadeOut();
                    }, 600);
                },
                error: function(data){
                    console.log(data);
                }
            });

        } else {

            $infoNotice.removeClass('notice-info').addClass('notice-error').fadeIn(200).html('<p>' + errorMessage + '</p>');
            for ( var i = 0, m = errorItems.length; i < m; i++ ) {
                $slotsToValidate.eq(errorItems[i]).addClass( appName + '-not-valid' );
            }

        }
    });

    /*----------------------------------------------*/
    /*-----------------POST SEARCH------------------*/
    /*----------------------------------------------*/

    var select2Init = function ($selectField, placeholderTxt, postType){
        postType = typeof postType !== 'undefined' ? postType : 'post'
        placeholderTxt = typeof placeholderTxt !== 'undefined' ? placeholderTxt : 'Select an item';
        $selectField.select2({
            placeholder: placeholderTxt,
            minimumInputLength: 3,
            width: '100%',
            delay: 250,
            ajax: {
                cache: false,
                type: 'POST',
                url: localVars.ajaxUrl,
                dataType: 'json',
                data: function (term, page) {
                    return {
                        q: term,
                        action: 'tf_dfp_update',
                        security: $security,
                        post_request: 'search_content',
                        post_type: postType,
                    }
                },
                processResults: function (search_data) {

                    var items=[];

                    $.each( search_data, function( i, item ) {
                        var new_item = {
                            'id' : item.id,
                            'text' : item.text
                        };

                        items.push(new_item);
                    });

                    return { results: items };
                }
            }
        });

        $selectField.on("select2:open select2:closing", function (e) {
            var $searchBox = $('input.select2-search__field'),
                type = e.type === 'select2:open' ? 'focus' : 'focusOut' ;
            setTimeout(function(){
                $searchBox.trigger(type);
            }, 250);
        });
    }

    //Setup initial select2 fields
    for( var i = 0, m = $select2Fields.length; i < m; i++ ){
        if(!$($select2Fields[i]).closest('li').hasClass('clone')) {
            var cpt = $select2Fields[i].getAttribute('data-post-type');
            select2Init( $($select2Fields[i]), 'Find a ' + cpt, cpt );
        }
    }

    //Validation on submit
    var validateSlot = function(target) {

        var errorItem = '',
            isValid = true,
            $isRadioActive = $(target).find('.select2_display select'),
            $isSlotActive = $(target).find( "input[name='" + appName + "-active']" ),
            //$inputsToValidate = $(target).find( ".tf-dfp-custom-tag, .tf-dfp-ad-unit" ),
            $inputsToValidate = $(target).find( ".tf-dfp-custom-tag" ),
            slot = { id: '', tag: '', active: '' },
            msg = '';

        if( $isRadioActive.length > 0 && $($isRadioActive).val() !== null ){

            var cpt = $isRadioActive[0].getAttribute("data-post-type");

            isValid = $isRadioActive[0].value !== '';
            errorItem = isValid ? target : '';
            slot['id'] = cpt.toLowerCase() + '-' + $isRadioActive[0].value;
            msg = "";

        } else {

            isValid = false;
            errorItem = '';
            msg = errorMessages.zones.search;

        }
        if( isValid ) {
            console.log($inputsToValidate[0]);
            for (var i = 0, m = $inputsToValidate.length; i < m; i++) {
                if (isValid) {
                    /*if ( $isSlotActive[0].value === '1' ){
                        if( $inputsToValidate[1].value !== 'none' ){
                            //Must select ad unit
                            slot['remove'] = $inputsToValidate[1].value;
                        } else {
                            isValid = false;
                            errorItem = '';
                            msg = errorMessages.zones.adUnits;
                            break;
                        }
                    } else {*/
                        if( $inputsToValidate[0].value !== '' ){
                            //Must have /Custom tag input
                            slot['tag'] = $inputsToValidate[0].value.replace(/^\//g, ''); //Remove leading slash
                        } else {

                            isValid = false;
                            errorItem = '';
                            msg = errorMessages.zones.tag;
                            break;

                        }
                    //}
                }
            }
        }


        slot['active'] = $isSlotActive[0].value;

        return [slot, isValid, errorItem, msg];
    }

    window.onbeforeunload = onclose;
});
