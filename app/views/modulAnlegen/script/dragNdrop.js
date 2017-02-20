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

                var childrenIDundSRC = [];
                children.forEach(function (item, index) {
                    if (index > 0)
                    {
                        childrenIDundSRC.push(new RowKeySrc(item.id, item.src == undefined ? null : item.src));
                    }
                });

                sessionStorage.setItem('inhaltModul', JSON.stringify(childrenIDundSRC));

                function RowKeySrc(id, src)
                {
                    this.id = id;
                    this.src = src;
                }

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
                var inhaltModulIDsundSRCs = JSON.parse(sessionStorage.getItem('inhaltModul'))
                if (inhaltModulIDsundSRCs != null)
                {
                    inhaltModulIDsundSRCs.forEach(function (item) {
                        inhaltModul.appendChild(dragNdrop.inhaltModulElementErstellen(dragNdrop.filterID(item.id), item.src));
                    });
                }



            },
            filterID: function (id)
            {
                var inhalte = ['text', 'audio', 'video', 'image', 'vorhandeneInhalte', 'imgTAG'];
                var inhaltTyp;

                inhalte.forEach(function (item) {
                    if (id.includes(item))
                    {
                        inhaltTyp = item;
                    }
                });

                return inhaltTyp;
            },
            inhaltModulElementErstellen: function (data, src)
            {
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
                            var inhaltsTyp = dragNdrop.filterID(parent.id);

                            console.log(inhaltsTyp);
                            console.log(file);
                            if (file.length > 0)
                            {
                                parent.innerHTML = 'Uploading...';
                                (function ()
                                {

                                    var formData = new FormData();
                                    formData.append('upload', file[0], file[0].name);
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', 'upload/test/' + inhaltsTyp, true);
                                    xhr.onload = function () {
                                        if (xhr.status === 200) {

                                            parent.innerHTML = '';

                                            // responseText ist der Pfad zum Bild
                                            console.log(this.responseText);

                                            var element = dragNdrop.inhaltModulElementErstellen(idAnpassen(parent.id), this.responseText);
                                            parent.replaceWith(element);
                                            dragNdrop.saveAllNodes();

                                        } else {
                                            alert('An error occurred!');
                                        }
                                    };

                                    xhr.send(formData);

                                    function idAnpassen(id)
                                    {
console.log('here');
                                        id = dragNdrop.filterID(id);
                                        switch (id)
                                        {
                                            case'image':
                                                return 'imgTAG';
                                                break;
                                            case'audio':
                                                return 'audioTAG';
                                                break;
                                            case'video':
                                                return 'videoTAG';
                                                break;

                                        }
                                    }
                                }
                                )();
                            } else
                            {

                                parent.style.border = '1px solid red';
                                setTimeout(function ()
                                {
                                    parent.style.border = 'none';
                                }, 500);
                            }

                        });

                        form.appendChild(input);

                        element = form;
                        break;

                    case 'imgTAG':

                        var element = document.createElement('img');
                        element.src = src;
                        element.id = data + this.elementNum;
                        element.style.width = '100%';
                        break;

                    case'audioTAG':
                       
                        var element = document.createElement('audio');
                        element.controls = 'true';
                        element.style.width = '100%';
                        element.id = data + this.elementNum;
                        var source = document.createElement('source');
                        source.src = src;
                        element.appendChild(source);
                        break;

                    case'videoTAG':
                        
                         console.log('inhere');
                        var element = document.createElement('video');
                        element.controls = 'true';
                       
                        element.id = data + this.elementNum;
                        var source = document.createElement('source');
                        source.src = src;
                        element.appendChild(source);
                        
                        break;
                    case 'vorhandeneInhalte':
//todo
                        break;

                }

                this.elementNum++;
                element.className = 'inhalt';

                return makeElementDragAble(element);

                function makeElementDragAble(element)
                {
                    element.draggable = 'true';

                    element.addEventListener('dragstart', function (event)
                    {
                        dragNdrop.drag(event);
                    });

                    element.addEventListener('dragend', function (event)
                    {
                        if (event.dataTransfer.dropEffect == 'none')
                        {
                            event.target.remove();
                        }
                        dragNdrop.saveAllNodes();
                    });

                    return element;
                }
                
                //function 
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