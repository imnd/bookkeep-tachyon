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
      ajax
        .post(
          btnHref,
          params
        )
        .then(data => {
          if (data.success) {
            callback()
          }
        });
      return false;
    })
}

export default setup;
