var contractTypes =
        {
            wysiwyg: 'text',
            audioWithoutContent: 'audio',
            videoWithoutContent: 'video',
            imageWithoutContent: 'image',
            audioWithContent: 'audTAG',
            videoWithContent: 'vidTAG',
            imageWithContent: 'imgTAG'

        };
var otherConstants =
        {
            wysiwygRefBaseID: 'ta',
        };

var dragNdrop =
        {
            titleExists: false,
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
                } else
                    var element = document.getElementById(data);
                try
                {
                    parent.appendChild(element);
                } catch (ex)
                {
                    console.log(ex.message);
                }

                dragNdrop.saveAllNodes();

                //verwendete IDs im HTML
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
                var children = inhaltModul.children;
                var childrenIDundSRC = [];

                for (var i = 0; i < children.length; i++)
                {
                    var source = dragNdrop.getSrcOfElement(children[i]);
                    childrenIDundSRC.push(new RowKeySrc(children[i].id, source == undefined ? null : source));
                }

                sessionStorage.setItem('inhaltModul', JSON.stringify(childrenIDundSRC));

//Holen von Inhalten von wysiwyg Editoren und deren Speicherung
                var dataFromWysiwyg = [];
                var wysiwygRefIDs = this.getWysiwygRefIDs();
                for (var i = 0; i < dragNdrop.getWysiwygCount(); i++)
                {
                    var data = CKEDITOR.instances[wysiwygRefIDs[i]].getData()

                    if (data.length > 0)
                        dataFromWysiwyg.push(data);

                }

                sessionStorage.setItem('inhaltTextArea', JSON.stringify(dataFromWysiwyg));

