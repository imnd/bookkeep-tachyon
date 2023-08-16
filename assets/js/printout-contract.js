import { findById, val } from 'imnd-dom';
import { convPriceToWords } from './print-utils';

let totalSumContainer = findById('total-sum-in-words');
val(totalSumContainer, convPriceToWords(val(totalSumContainer)));