/**
 * Компонент для работы с фактурами, счетами и договорами
 */

import dom from "imnd-dom";
import ajax from "imnd-ajax";

let
  entityName = '',
  pricesArr = [],

  calcPrice = row => {
    const sumInp = dom.find(".sum", row).child("input");
    let
      sum,
      quantity;

    if (sumInp.get()) {
      // если это не форма, а обычная таблица
      sum = dom.find(".sum", row).val();
      quantity = dom.find(".quantity", row).val();
    } else {
      sum = sumInp.val();
      quantity = dom.find(".quantity", row).child("input").val();
    }
    const priceInp = dom.find(".price", row).child("input");
    if (sum !== '' && quantity !== '') {
      let price = sum / quantity;
      price = price.toFixed(2);
      priceInp.val(price);
      return parseFloat(sum);
    } else {
      priceInp.val('');
    }
    return 0;
  },

  calcSum = row => {
    const priceInp = dom.find(".price", row).child("input");
    // если это не форма, а обычная таблица
    let
      price,
      quantity;

    if (priceInp.length === 0) {
      price = dom.find(".price", row).val();
      quantity = dom.find(".quantity", row).val();
    } else {
      price = priceInp.val();
      quantity = dom.find(".quantity", row).child("input").val();
    }
    const sumInp = dom.find(".sum", row).child("input");
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

  updatePriceInput = select => {
    const articleId = dom.set(select).val();
    if (articleId === '') {
      return;
    }

    const row = dom.set(select).parent().parent(),
      price = pricesArr[articleId];

    row.child(".price input").val(price);
  },

  /**
   * обновляем цены
   */
  updatePriceInputs = () => {
    dom.findAll(".article select").each((elem) => {
      updatePriceInput(elem);
    });
  },

  fillPricesArray = () => {
    const defPrices = eval(dom.find("#prices").val());
    pricesArr = [];
    for (let key = 0; key < defPrices.length; key++) {
      const arr = defPrices[key];
      pricesArr[arr["id"]] = arr["price"];
    }
  },

  calcSums = () => {
    let total = 0;
    dom.findAll("tr.row").each((elem) => {
      total += calcSum(elem);
    });
    dom
      .find("td.total")
      .val(total.toFixed(2));
  },

  calcPrices = () => {
    let total = 0;
    dom.findAll("tr.row").each((elem) => {
      total += calcPrice(elem);
    });
    dom
      .find("td.total")
      .val(total.toFixed(2));
  },
  updatePrices = () => {
    const contractNum = dom
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
          dom.findByName(`${entityName}[client_id]`).val(contract["client_id"]);
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

