var prices = (function() {
    var
        self = this,
        modelName = '',
        pricesArr = []
    ;
    
    return {
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
                total += self.calcPrice(row);
            }
            dom.val(dom.find('td.total'), total);
        },

        calcSum : function(row) {
            var priceElt = dom.find('.price', row);
            var priceInp = dom.find('input', priceElt);
            var quantityElt = dom.find('.quantity', row);
            // если это не форма а обычная таблица
            if (priceInp.length==0) {
                var price = dom.val(priceElt);
                var quantity = dom.val(quantityElt);
            } else {
                var price = dom.val(priceInp);
                var quantity = dom.val(dom.find('input', quantityElt));
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

        calcSums : function() {
            var total = 0;
            var rows = dom.findAll('tr.row');
            for (var key=0; key<rows.length; key++) {
                var row = rows[key];
                total += self.calcSum(row);
            }
            dom.val(dom.find('td.total'), total.toFixed(2));
        },

        updatePrices : function() {
            var contractNum = dom.val(dom.findByName(modelName + "[contract_num]"));
            if (contractNum==='') {
                self.fillPricesArray();
                return;
            }
            ajax.get(
                '/contracts/getItem/' + contractNum,
                function(data) {
                    var contract = data;
                    if (contract==false)
                        self.fillPricesArray();
                    else {
                        // заполняем массив цен
                        pricesArr = [];
                        var rows = contract['rows'];
                        for (var key=0; key<rows.length; key++) {
                            var row = rows[key];
                            pricesArr[row['article_id']] = row['price'];
                        }
                        // меняем цены
                        self.updatePriceInputs();
                        self.calcSums();
                        // меняем содержимое поля "клиент"
                        dom.val(dom.findByName(modelName + "[client_id]"), contract['client_id']);
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
                self.updatePriceInput(selects[key]);        
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
            var defPrices = eval(dom.val(dom.find('#self')));
            pricesArr = [];
            for (var key = 0; key < defPrices.length; key++) {
                var arr = defPrices[key];
                pricesArr[arr['id']] = arr['price'];
            }
        },

        setModelName : function(str) {
            modelName = str;
        }
    };
}());
