<article class="wrap meal">
    <p class="crumb"><a href="/menu/<?= e($meal['section_slug']) ?>"><?= e($meal['section_title']) ?></a></p>
    <div class="meal-layout">
        <img src="<?= e($meal['image']) ?>" alt="<?= e($meal['title']) ?>" width="800" height="800">
        <div>
            <h1><?= e($meal['title']) ?></h1>
            <?php if ($meal['price_label'] !== ''): ?>
                <p class="meal-price big"><?= e($meal['price_label']) ?></p>
            <?php endif; ?>
            <?php if ($meal['description'] !== ''): ?>
                <p class="lede"><?= e($meal['description']) ?></p>
            <?php endif; ?>
            <p>Ask for this in any Hungry Lion store in Namibia. Availability and price can differ by restaurant.</p>
            <p class="cta-row">
                <a class="btn" href="https://stores.hungrylion.co.na/">Find a store</a>
                <a class="btn btn-dark" href="/delivery">Order online</a>
            </p>
        </div>
    </div>
</article>
