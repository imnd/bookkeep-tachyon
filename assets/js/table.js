import dom from 'imnd-dom';

/**
 * удаление строки
 */
const bindDelParent = delBtn => {
  delBtn.click(() => this.parentNode.remove());
};

/**
 * очистка инпутов новой строки
 */
const clearRowInputs = row => {
  dom(row).findAll('td').each(td => {
    td.children().each(elem => elem.clear());
  });
};

export { bindDelParent, clearRowInputs };
