/**
 * Компонент для работы с фактурами, счетами и договорами
 *
 * @constructor
 * @this {prices}
 */
let prices = (function() {
    let
        entityName = '',
        pricesArr = [],

        calcPrice = row => {
            let
                sumElt = dom.find('.sum', row),
                sumInp = dom.find('input', sumElt),
                quantityElt = dom.find('.quantity', row),
                sum,
                quantity
            ;
            if (sumInp.length===0) {
                // если это не форма а обычная таблица
                sum = dom.val(sumElt);
                quantity = dom.val(quantityElt);
            } else {
                sum = dom.val(sumInp);
                quantity = dom.val(dom.find('input', quantityElt));
            }
            let priceInp = dom.find('input', dom.find('.price', row));
            if (sum!=='' && quantity!=='') {
                let price = sum / quantity;
                price = price.toFixed(2);
                dom.val(priceInp, price);
                return parseFloat(sum);
            } else {
                dom.val(priceInp, '');
            }
            return 0;
        },

        calcSum = row => {
            let priceElt = dom.find('.price', row),
                priceInp = dom.find('input', priceElt),
                quantityElt = dom.find('.quantity', row),
                // если это не форма а обычная таблица
                price,
                quantity;
            if (priceInp.length===0) {
                price = dom.val(priceElt);
                quantity = dom.val(quantityElt);
            } else {
                price = dom.val(priceInp);
                quantity = dom.val(dom.find('input', quantityElt));
            }
            let sumInp = dom.find('input', dom.find('.sum', row));
            if (price!=='' && quantity!=='') {
                price = price.replace(',', '.') * 1;
                price = price.toFixed(2);
                let sum = price * quantity;
                // округляем до копеек
                dom.val(sumInp, sum.toFixed(2));
                return sum;
            } else {
                dom.val(sumInp, '');
            }
            return 0;
        },

        updatePriceInput = select => {
            let articleId = dom.val(select);
            if (articleId==='')
                return;

            let row = select.parentNode.parentNode,
                price = pricesArr[articleId];

            dom.val(dom.find('.price input', row), price);
        },

        /**
         * обновляем цены
         */
        updatePriceInputs = () => {
            let selects = dom.findAll('.article select');
            for (let key=0; key<selects.length; key++) {
                updatePriceInput(selects[key]);
            }
        }
    ;

    return {
        calcPrices : () => {
            let total = 0,
                rows = dom.findAll('tr.row');
            for (let key=0; key < rows.length; key++) {
                total += calcPrice(rows[key]);
            }
            dom.val(dom.find('td.total'), total.toFixed(2));
        },

        calcSums : () => {
            let total = 0,
                rows = dom.findAll('tr.row');
            for (let key=0; key<rows.length; key++) {
                total += calcSum(rows[key]);
            }
            dom.val(dom.find('td.total'), total.toFixed(2));
        },

        updatePriceInput : updatePriceInput,

        updatePrices : () => {
            let contractNum = dom.val(dom.findByName(`${entityName}[contract_num]`));
            if (contractNum==='') {
                this.fillPricesArray();
                return;
            }
            ajax.get(
                `/contracts/getItem/${contractNum}`,
                data => {
                    let contract = data;
                    if (contract===false)
                        this.fillPricesArray();
                    else {
                        // заполняем массив цен
                        pricesArr = [];
                        let rows = contract['rows'];
                        for (let key=0; key<rows.length; key++) {
                            let row = rows[key];
                            pricesArr[row['article_id']] = row['price'];
                        }
                        // меняем цены
                        updatePriceInputs();
                        this.calcSums();
                        // меняем содержимое поля "клиент"
                        dom.val(dom.findByName(`${entityName}[client_id]`), contract['client_id']);
                    }
                }
            );
        },

        fillPricesArray : () => {
            let defPrices = eval(dom.val(dom.find('#prices')));
            pricesArr = [];
            for (let key = 0; key < defPrices.length; key++) {
                let arr = defPrices[key];
                pricesArr[arr['id']] = arr['price'];
            }
        },

        setEntityName : str => entityName = str
    };
}());
