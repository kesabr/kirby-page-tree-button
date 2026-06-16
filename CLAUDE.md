# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Kirby 5 Panel plugin that adds a "All pages" button to configurable Panel views. Clicking it opens a dropdown with the full recursive page tree for fast navigation.

**Status: Not working yet** — the button renders but Panel navigation via `this.$panel.view.open()` is not functional (see README and last commit).

## Commands

```bash
pnpm install    # install deps (kirbyup)
pnpm dev        # dev mode with watch
pnpm build      # build → index.js + index.css in plugin root
```

Build output (`index.js`, `index.css`) must land in the plugin root, which kirbyup handles automatically.

## Architecture

The plugin has two sides that must stay in sync:

**PHP side (`index.php` + `src/extensions/api.php`)**
- Registers the plugin under ID `vscode/page-tree`
- Defines a `page-tree` area with a `page-tree` button component (`k-page-tree-button`)
- Exposes `GET /api/page-tree/pages` (auth required) — returns the full page tree as JSON plus a `config` object derived from Kirby options

**JS/Vue side (`src/index.js` + `src/components/`)**
- `src/index.js` — registers viewButton `page-tree → k-page-tree-button` and the two global components
- `PageTreeButton.vue` — toolbar button + dropdown wrapper; handles open/close state and clickaway; emits navigation via `this.$panel.view.open()`
- `PageTree.vue` — fetches `/api/page-tree/pages` on mount (no caching between mounts), renders filtered tree via `k-tree-node`, optional search input
- `TreeNode.vue` — recursive self-referencing component; expand/collapse on click for nodes with children, navigate event for leaf nodes; indent = `12 + depth * 16` px

**Data flow:** `PageTreeButton` opens dropdown → `PageTree` mounts and GETs the API → renders `TreeNode` tree → user clicks leaf → `navigate` event bubbles up → `PageTreeButton.navigate()` calls `panel.view.open()`

## Kirby config options

Set in `site/config/config.php` under the `vscode.page-tree.*` namespace:

| Option | Default | Effect |
|--------|---------|--------|
| `vscode.page-tree.status` | `true` | Show colored status dot per page |
| `vscode.page-tree.search` | `false` | Show search input in dropdown |
| `vscode.page-tree.depth` | `null` (→10) | Max recursion depth |
| `vscode.page-tree.info` | `null` | Content field name to show as secondary label |

## Activating the button in Panel views

Add to `site/config/config.php`:

```php
'panel' => [
  'viewButtons' => [
    'page' => ['preview', 'settings', 'page-tree'],
    'site' => ['page-tree'],
    'file' => ['settings', 'page-tree'],
  ],
],
```

## Known issue

`this.$panel.view.open()` (in `PageTreeButton.vue:43`) does not navigate — this is the open bug. The Kirby 5 Panel API for programmatic navigation needs investigation.
