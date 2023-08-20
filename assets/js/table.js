import dom from 'imnd-dom';

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
  dom().findAll('td', row).each((td) => {
    td.children().each((elem) => {
      elem.clear();
    });
  });
};

export { bindDelParent, clearRowInputs };
