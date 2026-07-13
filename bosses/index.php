<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/content.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'Bosses and Base Timers',
    'description' => 'Compare all ten Tiny Heroes Tap bosses and their base countdowns, then learn how the repeating boss cycle works.',
    'canonical' => '/bosses/',
    'section' => 'bosses',
    'allow_ads' => false,
];

$bossNotes = [
    'Meadow Slime King' => 'This opening name has a 30-second base window.',
    'Cloud Gate Titan' => 'This boss uses the roster’s shortest base window at 22 seconds.',
    'Mist Rune Colossus' => 'Its base countdown allows 25 seconds.',
    'Storm Bridge Roc' => 'Its 25-second base window matches the Mist Rune Colossus timer.',
    'Star Tower Hydra' => 'This encounter begins with a 28-second base countdown.',
    'Moon Archive Golem' => 'Its base window is also 28 seconds.',
    'Thunder Forge Djinn' => 'This boss provides a 31-second base attempt.',
    'Frost Crown Beast' => 'Its base countdown matches that 31-second window.',
    'Void Gate Dragon' => 'This late-roster name has a 34-second base timer.',
    'Sky Throne Warden' => 'The tenth named boss also begins with 34 seconds.',
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Bosses'],
        ]); ?>
        <h1>Tiny Heroes Tap boss field guide</h1>
        <p>Every fifth stage replaces open-ended progress with a timed boss attempt. The party must remove the current boss’s health before its base countdown reaches zero. The reference below lists the public timing information players can use directly: each name and its starting time window.</p>

        <div class="card-grid boss-grid">
            <?php foreach ($bosses as $boss): ?>
                <article class="card boss-card">
                    <h2><?= escape_html($boss['name']) ?></h2>
                    <p><strong>Base timer: <?= escape_html((string) $boss['time']) ?> seconds.</strong> <?= escape_html($bossNotes[$boss['name']]) ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <h2>The repeating boss cycle</h2>
        <p>The 200-stage route places a boss at every fifth stage and cycles through these ten named opponents. Later boss milestones therefore return to the established roster instead of introducing forty separate names. Check both the stage number and the current boss before preparing. A multiple of five tells you a countdown is next; the displayed name tells you which base timer applies to that attempt.</p>

        <h2>Time limits are not difficulty ratings</h2>
        <p>The timer list does not run from easiest to hardest. Cloud Gate Titan provides 22 seconds, while later names can provide 25, 28, 31, or 34 seconds. More time alone does not guarantee an easier win. Your current tap damage, automatic hero DPS, and the health remaining when the clock ends are more useful evidence. Judge the specific attempt rather than treating a longer countdown as a promise.</p>

        <h2>How to use this field guide</h2>
        <p>Before a fifth-stage battle, find the opponent’s base timer and enter when you can tap throughout that window. If time expires, note how much health remains. Failure does not remove held gold, so return to ordinary earning, make a measurable damage improvement, and try again. An optional rewarded-ad choice can add 15 seconds once per battle, but it is not required for preparation or continued play.</p>

        <p>For a complete preparation process, read the <a href="/guides/boss-battles/">boss battles guide</a>. You can also review the <a href="/heroes/">hero roster</a> before deciding which damage source to improve, or <a href="/play/">start the next run</a>.</p>
    </article>
</main>
<?php render_footer(); ?>
