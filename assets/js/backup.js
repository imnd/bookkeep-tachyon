import dom from 'imnd-dom';

dom().ready(() => {
  // добавление поля
  dom()
    .findByName("add")
    .click(() => {
      let pathElt = findByName("path"),
        inpClone = pathElt.last().clone(),
        nextNumb = parseInt(inpClone.attr('id')) + 1;

      inpClone.attr('name', inpClone.attr('class') + nextNumb);
      inpClone.attr('id', nextNumb);
      inpClone.attr('value', '');
      pathElt.last().after(inpClone);
    });
  });
