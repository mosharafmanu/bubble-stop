# Bubble Stop - Order Page Specification

## Purpose

The Order Page is the most important page in the entire Bubble Stop website.

This page serves as both:

1. Product Details Page
2. Drink Customization Page

There is no separate product information page.

The customer should be able to:

- View the drink
- Configure the drink
- Add the drink to cart

from a single page.

---

# Customer Flow

Homepage
→ Menu Page
→ Order Page
→ Cart
→ Checkout

---

# WooCommerce Product Structure

Each drink is a WooCommerce Product.

Examples:

- Mango Mania
- Brown Sugar
- Apple Fruit Tea
- Strawberry Cheesecake Milkshake
- Watermelon Fizz

---

# Product Categories

- Milk Blends
- Milkshakes
- Smoothies
- Fizz Mojitos
- Fruit Teas
- Iced Coffee
- Hot Drinks
- Coffee
- Tea

---

# Order Page Layout

## Left Column

- Product Image
- Featured image from WooCommerce

## Right Column

### Product Name

Examples:

- Mango Mania
- Brown Sugar
- Apple Fruit Tea

---

# Product Configuration

## Size

Type: WooCommerce Product Variation

Required: Yes

Options:

- Regular
- Large

Rules:

- Price updates when variation changes.
- Must be selected before adding to cart.
- Use WooCommerce variations, not custom fields.

---

## Sweetness

Type: Customer Preference

Required: Yes

Options:

- Less
- Normal
- More

Rules:

- No price change.
- Save selection in cart item data.
- Save selection in order details.

---

## Ice Level

Type: Customer Preference

Required: Yes

Options:

- Less
- Normal
- More

Rules:

- No price change.
- Save selection in cart item data.
- Save selection in order details.

---

## Free Topping

Type: Drink Customization

Required: No

Client clarification required:

- Single selection?
- Multiple selection?

Possible values:

- Original Tapioca
- Jelly
- Mango Bubbles
- Lychee Bubbles
- Strawberry Bubbles

Rules:

- No additional cost.
- Save selection in cart item data.
- Save selection in order details.

---

## Extra Topping

Type: Paid Add-on

Additional Cost:

+£0.50

Rules:

- Add fee to product price.
- Save selection in cart item data.
- Save selection in order details.

---

## Extra

Type: Paid Add-on

Examples:

- Whipped Cream
- Cheese Cloud

Additional Cost:

+£0.50

---

## Booster

Type: Paid Add-on

Examples:

- Sea Moss Gel

Additional Cost:

+£0.50

---

# Add To Cart

Requirements:

- Validate required selections.
- Add WooCommerce variation.
- Add all customization options.
- Add all price adjustments.

---

# Cart Requirements

Display:

- Product Name
- Size
- Sweetness
- Ice Level
- Free Topping
- Extra Topping
- Extra
- Booster

---

# Order Requirements

All selections must appear inside WooCommerce order details for staff preparation.

---

# Technical Recommendation

WooCommerce Variations:

- Size

Custom Cart Item Data:

- Sweetness
- Ice Level
- Free Topping
- Extra Topping
- Extra
- Booster

Avoid creating unnecessary WooCommerce variations.

---

# Success Criteria

A customer can:

1. Open a drink.
2. Select size.
3. Select sweetness.
4. Select ice level.
5. Select toppings and boosters.
6. Add the drink to cart.
7. See all selections in cart.
8. Complete checkout.
9. Staff can see all selections in WooCommerce orders.
