import datepicker from 'imnd-datepicker';

datepicker.build();

import { ready, findByName } from 'imnd-dom';
import { setEntityName, calcSums, updatePrices } from './prices';

const setup = (entityName) => {
  ready(entityName => {
    setEntityName();
    calcSums();
    findByName('contract_num').addEventListener('change', updatePrices);
  });
}

export default setup;