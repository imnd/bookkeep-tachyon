import { ready, findById, findLast, findAll, findByClass, findAllByClass } from 'imnd-dom';
import { bindDelParent, clearRowInputs } from "./table";
import { updatePriceInput, calcSums, fillPricesArray } from "./prices";

const bindArticleChange = () => {
    // при смене товара меняем цену
    let articleSelects = findAll(".article select");
    for (let key = 0; key < articleSelects.length; key++)
        articleSelects[key].addEventListener("change", () => {
            updatePriceInput(this);
            calcSums();
        });
};
const bindInputsChange = function(className) {
    let inputs = findAll("." + className + " input");
    for (let key = 0; key<inputs.length; key++)
        inputs[key].addEventListener("change", calcSums);
};
const bindDelBtns = () => {
    let delBtns = findAllByClass("delete-btn");
    for (let key = 0; key<delBtns.length; key++) {
      bindDelParent(delBtns[key]);
    }
};
const bindInputHandlers = () => {
    bindArticleChange();
    bindInputsChange("quantity");
    bindInputsChange("price");
    bindInputsChange("sum");
    bindDelBtns();
};

ready(() => {
    findById("add").addEventListener("click", () => {
        const row = findLast(".row"),
              newRow = row.cloneNode(true),
              parent = row.parentNode;

        parent.insertBefore(newRow, row.nextSibling);
        const delBtn = findByClass("delete-btn", newRow);
        // удаление строки
        bindDelParent(delBtn);
        clearRowInputs(newRow);
        bindInputHandlers();
    });
    fillPricesArray();
    bindInputHandlers();
});

export { bindInputsChange };