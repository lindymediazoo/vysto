<?php $old = $old ?? []; ?>
<article class="wrap prose">
    <h1>Our contact details</h1>
    <div class="contact-cards">
        <section>
            <h2>Call centre</h2>
            <p><a href="tel:+27214932600">+27 21 493 2600</a></p>
        </section>
        <section>
            <h2>Head office</h2>
            <p>Trumali House<br>Trumali Street<br>Harringtons Place<br>Stellenbosch, 7600<br>South Africa</p>
        </section>
        <section>
            <h2>Share your feedback</h2>
            <p><a href="https://www.hungrylion.review">hungrylion.review</a></p>
        </section>
    </div>
    <h2>Send a message</h2>
    <?php foreach (($errors ?? []) as $error): ?>
        <p class="form-error"><?= e($error) ?></p>
    <?php endforeach; ?>
    <form class="stack-form" method="post" action="/contact">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <label class="hp">Website <input name="website" tabindex="-1" autocomplete="off"></label>
        <label>Name <input name="name" required maxlength="120" value="<?= e($old['name'] ?? '') ?>"></label>
        <label>Email <input name="email" type="email" required maxlength="160" value="<?= e($old['email'] ?? '') ?>"></label>
        <label>Phone <input name="phone" maxlength="40" value="<?= e($old['phone'] ?? '') ?>"></label>
        <label>Message <textarea name="message" required maxlength="4000" rows="6"><?= e($old['message'] ?? '') ?></textarea></label>
        <button class="btn" type="submit">Send</button>
    </form>
</article>
