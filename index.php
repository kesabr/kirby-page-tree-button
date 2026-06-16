<?php

Kirby::plugin('vscode/page-tree', [
    'areas' => [
        'page-tree' => function () {
            return [
                'buttons' => [
                    'page-tree' => [
                        'component' => 'k-page-tree-button',
                    ]
                ]
            ];
        }
    ],
    'translations' => [
        'en' => [
            'page-tree.button.label'       => 'All pages',
            'page-tree.status.listed'      => 'Listed',
            'page-tree.status.unlisted'    => 'Unlisted',
            'page-tree.status.draft'       => 'Draft',
            'page-tree.search.placeholder' => 'Search pages…',
            'page-tree.search.empty'       => 'No pages found.',
        ],
        'de' => [
            'page-tree.button.label'       => 'Alle Seiten',
            'page-tree.status.listed'      => 'Gelistet',
            'page-tree.status.unlisted'    => 'Nicht gelistet',
            'page-tree.status.draft'       => 'Entwurf',
            'page-tree.search.placeholder' => 'Seiten suchen…',
            'page-tree.search.empty'       => 'Keine Seiten gefunden.',
        ],
    ],
    'api' => require __DIR__ . '/src/extensions/api.php',
]);
