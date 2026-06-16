# kirby-page-tree – Implementierungsplan

## Phase 1: Setup

- [x] Verzeichnisstruktur anlegen (`src/`, `src/components/`, `src/extensions/`)
- [x] `package.json` erstellen (kirbyup dev/build scripts)
- [x] `index.php` – Plugin-Registrierung, area + button definition
- [x] `src/extensions/api.php` – GET `/api/page-tree/pages`, rekursive Page-Funktion, Tiefenlimit 10

## Phase 2: Vue Components

- [x] `src/index.js` – `panel.plugin()` entry, viewButtons + components registrieren
- [x] `src/components/PageTreeButton.vue` – Button (globe-icon), Dropdown, lazy fetch, clickaway, panel.open() Navigation, Loading- und Error-State
- [x] `src/components/TreeNode.vue` – rekursiver Node, Status-Dot (listed/unlisted/draft), Indent (16px/Ebene), Expand/Collapse toggle

## Phase 3: Styling

- [x] CSS mit Kirby CSS-Variablen (`--kirby-color-text`, `--kirby-color-border`, `--kirby-color-background`) für Dark Mode Kompatibilität
- [x] Status-Dots (grün = listed, gelb = unlisted, grau = draft)
- [x] Hover- und Focus-States via Kirby Panel CSS-Variablen

## Phase 4: Build & Test

- [x] `pnpm install` ausführen
- [x] `pnpm build` → `index.js` + `index.css` generiert
- [ ] Plugin in Kirby-Testinstanz einbinden (symlink oder direktes Kopieren nach `site/plugins/`)
- [ ] `config.php` viewButtons konfigurieren:
  ```php
  'panel' => [
    'viewButtons' => [
      'page' => ['preview', 'settings', 'page-tree'],
      'site' => ['page-tree'],
      'file' => ['settings', 'page-tree'],
    ]
  ]
  ```
- [ ] Manueller Test: Button sichtbar, Dropdown öffnet sich, Navigation via `panel.open()` funktioniert

## Phase 5: Polish

- [x] Loading Spinner während API-fetch
- [x] Error Message bei API-Fehler
- [x] Leerer State wenn keine Pages vorhanden
- [x] `README.md` mit Installationsanleitung + `config.php`-Snippet

---

## Hinweis für den User

Nach dem Build muss in der Kirby-Instanz folgendes in `config.php` ergänzt werden:

```php
'panel' => [
  'viewButtons' => [
    'page' => ['preview', 'settings', 'page-tree'],
    'site' => ['page-tree'],
    'file' => ['settings', 'page-tree'],
  ]
]
```

Das Plugin liegt unter `site/plugins/kirby-page-tree/`.
