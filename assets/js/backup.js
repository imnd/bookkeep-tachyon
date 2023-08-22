import dom from 'imnd-dom';

dom(() => {
  // добавление поля
  dom('[name="add"]')
    .click(() => {
      let
        pathElt = dom('[name="path"]'),
        inpClone = pathElt.last().clone(),
        nextNumb = Number(inpClone.attr('id')) + 1;

      inpClone.attr('name', inpClone.attr('class') + nextNumb);
      inpClone.attr('id', nextNumb);
      inpClone.attr('value', '');
      pathElt.last().after(inpClone);
    });
  });
