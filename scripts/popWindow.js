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
    
    this.generate = function(title, type, id) {
        _id = typeof id !== 'undefined' ? id : new Date().getTime();
        _type = type;
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
            var formId = jQuery("#" + _id).children('form')[0];
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
                var arr = jQuery.parseJSON(result);

                var str = "";
                arr.forEach(function(field) {
                    if (field.element == 'input') {
                        jQuery('#' + _id + ' input[name=' + field.name + ']').val(field.value);
                    }
                    if (field.element == 'textarea') {
                        jQuery('#' + _id + ' textarea[name=' + field.name + ']').val(field.value);
                    }
                });
            });

        }
        
        if (_type != 'message') {
            _buttonAction.onmouseup = function(event) {
                var form = _content.getElementsByTagName('form')[0];
                if (isValidForm(form.id))
                    form.submit();
            }
        }
    }

    this.close = function() {
        var p = win.parentNode;
        p.removeChild(win);
        p.removeChild(mask);
    }
}