import dom from 'imnd-dom';
import { bindInputsChange } from './bind-btn-handlers';

dom(() => {
  bindInputsChange('quantity');
  bindInputsChange('price');
  bindInputsChange('sum');
});