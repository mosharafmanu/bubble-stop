# Bubble Stop Work Resume

Updated: June 9, 2026

## Repository

- Theme root: `/Applications/AMPPS/www/ClientProjects/WordPress/2026/bubble-stop/wp-content/themes/bubble-stop`
- Branch: `main`
- Last known pushed commit: `f31740c Reorganize shared and project CSS`
- The worktree contains substantial uncommitted project work. Do not discard or broadly reset it.

## Current Project Direction

Bubble Stop is a custom WordPress cafe website with a WooCommerce menu and drink ordering flow.

Current WooCommerce behavior:

- Shop page displays product categories as separate carousel blocks.
- Single-product pages provide a custom drink configurator.
- Product size uses WooCommerce variations.
- Sweetness, ice level, free toppings, paid topping, and extra selections are stored as cart/order metadata.
- Paid add-ons currently use one global price of `£0.50` from `bubble_stop_get_paid_addon_price()`.
- Cart item prices include paid add-ons.
- Selected customizations appear in cart, checkout, and order data.

## Completed Theme Work

### Global Site

- Updated theme ownership details for Mosharaf Hossain and `mosharafmanu.com`.
- Rebuilt the header and footer from the supplied designs.
- Header account/cart icons use existing theme assets.
- Footer uses the registered footer menu and site settings.

### Flexible Content

Implemented ACF layouts and templates for:

- Hero section with two artwork fields.
- Smart 50/50 media-content section with media/content tabs, media type selection, and left/right layout control.
- Product category showcase with AJAX category tabs and Slick product carousels.
- Loyalty rewards cards.
- Testimonials carousel using `assets/svgs/quote.php` in the template.

Flexible-content fields were changed so fields are not required. The page builder remains visible on the Shop page because the attempted exclusion was intentionally removed.

### Shop Page

- Removed the old filter and toolbar implementation.
- Added custom Shop hero settings and category-based product carousel blocks.
- Categories with variations show size prices.
- Simple products show their product price between title and product link.
- Product cards do not display descriptions.
- Product/cart icons link to the single-product page rather than adding directly to cart.

Key files:

- `woocommerce/archive-product.php`
- `inc/woocommerce/shop-archive.php`
- `assets/css/woocommerce/bubble-stop-shop-archive.css`
- `assets/js/woocommerce/bubble-stop-shop-archive.js`
- `acf-json/group_shop_page.json`
- `acf-json/group_product_category_menu.json`

### Single Product / Drink Configurator

The old WooCommerce product layout was replaced with the custom “Create Your Drink” design.

Implemented:

- Responsive product image and custom order card.
- Visual variation choices with prices.
- Sweetness and ice-level radio choices.
- Smoothly opening Free Topping picker.
- Included original tapioca selection plus optional free topping checkboxes.
- Paid Extra Topping and Extra selects.
- Global `£0.50` add-on pricing displayed and calculated in cart.
- Variation image updates.
- Cart validation, cart metadata, checkout/order display, and price adjustment.
- WooCommerce notices moved inside the single-product layout container.

Key files:

- `woocommerce/single-product.php`
- `woocommerce/single-product/add-to-cart/variable.php`
- `woocommerce/single-product/add-to-cart/simple.php`
- `woocommerce/single-product/add-to-cart/variation-add-to-cart-button.php`
- `inc/woocommerce/product-customizations.php`
- `assets/css/woocommerce/bubble-stop-single-product.css`
- `assets/js/woocommerce/bubble-stop-single-product.js`

Important CSS detail: global `label:has(input)` rules in `bubble-stop-form.css` required higher-specificity single-product overrides for radio and checkbox alignment.

### Shared Forms And Tables

- Native inputs, selects, textareas, and Select2 controls now use white surfaces with visible neutral borders.
- Generic content tables use white backgrounds and visible borders.
- Single-product paid selects explicitly retain their pale-blue background.

### Cart Page

