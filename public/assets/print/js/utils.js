let utils = (function() {
    
    let
        splitNum = function(number) {
            let str = number.toString(),
                arr = str.split(".");

            if (arr[1]===undefined) {
                arr[1] = 0;
            }
            return arr;
        },

        /**
         * Грамматическое окончание числа
         *
         * @param {number} number число
         * @param {string} gender грамматический род
         * @return {string} 
         */
        ending = function(number, gender) {
            let numbStr = number.toString(),
                numbLen = numbStr.length;

            if (numbLen===3) {
                number = number % 100;
                numbStr = number.toString();
                numbLen = numbStr.length;
            }
            let endings = {
                'feminine' : ['', 'а', 'и', 'и', 'и', '', '', '', '', '', ''],
                'masculine' : ['', '', 'а', 'а', 'а', 'ов', 'ов', 'ов', 'ов', 'ов', 'ов'],
            };
            switch (numbLen) {
                case 1:
                    return endings[gender][number];

                case 2:
                    if (number < 20)
                        return endings[gender][10];

                    return endings[gender][number % 10];
            }    
        },

        strPad = function(input, length, string, type) {
            input = input.toString();
            string = string || ' ';
            if (
                type !== 'STR_PAD_LEFT'
                && type !== 'STR_PAD_RIGHT'
                && type !== 'STR_PAD_BOTH'
            ) {
                type = 'STR_PAD_RIGHT';
            }

            let half = '',
                padToGo,
                repeat = function (s, len) {
                    let collect = '';

                    while (collect.length < len)
                        collect += s;

                    return collect.substr(0, len);
                };

            if ((padToGo = length - input.length) > 0) {
                if (type === 'STR_PAD_LEFT') {
                    input = repeat(string, padToGo) + input;
                } else if (type === 'STR_PAD_RIGHT') {
                    input = input + repeat(string, padToGo);
                } else if (type === 'STR_PAD_BOTH') {
                    half = repeat(string, Math.ceil(padToGo / 2));
                    input = half + input + half;
                    input = input.substr(0, length);
                }
            }
            return input;
        }
    ;
    
    return {
        /**
         * Возвращает цену словами на русском языке
         *
         * @param {number} number
         * @return {string} 
         */
        convPriceToWords : function(number) {
            let result = splitNum(number),
                roubles = result[0];
            return this.convNumToWords(roubles) + " рубл" + ["ей", "ь", "я", "я", "я", "ей", "ей", "ей", "ей", "ей"][roubles.substr(roubles.length - 1, 1)] + " " + strPad(result[1], 2, 0) + " копеек";
        },

        /**
         * Возвращает вес словами на русском языке
         *
         * @param {number} number
         * @return {string} 
         */
        convWeightToWords : function(number) {
            let result = splitNum(number);
            return this.convNumToWords(result[0]) + " килограмм " + result[1] + " грамм";
        },

        /**
         * Возвращает представление числа словами на русском языке
         *
         * @param {number} number
         * @param {number} order
         * @return {string}
         */
        convNumToWords : function (number, order) {
            order = order || 0;

            let numbersAsWords = [
                ["", "один", "два", "три", "четыре", "пять", "шесть", "семь", "восемь", "девять", "деcять", "одиннадцать", "двенадцать", "тринадцать", "четырнадцать", "пятнадцать", "шестнадцать", "семнадцать", "восемнадцать", "девятнадцать"],
                ["", "", "двадцать", "тридцать", "сорок", "пятьдесят", "шестьдесят", "семьдесят", "восемьдесят", "девяносто"],
                ["", "сто", "двести", "триста", "четыреста", "пятьсот", "шестьсот", "семьсот", "восемьсот", "девятьсот"],
                ["", "одна", "две", "три", "четыре", "пять", "шесть", "семь", "восемь", "девять", "десять", "одиннадцать", "двенадцать", "тринадцать", "четырнадцать", "пятнадцать", "шестнадцать", "семнадцать", "восемнадцать", "девятнадцать"]    
            ],
                numbStr = number.toString(),
                thousands,
                millions,
                millionsInWords
            ;

            switch (numbStr.length) {
                case 1:
                case 2:
                    if (number < 20) 
                        return numbersAsWords[order][number];
                    
                    return numbersAsWords[1][Math.floor(number / 10)] + " " + this.convNumToWords(number % 10);
                case 3:
                    return numbersAsWords[2][Math.floor(number / 100)] + " " + this.convNumToWords(number % 100);
                case 4:
                    thousands = Math.floor(number / 1000);
                    return numbersAsWords[3][thousands] + " тысяч" + ending(thousands, "feminine") + " " + this.convNumToWords(number % 1000);
                case 5:
                case 6:
                    thousands = Math.floor(number / 1000);
                    return this.convNumToWords(thousands) + " тысяч" + ending(thousands, "feminine") + " " + this.convNumToWords(number % 1000);
                case 7:
                case 8:
                    if ((millions = Math.floor(number / 1000000)) < 20)
                        millionsInWords = numbersAsWords[0][millions];
                    else
                        millionsInWords = numbersAsWords[1][Math.floor(millions / 10)] + " " + this.convNumToWords(millions % 10);
                        
                    return millionsInWords + " миллион" + ending(millions, "masculine") + " " + this.convNumToWords(number % 1000000);
                case 9:
                    millions = Math.floor(number / 1000000);
                    return this.convNumToWords(millions) + " миллион" + ending(millions, "masculine") + " " + this.convNumToWords(number % 1000000);
                default:
                    return "";
            }
        }
    };                
})();
