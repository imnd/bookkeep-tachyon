import dom from 'imnd-dom';
import { convPriceToWords, convNumToWords, convWeightToWords } from './print-utils';

dom().clear();

let itemsCount1 = dom().find('#items-count-1');
itemsCount1.val(convNumToWords(itemsCount1.val()));

let itemsCount2 = dom().find('#items-count-2');
itemsCount2.val(convNumToWords(itemsCount2.val()));

let quantSum1 = dom().find('#quantity-sum-1');
quantSum1.val(convWeightToWords(quantSum1.val()));

let quantSum2 = dom().find('#quantity-sum-2');
quantSum2.val(convWeightToWords(quantSum2.val()));

let totalSumContnr = dom().find('#total-sum-in-words');
totalSumContnr.val(convPriceToWords(totalSumContnr.val()));