The cart was redesigned from a traditional table into modern product cards while preserving WooCommerce table markup.

Implemented:

- Separate rounded product rows on desktop.
- Improved image, product title, customization metadata, price, quantity, subtotal, and remove controls.
- Receipt-style cart totals card.
- Sticky cart totals on large desktop.
- Totals stack below the cart under `1280px`.
- Structured responsive product cards at `991px` and below.
- Mobile-specific layout at `479px` and below.
- Coupon section uses a single card border and stacks on narrow screens.
- Empty notice wrappers no longer create large spacing.
- Fixed inherited first/last table-cell borders on responsive cards.

Primary stylesheet: `assets/css/woocommerce/bubble-stop-woocommerce.css`.

### Checkout Page: Task 1

Completed the first checkout improvement pass:

- Empty notice wrappers no longer create a title gap.
- Main two-column grid now targets only `form.checkout`, not the coupon form.
- Coupon toggle/form received a compact card treatment.
- Billing and shipping field spacing was reduced.
- First/last name remain two columns where space allows.
- Order sidebar widened to `25rem` and is sticky below the site header on desktop.
- Sidebar returns to document flow below `991px`.
- Order review uses a white receipt-style card instead of pale nested tables.
- Product customization metadata is compact and aligned.
- Payment, no-payment notice, privacy text, and Place Order area received cleaner spacing and surfaces.

This checkout work has passed CSS whitespace validation but still needs visual testing at desktop, tablet, and mobile widths.

## Tebi Discussion And Decision Pending

The client asked for a “payments system by Tebi” and supplied the Tebi takeaway widget screen.

Current understanding:

- The supplied Tebi script is a standalone takeaway ordering widget, not confirmed as a WooCommerce payment gateway.
- With the widget, products, payments, and orders would normally be managed in Tebi, not WooCommerce.
- Keeping WooCommerce order management would require an official Tebi WooCommerce plugin or documented API/webhook integration.
- Recommended architecture, if the client confirms the widget approach: WordPress handles the designed marketing site, Order buttons open Tebi, and Tebi owns products/modifiers/payments/orders.
- Do not add the widget or remove WooCommerce yet. Await the client’s answer about whether orders must be managed in Tebi or WooCommerce.

Message prepared for the client asks them to choose:

1. Tebi manages products, payments, and orders through its widget.
2. WooCommerce manages orders, with Tebi used only as a payment gateway.

## Verification Status

- Repeated `git diff --check` validation passed after the latest edits.
- PHP syntax for the custom single-product template passed.
- The in-app browser was unavailable during the latest work, so final visual QA was based on user screenshots.
- Cart responsive styling was iterated against screenshots at large desktop, compact desktop/tablet, and mobile widths.
- Checkout task 1 has not yet received post-change screenshots.

## Next Session

1. Run `git status --short --branch` and read this file before editing.
2. Ask for or review fresh checkout screenshots after task 1 changes.
3. Fix any checkout task 1 visual regressions before accepting checkout task 2.
4. Continue the user’s checkout to-do list one item at a time.
5. Get the client’s answer about Tebi versus WooCommerce order ownership before changing payment/order architecture.
6. If Tebi widget use is confirmed, request the complete generated installation snippet and test it on staging before replacing WooCommerce actions.
7. Perform final cross-device QA for shop, single product, cart, checkout, header, and footer.
8. Review and organize the large uncommitted diff before committing. Do not mix unrelated user changes without explicit approval.

## Worktree Caution

The repository contains moved documentation, deleted filter files, new ACF JSON, new section templates, WooCommerce overrides, and substantial style changes. Treat all existing modifications as intentional project work. Never run destructive reset/checkout commands or revert unrelated changes.

Documentation currently lives in `docs/`, including:

- `docs/AI-AGENT-INSTRUCTIONS.md`
- `docs/Bubble-Stop-Order-Page-Specification.md`
- `docs/bubble-stop-docs.zip`
