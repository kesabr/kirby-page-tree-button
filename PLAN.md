# kirby-page-tree – Implementierungsplan

## Phase 1: Setup

- [x] Verzeichnisstruktur anlegen (`src/`, `src/components/`, `src/extensions/`)
- [x] `package.json` erstellen (kirbyup dev/build scripts)
- [x] `index.php` – Plugin-Registrierung, area + button definition
- [x] `src/extensions/api.php` – GET `/api/page-tree/pages`, rekursive Page-Funktion

## Phase 2: Vue Components

- [x] `src/index.js` – `panel.plugin()` entry, viewButtons + components registrieren
- [x] `src/components/PageTreeButton.vue` – Button, Dropdown, clickaway, Navigation via `panel.open()`
- [x] `src/components/PageTree.vue` – API-Fetch, Filterlogik, Search-Input (optional)
- [x] `src/components/TreeNode.vue` – rekursiver Node, Blueprint-Icon, Expand/Collapse, Status-Dot

## Phase 3: Styling

- [x] Visuell an native Kirby Sitemap angelehnt: `[chevron] [blueprint-icon] [title] [info?] [status-dot?]`
- [x] Status-Dots nach Kirby-Design: gefüllt grün (listed), halb gefüllt blau (unlisted), Outline rot (draft)
- [x] Dropdown: weisser Hintergrund, Panel-Shadow, weisse Dropdown-Box
- [x] Hover- und Focus-States via Kirby Panel CSS-Variablen
- [x] Indent: 20px pro Ebene

## Phase 4: Konfigurierbare Optionen

- [x] `vscode.page-tree.status` (default: `true`) – Status-Dot am Ende jeder Zeile
- [x] `vscode.page-tree.info` (default: `false`) – Wert eines Content-Feldes direkt nach dem Titel
- [x] `vscode.page-tree.search` (default: `false`) – Suchfeld oben im Dropdown
- [x] `vscode.page-tree.depth` (default: `null` → 10) – Maximale Rekursionstiefe

## Phase 5: Daten & API

- [x] Blueprint-Icon pro Seite (`$page->blueprint()->icon() ?? 'page'`)
- [x] Drafts werden angezeigt (API nutzt `childrenAndDrafts()` statt `children()`)
- [x] Error-Page wird ausgeblendet (Filter auf `slug !== 'error'`)
- [x] `pnpm build` → `index.js` + `index.css` generiert

## Phase 6: Build & Test

- [x] Plugin in Kirby-Testinstanz eingebunden (`site/plugins/site-nav-panel-button/`)
- [x] `config.php` viewButtons konfiguriert:
  ```php
  'panel' => [
    'viewButtons' => [
      'page' => ['page-tree', '-', '-', 'open', 'preview', 'settings', 'status'],
      'site' => ['page-tree'],
      'file' => ['settings', 'page-tree'],
    ]
  ]
  ```
- [ ] **Manueller Test: Navigation via `panel.open()` funktioniert** ← noch nicht gelöst (open bug)

## Noch offen

- [ ] **Navigation funktioniert nicht** – `this.$panel.view.open()` in `PageTreeButton.vue:43` navigiert nicht. Kirby 5 Panel API für programmatische Navigation muss noch recherchiert werden.
- [ ] Dark Mode testen – CSS nutzt Kirby-Variablen, aber im Dark Mode noch nicht verifiziert
- [ ] README aktualisieren – neue Konfigurationsoptionen (`info`, `search`) noch nicht dokumentiert
