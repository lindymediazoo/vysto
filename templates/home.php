<section class="hero" aria-roledescription="carousel" aria-label="Promotions">
    <div class="hero-track" data-hero>
        <?php foreach ($slides as $index => $slide): ?>
            <a class="hero-slide<?= $index === 0 ? ' is-active' : '' ?>" href="<?= e($slide['href']) ?>">
                <picture>
                    <source media="(max-width: 767px)" srcset="<?= e($slide['mobile']) ?>">
                    <img src="<?= e($slide['desktop']) ?>" alt="<?= e($slide['alt']) ?>" width="2000" height="400" <?= $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>>
                </picture>
            </a>
        <?php endforeach; ?>
    </div>
    <button class="hero-nav prev" type="button" data-hero-prev aria-label="Previous promotion">‹</button>
    <button class="hero-nav next" type="button" data-hero-next aria-label="Next promotion">›</button>
</section>

<section class="band">
    <div class="wrap">
        <h1>Our menu</h1>
        <p class="lede">Bigger chicken pieces, thick-cut chips, and meals made for sharing. Prices are in Namibian dollars.</p>
        <div class="cat-grid">
            <?php foreach ($sections as $section): ?>
                <?php $cover = $section['items'][0]['image'] ?? ''; ?>
                <a class="cat-card" href="/menu/<?= e($section['slug']) ?>">
                    <?php if ($cover !== ''): ?>
                        <img src="<?= e($cover) ?>" alt="" width="300" height="300">
                    <?php endif; ?>
                    <span><?= e($section['title']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
        <p class="cta-row">
            <a class="btn" href="/menu">See the full menu</a>
            <a class="btn btn-dark" href="https://stores.hungrylion.co.na/">Find a store</a>
            <a class="btn btn-ghost" href="/media/brand/namibia-menu.pdf">Download PDF</a>
        </p>
    </div>
</section>

<section class="split">
    <div>
        <h2>Join our team</h2>
        <p>Hungry Lion is hiring hardworking, energetic people for stores across Namibia.</p>
        <a class="btn" href="/jobs">Work for us</a>
    </div>
    <div>
        <h2>Order online</h2>
        <p>Get Hungry Lion delivered through Dial-a-Meal or Buddy.</p>
        <a class="btn btn-dark" href="/delivery">Delivery partners</a>
    </div>
</section>
