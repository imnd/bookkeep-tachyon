const bindArticleChange = function() {
    // при смене товара меняем цену
    let articleSelects = dom.findAll(".article select");
    for (let key = 0; key < articleSelects.length; key++)
        articleSelects[key].addEventListener("change", function() {
            prices.updatePriceInput(this);
            prices.calcSums();
        });
};
const bindInpsChange = function(className) {
    let inps = dom.findAll("." + className + " input");
    for (let key = 0; key<inps.length; key++)
        inps[key].addEventListener("change", prices.calcSums);
};
const bindDelBtns = function() {
    let delBtns = dom.findAllByClass("delete-btn");
    for (let key = 0; key<delBtns.length; key++) {
        bindDelParent(delBtns[key]);
    }
};
const bindInputHandlers = function() {
    bindArticleChange();
    bindInpsChange('quantity');
    bindInpsChange('price');
    bindInpsChange('sum');
    bindDelBtns();
};

import dom from './dom.js';
import prices from './prices.js';
import {bindDelParent, clearRowInputs} from './table.js';

dom.ready(function() {
    dom.findById("add").addEventListener("click", function() {
        const row = dom.findLast(".row");
        const newRow = row.cloneNode(true);
        let parent = row.parentNode;
        parent.insertBefore(newRow, row.nextSibling);
        const delBtn = dom.findByClass("delete-btn", newRow);
        // удаление строки
        bindDelParent(delBtn);
        clearRowInputs(newRow);
        bindInputHandlers();
    });
    prices.fillPricesArray();
    bindInputHandlers();
});
