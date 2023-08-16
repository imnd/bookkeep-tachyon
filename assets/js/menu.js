import { findById } from 'imnd-dom';
import ajax from 'imnd-ajax';

const setup = (btnId, confirmMsg, btnHref, params, callback) => {
  findById(btnId).addEventListener("click", e => {
    e.preventDefault();
    if (confirm(confirmMsg)!==true) {
      return false;
    }
    ajax.post(
      btnHref,
      params,
      data => {
        if (data.success===true) {
          callback
        }
      }
    );
    return false;
  })
}

export default setup;
