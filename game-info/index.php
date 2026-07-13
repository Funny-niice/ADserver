<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'Game Information',
    'description' => 'Read the current Tiny Heroes Tap game facts: format, stages, heroes, gold, bosses, offline rewards, optional ads, and rebirth.',
    'canonical' => '/game-info/',
    'section' => 'game-info',
    'allow_ads' => false,
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Game Information'],
        ]); ?>
        <h1>About the Tiny Heroes Tap game</h1>
        <p>Tiny Heroes Tap is a portrait tap-and-idle RPG for the web. Its core loop combines active tapping, automatic hero attacks, gold upgrades, boss battles, offline rewards, and rebirth. The game is designed around short interactions that can grow into a longer run, with direct player input and automatic damage remaining distinct.</p>

        <h2>Format and progression</h2>
        <p>A complete run contains 200 stages across ten named realms. Normal encounters use a roster of 20 monster types, and a boss appears every fifth stage. Ten named bosses repeat through those milestones, each with its own base timer. The portrait layout keeps the current enemy, party progress, and upgrade choices suited to an upright play area on supported mobile or desktop browsers.</p>

        <h2>The six-character roster</h2>
        <p>The Swordsman is the main hero and deals player-controlled tap damage from stage 1. Five companions add automatic DPS in sequence: Archer at stage 5, Mage at 10, Paladin at 15, Rogue at 22, and Priest at 35. These unlock stages make characters available during a run. Rebirth later resets companion unlocks and hero levels, so the roster is assembled again.</p>

        <h2>Gold and damage</h2>
        <p>Defeated enemies provide gold for upgrades within the current run. Swordsman improvements support active tap damage, while companion improvements support automatic hero DPS. Those sources work together during battle but are not interchangeable. Players can watch ordinary clear speed and remaining boss health to decide where the next purchase is useful instead of following a required percentage split.</p>

        <h2>Bosses and optional rewarded ads</h2>
        <p>Boss encounters ask the party to deal enough damage before the displayed countdown ends. A failed attempt does not remove held gold. During a boss battle, optional rewarded ads can offer one 15-second extension per battle. The choice is voluntary. Players can continue earning, upgrade the team, and defeat bosses through ordinary preparation without using the extension.</p>

        <h2>Offline rewards</h2>
        <p>When a player returns after eligible time away, automatic hero DPS contributes to the base offline reward. The simulation can move through normal encounters but does not defeat a boss, so a boss milestone can stop further stage progress. A voluntary rewarded-ad choice may double the displayed return reward; declining it leaves the base earned reward available.</p>

        <h2>Rebirth</h2>
        <p>Rebirth becomes available at stage 20, and stage 25 is the recommended first checkpoint. It resets stage progress, the Swordsman’s level, companion levels, and companion unlocks while retaining held gold. Each rebirth adds a permanent 5% bonus to main-hero tap damage, not hero DPS, with a maximum of 100 rebirths.</p>

        <p>New players can continue with the <a href="/guides/beginners-guide/">beginner’s guide</a>, compare every name in the <a href="/heroes/">hero reference</a>, or <a href="/play/">play Tiny Heroes Tap</a>.</p>
    </article>
</main>
<?php render_footer(); ?>
