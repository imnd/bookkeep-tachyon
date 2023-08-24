import dom from 'imnd-dom';
import upload from 'imnd-upload';

upload
  .defaults({
    'chunk-size': 600000,
    'file-id': 'file',
    'upload-url': '/settings/acceptFile',
    'on-complete': () => {
      dom('.complete').html('Готово');
    },
  })
  .attach('file-upload')
;