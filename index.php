<?php
declare(strict_types=1);

require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/content.php';
require __DIR__ . '/includes/render.php';

$page = [
    'title' => 'Tiny Heroes Tap — Official Game and Player Guides',
    'description' => 'Learn how Tiny Heroes Tap works, meet every hero, prepare for bosses, explore ten realms, and read practical player guides.',
    'canonical' => '/',
    'section' => 'home',
    'allow_ads' => false,
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <section class="container card-grid" aria-labelledby="home-title">
        <div>
            <p>Tiny Heroes Tap game and guide hub</p>
            <h1 id="home-title">Build a tiny team for a 200-stage sky adventure</h1>
            <p>Tiny Heroes Tap is an incremental web game about active tapping, automatic hero damage, careful upgrades, and timed boss fights. A run begins with the Swordsman under your control. Each tap adds direct damage while recruited companions keep attacking on their own. Coins earned in battle let the party grow stronger, and progress through later stages opens five additional heroes with distinct attack rhythms.</p>
            <p>This official hub explains the rules that matter during play without pretending there is only one correct upgrade path. Start the game when you are ready, or read the beginner guide first if you want a clear account of damage, stages, heroes, and the first progression decisions.</p>
            <p><a href="/play/">Play Tiny Heroes Tap</a> · <a href="/guides/beginners-guide/">Read the beginner guide</a></p>
        </div>
        <figure class="card">
            <img src="/assets/landing/ui_loading_screen.png" alt="Tiny Heroes Tap sky castle loading artwork" width="960" height="540" style="display:block;max-width:100%;height:auto">
            <figcaption>Artwork from the game client.</figcaption>
        </figure>
    </section>

    <section class="container" aria-labelledby="adventure-heading">
        <h2 id="adventure-heading">How the adventure works</h2>
        <p>The central loop is simple to learn, but each part affects the next. Active taps help clear the current enemy, automatic damage keeps the run moving when your attention shifts, and coins turn each victory into stronger future attacks.</p>
        <ol class="card-grid">
            <li class="card"><strong>Tap the current enemy.</strong> The Swordsman represents player-controlled tap damage. Tapping is especially useful when a normal enemy is nearly defeated or a boss countdown makes every second valuable.</li>
            <li class="card"><strong>Collect battle coins.</strong> Defeated enemies provide the currency used during a run. Spending those coins increases the damage available to the party instead of merely changing its appearance.</li>
            <li class="card"><strong>Upgrade and recruit.</strong> The Archer joins at stage 5, followed by the Mage at 10, Paladin at 15, Rogue at 22, and Priest at 35. Reaching an unlock stage is only the opportunity to add that hero; the run still needs enough coins to support upgrades.</li>
            <li class="card"><strong>Clear stages and bosses.</strong> The full route contains 200 stages, including 20 normal monster types and ten named bosses. Normal encounters allow steady progress, while a boss asks the team to deal enough damage before its individual timer expires.</li>
            <li class="card"><strong>Rebirth for later runs.</strong> Rebirth becomes available at stage 20, with stage 25 serving as the first recommended checkpoint. It resets stage and hero progress while keeping gold and adding 5% main-hero tap damage per rebirth. That bonus does not increase companion hero DPS, and the system caps at 100 rebirths.</li>
        </ol>
    </section>

    <section class="container" aria-labelledby="heroes-heading">
        <h2 id="heroes-heading">Meet the heroes</h2>
        <p>The party combines one active hero with five automatic attackers. Their stage requirements create a dependable order, but their roles are not identical. Tap upgrades matter directly to the Swordsman, while companion upgrades build the automatic damage that continues without constant input.</p>
        <div class="card-grid">
            <?php foreach ($heroes as $hero): ?>
                <article class="card">
                    <h3><?= escape_html($hero['name']) ?></h3>
                    <p><strong>Available from stage <?= escape_html((string) $hero['stage']) ?>.</strong> <?= escape_html($hero['role']) ?>. Consider what the current run needs before dividing coins between immediate tap strength and continuing automatic damage.</p>
                </article>
            <?php endforeach; ?>
        </div>
        <p><a href="/heroes/">See the complete hero reference</a> for the roster in one place.</p>
    </section>

    <section class="container" aria-labelledby="boss-heading">
        <h2 id="boss-heading">Boss battles</h2>
        <p>Bosses replace open-ended stage progress with a countdown. Entering one before the party is ready can expose a damage shortfall that was less obvious against normal monsters. A failed attempt is useful information: strengthen tap damage, improve automatic hero damage, or gather more coins before trying again. The game also offers an optional, one-time 15-second extension during a boss encounter, but a player can prepare and win without depending on that option.</p>
        <p>The ten timers are not arranged as a simple shortest-to-longest ladder. The Meadow Slime King allows 30 seconds, while the Cloud Gate Titan allows 22. The Mist Rune Colossus and Storm Bridge Roc each allow 25; the Star Tower Hydra and Moon Archive Golem each allow 28; the Thunder Forge Djinn and Frost Crown Beast each allow 31; and the Void Gate Dragon and Sky Throne Warden each allow 34. Check the actual opponent rather than assuming every later boss uses less time.</p>
        <p><a href="/guides/boss-battles/">Open the boss battles guide</a> for a preparation checklist, or <a href="/bosses/">compare all ten bosses</a>.</p>
    </section>

    <section class="container" aria-labelledby="realms-heading">
        <h2 id="realms-heading">Explore ten sky realms</h2>
        <p>The 200-stage journey is divided across ten named realms. Together they give the run a visible route from the opening fields to the final throne. Realm names mark where the adventure is taking place; damage, upgrades, hero unlocks, and boss readiness remain the systems that determine whether the party advances.</p>
        <div class="card-grid">
            <?php foreach ($worlds as $number => $world): ?>
                <article class="card">
                    <h3><?= escape_html($world) ?></h3>
                    <p>Realm <?= escape_html((string) ($number + 1)) ?> of 10. Continue clearing its normal encounters, invest battle earnings, and prepare for the boss that guards this part of the route.</p>
                </article>
            <?php endforeach; ?>
        </div>
        <p><a href="/worlds/">View the world overview</a> for the complete realm order.</p>
    </section>

    <section class="container" aria-labelledby="guides-heading">
        <h2 id="guides-heading">Player guides</h2>
        <p>These five guides answer different progression questions. Begin with the rules if this is your first run, use the upgrading and boss guides when progress slows, check offline rewards before stepping away, and read the rebirth guide before resetting stage and hero progress.</p>
        <?php render_card_grid($guides, 'guide-grid'); ?>
    </section>
</main>
<?php render_footer(); ?>
