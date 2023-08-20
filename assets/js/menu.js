import ajax from 'imnd-ajax';
import dom from 'imnd-dom';

const setup = (btnId, confirmMsg, btnHref, params, callback) => {
  dom()
    .findById(btnId)
    .click(e => {
      e.preventDefault();
      if (confirm(confirmMsg) !== true) {
        return false;
      }
      ajax.post(
        btnHref,
        params,
        data => {
          if (data.success === true) {
            callback()
          }
        }
      );
      return false;
    })
}

export default setup;
