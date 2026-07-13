<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'Play Tiny Heroes Tap',
    'description' => 'Launch the Tiny Heroes Tap web game.',
    'canonical' => '/play/',
    'section' => 'play',
    'allow_ads' => false,
];

render_header($page);
?>
<main id="main-content" class="play-page">
    <div class="container">
        <h1>Play Tiny Heroes Tap</h1>
        <p>If the game does not load, <a href="<?= htmlspecialchars(GAME_CLIENT_PATH, ENT_QUOTES, 'UTF-8') ?>">open the client directly</a>.</p>
    </div>
    <iframe class="game-frame" src="<?= htmlspecialchars(GAME_CLIENT_PATH, ENT_QUOTES, 'UTF-8') ?>" title="Tiny Heroes Tap game client" allow="autoplay; fullscreen" style="display:block;width:100%;min-height:75vh;border:0"></iframe>
    <nav class="container" aria-label="Game help">
        <a href="/guides/beginners-guide/">Beginner’s guide</a>
        <a href="/guides/boss-battles/">Boss help</a>
        <a href="/contact/">Report a problem</a>
    </nav>
</main>
<?php render_footer(); ?>
