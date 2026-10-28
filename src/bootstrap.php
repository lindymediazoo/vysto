<?php

declare(strict_types=1);

session_start();

const ROOT = __DIR__ . '/..';

function catalog(): array
{
    static $data = null;
    if ($data === null) {
        $json = file_get_contents(ROOT . '/data/catalog.json');
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }
    return $data;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function sections(): array
{
    return catalog()['sections'];
}

function find_section(string $slug): ?array
{
    foreach (sections() as $section) {
        if ($section['slug'] === $slug) {
            return $section;
        }
    }
    return null;
}

function find_meal(string $slug): ?array
{
    foreach (sections() as $section) {
        foreach ($section['items'] as $item) {
            if ($item['slug'] === $slug) {
                $item['section_slug'] = $section['slug'];
                $item['section_title'] = $section['title'];
                return $item;
            }
        }
    }
    return null;
}

function all_meals(): array
{
    $meals = [];
    foreach (sections() as $section) {
        foreach ($section['items'] as $item) {
            $item['section_slug'] = $section['slug'];
            $item['section_title'] = $section['title'];
            $meals[] = $item;
        }
    }
    return $meals;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_ok(): bool
{
    $sent = (string) ($_POST['csrf'] ?? '');
    $known = (string) ($_SESSION['csrf'] ?? '');
    return $sent !== '' && $known !== '' && hash_equals($known, $sent);
}

function flash(?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'] = $message;
        return null;
    }
    $current = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return is_string($current) ? $current : null;
}

function redirect(string $to): never
{
    header('Location: ' . $to);
    exit;
}

function append_record(string $file, array $row): void
{
    $dir = ROOT . '/storage';
    if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
        throw new RuntimeException('Could not store the submission.');
    }
    $row['received_at'] = gmdate('c');
    $line = json_encode($row, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) . "\n";
    file_put_contents($dir . '/' . $file, $line, FILE_APPEND | LOCK_EX);
}

function field(string $key, int $max): string
{
    $value = trim((string) ($_POST[$key] ?? ''));
    if (strlen($value) > $max) {
        $value = substr($value, 0, $max);
    }
    return $value;
}

function render(string $view, array $data = []): void
{
    $title = $data['title'] ?? 'Hungry Lion Namibia';
    $description = $data['description'] ?? 'Fried chicken, burgers, buckets and value meals across Namibia.';
    $viewFile = ROOT . '/templates/' . $view . '.php';
    extract($data, EXTR_SKIP);
    ob_start();
    require $viewFile;
    $content = ob_get_clean();
    require ROOT . '/templates/layout.php';
}

function price_text(array $item): string
{
    $label = trim((string) ($item['price_label'] ?? ''));
    return $label;
}
