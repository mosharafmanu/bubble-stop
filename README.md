# Bubble Stop Theme

Bubble Stop is a custom WordPress theme built for a cafe/bubble tea shop. It uses ACF Pro for a modular "Section Builder" approach.

## Tech Stack
- **WordPress 6.0+**
- **ACF Pro** (Flexible Content for page building)
- **Slick Carousel**
- **Vanilla CSS** (Custom design tokens)

## Products (Custom Post Type)
Bubble Stop uses a custom post type for products (`bubble_product`). This was transitioned from WooCommerce to a simplified structure that supports:
- Product Title
- Featured Image
- Product Archive (`/products/`)

The theme is now lean and free of WooCommerce dependencies.

## Key Features
- **Section Builder:** Modular sections (Hero, Media/Content, Testimonials, etc.) can be stacked on any Page, Post, or Product.
- **Custom Post Type:** Dedicated Product management without the overhead of WooCommerce.
- **AJAX Navigation:** Optimized search and filtering.
- **Video System:** Robust renderer for self-hosted, YouTube, and Vimeo videos with autoplay/popup behaviors.

## Development
- **SCSS:** Compiled using `node-sass`.
- **Assets:** Organized by component in `inc/components/` and `assets/`.
