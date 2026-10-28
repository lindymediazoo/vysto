<?php

declare(strict_types=1);

$brand = catalog()['brand'];
$flashMessage = $flash ?? flash();
?>
<!doctype html>
<html lang="en-NA">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($description) ?>">
    <link rel="icon" href="<?= e($brand['favicon']) ?>" sizes="32x32">
    <link rel="icon" href="<?= e($brand['icon']) ?>" sizes="192x192">
    <link rel="apple-touch-icon" href="<?= e($brand['icon']) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<a class="skip" href="#content">Skip to content</a>
<header class="site-header">
    <button class="icon-btn" type="button" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
        <span class="sr">Open menu</span>
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3.5 7.5h17a1.5 1.5 0 0 0 0-3h-17a1.5 1.5 0 0 0 0 3zm17 3h-17a1.5 1.5 0 0 0 0 3h17a1.5 1.5 0 0 0 0-3zm0 6h-17a1.5 1.5 0 0 0 0 3h17a1.5 1.5 0 0 0 0-3z"/></svg>
    </button>
    <a class="logo" href="/">
        <img src="<?= e($brand['logo']) ?>" alt="Hungry Lion" width="1505" height="280">
    </a>
    <a class="icon-btn store-pin" href="https://stores.hungrylion.co.na/" aria-label="Find a store">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.2A7.3 7.3 0 0 0 4.7 9.5c0 5.4 6.4 11.7 6.7 12 .2.2.4.3.6.3s.4-.1.6-.3c.3-.3 6.7-6.6 6.7-12A7.3 7.3 0 0 0 12 2.2zm0 9.9a2.7 2.7 0 1 1 0-5.4 2.7 2.7 0 0 1 0 5.4z"/></svg>
    </a>
</header>
<nav id="site-nav" class="drawer" hidden>
    <ul>
        <li><a href="/menu">Our Menu</a></li>
        <li><a href="https://stores.hungrylion.co.na/">Find a Store</a></li>
        <li><a href="/delivery">Order Online</a></li>
        <li><a href="/about">About Us</a></li>
        <li><a href="/africa">Africa</a></li>
        <li><a href="/jobs">Work for Us</a></li>
        <li><a href="/donation-request">Donation Requests</a></li>
        <li><a href="/contact">Contact Us</a></li>
        <li><a href="/legal">Legal</a></li>
    </ul>
</nav>
<main id="content">
    <?php if (is_string($flashMessage) && $flashMessage !== ''): ?>
        <p class="flash" role="status"><?= e($flashMessage) ?></p>
    <?php endif; ?>
    <?= $content ?>
</main>
<footer class="site-footer">
    <img class="crown" src="<?= e($brand['crown']) ?>" alt="" width="80" height="88">
    <a class="footer-logo" href="/">
        <img src="<?= e($brand['logo_footer']) ?>" alt="Hungry Lion" width="500" height="54">
    </a>
    <div class="footer-grid">
        <div>
            <h2>Hungry Lion</h2>
            <ul>
                <li><a href="/menu">Our Menu</a></li>
                <li><a href="https://stores.hungrylion.co.na/">Find a Store</a></li>
                <li><a href="/about">About Us</a></li>
                <li><a href="/africa">Africa</a></li>
                <li><a href="/contact">Contact Us</a></li>
            </ul>
        </div>
        <div>
            <h2>Work for us</h2>
            <ul>
                <li><a href="/jobs">General Workers</a></li>
                <li><a href="https://hungrylion.applytojob.com/apply">HQ &amp; Store Management</a></li>
                <li><a href="/donation-request">Donation Requests</a></li>
                <li><a href="/legal">Legal</a></li>
                <li><a href="/media/brand/namibia-menu.pdf">Downloadable menu (PDF)</a></li>
            </ul>
        </div>
        <div>
            <h2>Stay in touch</h2>
            <p><a href="tel:+27214932600">+27 21 493 2600</a></p>
            <p class="socials">
                <a href="https://www.facebook.com/HungryLionNA/">Facebook</a>
                <a href="https://www.instagram.com/hungrylion_namibia/">Instagram</a>
                <a href="https://www.linkedin.com/company/hungrylion/">LinkedIn</a>
            </p>
        </div>
    </div>
    <p class="fine">Prices shown are Namibia menu prices in N$ and can change in store. © <?= date('Y') ?> Hungry Lion.</p>
</footer>
<script src="/assets/js/app.js"></script>
</body>
</html>
