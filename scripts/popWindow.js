/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function popWindowClass() {
    var that = this;
    var _id;
    var win;
    var mask;
    var _title;
    var _content;
    var _buttonCancel;
    var _buttonAction;
    var _footer;
    var _type;
    var that = this;
    this.generate = function(title, type, id) {
        _id = typeof id !== 'undefined' ? id : new Date().getTime();
//        alert(id);
        _type = type;
//        alert(title);
        win = document.createElement('div');
        win.className = 'pop';
        win.id = _id;
        var header = document.createElement('header');
        _title = document.createElement('p');
        _title.innerHTML = title;
        var close = document.createElement('div');
        close.className = 'close';
        close.onmouseup = function(event) {
            that.close();
        }

        header.appendChild(_title);
        header.appendChild(close);
        win.appendChild(header);
        _content = document.createElement('div');
        _content.className = 'popContent';
        win.appendChild(_content);
//        header.appendChild("<div></div>");
        /* win.innerHTML = '<header>\n\
         <p>' + title + '</p>\n\
         <div class="close"  ></div>\n\
         </header>\n\
         <div class="popContent" id="popContent">\n\
         </div>\n\
         ';*/
//        if (_type == 'message') {
////            win.getElementsByClassName ('popContent');
//        }
////        alert(_type);
        _footer = document.createElement('footer');
        var _buttons = document.createElement('div');
        _buttons.className = 'buttons';
        _footer.appendChild(_buttons);
        _buttonCancel = document.createElement('button');
        _buttonCancel.innerHTML = 'OK';
        _buttonCancel.onmouseup = function(event) {
            that.close();
        }
        _buttons.appendChild(_buttonCancel);
        win.appendChild(_footer);

        switch (_type)
        {
            case 'prompt':
                _buttonAction = document.createElement('button');
                _buttonAction.innerHTML = 'OK';
                _buttons.insertBefore(_buttonAction, _buttonCancel);
                _buttonCancel.innerHTML = 'Cancel';
                break;

            case 'add':
                _buttonAction = document.createElement('button');
                _buttonAction.innerHTML = 'Save';
                _buttons.insertBefore(_buttonAction, _buttonCancel);
                _buttonCancel.innerHTML = 'Cancel';
                break;
            case 'edit':
                _buttonAction = document.createElement('button');
                _buttonAction.innerHTML = 'Save';
                _buttons.insertBefore(_buttonAction, _buttonCancel);
                _buttonCancel.innerHTML = 'Cancel';
                break;
            case 'delete':
                _buttonAction = document.createElement('button');
                _buttonAction.innerHTML = 'Delete';
                _buttons.insertBefore(_buttonAction, _buttonCancel);
                _buttonCancel.innerHTML = 'Cancel';
                break;
        }
        mask = document.createElement('div');
        mask.className = 'mask';
        document.getElementsByTagName('body')[0].appendChild(win);
        document.getElementsByTagName('body')[0].appendChild(mask);
        jQuery('.pop').draggable();
        var close = win.getElementsByClassName('close');
    }

    this.content = function(text) {
        _content.innerHTML = text;
        if (_type == 'message')
        {
            _content.innerHTML = text;
            return;
        }
        if (_type == 'edit')
        {
            var formId = jQuery("#" + _id).children('form')[0];//.attr('id');
            console.log("formId" + formId);
//            console.log("content" + _content);
//            _content.innerHTML = text;
            var data = _id.split("-");
            jQuery.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: {
                    id: data[2],
                    objType: data[1],
                    action: 'getEditableFields'
                }
            }).success(function(result) {
//alert(result);
//        var j = '[{"element":"input","name":"date","value":"2012-12-12"},{"element":"input","name":"time","value":"12:12"},{"element":"textarea","name":"eventDesc","value":"Description"}]';

                var arr = jQuery.parseJSON(result);
//    console.log(arr);
                var str = "";
                arr.forEach(function(field) {


                    if (field.element == 'input') {
                        jQuery('#' + _id + ' input[name=' + field.name + ']').val(field.value);
                    }
                    if (field.element == 'textarea') {
                        jQuery('#' + _id + ' textarea[name=' + field.name + ']').val(field.value);
                    }
                });
//                alert(formId);
//                var element = jQuery.parseHTML(str);
//                console.log(element);
////    document.getElementById("#"+formId).appendChild(element);
////     += str;
//                jQuery('#' + formId).append(element);
//                console.log(str);
//                return;

                // }
                /* else
                 {
                 res = false;
                 
                 jQuery("#" + formId + "#notes").children('p.' + fieldName + 'FErr').html('');
                 elem.removeClass('until-validate validation-failed').addClass('validation-passed');
                 showErrorMsg(formId);
                 
                 }*/
            });

        }
        if (_type != 'message') {
            _buttonAction.onmouseup = function(event) {
                var form = _content.getElementsByTagName('form')[0];
                console.log(form.id);
//            var formId='';
                if (isValidForm(form.id))
                    form.submit();

            }
        }
    }

    this.actionParam = function(obj, id) {
//        alert(obj+'action'+id);

    }

    this.close = function() {
//        alert('close');

        var p = win.parentNode;
        console.log(p);
        p.removeChild(win);
        p.removeChild(mask);
//        document.getElementsByTagName('body')[0].removeChild(win);

    }
}