//Verbunddatentyp zur Speicherung von Inhalten des Moduls
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
                        inhaltModul.appendChild(dragNdrop.inhaltModulElementErstellen(dragNdrop.filterIDgetTyp(item.id), item.src));
                    });
                }

            },
            filterIDgetTyp: function (id)
            {
                var inhaltTyp;
                for (type in contractTypes) {
                    if (id.includes(contractTypes[type]))
                    {
                        inhaltTyp = contractTypes[type];
                    }
                }
                return inhaltTyp;
            },
            inhaltModulElementErstellen: function (type, src)
            {
                var element = null;

                switch (type)
                {
                    case contractTypes.wysiwyg:

                        element = document.createElement('div');
                        element.id = type + this.elementNum;

                        var textarea = document.createElement('textarea');
                        textarea.style.width = '100%';
                        textarea.id = otherConstants.wysiwygRefBaseID + this.elementNum;

//wysiwyg inhalt
                        var inhaltTextArea = JSON.parse(sessionStorage.getItem('inhaltTextArea'));
                        var wysiwygCount = dragNdrop.getWysiwygCount();

                        if (inhaltTextArea !== null &&
                                inhaltTextArea.length > wysiwygCount)
                        {
                            textarea.innerHTML = inhaltTextArea[wysiwygCount];
                        }

                        var ckeditor = document.createElement('script');
                        ckeditor.innerHTML = ' CKEDITOR.replace(' + textarea.id + ');';

                        element.appendChild(textarea);
                        element.appendChild(ckeditor);

                        break;
                    case contractTypes.audioWithoutContent:

                    case contractTypes.videoWithoutContent:

                    case contractTypes.imageWithoutContent:

                        var form = document.createElement('form');
                        form.id = type + 'Upload' + this.elementNum;
                        form.action = 'upload/verarbeitung/' + type;
                        form.method = 'post';
                        form.enctype = 'multipart/form-data';

                        var input = document.createElement('input');
                        input.type = 'file';
                        input.name = 'upload';
                        input.accept = type + '/*';
                        form.appendChild(input);

                        var input = document.createElement('input');
                        input.type = 'submit';
                        input.value = capitalizeFirstLetter(type) + ' hochladen';
                        input.addEventListener('click', function (event)
                        {
                            event.preventDefault();
                            var parent = event.target.parentElement;
                            var children = parent.children;
                            var file = children[0].files;
                            var inhaltsTyp = dragNdrop.filterIDgetTyp(parent.id);

                            if (file.length > 0)
                            {
                                parent.innerHTML = 'Uploading...';
                                (function ()
                                {
                                    var formData = new FormData();
                                    var nameWitoutSpaces = file[0].name.replace(/\s+/g, '');
                                    console.log(nameWitoutSpaces);
                                    formData.append('upload', file[0], nameWitoutSpaces);
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', 'modulAnlegen/upload/' + inhaltsTyp, true);
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
                                        id = dragNdrop.filterIDgetTyp(id);
                                        switch (id)
                                        {
                                            case contractTypes.imageWithoutContent:
                                                return contractTypes.imageWithContent;
                                                break;
                                            case contractTypes.audioWithoutContent:
                                                return contractTypes.audioWithContent;
                                                break;
                                            case contractTypes.videoWithoutContent:
                                                return contractTypes.videoWithContent;
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
                    case contractTypes.imageWithContent:

                        var element = document.createElement('img');
                        element.src = src;
                        element.id = type + this.elementNum;
                        element.style.width = '100%';
                        break;
                    case contractTypes.audioWithContent:

                        var element = document.createElement('audio');
                        element.controls = 'true';
                        element.style.width = '100%';
                        element.id = type + this.elementNum;
                        var source = document.createElement('source');
                        source.src = src;
                        element.appendChild(source);
                        break;
                    case contractTypes.videoWithContent:

                        var element = document.createElement('video');
                        element.controls = 'true';
                        element.style.width = '100%';
                        element.id = type + this.elementNum;
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
                            var src = dragNdrop.getSrcOfElement(event.target);

                            if (!dragNdrop.isBeeingUsed(src))
                                dragNdrop.deleteContent(src);
                        }

                        dragNdrop.saveAllNodes();

                    });

                    return element;
                }

                //function 
                function capitalizeFirstLetter(string) {
                    return string.charAt(0).toUpperCase() + string.slice(1);
                }

            },
            getWysiwygCount: function ()
            {
                var children = document.getElementById('inhaltModul').children;
                var count = 0;
                for (var i = 1; i < children.length; i++)
                {
                    var id = children[i]['id'];
                    if (id.includes(contractTypes.wysiwyg))
                        count++;
                }
                return count;

            }, getWysiwygRefIDs: function ()
            {
                var children = document.getElementById('inhaltModul').children;
                var wysiwygRefIDs = [];
                for (var i = 1; i < children.length; i++)
                {
                    var id = children[i]['id'];
                    if (id.includes(contractTypes.wysiwyg))
                    {
                        var wysiwygRef = document.getElementById(id).children;
                        wysiwygRefIDs.push(wysiwygRef[0]['id']);
                    }
                }
                return wysiwygRefIDs;
            },
            deleteContent: function (src) {

                formData = new FormData();
                formData.append('src', src);

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        console.log(this.responseText);
                    }
                };
                xmlhttp.open('POST', 'modulAnlegen/deleteContent', true);
                xmlhttp.send(formData);
            }
            ,
            getSrcOfElement: function (element)
            {
                var type = dragNdrop.filterIDgetTyp(element.id);
                if (type == contractTypes.imageWithContent)
                    return element.src;
                else
                    return element.children[0].src;
            },
            isBeeingUsed: function (src)
            {
                var parent = document.getElementById('inhaltModul');
                var children = parent.children;

                for (var i = 0; i < children.length; i++)
                {
                    if (dragNdrop.getSrcOfElement(children[i]) == src)
                        return true;
                }
                return false;
            },
            checkIfTitelExists: function (str, element) {
                if (str.length == 0) {
                    element.style.outlineColor = ' rgb(77, 144, 254)';
                    return;
                } else {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {

                            if (!this.responseText)
                            {
                                element.style.outlineColor = 'red';
                                dragNdrop.titleExists = true;
                            } else
                            {
                                element.style.outlineColor = ' rgb(77, 144, 254)';
                                dragNdrop.titleExists = false;
                            }

                        }
                    };
                    xmlhttp.open('POST', 'modulAnlegen/anfrage/' + str, true);
                    xmlhttp.send();
                }
            }
            ,
            submit: function ()
            {
                this.saveAllNodes();


                if (dragNdrop.titleExists)
                {
                    this.setMessage('Titel existiert bereits!');
                    return false;
                }

                var modulTitle = document.getElementById('title').value;

                if (modulTitle.length == 0)
                {
                    this.setMessage('Ein Titel muss eingegeben werden!');
                    var fieldsetName = document.getElementById('fieldsetName')
                    fieldsetName.style.border = '1px solid red';
                    setTimeout(function ()
                    {
                        fieldsetName.style.border = '1px solid black';
                    }, 500);

                    return false;
                }

                var data = new FormData();
                var wysiwygContent = JSON.parse(sessionStorage.getItem('inhaltTextArea'));

                data.append('wysiwygContent', wysiwygContent);
                data.append('title', modulTitle);
                data.append('positions', this.getPositions());

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        var response = this.responseText
                        console.log(response);
                        if (response == 1)
                        {
                            dragNdrop.clearModul();
                            dragNdrop.setMessage('Modul wurde gespeichert!');
                        }
                        else
                        {
                            console.log(response);
                            dragNdrop.setMessage('Modul konnte nicht gespeichert werden!');
                        }
                    }
                };
                xmlhttp.open('POST', 'modulAnlegen/submit', true);
                xmlhttp.send(data);



            },
            setMessage: function (message)
            {
                var error = document.getElementById('error');
                error.innerHTML = message;
                setTimeout(function ()
                {
                    error.innerHTML = '';
                }, 1000);
            },
            getPositions: function ()
            {
                var children = document.getElementById('inhaltModul').children;

                var typesAndSrcs = [];
                for (var i = 0; i < children.length; i++)
                {

                    typesAndSrcs.push(
                            [
                                this.filterIDgetTyp(children[i].id),
                                this.getSrcOfElement(children[i])
                            ]
                            );
                }

                return typesAndSrcs;

            },
            clearModul: function ()
            {
                var content = document.getElementById('inhaltModul');
                content.innerHTML = '';
            }

        };

document.getElementById('submit').addEventListener('click', function (event) {
    event.preventDefault();
    dragNdrop.submit();
});

document.addEventListener('DOMContentLoaded', function () {
    dragNdrop.inhaltModulFuellen();
});

