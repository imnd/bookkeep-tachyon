import {
  convPriceToWords,
  convWeightToWords,
  convNumToWords
} from '../print-utils';

test('Test convPriceToWords', () => {
    expect(convPriceToWords(164.34)).toBe('сто шестьдесят четыре рубля 34 копеек');
})

test('Test convWeightToWords', () => {
    expect(convWeightToWords(65.98)).toBe('шестьдесят пять килограмм 98 грамм');
})

test('Test convNumToWords', () => {
    expect(convNumToWords(587)).toBe('пятьсот восемьдесят семь');
})

