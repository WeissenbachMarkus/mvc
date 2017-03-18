<form class="col-9" action ="" method="POST">
    <fieldset>
        <legend> Modulanlegen </legend>
        <fieldset id="fieldsetName">
            <legend> Name </legend>
            <input id="title" type = "text" name = "title" placeholder = "Name" onkeyup="dragNdrop.checkIfTitelExists(this.value, this)">
            <fieldset id="inhaltFieldset">
                <legend>Inhalt</legend>
                <ul id="inhaltModul" 
                    ondrop="dragNdrop.drop(event, this)" ondragover="dragNdrop.allowDrop(event)">
                </ul>
            </fieldset>
        </fieldset>  
        <input id="submit" type="submit" value="Fertig">
    </fieldset>

</form>

<ul id="modulMenu" class=" col-3">
    <li id="text" draggable="true" ondragstart="dragNdrop.drag(event)">Text</li>
    <li id="audio" draggable="true" ondragstart="dragNdrop.drag(event)">Audio</li>
    <li id="video" draggable="true" ondragstart="dragNdrop.drag(event)">Video</li>
    <li id="image" draggable="true" ondragstart="dragNdrop.drag(event)">Bild</li>
    <li id="vorhandeneInhalte" draggable="true" ondragstart="dragNdrop.drag(event)">vorhandene Inhalte</li>
</ul>