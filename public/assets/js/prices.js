var prices = (function() {
    return {
        pricesArr : [],

        calcPrice : function(row) {
            var sumElt = dom.find('.sum', row);
            var sumInp = dom.find('input', sumElt);
            var quantityElt = dom.find('.quantity', row);
            if (sumInp.length==0) {
                // если это не форма а обычная таблица
                var sum = dom.val(sumElt);
                var quantity = dom.val(quantityElt);
            } else {
                var sum = dom.val(sumInp);
                var quantity = dom.val(dom.find('input', quantityElt));
            }
            var priceInp = dom.find('input', dom.find('.price', row));
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

        calcPrices : function() {
            var total = 0;
            var rows = dom.findAll('tr.row');
            for (var key=0; key<rows.length; key++) {
                var row = rows[key];
                total += prices.calcPrice(row);
            }
            dom.val(dom.find('td.total'), total);
        },

        calcSum : function(row) {
            var priceElt = dom.find('.price', row);
            var priceInp = dom.find('input', priceElt);
            var quantityElt = dom.find('.quantity', row);
            var sumInp = dom.find('input', dom.find('.sum', row));
            // если это не форма а обычная таблица
            if (priceInp.length==0) {
                var price = dom.val(priceElt);
                var quantity = dom.val(quantityElt);
            } else {
                var price = dom.val(priceInp);
                var quantity = dom.val(dom.find('input', quantityElt));
            }
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

        calcSums : function() {
            var total = 0;
            var rows = dom.findAll('tr.row');
            for (var key=0; key<rows.length; key++) {
                var row = rows[key];
                total += prices.calcSum(row);
            }
            dom.val(dom.find('td.total'), total.toFixed(2));
        },

        updatePrices : function() {
            var contractNum = dom.val(dom.findByName(prices.modelName + "[contract_num]"));
            if (contractNum==='') {
                prices.fillPricesArray();
                return;
            }
            ajax.get(
                '/contracts/getItem/' + contractNum,
                function(data) {
                    var contract = data;
                    if (contract==false)
                        prices.fillPricesArray();
                    else {
                        // заполняем массив цен
                        prices.pricesArr = [];
                        var rows = contract['rows'];
                        for (var key=0; key<rows.length; key++) {
                            var row = rows[key];
                            prices.pricesArr[row['article_id']] = row['price'];
                        }
                        // меняем цены
                        prices.updatePriceInputs();
                        prices.calcSums();
                        // меняем содержимое поля "клиент"
                        dom.val(dom.findByName(prices.modelName + "[client_id]"), contract['client_id']);
                    }
                }
            );
        },

        /**
         * обновляем цены
         */
        updatePriceInputs : function() {
            var selects = dom.findAll(".article select");
            for (var key=0; key<selects.length; key++)
                prices.updatePriceInput(selects[key]);        
        },

        updatePriceInput : function(select) {
            var articleId = dom.val(select);
            if (articleId==="")
                return;
            
            var row = select.parentNode.parentNode;
            var price = prices.pricesArr[articleId];
            dom.val(dom.find(".price input", row), price);
        },

        fillPricesArray : function(sel) {
            var defPrices = eval(dom.val(dom.find('#prices')));
            prices.pricesArr = [];
            for (var key=0; key<defPrices.length; key++) {
                var arr = defPrices[key];
                prices.pricesArr[arr['id']] = arr['price'];
            }
        },

        modelName : '',
        setModelName : function(modelName) {
            prices.modelName = modelName;
        }
    };

}());

var bindArticleChange = function() {
    // при смене товара меняем цену
    var articleSelects = dom.findAll(".article select");
    for (var key=0; key<articleSelects.length; key++)
        articleSelects[key].addEventListener("change", function() {
            prices.updatePriceInput(this);
            prices.calcSums();
        });
};
var bindInpsChange = function(className) {
    var inps = dom.findAll("." + className + " input");
    for (var key=0; key<inps.length; key++)
        inps[key].addEventListener("change", prices.calcSums);
};
var bindDelBtns = function() {
    var delBtns = dom.findAllByClass("delete-btn");
    for (var key=0; key<delBtns.length; key++)
        bindDelParent(delBtns[key]);
};
