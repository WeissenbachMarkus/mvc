
var dragNdrop = {
    element: null,
    drag: function (element) {

        this.element = element;
        console.log(this.element);
    },
    drop: function (container)
    {
        alert('here');
        container.appendChild(this.element);
    }
    , allowDrop: function (ev) {
      ev.preventdefault()
    }
};