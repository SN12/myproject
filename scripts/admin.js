jQuery(document).ready(function() {
    
    jQuery('.req').focusout(function() {
        var formId = jQuery(this).parents('form').attr('id');
        if (requiredFieldValidate(formId, jQuery(this)))
            hideErrorMsg(formId);
        else
            showErrorMsg(formId);
    });

    jQuery('#adminLogin input[type=password]').focusout(function() {
        var pass = jQuery(this);
        var formId = jQuery(this).parents('form').attr('id');
        if (passwordValidate(formId, pass)) {
            jQuery("#" + formId + " #notes").children('p.passMatchErr').html('');
            jQuery(this).removeClass('until-validate, validation-failed').addClass('validation-passed');
            hideErrorMsg(formId);
        }
        else {
            showErrorMsg(formId);
        }
    });

    jQuery('#admin-login-button').click(function() {
        var form = jQuery(this).parents('form');
        if (isValidForm(form.attr('id'))) {
            form.submit();
        }
    });

});
