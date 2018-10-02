var utils = {

    /**
     * Возвращает цену словами на русском языке
     *
     * @param {number} number
     * @return {string} 
     */
    convPriceToWords : function (number) {
        result = this._split(number, 2);
        var roubles = result[0];
        return this.convNumToWords(roubles) + ' рубл' + ['ей', 'ь', 'я', 'я', 'я', 'ей', 'ей', 'ей', 'ей', 'ей'][roubles.substr(roubles.length - 1, 1)] + ' ' + this.strPad(result[1], 2, 0) + ' копеек';
    },

    /**
     * Возвращает вес словами на русском языке
     *
     * @param {number} number
     * @return {string} 
     */
    convWeightToWords : function (number) {
	    result = this._split(number, 3);
	    return this.convNumToWords(result[0]) + ' килограмм ' + result[1] + ' грамм';
    },

    /**
     * Возвращает представление числа словами на русском языке
     *
     * @param {number} number
     * @param {number} order
     * @return {string} 
     */
    convNumToWords : function (number, order) {
	    if (order===undefined)
		    order = 0;

	    var numbersAsWords = [
		    ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять', 'деcять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'],
		    ['', '', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'],
		    ['', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'],
		    ['', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять', 'десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать']	
	    ];
	    numbStr = number.toString();
	    switch (numbStr.length) {
		    case 1:
		    case 2:
			    if (number < 20) 
				    return numbersAsWords[order][number];
			    
                return numbersAsWords[1][Math.floor(number / 10)] + ' ' + this.convNumToWords(number % 10, order);
		    case 3:
			    return numbersAsWords[2][Math.floor(number / 100)] + ' ' + this.convNumToWords(number % 100, order);
		    case 4:
			    thousands = Math.floor(number / 1000);
			    return numbersAsWords[3][thousands] + ' тысяч' + this._ending(thousands, 'feminine') + ' ' + this.convNumToWords(number % 1000, order);
		    case 5:
		    case 6:
			    thousands = Math.floor(number / 1000);
			    return this.convNumToWords(thousands, 3) + ' тысяч' + this._ending(thousands, 'feminine') + ' ' + this.convNumToWords(number % 1000);
		    case 7:
		    case 8:
			    millions = Math.floor(number / 1000000);
			    if (millions < 20)
				    millionsInWords = numbersAsWords[0][millions];
			    else
				    millionsInWords = numbersAsWords[1][Math.floor(millions / 10)] + ' ' + this.convNumToWords(millions % 10);
				    
			    return millionsInWords + ' миллион' + this._ending(millions, 'masculine') + ' ' + this.convNumToWords(number % 1000000, 3);
		    case 9:
			    millions = Math.floor(number / 1000000);
			    return this.convNumToWords(millions) + ' миллион' + this._ending(millions, 'masculine') + ' ' + this.convNumToWords(number % 1000000);
		    default:
			    return '';
	    }
    },

    _split : function (number, points) {
        number = parseFloat(number);
        whole = Math.floor(number);
        var fractional = number - whole;
        if (fractional > 0) {
            multiplier = Math.pow(10, points - fractional.length);
        } else {
            multiplier = 0;
        }
        return [whole.toString(), fractional * multiplier];
    },

    /**
     * Грамматическое окончание числа
     *
     * @param {number} number число
     * @param {string} gender грамматический род
     * @return {string} 
     */
    _ending : function (number, gender) {
        numbStr = number.toString();
        numbLen = numbStr.length;
        if (numbLen==3) {
            number = number % 100;
            numbStr = number.toString();
            numbLen = numbStr.length;
        }
        var ending = '';
        var endings = {
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

    strPad : function (input, length, string, type) {
        var half = '',
            padToGo;

        var repeater = function (s, len) {
            var collect = '', i;

            while (collect.length < len)
                collect += s;
        
            collect = collect.substr(0, len);
            return collect;
        };

        input += '';
        string = string !== undefined ? string : ' ';

        if (type != 'STR_PAD_LEFT' && type != 'STR_PAD_RIGHT' && type != 'STR_PAD_BOTH') {
            type = 'STR_PAD_RIGHT';
        }
        if ((padToGo = length - input.length) > 0) {
            if (type == 'STR_PAD_LEFT') {
                input = repeater(string, padToGo) + input;
            } else if (type == 'STR_PAD_RIGHT') {
                input = input + repeater(string, padToGo);
            } else if (type == 'STR_PAD_BOTH') {
                half = repeater(string, Math.ceil(padToGo / 2));
                input = half + input + half;
                input = input.substr(0, length);
            }
        }
        return input;
    }
};