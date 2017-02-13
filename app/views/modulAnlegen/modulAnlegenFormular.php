<form class="col-9" action ="" method="POST">
    <fieldset>
        <legend> Modulanlegen </legend>
        <fieldset>
            <legend> Name </legend>
            <input type = "text" name = "name" placeholder = "Name">
            <fieldset>
                <legend>Inhalt</legend>
                <div id="inhaltModul" ondrop="dragNdrop.drop(this)" ondragover="dragNdrop.allowDrop(this)">
                </div>
            </fieldset>
        </fieldset>  
    </fieldset>
</form>

<div class="col-3 Modulmenu">
    <ul>
        <li id="text" draggable="true"  ondragstart="dragNdrop.drag(this)">Text</li>
        <li id="audio" draggable="true" ondragstart="drag(this)">Audio</li>
        <li id="video" draggable="true" ondragstart="drag(this)">Video</li>
         <li id="bild" draggable="true" ondragstart="drag(this)">Bild</li>
    </ul>
</div>