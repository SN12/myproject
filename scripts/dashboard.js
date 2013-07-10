jQuery(document).on('focusout', '.req', function() {
    var formId = jQuery(this).parents('form').attr('id');
    if (requiredFieldValidate(formId, jQuery(this)))
        hideErrorMsg(formId);
    else
        showErrorMsg(formId);
});

jQuery(document).ready(function() {
    
    jQuery('.req').focusout(function() {
        var formId = jQuery(this).parents('form').attr('id');
        if (requiredFieldValidate(formId, jQuery(this)))
            hideErrorMsg(formId);
        else
            showErrorMsg(formId);
    });

    jQuery('#add-contact input[type=email]').focusout(function() {
        var emailElem = jQuery(this);
        var formId = emailElem.parents('form').attr('id');

        if (emailValidate(formId, emailElem))
        {
            dublicateFieldValue(formId, emailElem, 'email');
        }
        else
            showErrorMsg(formId);
    });

    jQuery('#add-contact-button').click(function() {
        var form = jQuery(this).parents('form');
        if (isValidForm(form.attr('id'))) {
            form.submit();
        }
    });

    jQuery('#add-event-button').click(function() {
        
        var window = new popWindowClass();
        window.generate('Add a new event', 'add');
        window.content('<form class="register gray" id="add-event" action="actions.php" method="post">\n\
                            <div id="notes" >\n\
                                <p class="reqErrMsg"></p>\n\
                                <p class="passCharErr"></p>\n\
                                <p class="passMatchErr"></p>\n\
                                <p class="emailFErr"></p>\n\
                                <p class="emailDErr"></p>\n\
                            </div>\n\
                            <div class="table">\n\
                                <p class="row required">\n\
                                    <label for="date">Date/Time</label>\n\
                                        <input class="until-validate req" type="date" alt="dateTime" id="date"  name="date" />\n\
                                        <input class="until-validate req" type="time" alt="dateTime" id="time" placeholder=""  name="time" />\n\
                                        <span>*</span>\n\
                                </p>\n\
                                <p class="row required">	\n\
                                           <label for="eventDesc">Event Description</label>\n\
                                           <textarea class="until-validate req" type="text" alt="event description" id="eventDesc" placeholder=""  name="eventDesc" ></textarea>\n\
                                           <span>*</span>\n\
                                </p>\n\
                            </div>\n\
                            <input type="hidden" name="action" value="addEvent"/>\n\
                            <div class="form-bottom">\n\
                            </div>\n\
                        </form>');

    });

    jQuery('.delete-icon').click(function() {
        var win = new popWindowClass();
        var id = jQuery(this).attr('id');
        var elem = id.split("-");

        win.generate('Delete event', 'delete');
        win.content('Are you sure you want to delete this event?\n\
                      <form id="deleteEventForm" method="POST" action="actions.php" >\n\
                        <input type="hidden" name="action" value="deleteEvent" />\n\
                        <input type="hidden" name="eventId" value="' + elem[2] + '" />\n\
                      </form>');
    });

    jQuery('.edit-icon').click(function() {
        var win = new popWindowClass();
        var id = jQuery(this).attr('id');
        var elem = id.split("-");

        win.generate('Edit event', 'edit', "edit-event-" + elem[2]);
        win.content('<form class="register gray" id="editEventForm" name="edit" action="actions.php" method="post">\n\
                            <div id="notes" >\n\
                                <p class="reqErrMsg"></p>\n\
                                <p class="passCharErr"></p>\n\
                                <p class="passMatchErr"></p>\n\
                                <p class="emailFErr"></p>\n\
                                <p class="emailDErr"></p>\n\
                            </div>\n\
                            <div class="table">\n\
                                <p class="row required">\n\
                                    <label for="date">Date/Time</label>\n\
                                        <input class="until-validate req" type="date" alt="date" id="date"  name="date" />\n\
                                        <input class="until-validate req" type="time" alt="time" id="time" placeholder=""  name="time" />\n\
                                        <span>*</span>\n\
                                </p>\n\
                                <p class="row required">	\n\
                                           <label for="eventDesc">Event Description</label>\n\
                                           <textarea class="until-validate req" type="text" alt="event description" id="eventDesc" placeholder=""  name="eventDesc" ></textarea>\n\
                                           <span>*</span>\n\
                                </p>\n\
                            </div>\n\
                            <input type="hidden" name="action" value="updateEvent"/>\n\
                            <input type="hidden" name="eventId" value="' + elem[2] + '" />\n\
                            <div class="form-bottom">\n\
                            </div>\n\
                        </form>');
    });

    jQuery('#send-mail-form-button').click(function() {
        var form = jQuery(this).parents('form');
        if (isValidForm(form.attr('id'))) {
            form.submit();
        }
    });
    
});