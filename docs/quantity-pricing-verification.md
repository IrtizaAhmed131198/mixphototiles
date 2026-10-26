# Quantity ladder verification

Version: `quantity-ladder-2026-10-26`.

Prices and per-size floors come from the supplied Indian and European workbooks.
The actual discount cells O5:O9/B14 are authoritative: 0%, 2%, 3%, 5%, 10%
at quantities 1, 2, 3–5, 6–9, 10+. The inconsistent B13 labels and the European
H5 hardcoded 355 are not used. Each unit is rounded to two decimals after
MAX(retail × (1 − discount), size floor). Shipping is 80 for 1–2 units,
zero for an empty cart or 3+ units. Quantities include all frames in the order.
Unlisted products retain their stored price without an automatic discount.
Existing finish/LED charges are added to both retail and floor.

## Deploy

Deploy the changed PHP, JavaScript and Blade files together on master, then run
`php artisan optimize:clear`. No database migration is needed. Start a new
incognito session and hard-refresh to load the updated JavaScript.

## Customer checks (no coupon, gift wrap, or paid add-ons)

| Collection / size | Quantity | Product total | Shipping | Final total |
|---|---:|---:|---:|---:|
| Indian 8x8 | 1 | 294.00 | 80 | 374.00 |
| Indian 8x8 | 2 | 576.24 | 80 | 656.24 |
| Indian 8x8 | 3 | 858.00 | 0 | 858.00 |
| Indian 8x8 | 6 | 1716.00 | 0 | 1716.00 |
| Indian 8x8 | 10 | 2860.00 | 0 | 2860.00 |
| European 8x11 | 4 | 1897.32 | 0 | 1897.32 |
| Indian 8x8 + Indian 12x18 | 1 each | 1002.54 | 80 | 1082.54 |

Compare the designer bundle/grand total, cart, order summary, and Razorpay popup.
The designer Item Price is the average unit price; individual mixed-size cart
items keep their own prices. Remove a frame from a 3-frame cart and confirm
the 2-item tier and 80 shipping return. Opening Razorpay creates a pending order;
payment is not required to compare the displayed payable amount.

In the same browser session, open `/get-grand-total` (or inspect that request in
DevTools Network). The `pricing` object must include the version above, quantity,
discount, individual item_prices, subtotal, shipping, saving and total. This proves
which server calculation is serving the designer; also compare cart and checkout.

Local regression check:
`php vendor/phpunit/phpunit/phpunit --filter "QuantityLadderTest|CheckoutSafetyTest"`
