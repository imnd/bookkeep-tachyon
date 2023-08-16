import { ready } from 'imnd-dom';
import { bindInputsChange } from './bind-btn-handlers';

ready(() => {
  bindInputsChange('quantity');
  bindInputsChange('price');
  bindInputsChange('sum');
});