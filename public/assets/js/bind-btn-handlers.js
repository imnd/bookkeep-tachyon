let bindArticleChange = function() {
    // при смене товара меняем цену
    let articleSelects = dom.findAll(".article select");
    for (let key=0; key<articleSelects.length; key++)
        articleSelects[key].addEventListener("change", function() {
            prices.updatePriceInput(this);
            prices.calcSums();
        });
};
let bindInpsChange = function(className) {
    let inps = dom.findAll("." + className + " input");
    for (let key=0; key<inps.length; key++)
        inps[key].addEventListener("change", prices.calcSums);
};
let bindDelBtns = function() {
    let delBtns = dom.findAllByClass("delete-btn");
    for (let key=0; key<delBtns.length; key++)
        bindDelParent(delBtns[key]);
};
let bindInputHandlers = function() {
    bindArticleChange();
    bindInpsChange('quantity');
    bindInpsChange('price');
    bindInpsChange('sum');
    bindDelBtns();
};
dom.ready(function() {
    dom.findById("add").addEventListener("click", function() {
        let row = dom.findLast(".row");
        let newRow = row.cloneNode(true);
        let parent = row.parentNode;
        parent.insertBefore(newRow, row.nextSibling);
        let delBtn = dom.findByClass("delete-btn", newRow);
        // удаление строки
        bindDelParent(delBtn);
        clearRowInputs(newRow);
        bindInputHandlers();
    });
    prices.fillPricesArray();
    bindInputHandlers();
});
