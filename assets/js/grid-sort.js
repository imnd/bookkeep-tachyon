import ajax from './ajax';
import dom from './dom';

let
  sortFields,
  order = 'DESC',
  orderBy
;
const
  sort = (field, tblId, url) => {
    order = orderBy !== field ? 'ASC' : order === 'DESC' ? 'DESC' : 'ASC';
    orderBy = field;
    ajax
      .get(url, {
          'order-by': orderBy,
          order,
        }, 'html')
      .then(
        result => {
          dom(`#${tblId}`).html(result);
          _bindSortHandlers(sortFields, tblId, url);
          dom(`#${field}`).class(`${order} sortable-column`);
        }
      );
  };

// прикручиваем обработчик к ячейкам таблицы
const bindSortHandler = (field, tblId, url) => {
  dom(`#${field}`)
    .attr('style', 'cursor: pointer')
    .click(() => sort(field, tblId, url));
};

// прикручиваем обработчики к ячейкам таблицы
const bindSortHandlers = (fields, tblId, url) => {
  sortFields = fields;
  dom(() => _bindSortHandlers(fields, tblId, url));
};

// прикручиваем обработчики к ячейкам таблицы
const _bindSortHandlers = (fields, tblId, url) => {
    for (let key = 0; key < fields.length; key++) {
      bindSortHandler(fields[key], tblId, url || "")
    }
};

export default bindSortHandlers;
