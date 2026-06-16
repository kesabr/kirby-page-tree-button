# kirby-page-tree

## NOT WORKING YET

Ein Kirby 5 Panel Plugin, das auf allen Panel-Views einen Globe-Button hinzufügt. Ein Klick öffnet ein Dropdown mit dem vollständigen Page-Tree der Site zur schnellen Navigation.

## Installation

Plugin-Ordner nach `site/plugins/kirby-page-tree/` kopieren (oder symlinken).

## Konfiguration

In `config.php` die `viewButtons` für die gewünschten Views ergänzen:

```php
return [
    'panel' => [
        'viewButtons' => [
            'page' => ['preview', 'settings', 'page-tree'],
            'site' => ['page-tree'],
            'file' => ['settings', 'page-tree'],
        ],
    ],
];
```

## Build

```bash
pnpm install
pnpm build
```

Die generierten Dateien `index.js` und `index.css` werden direkt im Plugin-Root erwartet.

## Features

- Rekursiver Page-Tree bis 10 Ebenen Tiefe
- Status-Indikator pro Seite (grün = listed, gelb = unlisted, grau = draft)
- Expand/Collapse für Unterseiten
- Lazy Load: API wird nur beim ersten Öffnen gefetcht, danach gecacht
- Dark Mode kompatibel via Kirby CSS-Variablen
- Clickaway schließt das Dropdown
