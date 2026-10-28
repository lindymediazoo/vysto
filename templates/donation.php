<?php $old = $old ?? []; ?>
<article class="wrap prose">
    <h1>Donation request</h1>
    <p class="note">Donation requests for events taking place between 24 November 2026 and 6 January 2027 will not be accepted.</p>
    <?php foreach (($errors ?? []) as $error): ?>
        <p class="form-error"><?= e($error) ?></p>
    <?php endforeach; ?>
    <form class="stack-form" method="post" action="/donation-request">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <label class="hp">Website <input name="website" tabindex="-1" autocomplete="off"></label>
        <label>Organisation <input name="organisation" required maxlength="160" value="<?= e($old['organisation'] ?? '') ?>"></label>
        <label>Contact name <input name="contact_name" required maxlength="120" value="<?= e($old['contact_name'] ?? '') ?>"></label>
        <label>Email <input name="email" type="email" required maxlength="160" value="<?= e($old['email'] ?? '') ?>"></label>
        <label>Phone <input name="phone" maxlength="40" value="<?= e($old['phone'] ?? '') ?>"></label>
        <label>Event <input name="event" required maxlength="200" value="<?= e($old['event'] ?? '') ?>"></label>
        <label>Event date <input name="event_date" type="date" required value="<?= e($old['event_date'] ?? '') ?>"></label>
        <label>What you need <textarea name="details" required maxlength="4000" rows="6"><?= e($old['details'] ?? '') ?></textarea></label>
        <button class="btn" type="submit">Submit request</button>
    </form>
</article>
