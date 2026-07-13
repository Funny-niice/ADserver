<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function escape_html($value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function canonical_url(string $path): string
{
    if ($path === '') {
        $path = '/';
    }

    return SITE_ORIGIN . '/' . ltrim($path, '/');
}

function render_header(string $title, string $description, string $canonicalPath): void
{
    $pageTitle = $title === SITE_NAME ? SITE_NAME : $title . ' | ' . SITE_NAME;
    $navigation = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Guides', 'url' => '/guides/'],
        ['label' => 'Heroes', 'url' => '/heroes/'],
        ['label' => 'Bosses', 'url' => '/bosses/'],
        ['label' => 'Worlds', 'url' => '/worlds/'],
        ['label' => 'FAQ', 'url' => '/faq/'],
        ['label' => 'Play', 'url' => GAME_CLIENT_PATH],
    ];
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= escape_html($pageTitle) ?></title>
    <meta name="description" content="<?= escape_html($description) ?>">
    <meta name="google-adsense-account" content="<?= escape_html(ADSENSE_PUBLISHER_ID) ?>">
    <link rel="canonical" href="<?= escape_html(canonical_url($canonicalPath)) ?>">
    <link rel="stylesheet" href="/assets/site.css">
    <script src="/assets/site.js" defer></script>
</head>
<body>
<a class="skip-link" href="#main-content">Skip to main content</a>
<header class="site-header" data-site-header>
    <div class="container header-inner">
        <a class="site-brand" href="/"><?= escape_html(SITE_NAME) ?></a>
        <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="site-navigation">
            <span class="sr-only">Toggle navigation</span>
            <span aria-hidden="true">Menu</span>
        </button>
        <nav class="site-nav" id="site-navigation" aria-label="Primary navigation">
            <ul>
                <?php foreach ($navigation as $item): ?>
                    <li><a href="<?= escape_html($item['url']) ?>"><?= escape_html($item['label']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</header>
<main class="site-main" id="main-content">
    <?php
}

function render_footer(): void
{
    $footerLinks = [
        ['label' => 'About', 'url' => '/about/'],
        ['label' => 'Contact', 'url' => '/contact/'],
        ['label' => 'Privacy', 'url' => '/privacy/'],
        ['label' => 'Terms', 'url' => '/terms/'],
        ['label' => 'Updates', 'url' => '/updates/'],
        ['label' => 'GitHub', 'url' => 'https://github.com/Funny-niice/ADserver'],
    ];
    ?>
</main>
<footer class="site-footer">
    <div class="container footer-inner">
        <p>&copy; <?= escape_html(date('Y')) ?> <?= escape_html(SITE_NAME) ?></p>
        <nav aria-label="Footer navigation">
            <ul>
                <?php foreach ($footerLinks as $item): ?>
                    <li><a href="<?= escape_html($item['url']) ?>"><?= escape_html($item['label']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</footer>
</body>
</html>
    <?php
}

function render_ad_slot(bool $pageEnabled = false): void
{
    if (!ADSENSE_DISPLAY_ENABLED || !$pageEnabled) {
        return;
    }
    ?>
<aside class="ad-slot" aria-label="Advertisement">
    <ins class="adsbygoogle"
         data-ad-client="<?= escape_html(ADSENSE_PUBLISHER_ID) ?>"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
</aside>
    <?php
}
