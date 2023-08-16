import ajax from "imnd-ajax";
import { findById, findByClass } from 'imnd-dom';

let
  sortOrder = "DESC",
  sortCols,
  sortField
;
const parser = new DOMParser();
const sort = (url, field, tblId) => {
    sortOrder = sortField !== field ? "ASC" : sortOrder === "DESC" ? "DESC" : "ASC";
    sortField = field;
    ajax.get(
      url,
      {
        field: sortField,
        order: sortOrder,
      },
      (resp) => {
        const
          xmlDoc = parser.parseFromString(resp, "text/html"),
          newTable = findByClass("data-grid", xmlDoc),
          newTableId = newTable.id,
          oldTable = findById(tblId);

        oldTable.innerHTML = newTable.innerHTML;
        oldTable.id = newTableId;
        bindSortHandlers(url, sortCols, newTableId);
        findById(field).className = sortOrder + " sortable-column";
      },
      "html"
    );
  };

// прикручиваем обработчик к ячейкам таблицы
const bindSortHandler = (url, field, tblId) => {
  findById(field).addEventListener("click", () => {
    sort(url, field, tblId);
  });
};

// прикручиваем обработчики к ячейкам таблицы
const bindSortHandlers = (url, columns, tblId) => {
  sortCols = columns;
  for (let key = 0; key < columns.length; key++) {
    bindSortHandler(url, columns[key], tblId)
  }
};

export { bindSortHandler, bindSortHandlers };