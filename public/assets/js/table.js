// удаление строки
function bindDelParent(delBtn) {
    delBtn.addEventListener("click", function() {
        this.parentNode.remove();
    });
}
// очистка инпутов новой строки
function clearRowInputs(row) {
    var tds = dom.findAll('td', row);
    for (var key in tds) {
        var td = tds[key];
        var tdChildren = td.childNodes;
        for (var tdKey in tdChildren)
            dom.clear(tdChildren[tdKey]);
    }
}
