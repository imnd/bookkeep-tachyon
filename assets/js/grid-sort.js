import ajax from "imnd-ajax";
import dom from 'imnd-dom';

let
  sortOrder = "DESC",
  sortCols,
  sortField
;
const
  parser = new DOMParser(),
  sort = (url, field, tblId) => {
    sortOrder = sortField !== field ? "ASC" : sortOrder === "DESC" ? "DESC" : "ASC";
    sortField = field;
    ajax.get(
      url,
      {
        field: sortField,
        order: sortOrder,
      },
      resp => {
        const
          xmlDoc = parser.parseFromString(resp, "text/html"),
          newTable = dom().findByClass("data-grid", xmlDoc).get(),
          newTableId = newTable.id;

          dom()
            .findById(tblId)
            .html(newTable.innerHTML)
            .id(newTableId);

          bindSortHandlers(url, sortCols, newTableId);
          dom()
            .findById(field)
            .className(sortOrder + " sortable-column");
      },
      "html"
    );
  };

// прикручиваем обработчик к ячейкам таблицы
const bindSortHandler = (url, field, tblId) => {
  dom()
    .findById(field)
    .click(() => sort(url, field, tblId));
};

// прикручиваем обработчики к ячейкам таблицы
const bindSortHandlers = (url, columns, tblId) => {
  sortCols = columns;
  for (let key = 0; key < columns.length; key++) {
    bindSortHandler(url, columns[key], tblId)
  }
};

export { bindSortHandler, bindSortHandlers };