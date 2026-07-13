<?php
declare(strict_types=1);

http_response_code(404);

require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/render.php';

$page = [
    'title' => 'Page Not Found',
    'description' => 'The requested Tiny Heroes Tap page could not be found. Return to the game, player guides, or frequently asked questions.',
    'canonical' => '/404.php',
    'section' => 'error',
    'allow_ads' => false,
    'robots' => 'noindex,follow',
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <h1>Page not found</h1>
        <p>The requested page does not exist or may have moved. Choose a destination below to continue exploring Tiny Heroes Tap.</p>
        <nav aria-label="Page not found help">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/guides/">Guides</a></li>
                <li><a href="/faq/">FAQ</a></li>
                <li><a href="/play/">Play</a></li>
            </ul>
        </nav>
    </article>
</main>
<?php render_footer(); ?>
