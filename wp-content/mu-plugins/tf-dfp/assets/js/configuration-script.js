jQuery(document).ready(function ($) {
    'user strict';

    var localVars = dfp24Vars,
        appName = localVars.appName,
        $form = $('#' + appName + '-admin-post'),
        unsavedChanges = false,
        pageName = localVars.pageNow,
        $infoNotice = $form.find('.status-box'),
        $security = $form.find('input[name=security]').val(),
        $deskPrefix = $form.find("input[name=" + appName + "-d-prefix]"),
        $tabletPrefix = $form.find("input[name=" + appName + "-t-prefix]"),
        $mobiPrefix = $form.find("input[name=" + appName + "-m-prefix]"),
        $cxSiteId = $form.find("input[name=" + appName + "-cxense-siteid]"),
        $cxPersistedQueryId = $form.find("input[name=" + appName + "-cxense-persistedqueryid]"),
        $activateBtns = $form.find('.tf-dfp-i-toggle'),
        configStorage = {
            d:'',
            t:'',
            m:'',
            s:'',
            p:'',
            a:''
        };

    /*----------------------------------------------*/
    /*----------------ACTIVATE CLICK----------------*/
    /*----------------------------------------------*/

    $activateBtns.on('click', function (e) {
        var $that = $(this),
            $input = $that.next('input[type=hidden]');

        $that.trigger('change');

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
            return localVars.errorMessages.unsavedChanges;
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
    /*-----------------AJAX SUBMIT------------------*/
    /*----------------------------------------------*/

    $form.on('submit', function (e) {

        e.preventDefault();
        var validated = true;

        if($deskPrefix[0].value === ''){
            validated = false;
            configStorage.d = '';
        }else{
            configStorage.d = $deskPrefix[0].value.replace(/\/+$/, ""); //Remove trailing slash
            $($deskPrefix[0]).trigger('blur');
        }
        if($mobiPrefix[0].value === '') {
            configStorage.m = '';
        }else{
            configStorage.m = $mobiPrefix[0].value.replace(/\/+$/, ""); //Remove trailing slash
            $($mobiPrefix[0]).trigger('blur');
        }
        if($tabletPrefix[0].value === '') {
            configStorage.t = '';
        }else{
            configStorage.t = $tabletPrefix[0].value.replace(/\/+$/, ""); //Remove trailing slash
            $($tabletPrefix[0]).trigger('blur');
        }

        if($cxSiteId[0].value === '') {
            configStorage.s = '';
        }else{
            configStorage.s = $cxSiteId[0].value;
            $($cxSiteId[0]).trigger('blur');
        }

        if($cxPersistedQueryId[0].value === '') {
            configStorage.p = '';
        }else{
            configStorage.p = $cxPersistedQueryId[0].value;
            $($cxPersistedQueryId[0]).trigger('blur');
        }

        configStorage.a = $activateBtns.next('input[type=hidden]').val();
        $infoNotice.removeClass('notice-error').addClass('notice-info').fadeIn(200).html('<p>' + localVars.loadingMessage + '</p>');

        if (validated) {
            unsavedChanges = false; $form.on('change', inputChange);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: localVars.ajaxUrl,
                data: {
                    'action': 'tf_dfp_update',
                    'page': pageName,
                    'security': $security,
                    'field_data': $.param(configStorage)
                },
                success: function (data) {
                    $infoNotice.html('<p>' + data.notice + '</p>');
                    setTimeout(function () {
                        $infoNotice.fadeOut();
                        validated = true;
                    }, 600);
                },
                error: function(){
                    $infoNotice.removeClass('notice-info').addClass('notice-error').fadeIn(200).html('<p>' + localVars.errorMessages[pageName] + '</p>');
                }
            });
        } else {
            $infoNotice.removeClass('notice-info').addClass('notice-error').fadeIn(200).html('<p>' + localVars.errorMessages[pageName] + '</p>');
        }
    });
    window.onbeforeunload = onclose;
});