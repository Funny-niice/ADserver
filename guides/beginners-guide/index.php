<?php
declare(strict_types=1);

require dirname(dirname(__DIR__)) . '/includes/config.php';
require dirname(dirname(__DIR__)) . '/includes/render.php';

$page = [
    'title' => "Beginner's Guide",
    'description' => 'Learn Tiny Heroes Tap basics: tapping, hero DPS, gold, stages, bosses, hero unlocks, and what to do when progress slows.',
    'canonical' => '/guides/beginners-guide/',
    'section' => 'guides',
    'allow_ads' => false,
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Guides', 'url' => '/guides/'],
            ['label' => "Beginner's Guide"],
        ]); ?>
        <h1>Beginner's guide to Tiny Heroes Tap</h1>
        <p>A first run is easier to understand when you treat it as a repeating chain: deal damage, defeat an enemy, collect gold, buy damage, and advance. The game never requires one fixed upgrade pattern. Your useful choice depends on whether you are actively tapping, letting companions attack, or preparing for a boss timer.</p>

        <h2>Your first battle</h2>
        <p>The Swordsman is the main hero and responds to your input. Tap the current enemy to make the Swordsman attack. The enemy's health falls with each hit, and defeating it produces gold that can support the run. At the start, this direct rhythm is the whole battle: choose the target already on screen, tap until it falls, and notice how much health a single tap removes. That observation is more useful than racing through menus, because it gives you a baseline for judging the next upgrade.</p>
        <p>Let the next enemy sit untouched for a moment after companions become available. The contrast shows which damage continues automatically and which damage waits for you. Learning that distinction early makes later upgrade screens, offline results, and boss attempts much easier to interpret.</p>

        <h2>Tap damage and Hero DPS</h2>
        <p><strong>Tap damage</strong> is the damage caused by your active input through the Swordsman. <strong>Hero DPS</strong> is the automatic damage supplied by unlocked companion heroes. They solve different problems. Tap damage rewards attention and can add a burst when a boss clock is running. Hero DPS keeps landing hits without a tap for every attack, making normal progress steadier and supporting offline rewards. Buying one type does not silently raise the other, so read the upgrade label and decide which part of the run currently needs help.</p>

        <h2>How stages work</h2>
        <p>The route contains 200 stages across ten named worlds. Normal encounters let you continue fighting until the next stage condition is met. <strong>Every fifth stage</strong> triggers a boss battle, so the pace regularly changes from open-ended clearing to a timed damage check. The game cycles through ten named bosses rather than introducing a unique boss on every fifth stage. A stage number is therefore both a record of progress and a warning: when the next multiple of five is close, keep some attention for the countdown.</p>

        <h2>Spending your first gold</h2>
        <p>Gold improves damage during the current run. An early Swordsman upgrade makes every following tap more effective; an available companion upgrade strengthens automatic attacks. Compare the result you need instead of searching for a universal purchase order. If normal enemies only fall while you tap continuously, automatic damage may deserve attention. If a boss is nearly defeated when time expires and you are tapping throughout the attempt, a tap upgrade may close that particular gap. Spend in small steps, then watch the next fight before spending again.</p>

        <h2>Meeting the first boss</h2>
        <p>A boss replaces ordinary progress with a visible countdown. You must remove its health before time ends. Failure does not erase the gold you already hold, so a lost attempt is information rather than a ruined run. Return to building damage, use battle earnings on upgrades, and challenge the boss again. During the fight, keep tapping even when companions are attacking. An optional rewarded-ad choice can add 15 seconds once per battle, but it is an extra chance, not a requirement for preparing a stronger team.</p>

        <h2>Unlocking the team</h2>
        <p>The companion roster opens at specific milestones. Archer becomes available at stage 5, Mage at stage 10, Paladin at stage 15, Rogue at stage 22, and Priest at stage 35. The Swordsman is present from stage 1. Reaching a milestone adds an option; it does not make earlier damage irrelevant or guarantee that every new hero is instantly affordable. Look at what each purchase contributes and continue using both the active Swordsman and automatic companions as the roster expands.</p>

        <h2>When progress slows</h2>
        <p>First identify the kind of slowdown. If normal enemies take a long time, collect more battle gold and improve the damage source that is lagging. If offline progress is weak, Hero DPS matters because taps do not happen while you are away. If a boss survives the countdown, compare how much health remains: a narrow miss calls for a modest increase or cleaner tapping, while a large remainder signals that more preparation is sensible. Rebirth becomes available later, at stage 20, but it is not a substitute for learning the current run's upgrade choices.</p>

        <h2>First-run checklist</h2>
        <ul>
            <li>Tap the current enemy and observe the damage from one hit.</li>
            <li>Collect gold, buy one relevant upgrade, and compare the result.</li>
            <li>Recruit companions as their stage milestones become available.</li>
            <li>Expect a timed boss on each fifth stage and keep tapping during it.</li>
            <li>Treat boss failure as a prompt to strengthen the party, not as lost progress.</li>
            <li>Build Hero DPS before relying on meaningful progress while away.</li>
        </ul>
        <p>Continue with the <a href="/guides/upgrading-guide/">upgrading guide</a> for spending decisions or the <a href="/guides/boss-battles/">boss battles guide</a> for countdown preparation. You can also <a href="/play/">play Tiny Heroes Tap</a> and return here as new systems appear.</p>
    </article>
</main>
<?php render_footer(); ?>
