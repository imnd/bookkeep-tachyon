/**
 * Компонент для работы с фактурами, счетами и договорами
 * 
 * @constructor
 * @this {prices}
 */
var prices = (function() {
    var
        self = this,
        entityName = '',
        pricesArr = [],

        calcPrice = function(row) {
            var
                sumElt = dom.find('.sum', row),
                sumInp = dom.find('input', sumElt),
                quantityElt = dom.find('.quantity', row),
                priceInp = dom.find('input', dom.find('.price', row)),
                sum,
                quantity
            ;
            if (sumInp.length==0) {
                // если это не форма а обычная таблица
                sum = dom.val(sumElt);
                quantity = dom.val(quantityElt);
            } else {
                sum = dom.val(sumInp);
                quantity = dom.val(dom.find('input', quantityElt));
            }
            if (sum!=='' && quantity!=='') {
                var price = sum / quantity;
                price = price.toFixed(2);
                dom.val(priceInp, price);
                return parseFloat(sum);
            } else {
                dom.val(priceInp, '');
            }
            return 0;
        },

        calcSum = function(row) {
            var priceElt = dom.find('.price', row);
            var priceInp = dom.find('input', priceElt);
            var quantityElt = dom.find('.quantity', row);
            // если это не форма а обычная таблица
            var price, quantity;
            if (priceInp.length==0) {
                price = dom.val(priceElt);
                quantity = dom.val(quantityElt);
            } else {
                price = dom.val(priceInp);
                quantity = dom.val(dom.find('input', quantityElt));
            }
            var sumInp = dom.find('input', dom.find('.sum', row));
            if (price!=='' && quantity!=='') {
                price = price.replace(',', '.') * 1;
                price = price.toFixed(2);
                var sum = price * quantity;
                // округляем до копеек
                dom.val(sumInp, sum.toFixed(2));
                return sum;
            } else {
                dom.val(sumInp, '');
            }
            return 0;
        },

        /**
         * обновляем цены
         */
        updatePriceInputs = function() {
            var selects = dom.findAll(".article select");
            for (var key=0; key<selects.length; key++) {
                this.updatePriceInput(selects[key]);
            }    
        }
    ;
    
    return {
        calcPrices : function() {
            var total = 0;
            var rows = dom.findAll('tr.row');
            for (var key=0; key<rows.length; key++) {
                var row = rows[key];
                total += calcPrice(row);
            }
            dom.val(dom.find('td.total'), total);
        },

        calcSums : function() {
            var total = 0;
            var rows = dom.findAll('tr.row');
            for (var key=0; key<rows.length; key++) {
                var row = rows[key];
                total += calcSum(row);
            }
            dom.val(dom.find('td.total'), total.toFixed(2));
        },

        updatePrices : function() {
            var contractNum = dom.val(dom.findByName(entityName + "[contract_num]"));
            if (contractNum==='') {
                this.fillPricesArray();
                return;
            }
            ajax.get(
                '/contracts/getItem/' + contractNum,
                function(data) {
                    var contract = data;
                    if (contract==false)
                        this.fillPricesArray();
                    else {
                        // заполняем массив цен
                        pricesArr = [];
                        var rows = contract['rows'];
                        for (var key=0; key<rows.length; key++) {
                            var row = rows[key];
                            pricesArr[row['article_id']] = row['price'];
                        }
                        // меняем цены
                        updatePriceInputs();
                        this.calcSums();
                        // меняем содержимое поля "клиент"
                        dom.val(dom.findByName(entityName + "[client_id]"), contract['client_id']);
                    }
                }
            );
        },

        updatePriceInput : function(select) {
            var articleId = dom.val(select);
            if (articleId==="")
                return;
            
            var row = select.parentNode.parentNode;
            var price = pricesArr[articleId];
            dom.val(dom.find(".price input", row), price);
        },

        fillPricesArray : function() {
            var defPrices = eval(dom.val(dom.find('#prices')));
            pricesArr = [];
            for (var key = 0; key < defPrices.length; key++) {
                var arr = defPrices[key];
                pricesArr[arr['id']] = arr['price'];
            }
        },

        setEntityName : function(str) {
            this.entityName = str;
        }
    };
}());
