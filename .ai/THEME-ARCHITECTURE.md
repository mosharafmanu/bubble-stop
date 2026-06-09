# Bubble Stop — Theme Architecture

Bubble Stop is a clean ACF-based WordPress theme framework. Every real section is created per project from the client design. The framework provides the architecture, dispatcher, and helper patterns — not pre-built sections.

---

## Philosophy

**The framework provides the plumbing. Each project provides the design.**

- You do not get sections for free. You build each section from the client design using the provided helpers and patterns.
- The `example_section.php` template is the only pre-built section. Copy it, rename it, build your section from it.
- Site settings helpers exist as patterns. Configure them per project — not every project uses the same header/footer structure.
- Image sizes are project-specific. Define them in `inc/image-sizes.php` based on the design grid.
- ACF Options pages are created and configured directly in the ACF plugin UI — not via code.

---

## File Structure

```
bubble-stop/
├── .ai/                          # AI documentation (this folder)
│   ├── ACF-PATTERNS.md           # How to build sections + all helper function signatures
│   ├── VIDEO-SYSTEM.md           # Video field and helper documentation
│   └── THEME-ARCHITECTURE.md    # This file
├── acf-json/                     # ACF field groups (auto-synced from WP Admin)
│   ├── group_flexible_content.json  # Flexible Content — add layouts per project
│   ├── group_site_settings.json     # Site settings — configure per project
│   ├── group_page_settings.json     # Per-page settings
│   ├── group_blog_options.json      # Blog options
│   └── ui_options_page_*.json       # ACF options page definitions
├── assets/
│   ├── css/
│   │   ├── bubble-stop-design-style.css   # Base/reset, typography, layout, buttons, color utilities
│   │   ├── bubble-stop-starter-style.css  # Component styles — header, footer, nav, cards, single post
│   │   ├── bubble-stop-form.css           # Form styles (inputs, labels, checkboxes, submit)
│   │   ├── woocommerce/                     # WooCommerce module CSS — see WOOCOMMERCE.md (removable as a unit)
│   │   ├── spacer.css                       # Spacing utilities (mt-*, mb-*, pt-*, pb-*)
│   │   ├── utilities.css                    # Display/layout utilities
│   │   ├── video-behaviors.css              # Video system CSS
│   │   └── video-popup.css                  # Video popup modal CSS
│   ├── js/
│   │   ├── video-behaviors.js             # Video system JS
│   │   ├── video-popup.js                 # Video popup JS
│   │   ├── jquery.mb.vimeo_player.min.js  # Vimeo API player (if needed)
│   │   └── scripts.js                     # Main theme JS
│   └── svgs/                              # SVG icon includes (PHP)
├── inc/
│   ├── components/
│   │   ├── cards/
│   │   │   └── post-card.php      # bubble_stop_render_post_card() — reusable post card
│   │   └── header/
│   │       ├── class-menu-walker.php  # Injects submenu indicators into mainMenu
│   │       └── hamburger-menu.php     # bubble_stop_render_mobile_navigation()
│   ├── helper-functions/          # Generic, reusable across all projects
│   │   ├── breadcrumb.php         # bubble_stop_breadcrumb()
│   │   ├── button-renderer.php    # ACF link field → button HTML
│   │   ├── flexible-content.php   # The dispatcher ← core of the framework
│   │   ├── icon-renderer.php      # SVG/image icon renderer
│   │   ├── pagination.php         # Numbered pagination
│   │   ├── post-utilities.php     # Post-level helpers
│   │   ├── responsive-picture.php # srcset image renderer
│   │   ├── site-settings.php      # ACF options wrappers — project-specific
│   │   └── video-renderer.php     # Multi-source video renderer
│   ├── image-sizes.php            # Image size registration ← define per project
│   └── woocommerce/
│       └── woocommerce-setup.php  # WooCommerce module entry — see WOOCOMMERCE.md (removable as a unit)
├── languages/
│   └── bubble-stop.pot
├── template-parts/
│   ├── content-post.php           # Single post template — loaded first by single.php
│   ├── content.php                # Fallback loop template (non-post types)
│   ├── content-page.php           # Page loop template — loaded by page.php
│   ├── content-none.php           # No results fallback
│   ├── content-search.php         # Search result item
│   └── sections/
│       └── example_section.php    # The pattern template — start every section here
├── functions.php                  # Theme bootstrap
├── style.css                      # Theme metadata + :root {} design tokens
├── header.php
├── footer.php
├── page.php
├── single.php
├── archive.php
├── index.php
└── 404.php
```

