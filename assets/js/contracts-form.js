import datepicker from 'imnd-datepicker';

datepicker.build({
    class: 'datepicker',
    locale: 'en',
});

import dom from 'imnd-dom';
import { setEntityName, calcSums, updatePrices } from './prices';

const setup = entityName =>
  dom(entityName => {
    setEntityName();
    calcSums();
    dom()
      .findByName('contract_num')
      .change(updatePrices);
  })

export default setup;