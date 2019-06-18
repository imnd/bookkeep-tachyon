// удаление строки
function bindDelParent(delBtn) {
    delBtn.addEventListener("click", function() {
        this.parentNode.remove();
    });
}
// очистка инпутов новой строки
function clearRowInputs(row) {
    let tds = dom.findAll('td', row);
    for (let key in tds) {
        if (!tds.hasOwnProperty(key))
            continue;

        let td = tds[key];
        let tdChildren = td.childNodes;
        for (let tdKey in tdChildren)
            dom.clear(tdChildren[tdKey]);
    }
}
