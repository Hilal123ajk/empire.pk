# Soft Deletes & Confirmations — User Guide

How **deleting, restoring, and permanently removing** products and categories works—and what the confirmation dialogs mean.

---

## Why “Trash” instead of instant delete?

When you delete a product or category, it goes to **Trash** first—not gone forever.

| Benefit | Explanation |
|---------|-------------|
| Safety | Undo mistakes with **Restore** |
| Store stays clean | Trashed items are hidden from customers immediately |
| Control | **Permanent delete** only when you are sure |

---

## Moving items to trash

### Products

1. Go to **Admin → Products**.
2. Row menu **⋮ → Move to Trash**.
3. Read the confirmation dialog:
   - Title: **Move product to trash?**
   - Explains the product will be hidden from the store
4. Click **Move to Trash** to confirm, or **Cancel** to go back.

### Categories

1. Go to **Admin → Categories**.
2. Open category detail or use card actions.
3. Click **Move to Trash** and confirm.

**Note:** Categories with products still assigned **cannot** be trashed. Remove or reassign products first.

---

## Viewing trash

### Products

1. **Admin → Products**
2. Status filter → **Trash**
3. Click **Filter**

You see all trashed products with an **In Trash** badge.

### Categories

1. **Admin → Categories**
2. Filter dropdown → **Trash**
3. Click **Filter**

---

## Restoring items

1. Open the **Trash** filter (steps above).
2. For the item you want back:
   - **Products:** ⋮ menu → **Restore**
   - **Categories:** **Restore** button on card or detail drawer
3. Item returns to the normal list and appears on the store (if Active).

No confirmation needed for restore—it is a safe action.

---

## Deleting permanently

Use only when you are **certain** the item should never come back.

1. Open **Trash** filter.
2. Choose **Delete Permanently** (products menu or category button).
3. Confirm in the dialog:
   - Warns that **images will be removed**
   - **Cannot be undone**

After permanent delete, the item and its uploaded images are removed from the system.

---

## Confirmation dialogs

Empire.pk uses **styled confirmation popups** in admin (not the browser’s plain “OK/Cancel” box).

| Button | Meaning |
|--------|---------|
| **Cancel** | Nothing happens; close dialog |
| **Move to Trash** | Soft delete |
| **Delete Permanently** | Hard delete with file removal |

Always read the message before confirming.

---

## What customers see

| Your action | Storefront |
|-------------|------------|
| Move to Trash | Item hidden immediately |
| Restore | Item visible again (if Active) |
| Delete Permanently | Item gone forever |

---

## Common questions

**I deleted a product by mistake.**  
Open Products → filter **Trash** → **Restore**.

**Can I trash a category that has products?**  
No. Move products to another category or trash products first.

**Does trash free up the SKU or slug?**  
Trashed items still hold their SKU/slug internally. Permanent delete frees them for reuse.

**Are brands in trash?**  
Not yet—brand delete is still immediate. Be careful when deleting brands.

---

## Best practice

1. **Move to Trash** for day-to-day removals.
2. Review trash periodically.
3. **Delete Permanently** only for old junk you will never need.
4. Keep backups of important product images outside the system if they are irreplaceable.
