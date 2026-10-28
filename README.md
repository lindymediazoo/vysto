# Hungry Lion Namibia

PHP site for [hungrylion.co.na](https://hungrylion.co.na): home, Namibia menu and prices, meal pages, about, Africa, jobs, delivery partners, contact, donation requests, and legal.

Menu prices and product photos were taken from the public WordPress site. Prices are Namibian dollars and can change in store.

## Run

```bash
php -S localhost:8080 -t public public/router.php
```

Apache and similar servers should use `public/` as the document root. `public/.htaccess` sends other requests to `index.php`.

Contact and donation forms append JSON lines to `storage/contact.jsonl` and `storage/donations.jsonl`. Those files are not committed. Point the host at a mailbox or CRM if the messages need to leave the server.

## Pages

- `/` home and promotions
- `/menu` and `/menu/{category}`
- `/meal/{slug}`
- `/about`, `/africa`, `/jobs`, `/delivery`, `/contact`, `/donation-request`, `/legal`
