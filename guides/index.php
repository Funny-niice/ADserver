<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/content.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'Player Guides',
    'description' => 'Browse practical Tiny Heroes Tap guides for first runs, upgrades, bosses, offline rewards, and rebirth.',
    'canonical' => '/guides/',
    'section' => 'guides',
    'allow_ads' => false,
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <div class="container">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Guides'],
        ]); ?>
        <h1>Tiny Heroes Tap player guides</h1>
        <p>Tiny Heroes Tap combines direct taps, automatic hero attacks, gold upgrades, timed bosses, offline earnings, and rebirth. These guides separate those systems so you can answer the question in front of you without following a rigid build. New players can learn how a run develops from the first enemy to the first boss. Returning players can compare tap damage with hero DPS, prepare for a countdown, or decide how to use gold collected while away. The rebirth guide explains exactly what resets and what remains before you make that choice. Every article uses the current 200-stage rules and links back to the game, while the shorter summaries below help you choose a useful starting point. If several topics apply, begin with the beginner guide, then move to upgrading or boss preparation when progress slows.</p>
        <?php render_card_grid($guides, 'guide-grid'); ?>
        <p><a href="/play/">Play Tiny Heroes Tap</a> when you are ready to put a guide into practice.</p>
    </div>
</main>
<?php render_footer(); ?>
