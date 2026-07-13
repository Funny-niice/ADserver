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
    'Sunrise Fields' => 'Sunrise Fields opens the named journey and gives the route a bright starting point. Its place at the beginning makes it the setting in which players first establish the Swordsman’s tap damage and begin working toward the earliest companion unlocks. The realm name supplies atmosphere without changing the central rules: battles produce gold, upgrades build damage, and every fifth stage still leads to a timed boss encounter.',
    'Cloud Castle' => 'Cloud Castle is the second realm in the fixed ten-name order. The move from open fields to a castle in the clouds makes the journey feel higher and more enclosed while the same progression systems continue underneath. Players still combine active Swordsman taps with automatic companion attacks, spend earned gold, and watch for fifth-stage boss milestones. The location marks movement through the route rather than a separate game mode or ruleset.',
    'Mist Ruins' => 'Mist Ruins occupies the third position and shifts the route toward an older, obscured destination. By this point in the named sequence, the world list has moved beyond its bright departure and airborne fortress into a more weathered theme. That identity is narrative and visual context, not a claim about special hazards. Stage clearing continues to depend on current damage, upgrades, unlocked heroes, and readiness for the next recurring boss countdown.',
    'Storm Bridge' => 'Storm Bridge is the fourth named stop, framing this part of the journey as a crossing exposed to rough weather. The bridge image distinguishes the realm from the fields, castle, and ruins that precede it, while preserving one continuous run. Players do not need a realm-specific build. They advance through the same combination of tapping, automatic hero DPS, gold investment, normal encounters, and timed battles at every fifth stage.',
    'Star Tower' => 'Star Tower closes the first half of the ten-realm order with a high celestial landmark. It works as a visible midpoint in the list of destinations, not as a separate campaign with new controls. The party keeps developing through the established roster and economy while stages advance toward the next named setting. Boss readiness still comes from observing damage and countdown results, and realm placement does not replace the need to upgrade the current run.',
    'Moon Archive' => 'Moon Archive begins the second half of the realm sequence by pairing a night-sky theme with a place associated with records. Its name changes the setting’s character after Star Tower without adding an unsupported puzzle, library, or collection mechanic. Tiny Heroes Tap remains focused on combat progress: direct taps, automatic attacks, gold spending, recurring boss checks, offline rewards, and the player’s later decision about whether to continue or use rebirth.',
    'Thunder Forge' => 'Thunder Forge follows as realm seven, combining storm imagery with a place built for making. The name gives this stretch a forceful identity, but it should not be read as a promise of crafting or equipment systems. Progress still comes from the game’s documented loop of defeating enemies, collecting gold, strengthening the Swordsman and companions, and preparing for timed bosses. It is another destination within the same complete 200-stage journey.',
    'Frost Crown' => 'Frost Crown is the eighth realm and turns the route toward cold, royal imagery as the final destinations approach. Its position makes the journey feel later without assigning a hidden difficulty value to the setting itself. The current party’s damage and upgrades remain what determine progress. Normal battles continue to fund improvement, while recurring boss stages ask the team to deliver enough combined tap damage and hero DPS before the displayed countdown ends.',
    'Void Gate' => 'Void Gate is the ninth and penultimate named realm, presenting a threshold before the journey’s final destination. That placement makes it a transition in the world order rather than evidence of a portal mechanic or alternate rule set. Players continue the existing run with the heroes they have unlocked and upgraded. The familiar 200-stage structure, fifth-stage boss rhythm, gold economy, and rebirth choice remain consistent as the route nears its conclusion.',
    'Sky Throne' => 'Sky Throne is the tenth and final named destination in the 200-stage route. Its title brings the upward journey to a clear endpoint after fields, fortresses, ruins, celestial landmarks, and the late sequence of forge, crown, and gate. Reaching this realm does not add another hero after Priest or replace the established combat loop. Players still rely on taps, companion DPS, upgrades, and preparation for the remaining timed boss milestones.',
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
