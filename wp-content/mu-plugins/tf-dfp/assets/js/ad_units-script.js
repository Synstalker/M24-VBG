jQuery(document).ready(function ($) {
    'user strict';

    /*----------------------------------------------*/
    /*---------------INITIAL VARS-------------------*/
    /*----------------------------------------------*/

    var localVars = dfp24Vars,
        appName = localVars.appName,
        errorMessages = localVars.errorMessages,
        unsavedChanges = false,
        $form = $('#' + appName + '-admin-post'),
        pageName = localVars.pageNow,
        $infoNotice = $form.find('.status-box'),
        $security = $form.find('input[name=security]').val(),
        $addSlotBtn = $form.find('#add-slot'),
        $removeSlotBtn = $form.find('.remove-slot'),
        $oopBtn = $form.find('.tf-dfp-slot-oop .tf-dfp-i-toggle'),
        oopActive = $form.find('input[name=tf-dfp-use-oop]'),
        $sortable = $form.find('#' + appName + '-repeater-wrap'),
        $activateBtns = $sortable.find('.tf-dfp-i-toggle'),
        $devices = $form.find(".tf-dfp-i-device"),
        codesStorage = {},
        oopStorage = {};

    //If more then 1 li make sortable
    canSort($sortable);

    /*----------------------------------------------*/
    /*-----------------ADD CLICK--------------------*/
    /*----------------------------------------------*/

    $addSlotBtn.on('click', function () {
        var currentItem = $form.find('.' + appName + '-slot:last'),
            $clonedItem = currentItem.clone(true);
        if (!currentItem.hasClass(appName + '-not-valid')) {
            $clonedItem.find('.' + appName + '-ad-units').val("none");
            $clonedItem.insertAfter(currentItem);
        }

        $form.trigger('change'); //Unsaved changes

        canSort($form.find('#' + appName + '-repeater-wrap'));
        //reIterate();
    });

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
    /*-----------------REMOVE CLICK-----------------*/
    /*----------------------------------------------*/

    $removeSlotBtn.each(function (k, v) {
        var $this = $(this);
        $this.on('click', function (e) {
            $removeSlotBtn = $form.find('.remove-slot');
            var currentItem = $(this).parents('.' + appName + '-slot');

            if ($removeSlotBtn.length > 1) {
                currentItem.remove();
            }

            $form.trigger('change'); //Unsaved changes

            canSort($form.find('#' + appName + '-repeater-wrap'));
            //reIterate();
        });
    });

    /*----------------------------------------------*/
    /*--------------------OOP CLICK-----------------*/
    /*----------------------------------------------*/

    $oopBtn.on('click', function (e) {
        $(this).trigger('change');
        $(this).toggleClass('tf-dfp-i-toggle-on tf-dfp-i-toggle-off');
        if ($(this).hasClass('tf-dfp-i-toggle-on')) {
            oopStorage['active'] = 1;
            oopActive[0].value = 1;
        } else {
            oopStorage['active'] = 0;
            oopActive[0].value = 0;
        }
    });


    /*----------------------------------------------*/
    /*----------------DEVICES CLICK-----------------*/
    /*----------------------------------------------*/

    $devices.on('click', function (e) {
        var $that = $(this),
            $input = $that.next('input[type=hidden]');
        $input.trigger('change');
        $that.children().toggleClass('active');
        if ($input[0].value === '0') {
            $input[0].value = '1';
        } else if ($input[0].value === '1') {
            $input[0].value = '0';
        }
    });

    /*----------------------------------------------*/
    /*----------------ACTIVATE CLICK----------------*/
    /*----------------------------------------------*/

    $activateBtns.on('click', function (e) {
        var $that = $(this),
            $input = $that.next('input[type=hidden]');

        $(this).toggleClass('tf-dfp-i-toggle-on tf-dfp-i-toggle-off');

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
        if(!unsavedChanges) {
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
    /*-----------------AJAX SUBMIT------------------*/
    /*----------------------------------------------*/

    $form.on('submit', function (e) {

        e.preventDefault();
        var $dataFields = $form.find('input[name=' + pageName + '_field]'),
            storage = '',
            errorItems = [],
            validate = true,
            errorValidation = errorMessages,
            $slotsToValidate = $form.find('.' + appName + '-slot'),
            $oopSlot = $form.find('.' + appName + '-slot-oop'),
            oopId = $oopSlot.find('input[name=' + appName + '-oop-id]');

        //reIterate();

        $slotsToValidate.each(function (k, v) {
            if ($(this).hasClass(appName + '-not-valid')) {
                $(this).removeClass(appName + '-not-valid');
            }
            if ($oopSlot.hasClass(appName + '-not-valid')) {
                $oopSlot.removeClass(appName + '-not-valid')
            }
            var isValid = validateSlot(this);
            for (var i in isValid[0]) {
                codesStorage[i] = isValid[0][i];
            }
            if (!isValid[1]) {
                errorItems.push(k);
                errorValidation = isValid[3];
            }

            $dataFields[k].value = $.param(codesStorage);
        });

        if (oopId[0].value === '' && oopActive[0].value === '1') {
            errorValidation = errorMessages.adUnits.oop;
            errorItems.push('oop');

        }

        $dataFields.each(function (k, v) {
            if (k < ($dataFields.length - 1)) {
                storage += v.value + '&';
            } else {
                storage += v.value;
            }
        });

        $infoNotice.removeClass('notice-error').addClass('notice-info').fadeIn(200).html('<p>' + localVars.loadingMessage + '</p>');

        validate = errorItems.length <= 0;

        if (validate) {
            unsavedChanges = false; $form.on('change', inputChange);
            if (errorItems.length < 1) {
                $slotsToValidate.each(function (k, v) {
                    if ($(this).hasClass(appName + '-not-valid')) {
                        $(this).removeClass(appName + '-not-valid');
                    }
                });
                $oopSlot.removeClass(appName + '-not-valid');
                errorItems = [];
            }
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: localVars.ajaxUrl,
                data: {
                    'action': 'tf_dfp_update',
                    'page': pageName,
                    'security': $security,
                    'field_data': 'oop=' + oopActive[0].value + '&code=' + oopId[0].value + '|' + storage
                },
                success: function (data) {
                    $infoNotice.html('<p>' + data.notice + '</p>');
                    setTimeout(function () {
                        $infoNotice.fadeOut();
                    }, 600);
                }
            });
        } else {
            console.log(localVars.errorMessages.default);
            $infoNotice.removeClass('notice-info').addClass('notice-error').fadeIn(200).html('<p>' + errorValidation + '</p>');
            for (var i = 0; i < errorItems.length; i++) {
                if (errorItems[i] === 'oop') {
                    $oopSlot.addClass(appName + '-not-valid');
                } else {
                    $slotsToValidate.eq(errorItems[i]).addClass(appName + '-not-valid');
                }
            }
        }
    });

    function canSort($element) {
        $sortable.sortable({
            handle: ".sort-slot",
            placeholder: "widget-placeholder",
            stop: function (event, ui) {
                //reIterate();
            }
        });
        if ($element.find('li').length > 1) {
            $sortable.sortable('enable');
        } else {
            $sortable.sortable('disable');
        }
    }

    function reIterate() {
        var indexes = $form.find('.' + appName + '-codes-index'),
            ad_units = $form.find('.' + appName + '-ad-units'),
            i = 0;

        for (; i < indexes.length; i++) {
            indexes[i].value = i;
        }
    }

    //Need to pass repeating field here
    function validateSlot(target) {
        var errorItem = '',
            isValid = true,
            msg = 'Error!',
            $inputsToValidate = $(target).find('.' + appName),
            $devicesToValidate = $(target).find("input[name*='" + appName + "-device']"),
            $isSlotActive = $(target).find("input[name='" + appName + "-active']"),
            slot = {id: '', unit: '', device: '', active: '', pos: ''},
            devicesSelected = 0;

        for ( var i = 0; i < $inputsToValidate.length; i++ ) {
            var $this = $($inputsToValidate[i]),
                item = $inputsToValidate[i];
            if (isValid) {
                switch (true) {
                    case $this.hasClass(appName + '-codes-id'):
                        isValid = item.value !== '';
                        errorItem = item.value !== '' ? target : '';
                        item.value !== '' ? $(item).trigger('blur') : '';
                        msg = item.value === '' ? msg = errorMessages.adUnits.adIds : '';
                        slot['id'] = item.value;
                        break;
                    case $this.hasClass(appName + '-ad-units'):
                        isValid = item.value !== 'none';
                        errorItem = item.value !== 'none' ? target : '';
                        item.value !== 'none' ? $(item).trigger('blur') : '';
                        msg = item.value === 'none' ? msg = errorMessages.adUnits.adUnits : '';
                        slot['unit'] = item.value;
                        break;
                   case $this.hasClass(appName + '-codes-index'):
                        isValid = item.value !== '';
                        errorItem = isValid ? target : '';
                        isValid ? $(item).trigger('blur') : '';
                        slot['pos'] = item.value;
                        break;
                    default :
                        msg = 'You have broken the internet!';
                        isValid = false;
                        errorItem = '';
                        break;
                }
            }
        }
        for (var i = 0, m = $devicesToValidate.length; i < m; i++) {
            if ( isValid ) {
                var val = 0 !== parseInt($devicesToValidate[i].value) ? parseInt($devicesToValidate[i].value) : 0,
                    devicesSelected = 0 === val ? devicesSelected += 1 : devicesSelected;

                if (m === devicesSelected) {
                    isValid = false;
                    errorItem = target;
                    msg = errorMessages.adUnits.devices;
                    break;
                }

                slot['device'] += i < 2 ? val + '-' : val;
            }
        }
        slot['active'] = $isSlotActive[0].value;
        return [slot, isValid, errorItem, msg];
    }

    window.onbeforeunload = onclose;
});
