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
