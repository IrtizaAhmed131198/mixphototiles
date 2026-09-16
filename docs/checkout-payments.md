# Checkout payment safeguards

## Behavior

A complete pending website order, order items and delivery address are committed before the Razorpay checkout opens. Validation or persistence failure returns an error and does not expose a payable Razorpay order to the browser. Checkout totals are recalculated from database product prices, quantities, active coupon records and shipping settings; the displayed checkout total uses the same calculation.

The saved website order ID is sent in Razorpay receipt/notes and its Razorpay order ID is persisted in the database. Server-side signature verification uses that stored ID. The fetched payment must match the order amount, INR currency and saved Razorpay order ID. Before an authorized payment is captured, the payment ID is committed and complete order details are checked. A captured payment then marks the existing order paid. Duplicate confirmations do not create orders or reset a later fulfillment status.

Signed payment webhooks recover confirmation without the customer's browser session. API timeouts after capture are resolved by fetching payment state. Failed reconciliation returns HTTP 503 so Razorpay can retry. Email errors do not undo a paid order. Existing orders and manually recovered orders are not changed by the migration.

## Deploy before testing

1. Back up the live database. Deploy all changed files together, including app/Services/CheckoutService.php and the new migration.
2. Run `php artisan migrate --force`, followed by `php artisan optimize:clear`. The new fields must exist before accepting checkout requests. Use maintenance mode during deployment if necessary.
3. Set `RAZORPAY_WEBHOOK_SECRET` in the live environment to the secret you configure in Razorpay. Keep it private. Refresh configuration cache after setting it.
4. Configure the live Razorpay webhook URL as `https://magnetickphotoframes.com/razorpay/webhook` and subscribe to `payment.authorized`, `payment.captured`, and `order.paid`. The webhook is exempt from browser CSRF but requires a valid HMAC signature.
5. Set Razorpay payment capture to **manual capture** so this application can validate and persist the payment link before requesting capture. With dashboard auto-capture enabled, Razorpay may capture before the application performs that check. Bank authorization can still produce a debit/hold; manual capture cannot guarantee no temporary deduction.
6. Use Razorpay test keys first. Then test a dedicated INR 1 order with its saved total and Razorpay amount both INR 1 (100 paise). Do not change a real customer order or hardcode only the gateway amount. The integration rejects mismatched amounts.

Verify: complete order/address/items before opening checkout; a failed preparation does not open checkout; capture creates paid_at and payment_id on the same order; browser closure is recovered by the webhook; repeated confirmation has no duplicate order/items.

## Limits and operational notes

There is no distributed transaction between Razorpay and the website database. After capture, a database outage cannot undo the bank transaction synchronously; the durable pending order/payment link and signed webhook retries allow reconciliation. Do not tell a customer to pay again while confirmation is pending.

Preparation creates inactive guest accounts and sends their verification OTP before payment; retries of the same session reuse the pending order. Cancelling the Razorpay popup leaves the complete pending order visible to admins. The removed APP_VERIFY local bypass is replaced by proper Razorpay test keys.

The existing cart/design cleanup can delete products and image files. Broader cart/edit protections were rejected by automatic approval review and are not included in this change. Avoid editing/deleting cart products or image files while checkout is pending; these need separate protection before claiming immutable order designs. Pending records are intentionally retained for support/recovery.

The captured confirmation clears the cart/address/coupon session values, but does not delete upload files or session-image records. OTP and order emails are best effort; a failed email is logged, and webhook retries do not resend a successfully processed payment notification.

## Local verification

`php -d extension=pdo_sqlite -d extension=sqlite3 vendor/phpunit/phpunit/phpunit --filter CheckoutSafetyTest`

The tests use only an isolated in-memory SQLite database and explicit SDK doubles; they do not run the project's migrations against the local/live database or charge money.
