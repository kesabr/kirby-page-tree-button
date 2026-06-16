<?php

function pageTreeNode($page, int $depth = 0, ?int $maxDepth = null, ?string $infoField = null): array
{
    $children = [];
    $limit = $maxDepth ?? 10;

    if ($depth < $limit && $page->hasChildren()) {
        foreach ($page->children() as $child) {
            $children[] = pageTreeNode($child, $depth + 1, $maxDepth, $infoField);
        }
    }

    $info = null;
    if ($infoField) {
        $info = $page->content()->get($infoField)->value() ?: null;
    }

    return [
        'id'          => $page->id(),
        'title'       => $page->title()->value(),
        'status'      => $page->status(),
        'panelUrl'    => $page->panel()->url(),
        'hasChildren' => $page->hasChildren(),
        'children'    => $children,
        'info'        => $info,
    ];
}

return [
    'routes' => [
        [
            'pattern' => 'page-tree/pages',
            'method'  => 'GET',
            'auth'    => true,
            'action'  => function () {
                $config = [
                    'status' => option('vscode.page-tree.status', true),
                    'search' => option('vscode.page-tree.search', false),
                    'depth'  => option('vscode.page-tree.depth', null),
                    'info'   => option('vscode.page-tree.info', null),
                ];

                $pages = [];
                foreach (kirby()->site()->children() as $page) {
                    $pages[] = pageTreeNode($page, 0, $config['depth'], $config['info']);
                }

                return [
                    'pages'  => $pages,
                    'config' => $config,
                ];
            }
        ]
    ]
];
