jQuery(document).ready(function() {

    jQuery('.req').focusout(function() {
        var formId = jQuery(this).parents('form').attr('id');
        if (requiredFieldValidate(formId, jQuery(this)))
            hideErrorMsg(formId);
        else
            showErrorMsg(formId);
    });

    jQuery('#register input[type=email]').focusout(function() {
        var emailElem = jQuery(this);
        var formId = emailElem.parents('form').attr('id');
        if (emailValidate(formId, emailElem))
        {
            dublicateFieldValue(formId, emailElem, 'email');
        }

        else
            showErrorMsg(formId);
    });

    jQuery('#register input[type=password]').focusout(function() {
        var pass = jQuery(this);
        var formId = jQuery('#register').attr('id');
        var pass1 = jQuery('#' + formId + ' #password');
        var pass2 = jQuery('#' + formId + ' #conf_password');

        if (passwordValidate(formId, pass)) {
            if (pass1.val() != pass2.val()) {
                addErrorMsg(formId, 'Passwords do not match', 'passMatchErr');
                showErrorMsg(formId);
                jQuery(this).removeClass('until-validate validation-passed').addClass('validation-failed');
            }
            else {
                jQuery("#register #notes").children('p.passMatchErr').html('');
                jQuery('#register input[type=password]').removeClass('until-validate validation-failed').addClass('validation-passed');
                hideErrorMsg(formId);
            }
        }
        else {
            showErrorMsg(formId);
        }
    });

    jQuery('#register-button').click(function() {
        var form = jQuery(this).parents('form');
        if (isValidForm(form.attr('id'))) {
            form.submit();
        }
    });

    jQuery('#login input[type=password]').focusout(function() {
        var formId = jQuery(this).parents('form').attr('id');
        if (!passwordValidate(formId, jQuery(this)))
            showErrorMsg(formId);
        else
            hideErrorMsg(formId);
    });

    jQuery('#login input[type=email]').focusout(function() {
        var emailElem = jQuery(this);
        var formId = emailElem.parents('form').attr('id');
        if (emailValidate(formId, emailElem))
        {
            jQuery("#" + formId + "#notes").children('p.emailFErr').html('');
            emailElem.removeClass('until-validate validation-failed').addClass('validation-passed');
        }
        else
            showErrorMsg(formId);
    });

    jQuery('#user-login-button').click(function() {
        var form = jQuery(this).parents('form');
        if (isValidForm(form.attr('id'))) {
            form.submit();
        }
    });

});