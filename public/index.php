<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$path = rtrim($path, '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($path === '/') {
    render('home', [
        'title' => 'Hungry Lion Namibia | Fried Chicken, Burgers & Buckets',
        'description' => "Hungry Lion Namibia serves Africa's best-loved fried chicken, burgers, buckets and value meals. See the menu and prices, find a store and order online.",
        'slides' => catalog()['slides'],
        'sections' => sections(),
    ]);
    return;
}

if ($path === '/menu') {
    $query = trim((string) ($_GET['q'] ?? ''));
    if (strlen($query) > 80) {
        $query = substr($query, 0, 80);
    }
    render('menu', [
        'title' => 'Menu & Prices | Hungry Lion Namibia',
        'description' => 'Namibia menu and prices for chicken meals, family meals, buckets, winglets, burgers, chicken fingers, sides, desserts and drinks.',
        'sections' => sections(),
        'active' => null,
        'query' => $query,
    ]);
    return;
}

if (preg_match('#^/menu/([a-z0-9-]+)$#', $path, $match) === 1) {
    $section = find_section($match[1]);
    if ($section === null) {
        http_response_code(404);
        render('missing', [
            'title' => 'Menu section not found | Hungry Lion Namibia',
        ]);
        return;
    }
    render('menu', [
        'title' => $section['title'] . ' | Hungry Lion Namibia',
        'description' => $section['title'] . ' on the Hungry Lion Namibia menu, with prices in Namibian dollars.',
        'sections' => sections(),
        'active' => $section['slug'],
        'query' => '',
    ]);
    return;
}

if (preg_match('#^/meal/([a-z0-9-]+)$#', $path, $match) === 1) {
    $meal = find_meal($match[1]);
    if ($meal === null) {
        http_response_code(404);
        render('missing', [
            'title' => 'Meal not found | Hungry Lion Namibia',
        ]);
        return;
    }
    $blurb = $meal['description'] !== '' ? $meal['description'] : $meal['title'];
    render('meal', [
        'title' => $meal['title'] . ' | Hungry Lion Namibia',
        'description' => $blurb . ($meal['price_label'] !== '' ? ' ' . $meal['price_label'] : ''),
        'meal' => $meal,
    ]);
    return;
}

if ($path === '/about') {
    render('about', [
        'title' => 'About Us | Hungry Lion Namibia',
        'description' => 'Hungry Lion started in Stellenbosch in 1997 and opened in Namibia in 1998. Fried chicken, wings, burgers and chips across Africa.',
    ]);
    return;
}

if ($path === '/contact') {
    if ($method === 'POST') {
        handle_contact();
    }
    render('contact', [
        'title' => 'Contact Us | Hungry Lion Namibia',
        'description' => 'Call the Hungry Lion contact centre, write to head office in Stellenbosch, or send a message.',
        'flash' => flash(),
        'errors' => [],
    ]);
    return;
}

if ($path === '/africa') {
    render('africa', [
        'title' => 'Hungry Lion in Africa',
        'description' => 'Hungry Lion restaurants in South Africa, Namibia, Zambia, Botswana, Eswatini, Angola, Lesotho, Zimbabwe and Mauritius.',
    ]);
    return;
}

if ($path === '/jobs') {
    render('jobs', [
        'title' => 'Work at Hungry Lion',
        'description' => 'General worker and store roles at Hungry Lion. Apply online.',
    ]);
    return;
}

if ($path === '/delivery') {
    render('delivery', [
        'title' => 'Delivery Partners | Hungry Lion Namibia',
        'description' => 'Order Hungry Lion in Namibia through Dial-a-Meal and Buddy.',
        'partners' => catalog()['partners'],
    ]);
    return;
}

if ($path === '/donation-request') {
    if ($method === 'POST') {
        handle_donation();
    }
    render('donation', [
        'title' => 'Donation Request | Hungry Lion Namibia',
        'description' => 'Request a Hungry Lion donation for a community event.',
        'flash' => flash(),
    ]);
    return;
}

if ($path === '/legal') {
    render('legal', [
        'title' => 'Legal | Hungry Lion Namibia',
        'description' => 'Company information and terms of use for the Hungry Lion Namibia website.',
    ]);
    return;
}

http_response_code(404);
render('missing', [
    'title' => 'Page not found | Hungry Lion Namibia',
]);

function handle_contact(): never
{
    if (!csrf_ok() || trim((string) ($_POST['website'] ?? '')) !== '') {
        http_response_code(400);
        render('contact', [
            'title' => 'Contact Us | Hungry Lion Namibia',
            'description' => 'Call the Hungry Lion contact centre or send a message.',
            'flash' => null,
            'errors' => ['This form could not be submitted. Refresh the page and try again.'],
        ]);
        exit;
    }

    $name = field('name', 120);
    $email = field('email', 160);
    $phone = field('phone', 40);
    $message = field('message', 4000);
    $errors = [];
    if ($name === '') {
        $errors[] = 'Add your name.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Add a valid email address.';
    }
    if (strlen($message) < 8) {
        $errors[] = 'Add a short message.';
    }
    if ($errors !== []) {
        http_response_code(422);
        render('contact', [
            'title' => 'Contact Us | Hungry Lion Namibia',
            'description' => 'Call the Hungry Lion contact centre or send a message.',
            'flash' => null,
            'errors' => $errors,
            'old' => compact('name', 'email', 'phone', 'message'),
        ]);
        exit;
    }

    append_record('contact.jsonl', [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'message' => $message,
    ]);
    flash('Thanks, ' . $name . '. Your message is saved for the Hungry Lion team.');
    redirect('/contact');
}

function handle_donation(): never
{
    if (!csrf_ok() || trim((string) ($_POST['website'] ?? '')) !== '') {
        http_response_code(400);
        exit('This form could not be submitted.');
    }

    $organisation = field('organisation', 160);
    $contact = field('contact_name', 120);
    $email = field('email', 160);
    $phone = field('phone', 40);
    $event = field('event', 200);
    $date = field('event_date', 20);
    $details = field('details', 4000);
    $errors = [];
    if ($organisation === '' || $contact === '') {
        $errors[] = 'Add the organisation and a contact name.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Add a valid email address.';
    }
    if ($event === '' || strlen($details) < 8) {
        $errors[] = 'Describe the event and what you are asking for.';
    }
    $when = DateTimeImmutable::createFromFormat('Y-m-d', $date);
    $dateOk = $when instanceof DateTimeImmutable && $when->format('Y-m-d') === $date;
    if (!$dateOk) {
        $errors[] = 'Add the event date.';
    } elseif ($date >= '2026-11-24' && $date <= '2027-01-06') {
        $errors[] = 'Donation requests for events from 24 November 2026 to 6 January 2027 are not being accepted.';
    }

    if ($errors !== []) {
        http_response_code(422);
        render('donation', [
            'title' => 'Donation Request | Hungry Lion Namibia',
            'description' => 'Request a Hungry Lion donation for a community event.',
            'flash' => null,
            'errors' => $errors,
            'old' => [
                'organisation' => $organisation,
                'contact_name' => $contact,
                'email' => $email,
                'phone' => $phone,
                'event' => $event,
                'event_date' => $date,
                'details' => $details,
            ],
        ]);
        exit;
    }

    append_record('donations.jsonl', [
        'organisation' => $organisation,
        'contact_name' => $contact,
        'email' => $email,
        'phone' => $phone,
        'event' => $event,
        'event_date' => $date,
        'details' => $details,
    ]);
    flash('Request received. The team will read it and reply if they can help.');
    redirect('/donation-request');
}
