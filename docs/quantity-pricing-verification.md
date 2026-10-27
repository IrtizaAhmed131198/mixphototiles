# Dynamic size pricing verification

Version: `dynamic-size-ladder-2026-10-27`.

Retail prices come from active rows in the Sizes table, matched by collection
and size label. Adding a size or changing its price in admin requires no code
change. Saved browser prices and Excel example prices do not override Sizes.
Indian frames use the indian_floor_price setting; European and Luxury Tiles
use floor_price. A floor limits discounts and never increases the retail price.

Quantity tiers: 1 = 0%, 2 = 2%, 3–5 = 3%, 6–9 = 5%, 10+ = 10%.
For multiple items: unit price = MIN(retail, MAX(retail × (1 - tier), floor)).
Finish/LED add-ons are added to retail and floor. Round each unit to 2 decimals.
Shipping: 80 for 1–2 frames; free for 3+. Quantities include all frames.
Inactive, missing or zero-priced selected sizes cannot be checked out.

## Live verification

Deploy all changed files together and run `php artisan optimize:clear`.
Start a fresh incognito session. Check current admin size prices and floor
settings first: live values can differ from local values.

With Indian 6x8 price 299 and Indian floor 295, no coupons or paid add-ons:

| Quantity | Product total | Shipping | Final total |
|---|---:|---:|---:|
| 1 | 299 | 80 | 379 |
| 2 | 590 | 80 | 670 |
| 3 | 885 | 0 | 885 |
| 6 | 1770 | 0 | 1770 |
| 10 | 2950 | 0 | 2950 |

For Indian 8x12 price 399 and floor 295, 2 frames cost
399 × 0.98 × 2 + 80 = 862.04.

Compare designer totals, cart, order summary, and Razorpay popup.
In the same session open `/get-grand-total`: pricing.version must equal the
version above; pricing includes quantity, discount, item_prices, subtotal,
shipping and total. Remove one frame from a three-frame cart and verify the
two-item discount and 80 shipping return.

Local regression check:
`php vendor/phpunit/phpunit/phpunit --filter "QuantityLadderTest|CheckoutSafetyTest"`
Tests use in-memory SQLite and cover new sizes, admin price changes, changed
floor settings, tier boundaries, mixed sizes and persisted checkout prices.
