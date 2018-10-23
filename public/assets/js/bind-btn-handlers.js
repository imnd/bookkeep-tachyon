var bindArticleChange = function() {
    // при смене товара меняем цену
    var articleSelects = dom.findAll(".article select");
    for (var key=0; key<articleSelects.length; key++)
        articleSelects[key].addEventListener("change", function() {
            prices.updatePriceInput(this);
            prices.calcSums();
        });
};
var bindInpsChange = function(className) {
    var inps = dom.findAll("." + className + " input");
    for (var key=0; key<inps.length; key++)
        inps[key].addEventListener("change", prices.calcSums);
};
var bindDelBtns = function() {
    var delBtns = dom.findAllByClass("delete-btn");
    for (var key=0; key<delBtns.length; key++)
        bindDelParent(delBtns[key]);
};
var bindInputHandlers = function() {
    bindArticleChange();
    bindInpsChange('quantity');
    bindInpsChange('price');
    bindInpsChange('sum');
    bindDelBtns();
};
dom.ready(function() {
    dom.findById("add").addEventListener("click", function() {
        var row = dom.findLast(".row");
        var newRow = row.cloneNode(true);
        var parent = row.parentNode;
        parent.insertBefore(newRow, row.nextSibling);
        var delBtn = dom.findByClass("delete-btn", newRow);
        // удаление строки
        bindDelParent(delBtn);
        clearRowInputs(newRow);
        bindInputHandlers();
    });
    prices.fillPricesArray();
    bindInputHandlers();
});
