import { bindDelParent, clearRowInputs } from './table';
import { updatePriceInput, calcSums, fillPricesArray } from './prices';
import dom from 'imnd-dom';

const bindArticleChange = () => {
  // при смене товара меняем цену
  dom('.article select')
    .each(select => {
      dom(select).change(() => {
        updatePriceInput(this);
        calcSums();
      });
    });
};
const bindInputsChange = function (className) {
  dom(`.${className} input`)
    .each(input => dom(input).change(calcSums))
};

const bindInputHandlers = () => {
  bindArticleChange();
  bindInputsChange('quantity');
  bindInputsChange('price');
  bindInputsChange('sum');
  dom('.delete-btn').each(btn => bindDelParent(btn));
};

dom(() => {
  dom('#add')
    .click(() => {
      const
        row = dom().findLast('.row').get(),
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