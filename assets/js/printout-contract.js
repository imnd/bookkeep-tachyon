import dom from 'imnd-dom';
import { convPriceToWords } from './print-utils';

let totalSumContainer = dom('#total-sum-in-words');
totalSumContainer.val(convPriceToWords(totalSumContainer.val()));