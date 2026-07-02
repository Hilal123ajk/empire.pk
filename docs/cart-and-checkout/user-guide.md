# Cart & Checkout — User Guide

How customers shop and place orders—and what staff should know about the checkout process.

---

## For customers

### Adding items to the cart

1. Browse products and open a product page.
2. Select a **color** if options are shown (optional).
3. Click **Add to Cart**.
4. The cart drawer opens showing items, quantities, and total.
5. Same product in **different colors** appears as **separate lines**.

### Viewing the cart

- Click the cart icon in the header anytime.
- Adjust quantities or remove items in the drawer.
- **Continue Shopping** returns to the homepage.

### Checkout

1. From the cart, go to **Checkout** (or visit `/checkout`).
2. On mobile, use the **Back** button at the top to return to the previous page.
3. Fill in:
   - First and last name
   - Mobile number (Pakistani format: `03XX XXXXXXX`)
   - Delivery address (at least a few words—full street details)
   - City (from the dropdown list)
   - Optional notes for delivery
3. Payment method is **Cash on Delivery (COD)** only.
4. Review the order summary — a **flat delivery fee** applies (shown in cart and checkout).
5. Click **Place Order**.
6. A **confirmation popup** asks you to verify details before the order is sent.
7. After success, you see a thank-you message. The team will contact you to confirm delivery.

---

## Phone number rules

The checkout form accepts Pakistani mobile numbers in the format:

**03XXXXXXXXX** (11 digits starting with 03)

Examples: `03001234567`, `03451234567`

Invalid formats are rejected with a clear error message.

---

## Address rules

- Address is required and must be meaningful (minimum word count enforced).
- Use house/building, street, and area for smooth delivery.

---

## For store staff

### What happens when an order is placed

1. Order is saved in **Admin → Orders**.
2. Stock for each product is **reduced automatically**.
3. Each line shows the **color/variant** the customer chose (or “Main”).
4. Order starts as **Pending** until your team updates status.

### If checkout fails

Common causes:

| Issue | What to tell customer |
|-------|------------------------|
| Out of stock | Product sold out; try lower quantity or another item |
| Invalid phone | Use 03XXXXXXXXX format |
| Address too short | Add street and area details |
| Too many attempts | Wait a minute and try again (rate limit) |

---

## Payment

Only **Cash on Delivery** is available. Customers pay the delivery person when the order arrives. No card or online payment on the site yet.

---

## Cart is on the customer’s device

The cart is stored in the browser. If the customer clears browser data or uses another device, the cart will be empty. They need to add items again.

---

## Tips for accurate orders

- Encourage customers to **double-check phone and address** in the confirmation popup.
- Color shown on the admin order matches what they selected at checkout—use this when picking items from the warehouse.
