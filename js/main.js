/*jslint browser: true*/
/*global $, jQuery, alert*/
jQuery(document).ready(function ($) {
    "use strict";


    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');
    
    function validate(input) {
        if ($(input).attr('type') === 'email' || $(input).attr('name') === 'email') {
            if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) === null) {
                return false;
            }
        } else if ($(input).attr('type') === 'tel' || $(input).attr('name') === 'tel') {
            if ($(input).val().trim().match(/^\d{10}$/) === null) {
                return false;
            }
        } else {
            if ($(input).val().trim() === '') {
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    $('.validate-form').on('submit', function () {
        var check = true, i = 0;
        for (i = 0; i < input.length; i += 1) {
            if (validate(input[i]) === false) {
                showValidate(input[i]);
                check = false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function () {
        $(this).focus(function () {
            hideValidate(this);
        });
    });
    

});