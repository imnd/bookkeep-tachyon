function PriceInWords(number) {
	var tails = ['ей','ь','я','я','я','ей','ей','ей','ей','ей'];
    number += '';
	var price = number.split('.');
	var roubles = price[0];
	var roublesInWords = NumberInWords(roubles);
	var len = roubles.length - 1;
	ending = tails[roubles.substr(len, 1)];
	return roublesInWords + ' рубл' + ending + ' ' + price[1] + ' копеек';
}

function WeightInWords(number) {
	number += '';
	var weight = number.split('.');
	grams = weight[1];
	multiplier = Math.pow(10, 3 - grams.length);
	return NumberInWords(weight[0]) + ' килограмм ' + weight[1] * multiplier + ' грамм';
}

function DivideEnt(a, b) {
	return (a - a % b) / b;
}

function Ending(number, gender) {
	numbString = number.toString();
	numbLen = numbString.length;
	if (numbLen==3) {
		number = number%100;
		numbString = number.toString();
		numbLen = numbString.length;
	}
	var ending = '';
	var endings = {
		'feminine' : ['','а','и','и','и','','','','','',''],
		'masculine' : ['','','а','а','а','ов','ов','ов','ов','ов','ов'],
	};
	switch (numbLen) {
		case 1:
			ending = endings[gender][number];
		break;
		case 2:
			if (number<20)
				ending = endings[gender][10];
			else {
				number = number%10;
				ending = endings[gender][number];
			}
		break;
	}	
	return ending;
}

function NumberInWords(number, order) {
	if (order==undefined)
		order=0;

	var numbers_in_words = [
		['','один','два','три','четыре','пять','шесть','семь','восемь','девять','деcять','одиннадцать','двенадцать','тринадцать','четырнадцать','пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать'],
		['','','двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят','восемьдесят','девяносто'],
		['','сто','двести','триста','четыреста','пятьсот','шестьсот','семьсот','восемьсот','девятьсот'],
		['','одна','две','три','четыре','пять','шесть','семь','восемь','девять','десять','одиннадцать','двенадцать','тринадцать','четырнадцать','пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать']	
	];
	numbString = number.toString();
	switch (numbString.length) {
		case 1:
		case 2:
			if (number<20) 
				return numbers_in_words[order][number];
			else
				return numbers_in_words[1][DivideEnt(number, 10)] + ' ' + NumberInWords(number%10, order);
			break;
		case 3:
			return numbers_in_words[2][DivideEnt(number, 100)] + ' ' + NumberInWords(number%100, order);
			break;
		case 4:
			thousands = DivideEnt(number, 1000);
			return numbers_in_words[3][thousands] + ' тысяч' + Ending(thousands, 'feminine') + ' ' + NumberInWords(number%1000, order);
			break;
		case 5:
		case 6:
			thousands = DivideEnt(number, 1000);
			return NumberInWords(thousands, 3) + ' тысяч' + Ending(thousands, 'feminine') + ' ' + NumberInWords(number%1000);
			break;
		case 7:
		case 8:
			millions = DivideEnt(number, 1000000);
			if (millions<20)
				millions_in_words = numbers_in_words[0][millions];
			else
				millions_in_words = numbers_in_words[1][DivideEnt(millions, 10)] + ' ' + NumberInWords(millions%10);
				
			return millions_in_words + ' миллион' + Ending(millions, 'masculine') + ' ' + NumberInWords(number%1000000, 3);
			break;
		case 9:
			millions = DivideEnt(number, 1000000);
			return NumberInWords(millions) + ' миллион' + Ending(millions, 'masculine') + ' ' + NumberInWords(number%1000000);
			break;
		default:
			break;
	}
}

function str_pad(input, pad_length, pad_string, pad_type) {
  var half = '',
	pad_to_go;

  var str_pad_repeater = function (s, len) {
	var collect = '', i;

	while (collect.length < len)
	  collect += s;
	
	collect = collect.substr(0, len);
	return collect;
  };

  input += '';
  pad_string = pad_string !== undefined ? pad_string : ' ';

  if (pad_type != 'STR_PAD_LEFT' && pad_type != 'STR_PAD_RIGHT' && pad_type != 'STR_PAD_BOTH') {
	pad_type = 'STR_PAD_RIGHT';
  }
  if ((pad_to_go = pad_length - input.length) > 0) {
	if (pad_type == 'STR_PAD_LEFT') {
	  input = str_pad_repeater(pad_string, pad_to_go) + input;
	} else if (pad_type == 'STR_PAD_RIGHT') {
	  input = input + str_pad_repeater(pad_string, pad_to_go);
	} else if (pad_type == 'STR_PAD_BOTH') {
	  half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
	  input = half + input + half;
	  input = input.substr(0, pad_length);
	}
  }

  return input;
}

