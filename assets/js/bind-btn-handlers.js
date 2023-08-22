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
  dom(`.${className} input`)
    .each(elem => {
      elem.addEventListener('change', calcSums);
    })
};
const bindDelBtns = () => {
  dom('.delete-btn')
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

dom(() => {
  dom('#add')
    .click(() => {
      const row = dom().findLast('.row').get(),
        newRow = row.cloneNode(true);

      row.parentNode.insertBefore(newRow, row.nextSibling);
      const delBtn = dom(newRow).findByClass('delete-btn').get();
      // удаление строки
      bindDelParent(delBtn);
      clearRowInputs(newRow);
      bindInputHandlers();
    });

  fillPricesArray();
  bindInputHandlers();
});

export { bindInputsChange };