---

## How the Theme Boots

1. `functions.php` runs:
   - Theme support features (thumbnails, html5, custom logo, etc.)
   - Nav menu registration (mainMenu, footerMenu)
   - Asset enqueue (fonts, CSS, video JS)
   - Gutenberg disable
   - ACF JSON sync configuration
2. `inc/image-sizes.php` registers project image sizes
3. All helper function files are loaded from `inc/helper-functions/`
4. WordPress loads templates on request (`page.php`, `single.php`, etc.)
5. `page.php` calls `bubble_stop_flexible_content('cms')` which dispatches section templates

---

## The Dispatcher — Core Concept

Every page is composed of stacked ACF Flexible Content layouts. The dispatcher loads the matching template automatically.

```
Editor stacks layouts in WP Admin
        ↓
ACF Flexible Content field: "cms"
        ↓
bubble_stop_flexible_content('cms')  ← called in page.php
        ↓
Loads: template-parts/sections/{layout_name}.php
        ↓
Frontend output
```

See `ACF-PATTERNS.md` for the full workflow.

---

## Design Token System

All design tokens are CSS custom properties in `style.css` `:root {}`. This file loads after `assets/css/bubble-stop-theme-style.css`, so its values always win.

Key tokens: `--bubb-color-primary`, `--bubb-color-secondary`, `--bubb-color-accent`, `--bubb-color-dark`, `--bubb-color-mid`, `--bubb-color-subtle`, `--bubb-color-light`, `--bubb-font-heading`, `--bubb-font-body`, `--bubb-container-max`, `--bubb-section-padding-y`.

**Per-project setup:**
1. Update the 7 hex values in `style.css` `:root {}`
2. Update font tokens + Google Fonts URL in `functions.php`
3. Update container and spacing tokens if the design grid differs
4. Define image sizes in `inc/image-sizes.php`

Never write hex values outside `:root {}`. Never add client-name-based token names (`--brand-purple`). Use only `var(--bubb-*)` in CSS.

---

## Key Conventions

| Thing | Convention |
|---|---|
| Function prefix | `bubble_stop_` → replace per project |
| Text domain | `bubble-stop` → replace per project |
| CSS custom property prefix | `--bubb-` → update values per project |
| Image size slug prefix | `mc-` → define sizes per project |
| ACF flexible content field | `cms` (consistent across projects) |
| Section template location | `template-parts/sections/{layout_name}.php` |
| Layout name ↔ template | Must match exactly |

---

## Header

`header.php` outputs the sticky header: logo (left) + desktop nav (right) + hamburger toggle (far right, hidden on desktop).

| File | Purpose |
|---|---|
| `header.php` | Branding + desktop nav + hamburger toggle |
| `inc/components/header/class-menu-walker.php` | Injects `.submenu-indicator` chevron into `mainMenu` items |
| `inc/components/header/hamburger-menu.php` | `bubble_stop_render_mobile_navigation()` — slide-in panel + overlay |

The mobile menu is called in `footer.php` **after** `</div><!-- #page -->` and **before** `wp_footer()` — it must live outside the page wrapper to avoid stacking-context issues with fixed overlays.

Desktop nav hides at ≤991px. Mobile elements are `display: none` globally, restored inside `@media (max-width: 991px)`.

---

## Footer

