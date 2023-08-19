import { setEntityName, calcSums, updatePrices } from './prices';
import dom from 'imnd-dom';

const setup = (entityName) => {
  dom.ready(function() {
    setEntityName(entityName);
    calcSums();
    /**
     * при смене номера договора
     * - меняем содержимое поля "клиент";
     * - заполняем массив цен;
     * - меняем цены;
     */
    dom
      .findByName("contract_num")
      .change(updatePrices);
  });
}

export default setup;
