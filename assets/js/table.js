import { findAll, clear } from 'imnd-dom';

/**
 * удаление строки
 */
const bindDelParent = delBtn => {
  delBtn.addEventListener('click', function () {
    this.parentNode.remove();
  });
};

/**
 * очистка инпутов новой строки
 */
const clearRowInputs = row => {
  const tds = findAll('td', row);
  for (let key in tds) {
    const td = tds[key];
    const tdChildren = td.childNodes;
    for (let tdKey in tdChildren) {
      clear(tdChildren[tdKey]);
    }
  }
};

export { bindDelParent, clearRowInputs };
