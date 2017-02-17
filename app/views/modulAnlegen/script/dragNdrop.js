var dragNdrop =
        {
            elementNum: 0,
            allowDrop:
                    function (ev) {
                        ev.preventDefault();
                    },
            drag: function (ev) {
                ev.dataTransfer.setData("source", ev.target.id);
            },
            drop: function (ev, parent)
            {

                ev.preventDefault();
                var data = ev.dataTransfer.getData("source");

                if (checkMenuItem(data))
                {
                    var element = this.inhaltModulElementErstellen(data, null);
                }
                else
                    var element = document.getElementById(data);

                try
                {
                    parent.appendChild(element);
                }
                catch (ex)
                {
                    console.log(ex.message);
                }

                dragNdrop.saveAllNodes();

                function checkMenuItem(data)
                {
                    return data == 'text' ||
                            data == 'audio' ||
                            data == 'video' ||
                            data == 'image' ||
                            data == 'vorhandeneInhalte';
                }

            }
            ,
            saveAllNodes: function () {

                sessionStorage.clear();

                var inhaltModul = document.getElementById('inhaltModul');

                var children = inhaltModul.childNodes;

                var childrenID = [];

                children.forEach(function (item, index) {
                    if (index > 0)
                        childrenID.push(item.id);
                });

                sessionStorage.setItem('inhaltModul', JSON.stringify(childrenID));

            }
            ,
            /**
             * 
             * @param {type} path url
             * @param {type} params Objekt
             * @param {type} method
             * 
             */
            sendPOST: function (url, params, name)
            {
                var form = document.createElement("form");
                form.setAttribute("method", 'post');
                form.setAttribute("action", url);

                for (var key in params) {
                    if (params.hasOwnProperty(key)) {
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", name + '[' + key + ']');
                        hiddenField.setAttribute("value", params[key]);

                        form.appendChild(hiddenField);
                    }
                }

                document.body.appendChild(form);

                form.submit();

            }

            ,
            inhaltModulFuellen: function () {

                var inhaltModul = document.getElementById('inhaltModul');
                var inhaltModulIDs = JSON.parse(sessionStorage.getItem('inhaltModul'))
                if (inhaltModulIDs != null)
                {
                    inhaltModulIDs.forEach(function (item) {
                        inhaltModul.appendChild(dragNdrop.inhaltModulElementErstellen(filterID(item), item));
                    });
                }

                function filterID(id)
                {
                    var inhalte = ['text', 'audio', 'video', 'image', 'vorhandeneInhalte'];
                    var inhaltTyp;

                    inhalte.forEach(function (item) {
                        if (id.includes(item))
                        {
                            inhaltTyp = item;
                        }
                    });

                    return inhaltTyp;
                }
            },
            inhaltModulElementErstellen: function (data, id)
            {
                id = id || null;

                var element;

                switch (data)
                {
                    case 'text':
                        element = document.createElement('textarea');
                        element.id = 'textarea' + this.elementNum;
                        element.style.width = '100%';

                        break;

                    case 'audio':

                    case 'video':

                    case 'image':

                        var form = document.createElement('form');
                        form.id = data + 'Upload' + this.elementNum;
                        form.action = 'upload/verarbeitung/' + data;
                        form.method = 'post';
                        form.enctype = 'multipart/form-data';

                        var input = document.createElement('input');
                        input.type = 'file';
                        input.name = 'upload';
                        input.accept = data + '/*';

                        form.appendChild(input);

                        var input = document.createElement('input');
                        input.type = 'submit';
                        input.value = capitalizeFirstLetter(data) + ' hochladen';
                        input.addEventListener('click', function (event)
                        {
                            event.preventDefault();

                            var parent = event.target.parentElement;
                            var children = parent.childNodes;
                            var file = children[0].files;

                            if (file.length > 0)
                            {
                                parent.innerHTML = 'Uploading...';
                                (function ()
                                {
                                    console.log('in here');
                                    var formData = new FormData();
                                    formData.append('upload', file[0], file[0].name);
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', 'upload/test', true);
                                    xhr.onload = function () {
                                        if (xhr.status === 200) {
                                            // File uploaded.
                                            parent.innerHTML = 'Upload finished';
                                            console.log(this.responseText);
                                            (function(){
                                                
                                                
                                                
                                            })();
                                        } else {
                                            alert('An error occurred!');
                                        }
                                    };

                                    xhr.send(formData);
                                })();

                            } else
                            {

                                parent.style.border = '1px solid red';
                                setTimeout(function ()
                                {
                                    parent.style.border = 'none';
                                }, 500);
                            }



                            /*
                             var inhaltModul = JSON.parse(sessionStorage.getItem('inhaltModul'));
                             dragNdrop.sendPOST('modulAnlegen/sichereInhalt', inhaltModul, 'modulIDs');*/
                        });

                        form.appendChild(input);

                        element = form;
                        break;

                    case 'vorhandeneInhalte':
//todo
                        break;
                }

                this.elementNum++;
                element.className = 'inhalt';
                element.draggable = 'true';

                element.addEventListener('dragstart', function (event)
                {
                    dragNdrop.drag(event);
                });

                element.addEventListener('dragend', function (event)
                {
                    if (event.dataTransfer.dropEffect == 'none')
                    {
                        document.getElementById(event.target.id).remove();
                    }
                    dragNdrop.saveAllNodes();
                });

                return element;

                function capitalizeFirstLetter(string) {
                    return string.charAt(0).toUpperCase() + string.slice(1);
                }
            }

        };

function bereitsVorhanden(str, element) {
    if (str.length == 0) {
        element.style.outlineColor = ' rgb(77, 144, 254)';
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                if (!this.responseText)
                    element.style.outlineColor = 'red';
                else
                    element.style.outlineColor = ' rgb(77, 144, 254)';

                console.log(this.responseText);
            }
        };
        xmlhttp.open('POST', 'modulAnlegen/anfrage/' + str, true);
        xmlhttp.send();
    }
}

document.addEventListener('DOMContentLoaded', function () {
    dragNdrop.inhaltModulFuellen();
});

