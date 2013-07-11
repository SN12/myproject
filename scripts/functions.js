function requiredFieldValidate(formId, elem) {

    if (elem.val() == '')
    {
        elem.removeClass('until-validate validation-passed').addClass('validation-failed');
        addErrorMsg(formId, 'Please, enter the required fields', 'reqErrMsg');
        return false;
    }
    else {
        elem.removeClass('until-validate validation-failed').addClass('validation-passed');
        var status = true;
        jQuery('#' + formId + ' .validation-failed').each(function() {
            if (jQuery(this).val() == '' && jQuery(this).hasClass('req'))
                status = false;
        });

        if (status == true) {
            jQuery("#" + formId + " #notes").children('p.reqErrMsg').html('');
        }

        return true;
    }
}

function passwordValidate(formId, pass) {
    if (!requiredFieldValidate(formId, pass)) {
        return false;
    }

    if (pass.val().length < 6) {
        addErrorMsg(formId, 'Password must be min 6 characters', 'passCharErr');

        pass.removeClass('until-validate validation-passed').addClass('validation-failed');
        return false;
    }
    jQuery("#" + formId + " #notes").children('p.passCharErr').html('');
    return true;
}

function emailValidate(formId, emailElem) {
    if (requiredFieldValidate(formId, emailElem)) {
        var email = emailElem.val();
        var r = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
        if (email.match(r) == null) {
            emailElem.removeClass('until-validate validation-passed').addClass('validation-failed');
            addErrorMsg(formId, 'Please, enter a valid e-mail.', 'emailFErr');
            return false;
        }
        emailElem.removeClass('until-validate validation-failed').addClass('validation-passed');
        jQuery("#" + formId + " #notes").children('p.emailFErr').html('');
        return true;
    }
    return false;
}

function dublicateFieldValue(formId, elem, fieldName) {

    var obj = jQuery('#' + formId).attr('for');

    jQuery.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: {
            object: obj,
            fieldValue: elem.val(),
            fieldName: fieldName,
            action: 'fieldDublicate'
        }
    }).success(function(result) {
        result = result.trim();
//        var json = jQuery.parseJSON(result);
//        var st = status.status);
        
        
        if (result == 'true')
        {
            elem.removeClass('until-validate validation-passed').addClass('validation-failed');
            addErrorMsg(formId, 'This ' + fieldName + ' already exist. Please, enter an another ' + fieldName, fieldName + 'FErr');
            showErrorMsg(formId);
        }
        else
        {
            jQuery("#" + formId + "#notes").children('p.' + fieldName + 'FErr').html('');
            elem.removeClass('until-validate validation-failed').addClass('validation-passed');
            hideErrorMsg(formId);
        }
        
    });
}

function isValidForm(formId) {

    var uv = jQuery('#' + formId + ' .until-validate').length;
    var vf = jQuery('#' + formId + ' .validation-failed').length;
    var ft = jQuery('#' + formId).attr('name');
    if (vf != 0 || uv != 0) {
        
        if (vf == 0) {
            if (ft == 'edit')
            return true;
            jQuery('#' + formId + ' .req').each(function() {
                requiredFieldValidate(formId, jQuery(this));
            });
        }

        jQuery('#' + formId + '  #notes').slideUp(1000, function() {
            jQuery(this).hide();
        });

        jQuery('#' + formId + '  #notes').slideDown(500);
        return false;
    }
    else {

        return true;
    }
}

function addErrorMsg(formId, errMsg, type) {
    jQuery('#' + formId + ' #notes').children('.' + type).html(errMsg);
}

function showErrorMsg(formId) {
    jQuery('#' + formId + ' #notes').slideDown(500);
}

function hideErrorMsg(formId) {
    var vf = jQuery('#' + formId + ' .validation-failed').length;
    if (vf == 0) {
        jQuery('#' + formId + ' #notes').slideUp(1000, function() {
            jQuery(this).hide();
        });
    }
}
