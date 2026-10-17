# CLAUDE.md – Strata

Block theme for one-page sites built with [wp-app-framework](https://github.com/saijsaij/wp-app-framework) (slug `strata`, namespace `strata`: blocks `strata/…`, options `strata_…`, PHP `Saij\Strata\`). Not tied to a client; client sites include it as a standalone theme. `PLAN.md` holds the decisions and the steps – read it before you change anything, and keep it current. Framework principles, conventions and testing rules: the [developer documentation](https://saijsaij.github.io/wp-app-framework/next/development/) and the framework's CLAUDE.md (in the workspace `framework/wp-app-framework/`).

## Rules

- No markup in the post content: core blocks that store markup are disabled and replaced by blocks of the theme (list in `PLAN.md`); the only exception is one `#[RichText(postContent: true)]` field per block.
- Header and footer are template parts built from blocks the user edits in the site editor; no settings for their content.
- Colors only through the scheme tokens of `assets/styles.css` (`canvas`, `ink`, `line`, `accent` and their tones); no colors of Tailwind's default palette, no hex values in templates.
- Tailwind tokens read well as utilities: no names that repeat the utility (`bg-bg-…`, `border-border`).
- Fonts are self-hosted in `assets/fonts/`; no external requests for fonts or scripts.
- Class properties are never `public` (exceptions: block attribute and value classes); everything in this repository is English; other repositories are linked by GitHub URL.

## Commands

Development runs in the site `global` of wp-dev-env (`../wp-dev-env/scripts/setup global`, `http://global.localhost`), with the framework checkout linked into `vendor/`. Checks and tests run in the tools image of wp-test-env (checked out in `../framework/wp-test-env`).

```sh
../wp-dev-env/scripts/setup global                                         # site with this theme and the framework checkout
docker compose -f ../wp-dev-env/compose.yaml run --rm tools composer lint --working-dir=/workspace/strata
docker compose -f ../wp-dev-env/compose.yaml run --rm tools npm --prefix /workspace/strata run lint
docker compose -f ../wp-dev-env/compose.yaml run --rm tools npm --prefix /workspace/strata run build
docker compose -f ../wp-dev-env/compose.yaml run --rm tools composer build-manifest --working-dir=/workspace/strata
```

Browser tests run in wp-test-env with the pool files in `tests/` (`dev.pools`, `release.pools`); never against wp-dev-env. wp-test-env lies in `../framework/`, so its workspace is set to this directory's parent:

```sh
WP_TEST_ENV_WORKSPACE=/home/saij/dev/wp-dev ../framework/wp-test-env/bin/run "$PWD/tests/dev.pools"       # before a push
WP_TEST_ENV_WORKSPACE=/home/saij/dev/wp-dev ../framework/wp-test-env/bin/run "$PWD/tests/release.pools"   # the release ZIP
```

## Keep in sync

- `composer.json` requires the released framework (`^0.18`); a feature of the framework's `main` needs a framework release before the release workflow of the theme can pass.
- `screenshot.png` (1200 × 900) is the demo page `tests/e2e/demo.html` as a visitor sees it: after a change of the design, run `tests/screenshot` (a fresh instance of wp-test-env) and commit the new image.
- A release tag `v<version>` equals `Version:` in `style.css`; every GitHub release gets written release notes.
