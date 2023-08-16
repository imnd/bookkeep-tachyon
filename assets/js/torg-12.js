import { clear, find, val } from 'imnd-dom';
import { convPriceToWords, convNumToWords, convWeightToWords } from './print-utils';

clear();

let itemsCount1 = find('#items-count-1');
val(itemsCount1, convNumToWords(val(itemsCount1)));
let itemsCount2 = find('#items-count-2');
val(itemsCount2, convNumToWords(val(itemsCount2)));

let quantSum1 = find('#quantity-sum-1');
val(quantSum1, convWeightToWords(val(quantSum1)));
let quantSum2 = find('#quantity-sum-2');
val(quantSum2, convWeightToWords(val(quantSum2)));

let totalSumContnr = find('#total-sum-in-words');
val(totalSumContnr, convPriceToWords(val(totalSumContnr)));