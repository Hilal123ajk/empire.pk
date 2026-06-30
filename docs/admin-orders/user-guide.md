# Admin Orders — User Guide

How to **view and manage customer orders** in the Empire.pk admin panel.

---

## Opening orders

1. Log in to admin: `/admin/login`
2. Click **Orders** in the sidebar.
3. You see a list of all orders with ID, customer, total, and status.

---

## Finding an order

- Use the **search box** to find by order reference or customer name.
- Use the **status filter** to show only Pending, Processing, Shipped, etc.

---

## Order actions (three-dot menu)

Each row has a **⋮** menu:

| Action | What it does |
|--------|----------------|
| **View Detail** | Opens drawer with full order info and items |
| **Update Status** | Change order status (e.g. Pending → Processing → Shipped) |

The menu opens upward or downward automatically so it is never cut off by the table edge.

---

## Order detail drawer

Shows:

- Customer name and phone
- Delivery address and city
- Order notes (if customer added any)
- **Line items** with product name, quantity, price
- **Color/variant** — thumbnail and label (e.g. “Black” or “Main”)
- Order total and payment method (Cash on Delivery)

Use the variant image and color when picking products from stock.

---

## Updating order status

1. Open **⋮ → Update Status**.
2. Choose the new status from the dropdown.
3. Save.

Typical flow:

```
Pending → Processing → Shipped → Delivered
```

Use **Cancelled** if the order will not be fulfilled (communicate with customer separately).

---

## After checkout (what you should do)

1. New orders appear as **Pending**.
2. Call or message the customer to **confirm address and phone** if needed.
3. Move to **Processing** when preparing the package.
4. Move to **Shipped** when handed to courier.
5. Move to **Delivered** when complete.

---

## Stock

When a customer completes checkout, **stock is reduced automatically**. If you cancel an order, restock manually in **Products** today (automatic restock on cancel is not implemented yet).

---

## Tips

- Always check **variant color** on each line item before packing.
- Keep status updated so the team knows what is still pending.
- If an order looks suspicious (wrong phone, nonsense address), contact the customer before shipping.
