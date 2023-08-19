import path from 'path'
import { defineConfig } from 'vite'

const
  entries = {},
  jsFileNames = [
    'bind-btn-handlers',
    'contracts-form',
    'datepicker',
    'grid-sort',
    'invoices-form',
    'menu',
    'print-utils',
    'prices',
    'table',
    'upload',
    'backup',
    'create-purchase',
    'printout-contract',
    'torg-12',
  ]
;
for (let key in jsFileNames) {
  const entry = jsFileNames[key];
  entries[entry] = `./assets/js/${entry}`;
}

const config = defineConfig({
  build: {
    lib: {
      entry: entries,
      formats: ['es'],
    },
    copyPublicDir: false,
    emptyOutDir: true,
    outDir: path.resolve(__dirname, './public/assets/js/'),
  }
});

export default config;