The starter footer is intentionally minimal. Both rows are **fully conditional** — if an ACF Options field is empty or a menu location has no menu assigned, that element simply does not render.

### Structure

```
footer.php
├── .footer-top  (background: --bubb-color-primary)
│   ├── logo             ← bubble_stop_render_footer_logo()
│   └── footer menu      ← bubble_stop_render_footer_menu(['location'=>'footerMenu','show_title'=>false])
│
└── .footer-bottom  (background: --bubb-color-secondary)
    ├── copyright text   ← bubble_stop_render_footer_copyright()
    └── social icons     ← bubble_stop_render_social_medias()
```

### ACF Options fields (Site Settings options page)

| Field | Helper | Notes |
|---|---|---|
| `footer_logo` | `bubble_stop_render_footer_logo()` | Falls back to `site_logo` if not set |
| `footer_tagline` | `bubble_stop_render_footer_tagline()` | Available but **not rendered by default** — add per project |
| `social_medias` | `bubble_stop_render_social_medias()` | Repeater: SVG icon + URL |
| `footer_copyright` | `bubble_stop_render_footer_copyright()` | Supports `{year}` placeholder |

### Registered nav menu locations

Only two locations ship in the starter:

```php
'mainMenu'   // Desktop + mobile navigation
'footerMenu' // Footer menu — rendered flat with no title
```

Register additional footer menu locations in `functions.php` per project when a multi-column footer is needed. See `ACF-PATTERNS.md → Site Settings` for the full pattern.

### Back to top button

A fixed back-to-top button is rendered in `footer.php` after `.mobile-navigation` and outside `#page`. It appears after 400px of scroll via JS in `assets/js/scripts.js` and uses `.is-visible` to animate in. CSS lives in `style.css`.

### Extending the footer per project

- **Tagline:** call `bubble_stop_render_footer_tagline()` in `.footer-top` after the logo
- **Multiple menu columns:** register `footerMenu2`, `footerMenu3` in `functions.php`, add calls to `footer.php`, set `show_title => true`
- **Extra layout (office info, newsletter, etc.):** add directly in `footer.php` — no helper needed for one-off content

---

## Content Templates

| File | Loaded by | Purpose |
|---|---|---|
| `template-parts/content-post.php` | `single.php` | Single blog post — featured image, entry header (categories, title, meta), `.entry-content`, tags footer |
| `template-parts/content-page.php` | `page.php` | Static WordPress Pages — respects `show_page_title` ACF toggle |
| `template-parts/content.php` | fallback | Non-post types — identical structure to `content-post.php`, used if `content-post.php` is missing |

**Template hierarchy note:** `get_template_part('template-parts/content', 'post')` resolves `content-post.php` before `content.php`. Always edit `content-post.php` for single post changes.

The `.entry-content` class wraps all `the_content()` output across all three templates. All rich-text typography (headings rhythm, blockquotes, code, tables, image alignment, etc.) is scoped to this class in `assets/css/bubble-stop-design-style.css`.

See `TYPOGRAPHY.md` for full documentation of content typography and single post CSS.

---

## ACF Options Pages

ACF Options pages are created and managed **directly in the ACF plugin UI** — not via code. The helper functions in `inc/helper-functions/site-settings.php` read from those options fields. Configure which functions you need per project — add or remove them to match the project's header/footer structure.

---

## ACF JSON Sync

- Field groups auto-save to `acf-json/` on every WP Admin save
- Always commit `acf-json/` to version control
- Run Sync in WP Admin when deploying to a new environment
- Never edit `acf-json/*.json` files directly

---

## What Is NOT In This Framework

- Pre-built sections. Build each section from the client design.
- ~~WooCommerce integration~~ — **WooCommerce support is now included in the starter.** See `WOOCOMMERCE.md`.
- Custom post types. Register per project in `functions.php` or a new `inc/` file.
- Navigation walkers. Add per project if needed.
- Component libraries. There are no pre-built card, accordion, or gallery components.
