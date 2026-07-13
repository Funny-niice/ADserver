<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/content.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'Worlds and the 200-Stage Route',
    'description' => 'Follow all ten Tiny Heroes Tap realms in order, from Sunrise Fields to Sky Throne, across the complete 200-stage route.',
    'canonical' => '/worlds/',
    'section' => 'worlds',
    'allow_ads' => false,
];

$worldDescriptions = [
    'Sunrise Fields' => 'Sunrise Fields opens the named journey and gives the route a bright starting point. The Dawn Slime represents its normal monsters, and the Meadow Slime King is its named boss. Its place at the beginning makes it the setting in which players first establish the Swordsman’s tap damage and work toward early companion unlocks. Battles still produce gold, upgrades build damage, and every fifth stage leads to a timed boss encounter.',
    'Cloud Castle' => 'Cloud Castle is the second realm in the fixed order. The Cloud Page represents its normal monsters, while the Cloud Gate Titan is the realm’s named boss. The move from open fields to a castle in the clouds makes the journey feel higher and more enclosed while the same progression systems continue underneath. Players combine active Swordsman taps with automatic companion attacks, spend earned gold, and watch for fifth-stage boss milestones.',
    'Mist Ruins' => 'Mist Ruins occupies the third position and shifts the route toward an older, obscured destination. The Mist Wisp is a representative normal monster, and the Mist Rune Colossus is the named boss. That identity is narrative and visual context, not a claim about special hazards. Stage clearing continues to depend on current damage, upgrades, unlocked heroes, and readiness for the next recurring boss countdown.',
    'Storm Bridge' => 'Storm Bridge is the fourth named stop, framing this part of the journey as a crossing exposed to rough weather. The Storm Seed represents its normal encounters, and the Storm Bridge Roc is its named boss. The bridge image distinguishes the realm while preserving one continuous run. Players advance through the same combination of tapping, automatic hero DPS, gold investment, ordinary battles, and timed fights at every fifth stage.',
    'Star Tower' => 'Star Tower closes the first half of the ten-realm order with a high celestial landmark. The Starcap Shroom represents a normal encounter, while the Star Tower Hydra is the named boss. The realm works as a visible midpoint, not as a separate campaign with new controls. The party keeps developing through the established roster and economy, and boss readiness still comes from observing damage and countdown results.',
    'Moon Archive' => 'Moon Archive begins the second half of the realm sequence by pairing a night-sky theme with a place associated with records. The Moonlit Cub represents its normal encounters, and the Moon Archive Golem is its named boss. The setting does not add an unsupported puzzle or collection mechanic. Combat progress still comes from direct taps, automatic attacks, gold spending, recurring boss checks, offline rewards, and the later rebirth decision.',
    'Thunder Forge' => 'Thunder Forge follows as realm seven, combining storm imagery with a place built for making. Representative encounters include the recurring Meadow Shell and the Thunder Forge Djinn boss. The name should not be read as a promise of crafting or equipment systems. Progress still comes from defeating enemies, collecting gold, strengthening the Swordsman and companions, and preparing for timed bosses within the same 200-stage journey.',
    'Frost Crown' => 'Frost Crown is the eighth realm and turns the route toward cold, royal imagery as the final destinations approach. The Frost Gearling represents its normal monsters, and the Frost Crown Beast is its named boss. Its position does not assign a hidden difficulty value to the setting. Current damage and upgrades determine progress, while boss stages ask the team to deliver enough combined tap damage and hero DPS before the countdown ends.',
    'Void Gate' => 'Void Gate is the ninth and penultimate named realm, presenting a threshold before the journey’s final destination. The Void Lantern represents a normal encounter, and the Void Gate Dragon is its named boss. That placement is a transition in the world order rather than evidence of a portal mechanic or alternate rules. The familiar stage structure, boss rhythm, gold economy, hero upgrades, and rebirth choice remain consistent near the conclusion.',
    'Sky Throne' => 'Sky Throne is the tenth and final named destination in the 200-stage route. Its representative normal encounter is the recurring Void Lantern, and its named boss is the Sky Throne Warden. The realm brings the upward journey to a clear endpoint without adding another hero or replacing the established combat loop. Players still rely on taps, additive companion DPS, upgrades, and preparation for the remaining timed boss milestones.',
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Worlds'],
        ]); ?>
        <h1>The ten worlds of Tiny Heroes Tap</h1>
        <p>The full run travels through ten realms in a fixed order. Their names give each part of the journey a distinct identity, while tapping, automatic hero DPS, gold upgrades, boss preparation, offline rewards, and rebirth remain the systems that control progress.</p>

        <div class="card-grid world-grid">
            <?php foreach ($worlds as $index => $world): ?>
                <article class="card world-card">
                    <h2><?= escape_html($world) ?> <small>— Realm <?= escape_html((string) ($index + 1)) ?> of 10</small></h2>
                    <p><?= escape_html($worldDescriptions[$world]) ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <h2>How the 200-stage cycle works</h2>
        <p>The ten realms organize one 200-stage journey rather than ten separate games. A boss appears every fifth stage, and the ten named bosses repeat across those milestones. Realm names show where the party is in the route; they do not replace the stage, hero, gold, or damage rules. After every companion has become available by stage 35, the same six-member roster continues developing through the later worlds.</p>
        <p>Use the <a href="/bosses/">boss field guide</a> to compare the ten base timers, visit the <a href="/heroes/">hero reference</a> for every unlock stage, or <a href="/play/">play Tiny Heroes Tap</a> and follow the route from Sunrise Fields.</p>
    </article>
</main>
<?php render_footer(); ?>
