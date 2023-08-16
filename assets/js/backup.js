import { ready, findByName } from 'imnd-dom';

ready(function () {
  // добавление поля
  findByName("add").addEventListener("click", () => {
    let pathElt = findByName("path"),
      inpClone = pathElt.last().clone(),
      nextNumb = parseInt(inpClone.attr('id')) + 1;

    inpClone.attr('name', inpClone.attr('class') + nextNumb);
    inpClone.attr('id', nextNumb);
    inpClone.attr('value', '');
    pathElt.last().after(inpClone);
  });
});
