import PageTree from './components/PageTree.vue';
import PageTreeButton from './components/PageTreeButton.vue';

panel.plugin('vscode/page-tree', {
  translations: {
    en: {
      'page-tree.button.label':        'All pages',
      'page-tree.status.listed':       'Listed',
      'page-tree.status.unlisted':     'Unlisted',
      'page-tree.status.draft':        'Draft',
      'page-tree.search.placeholder':  'Search pages…',
      'page-tree.search.empty':        'No pages found.',
    },
    de: {
      'page-tree.button.label':        'Alle Seiten',
      'page-tree.status.listed':       'Gelistet',
      'page-tree.status.unlisted':     'Nicht gelistet',
      'page-tree.status.draft':        'Entwurf',
      'page-tree.search.placeholder':  'Seiten suchen…',
      'page-tree.search.empty':        'Keine Seiten gefunden.',
    },
  },
  viewButtons: {
    'page-tree': 'k-page-tree-button',
  },
  components: {
    'k-page-tree':        PageTree,
    'k-page-tree-button': PageTreeButton,
  },
});
