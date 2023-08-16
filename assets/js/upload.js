import { html } from 'imnd-dom';
import upload from 'imnd-upload';

upload
  .defaults({
    'chunk-size': 600000,
    'file-id': 'file',
    'upload-url': '/settings/acceptFile',
    'complete-callback': function () {
      html('complete', 'Готово');
    },
  })
  .attach('file-upload')
;