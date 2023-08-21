/**
 * Компонент для работы с фактурами, счетами и договорами
 */

import dom from "imnd-dom";
import ajax from "imnd-ajax";

let
  entityName = '',
  pricesArr = [],

  calcSum = row => {
    const priceInp = dom(row)
      .child(".price")
      .child("input");
    // если это не форма, а обычная таблица
    let
      price,
      quantity;

    if (priceInp.length === 0) {
      price = dom(row).child(".price").val();
      quantity = dom(row).child(".quantity").val();
    } else {
      price = priceInp.val();
      quantity = dom(row)
        .child(".quantity")
        .child("input")
        .val();
    }
    const sumInp = dom(row).child(".sum").child("input");
    if (price !== '' && quantity !== '') {
      price = price.replace(",", ".") * 1;
      price = price.toFixed(2);
      const sum = price * quantity;
      // округляем до копеек
      sumInp.val(sum.toFixed(2));
      return sum;
    } else {
      sumInp.val('');
    }
    return 0;
  },

  calcSums = () => {
    let total = 0;
    dom()
      .findAll("tr.row")
      .each(row => {
        total += calcSum(row);
      });
    dom()
      .find("td.total")
      .val(total.toFixed(2));
  },

  updatePriceInput = select => {
    const articleId = dom(select).val();
    if (articleId === '') {
      return;
    }

    const
      row = dom(select).parent().parent(),
      price = pricesArr[articleId];

    row.child(".price input").val(price);
  },

  /**
   * обновляем цены
   */
  updatePriceInputs = () => {
    dom()
      .findAll(".article select")
      .each((elem) => {
        updatePriceInput(elem);
      });
  },

  fillPricesArray = () => {
    const defPrices = eval(dom().find("#prices").val());
    pricesArr = [];
    for (let key = 0; key < defPrices.length; key++) {
      const arr = defPrices[key];
      pricesArr[arr["id"]] = arr["price"];
    }
  },

  updatePrices = () => {
    const contractNum = dom()
      .findByName(`${entityName}[contract_num]`)
      .val();

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
          const rows = contract["rows"];
          for (let key = 0; key < rows.length; key++) {
            const row = rows[key];
            pricesArr[row["article_id"]] = row["price"];
          }
          // меняем цены
          updatePriceInputs();
          calcSums();
          // меняем содержимое поля "клиент"
          dom().findByName(`${entityName}[client_id]`).val(contract["client_id"]);
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
  updatePrices,
  setEntityName
};

