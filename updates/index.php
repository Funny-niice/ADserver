<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'Updates',
    'description' => 'Read factual updates about the Tiny Heroes Tap official website and its manually maintained player content.',
    'canonical' => '/updates/',
    'section' => 'updates',
    'allow_ads' => false,
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Updates'],
        ]); ?>
        <h1>Site updates</h1>
        <p>This page records published changes to the official Tiny Heroes Tap site. It does not promise a fixed release schedule.</p>

        <section aria-labelledby="official-site-content-redesign">
            <h2 id="official-site-content-redesign">Official site content redesign</h2>
            <p><time datetime="2026-07-13">2026-07-13</time></p>
            <p>The official site was reorganized around the playable browser game and manually maintained player content. The redesign adds shared navigation, game and progression references, focused guides, a frequently asked questions page, and publisher, contact, privacy, and terms information.</p>
        </section>
    </article>
</main>
<?php render_footer(); ?>
