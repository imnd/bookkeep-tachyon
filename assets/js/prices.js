/**
 * Компонент для работы с фактурами, счетами и договорами
 *
 * @constructor
 * @this {prices}
 */

import { find, val } from 'imnd-dom';
import ajax from 'imnd-ajax';

let
  entityName = '',
  pricesArr = [],

  calcPrice = row => {
    const
      sumElt = find('.sum', row),
      sumInp = find('input', sumElt),
      quantityElt = find('.quantity', row);
    let
      sum,
      quantity;
    if (sumInp.length === 0) {
      // если это не форма, а обычная таблица
      sum = val(sumElt);
      quantity = val(quantityElt);
    } else {
      sum = val(sumInp);
      quantity = val(find('input', quantityElt));
    }
    const priceInp = find('input', find('.price', row));
    if (sum !== '' && quantity !== '') {
      let price = sum / quantity;
      price = price.toFixed(2);
      val(priceInp, price);
      return parseFloat(sum);
    } else {
      val(priceInp, '');
    }
    return 0;
  },

  calcSum = row => {
    const priceElt = find('.price', row),
      priceInp = find('input', priceElt),
      quantityElt = find('.quantity', row);
    // если это не форма а обычная таблица
    let price,
      quantity;
    if (priceInp.length === 0) {
      price = val(priceElt);
      quantity = val(quantityElt);
    } else {
      price = val(priceInp);
      quantity = val(find('input', quantityElt));
    }
    const sumInp = find('input', find('.sum', row));
    if (price !== '' && quantity !== '') {
      price = price.replace(',', '.') * 1;
      price = price.toFixed(2);
      const sum = price * quantity;
      // округляем до копеек
      val(sumInp, sum.toFixed(2));
      return sum;
    } else {
      val(sumInp, '');
    }
    return 0;
  },

  updatePriceInput = select => {
    const articleId = val(select);
    if (articleId === '')
      return;

    const row = select.parentNode.parentNode,
      price = pricesArr[articleId];

    val(find('.price input', row), price);
  },

  /**
   * обновляем цены
   */
  updatePriceInputs = () => {
    const selects = findAll('.article select');
    for (let key = 0; key < selects.length; key++) {
      updatePriceInput(selects[key]);
    }
  },

  fillPricesArray = () => {
    const defPrices = eval(val(find('#prices')));
    pricesArr = [];
    for (let key = 0; key < defPrices.length; key++) {
      const arr = defPrices[key];
      pricesArr[arr['id']] = arr['price'];
    }
  },

  calcSums = () => {
    let total = 0,
      rows = findAll('tr.row');
    for (let key = 0; key < rows.length; key++) {
      total += calcSum(rows[key]);
    }
    val(find('td.total'), total.toFixed(2));
  },

  calcPrices = () => {
  let total = 0;
  const rows = findAll('tr.row');
  for (let key = 0; key < rows.length; key++) {
    total += calcPrice(rows[key]);
  }
  val(find('td.total'), total.toFixed(2));
},
  updatePrices = () => {
  const contractNum = val(findByName(`${entityName}[contract_num]`));
  if (contractNum === '') {
    fillPricesArray();
    return;
  }
  ajax.get(
    `/contracts/getItem/${contractNum}`,
    data => {
      const contract = data;
      if (contract === false) {
        fillPricesArray();
      } else {
        // заполняем массив цен
        pricesArr = [];
        const rows = contract['rows'];
        for (let key = 0; key < rows.length; key++) {
          const row = rows[key];
          pricesArr[row['article_id']] = row['price'];
        }
        // меняем цены
        updatePriceInputs();
        calcSums();
        // меняем содержимое поля "клиент"
        val(findByName(`${entityName}[client_id]`), contract['client_id']);
      }
    }
  );
},
  setEntityName = str => entityName = str
;

export {
  calcSums,
  updatePriceInput,
  fillPricesArray,
  calcPrices,
  updatePrices,
  setEntityName
};

