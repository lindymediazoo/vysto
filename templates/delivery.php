<article class="wrap prose">
    <h1>Delivery partners</h1>
    <p>Order Hungry Lion in Namibia through these partners. Delivery areas and fees are set by the partner, not in the restaurant.</p>
    <div class="partner-grid">
        <?php foreach ($partners as $partner): ?>
            <a class="partner" href="<?= e($partner['url']) ?>">
                <img src="<?= e($partner['image']) ?>" alt="<?= e($partner['name']) ?>">
                <span><?= e($partner['name']) ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</article>
