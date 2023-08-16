import { ready, findByName } from 'imnd-dom';
import { setEntityName, calcSums, updatePrices } from './prices';

const setup = (entityName) => {
  ready(function() {
    setEntityName(entityName);
    calcSums();
    /**
     * при смене номера договора
     * - меняем содержимое поля "клиент";
     * - заполняем массив цен;
     * - меняем цены;
     */
    findByName("contract_num").addEventListener("change", updatePrices);
  });
}

export default setup;
