export let
    // удаление строки
    bindDelParent = delBtn => {
        delBtn.addEventListener("click", function () {
            this.parentNode.remove();
        });
    },
    // очистка инпутов новой строки
    clearRowInputs = row => {
        const tds = dom.findAll('td', row);
        for (let key in tds) {
            const td = tds[key];
            const tdChildren = td.childNodes;
            for (let tdKey in tdChildren) {
                dom.clear(tdChildren[tdKey]);
            }
        }
    };
