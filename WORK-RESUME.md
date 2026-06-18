# Work Resume - Bubble Stop

## Project Overview
Bubble Stop was transitioned from a WooCommerce-based store to a lightweight WordPress site using a Custom Post Type for products.

### Product System (Post-Migration)
- **CPT:** `bubble_product` (registered in `inc/post-types.php`).
- **Taxonomy:** `product_category` for grouping products.
- **Structure:** Uses Title, Featured Image, and Standard Content (Gutenberg enabled).
- **Templates:** 
  - `archive-bubble_product.php`: Automatic grid of all products.
  - `template-menu.php`: Custom category-based menu page with carousels.
  - `template-parts/content-bubble_product.php`: Single product layout matching design.
- **Full Mode:** Flexible content is disabled for Products to allow standard full-width content editing via the block editor.
- **Mango Mania Layout:** Implemented a two-column layout for single products matching the client's design image.
- **Menu Page:** Rebuilt the WooCommerce-style menu page with category-based Slick carousels, regular/large price displays, and product cards.
- **Archive Link:** `/products/`

### WooCommerce Removal
- **Plugin:** WooCommerce plugin deactivated and uninstalled.
- **Files:** All WooCommerce-related files (`inc/woocommerce/`, `woocommerce/`, `assets/css/woocommerce/`, etc.) have been removed.
- **Database:** All `wp_wc_*` and `wp_woocommerce_*` tables dropped. Options and metadata prefixed with `woocommerce_` or `_wc_` deleted.
- **Pages:** Standard WooCommerce pages (Cart, Checkout, My Account, Shop/Menu) deleted.
- **Terms:** WooCommerce taxonomies (`product_cat`, etc.) and their terms cleared.

### Core Theme Features
- **ACF Page Builder:** Flexible content `cms` field used for modular page building.
- **Section Templates:**
  - `hero_section`
  - `smart_50_50_media_content`
  - `loyalty_rewards`
  - `testimonials`
- **Responsive Media:** Custom responsive picture and video renderers.
- **Breadcrumbs:** Custom implementation supporting Posts and Products.

### Recent Major Updates
- Complete removal of WooCommerce dependency.
- Migration of 21 products to `bubble_product` CPT.
- Implementation of `product-card` component and product archive.
- Cleanup of `style.css` and `scripts.js` from obsolete WooCommerce logic.
