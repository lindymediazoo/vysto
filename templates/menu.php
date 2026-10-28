<?php
$visible = [];
foreach ($sections as $section) {
    if ($active !== null && $section['slug'] !== $active) {
        continue;
    }
    $items = $section['items'];
    if ($query !== '') {
        $needle = mb_strtolower($query);
        $items = array_values(array_filter($items, static function (array $item) use ($needle): bool {
            $hay = mb_strtolower($item['title'] . ' ' . $item['description']);
            return str_contains($hay, $needle);
        }));
    }
    if ($items === [] && $query !== '') {
        continue;
    }
    $copy = $section;
    $copy['items'] = $items;
    $visible[] = $copy;
}
?>
<section class="wrap menu-page">
    <h1><?= $active ? e($visible[0]['title'] ?? 'Menu') : 'Menu' ?></h1>
    <form class="search" method="get" action="/menu">
        <label class="sr" for="q">Search the menu</label>
        <input id="q" name="q" value="<?= e($query) ?>" placeholder="Search chicken, burgers, wings…" maxlength="80">
        <button class="btn" type="submit">Search</button>
    </form>
    <nav class="chips" aria-label="Menu categories">
        <a class="<?= $active === null && $query === '' ? 'is-on' : '' ?>" href="/menu">All</a>
        <?php foreach ($sections as $section): ?>
            <a class="<?= $active === $section['slug'] ? 'is-on' : '' ?>" href="/menu/<?= e($section['slug']) ?>"><?= e($section['title']) ?></a>
        <?php endforeach; ?>
    </nav>

    <?php if ($visible === []): ?>
        <p class="empty">Nothing on the menu matches “<?= e($query) ?>”.</p>
    <?php endif; ?>

    <?php foreach ($visible as $section): ?>
        <section class="menu-block" id="<?= e($section['slug']) ?>">
            <?php if ($active === null): ?>
                <h2><a href="/menu/<?= e($section['slug']) ?>"><?= e($section['title']) ?></a></h2>
            <?php endif; ?>
            <div class="meal-grid">
                <?php foreach ($section['items'] as $item): ?>
                    <a class="meal-card" href="/meal/<?= e($item['slug']) ?>">
                        <span class="meal-name"><?= e($item['title']) ?></span>
                        <img src="<?= e($item['image']) ?>" alt="<?= e($item['title']) ?>" width="600" height="600">
                        <span class="meal-price"><?= e(price_text($item)) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>
</section>
