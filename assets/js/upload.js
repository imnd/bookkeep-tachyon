import dom from 'imnd-dom';
import upload from 'imnd-upload';

upload
  .defaults({
    'chunk-size': 600000,
    'file-id': 'file',
    'upload-url': '/settings/acceptFile',
    'complete-callback': () => {
      dom
        .findByClass('complete')
        .html('Готово');
    },
  })
  .attach('file-upload')
;