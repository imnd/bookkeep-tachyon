import { bindDelParent, clearRowInputs } from './table';
import { updatePriceInput, calcSums, fillPricesArray } from './prices';
import dom from 'imnd-dom';

const bindArticleChange = () => {
  // при смене товара меняем цену
  dom()
    .findAll('.article select')
    .each(elem => {
      elem.addEventListener('change', () => {
        updatePriceInput(this);
        calcSums();
      });
    });
};
const bindInputsChange = function (className) {
  dom()
    .findAll(`.${className} input`)
    .each(elem => {
      elem.addEventListener('change', calcSums);
    })
};
const bindDelBtns = () => {
  dom()
    .findAllByClass('delete-btn')
    .each(elem => {
      bindDelParent(elem);
    });
};
const bindInputHandlers = () => {
  bindArticleChange();
  bindInputsChange('quantity');
  bindInputsChange('price');
  bindInputsChange('sum');
  bindDelBtns();
};

dom().ready(() => {
  dom()
    .findById('add')
    .click(() => {
      const row = dom().findLast('.row').get(),
        newRow = row.cloneNode(true);

      row.parentNode.insertBefore(newRow, row.nextSibling);
      const delBtn = dom().findByClass('delete-btn', newRow).get();
      // удаление строки
      bindDelParent(delBtn);
      clearRowInputs(newRow);
      bindInputHandlers();
    });
  fillPricesArray();
  bindInputHandlers();
});

export { bindInputsChange };