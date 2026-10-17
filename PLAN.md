# Plan – Strata

Strata is a block theme for one-page sites (a single page plus imprint and privacy policy): the page is a stack of full-width sections, each with a color scheme and a content width. Built with [wp-app-framework](https://github.com/saijsaij/wp-app-framework). Goals: modern, flexible, easy to use.

This file records the decisions and the steps. Tick a step when its commits are in; change a decision only together with the code.

## Decisions

### Page structure

- `templates/*.html` are full site editing templates: `<header>` and `<footer>` are template parts (`tagName` header/footer), `<main>` is `core/post-content` with `tagName: main` (allowed by WordPress: `wp-includes/blocks/post-content.php:65`) and the default layout, so sections are direct children of `<main>` and WordPress does not constrain their width. The 404 page is the template part `not-found` as `<main>`.
- The top level of a page holds sections only: every other block of the theme can only be inserted inside a section (`ancestor`), the core blocks of the header as well.
- A one-page site has no blog and no search: the post type `post` with categories and tags is hidden in the backend, the REST API and the front end; a search answers with the 404 page. When the site switches to the theme without a static front page, the first published page becomes it, or a new page "Home" (`src/Site/FrontPage.php`).
- Header and footer consist of single blocks and are edited in the site editor; the theme ships a sensible default:
  - header: Section › Group (row) › `core/site-title` + `core/site-tagline`; no navigation;
  - footer: Section › Group (row) › Paragraph with the links of the legal pages (chosen by the user) + Copyright.
- No settings for header and footer content.

### Sections

- A section is always a `<section>` and spans the whole browser width; its content is limited to one of three widths: `narrow`, `normal`, `wide` (enum attribute).
- A section has a color scheme (block support `colorScheme`) and an anchor.
- Responsive: fluid type and spacing with `clamp()`, columns stack below `md`.

### Colors

- Three colors per scheme: background, foreground, accent. Text on the accent uses the background color.
- Color schemes are a settings group (list of schemes): each scheme has an identifier (`#[Identifier]`, generated once, never shown), a name and the three colors (`#[Color]`). The first scheme is the scheme of the whole page; sections, groups and columns can choose any scheme, shown as defined (name and swatch).
- The block support stores the identifier; a section whose scheme no longer exists gets the page scheme. Class `scheme-{id}`.
- The theme prints the schemes as CSS variables (`--scheme-bg`, `--scheme-fg`, `--scheme-accent`) on `:root` and per scheme class, on `enqueue_block_assets` (front end and editor canvas).
- Derived tones with `color-mix()` towards the other scheme color (so they work in light and dark schemes), declared on `:root` and every scheme class so they recompute per section. Tailwind tokens (default palette reset with `--color-*: initial`):

  | Token | Use | Utilities |
  |---|---|---|
  | `canvas`, `canvas-soft`, `canvas-strong` | background, raised and sunken areas | `bg-canvas`, `bg-canvas-soft` |
  | `ink`, `ink-soft`, `ink-faint` | text, secondary text, meta text | `text-ink`, `text-ink-soft` |
  | `line`, `line-strong` | borders, separators | `border-line`, `divide-line` |
  | `accent`, `accent-strong`, `accent-soft` | accent, hover, accent areas | `bg-accent text-canvas hover:bg-accent-strong` |

- Scheme editor on the settings page (settings script, `registerSettingsControl()` for each scheme with `DefaultControl`): a preview of the combinations (text on background, accent on background, button text on accent) and the WCAG contrast ratio of each pair, rated good (≥ 4.5), medium (3–4.5) or poor (< 3).

### Typography

- Font: **Geist** (Vercel, SIL Open Font License, variable 100–900), self-hosted in `assets/fonts/` and preloaded – no Google Fonts CDN (GDPR).

### Blocks

Core blocks that store markup in the post content contradict the framework (no markup in post content) and are disabled with `allowed_block_types_all`; the theme replaces them. Verified in WordPress 7.1.3 (`wp-includes/js/dist/block-library.js` save functions, `wp-includes/blocks/require-static-blocks.php`):

- **Store their own markup (disabled):** paragraph, heading, list, list-item, quote, pullquote, verse, preformatted, code, table, image, gallery, cover, media-text, file, audio, video, embed, playlist, group, columns, column, buttons, button, separator, spacer, details, accordion (all four), tabs (all four), social-links, html, freeform, more, nextpage, math, text-columns, query, comments, terms-query.
- **Store only their inner blocks:** post-template, comment-template, term-template, query-pagination, query-no-results, comments-pagination, navigation, navigation-link, navigation-submenu, home-link – of no use without the disabled parents, disabled as well.
- **Store nothing (allowed where useful):** site-title, site-tagline, site-logo, post-content, template-part, pattern, block (synced patterns). Without a blog, the post blocks, query title and search are not offered.

Own blocks in version 1 (namespace `strata`):

| Block | Notes |
|---|---|
| Section | full width, content width narrow/normal/wide, color scheme, anchor, `contentRole` |
| Group | layout stack or row, alignment, gap, wrap; optional color scheme |
| Columns / Column | 2–4 columns, stacked on small screens |
| Heading | text in the post content (`#[RichText(postContent: true)]`), level 1–4 |
| Paragraph | text in the post content |
| List / List item | a list item has no text of its own: its content are blocks – a Paragraph for the text (in the post content), a List inside for a nested list |
| Image | attachment, caption, optional link |
| Buttons / Button | link (`Link`), style primary/secondary |
| Quote | text and citation |
| Separator | |
| Details | summary and inner blocks |
| Copyright | "© {year} {text}": the year rendered on the server, optional start year ("© 2019–2026"), text edited in the canvas, the site title when empty |
No blog, so no query blocks (they were built in step 6 and removed again); no comments in version 1.

### Templates

`index` and `page` (the same), `404`; parts `header`, `footer` and `not-found`.

## Steps

Each step is one or two commits; lint and build before each commit.

1. [x] Project from wp-app-starter (theme, code checks, release workflow, browser tests); site `global` in wp-dev-env; this plan.
2. [x] Base: Geist, `theme.json` (design tools of WordPress off: colors, type and spacing come from the theme), Tailwind tokens in `assets/styles.css`, templates `index`, `front-page`, `page` and the parts (interim content until step 4), allowed blocks (`src/Editor/AllowedBlocks.php`: blocks of the theme and of plugins, core blocks of the allowed list only).
3. [x] Color schemes (`src/Scheme/`): settings group with identifiers, block support with editor control, CSS output with the derived tones, scheme editor with preview and contrast check. The support control loads once a block uses the support (step 4).
4. [x] Section and Group blocks with widths and schemes; header and footer parts from blocks; Copyright. The legal links in the footer follow with the Paragraph (step 5).
5. [x] Content blocks: Heading, Paragraph, List, Image, Buttons, Columns, Quote, Separator, Details; the footer gets a paragraph for the legal links. (Found and fixed in the framework: void root elements such as `<hr>` in the editor.)
6. [x] Query (posts of the page or the latest posts), Post Template (`Repeater`, list or grid), Pagination (posts of the page; in the editor a sample, and the latest posts stand in for the posts of the page, since editor renders go through the REST API); the templates `index`, `single`, `archive`, `search`, `404` (`front-page.html` removed: WordPress uses `page.html` for a static front page and `index.html` for the blog).
7. [x] Browser tests (`tests/e2e/specs/`: sections, schemes and the scheme editor, header and footer, the allowed blocks and every block in the editor, the blog), green in the dev pool. The release pool passes once the framework release with the fix for void root elements (`<hr>` of the separator in the editor, framework `main` 7cc03f1) is out: 0.18.1.

## Dependencies

- wp-app-framework 0.18 (`#[Identifier]`, settings scripts, `Repeater` and `#[Item]`), required as `^0.18`; locally the package link of wp-dev-env runs the framework checkout.
- Repository: https://github.com/saijsaij/strata

## Changes after the first version (2026-10-17)

- Screenshot of the theme: `tests/screenshot` (see CLAUDE.md).
- No blog, no search, no archives (decision above); Query, Post Template, Pagination and the templates `single`, `archive`, `search` removed.
- Sections only at the top level; the element of a section removed (always `<section>`).
- All schemes choosable, shown as defined; columns with a boxed column line up their content.
- In the framework: compact color controls side by side, settings as headings (wp-app-framework `main`).

