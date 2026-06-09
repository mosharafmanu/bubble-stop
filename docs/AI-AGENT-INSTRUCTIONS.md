# Bubble Stop - AI Agent Instructions

## Project Identity

This is a custom WooCommerce theme for a bubble tea and coffee shop named Bubble Stop.

The project should feel playful, clean, soft, pastel, and café-focused.

## Important Rule

Do not treat this like a generic WooCommerce store.

This is a restaurant/café ordering website.

## Core Flow

Home  
→ Menu  
→ Order Page  
→ Cart  
→ Checkout

## Development Rules

- Follow Figma design closely.
- Do not use page builders.
- Use clean custom theme code.
- Use WooCommerce standards.
- Do not edit WooCommerce core files.
- Keep code modular.
- Make components reusable.
- Use semantic HTML.
- Keep layout responsive.
- Prioritize performance.
- Avoid unnecessary plugins.

## WooCommerce Rules

- Menu page = WooCommerce Shop page.
- Order page = WooCommerce Single Product page.
- Size should be WooCommerce variations.
- Sweetness, Ice Level, Toppings, Extra, Booster should be cart/order item meta.
- Paid add-ons must modify item price correctly.
- All custom selections must appear in cart, checkout, and WooCommerce order admin.

## File Organization Recommendation

/assets
/inc
/template-parts
/woocommerce
/acf-json
/docs

## Naming

Use clear class names.

Recommended prefix:

`bubble-stop-`

Example:

- bubble-stop-header
- bubble-stop-menu-section
- bubble-stop-product-card
- bubble-stop-order-form

## Do Not Do

- Do not create hundreds of product variations.
- Do not create a separate product info page.
- Do not hardcode product data if WooCommerce can manage it.
- Do not break WooCommerce checkout flow.
- Do not ignore mobile responsiveness.

## Main Priority

The Order Page / Single Product Page is the most important part of the project.

Build the drink configurator carefully and make sure all selected options are saved correctly.
