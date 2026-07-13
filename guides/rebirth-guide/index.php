<?php
declare(strict_types=1);

require dirname(dirname(__DIR__)) . '/includes/config.php';
require dirname(dirname(__DIR__)) . '/includes/render.php';

$page = [
    'title' => 'Rebirth Guide',
    'description' => 'Understand Tiny Heroes Tap rebirth availability, resets, retained gold, permanent tap bonus, timing, and rebuilding.',
    'canonical' => '/guides/rebirth-guide/',
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
            ['label' => 'Rebirth Guide'],
        ]); ?>
        <h1>Rebirth guide</h1>
        <p>Rebirth exchanges the current run's stage and hero development for a permanent increase to the main hero's tap damage. It is a deliberate restart, not a total wipe: gold is retained. Read the reset and retention rules together before deciding when a new run is worthwhile.</p>

        <h2>Availability at stage 20</h2>
        <p>The rebirth option becomes available at <strong>stage 20</strong>. Reaching that milestone gives you permission to use the system; it does not force an immediate reset. At this point you have encountered repeated boss checks and unlocked Archer, Mage, and Paladin. You can continue the run, collect more gold, and judge how quickly the party still advances before choosing. Availability is best understood as a new strategic option alongside ordinary upgrading.</p>

        <h2>The first stage 25 checkpoint</h2>
        <p>For a first rebirth, <strong>stage 25</strong> is the recommended checkpoint. It provides a little more experience with the run after the feature opens and includes another boss milestone. “Recommended” is guidance, not a hidden requirement: stage 20 remains the unlock point. If you are learning the system, reaching 25 gives you a clear first target without claiming that every later rebirth has one perfect stage.</p>

        <h2>What the reset changes</h2>
        <p>Rebirth resets stage progress, the Swordsman's level, companion hero levels, and companion unlocks. The next run therefore begins by rebuilding rather than continuing from the same battlefield. Archer again requires stage 5, Mage stage 10, Paladin stage 15, Rogue stage 22, and Priest stage 35. Plan for those losses before confirming. A strong late-run automatic team will not remain assembled immediately after the reset.</p>

        <h2>Gold is retained</h2>
        <p>Your gold carries into the new run. This retained currency is important because it lets you buy damage as you begin climbing again, even though levels and unlocks have reset. Consider how much gold you want available for rebuilding, but do not confuse retention with preserved upgrades: the currency stays, while the hero development purchased in the old run is reset. This distinction explains why the restart can feel faster without placing the party directly back at its former stage.</p>

        <h2>The permanent 5% bonus</h2>
        <p>Each rebirth adds a permanent <strong>5%</strong> bonus to the main hero's tap damage. The game supports up to 100 rebirths. Because the bonus persists, active taps begin future runs with increasing support from prior resets. It does not remove the need to upgrade during the new run, defeat bosses inside their timers, or unlock companions again. Think of it as a lasting addition to one damage source rather than a shortcut that completes every system.</p>

        <h2>Why it does not affect hero DPS</h2>
        <p>The rebirth bonus <strong>does not affect hero DPS</strong>. Archer, Mage, Paladin, Rogue, and Priest still depend on their own unlocks and upgrades for automatic damage. This matters for offline rewards, which use the automatic side of the team rather than Swordsman taps. A player who rebirths repeatedly but underfunds companions may tap more strongly while seeing less improvement in unattended progress than expected. Build both sides according to what the new run needs.</p>

        <h2>Choosing a later rebirth time</h2>
        <p>After the first recommended checkpoint, use the current run's pace as evidence. Continuing can make sense while normal stages fall steadily, bosses are manageable, and you are gathering useful gold. Rebirth becomes more appealing when progress has slowed enough that a new 5% tap bonus and retained gold would make the rebuild more valuable to you than pushing the current stage. This is a personal timing decision shaped by active play, companion strength, and the amount of rebuilding you want to do.</p>

        <h2>Rebuilding after confirmation</h2>
        <p>Start by spending retained gold deliberately rather than trying to recreate every previous purchase at once. Improve the Swordsman enough to use the permanent tap bonus, then restore automatic damage as companions unlock. Expect stage 5, 10, and 15 to reopen the early trio before Rogue at 22 and Priest at 35. Watch clear speed after each meaningful purchase. The familiar route provides a direct comparison with the earlier run and shows what the bonus actually changes.</p>
        <p>For a useful comparison, remember how the previous run felt at its early boss stages. During the rebuild, observe whether taps remove more health and how quickly retained gold restores companion support. The permanent bonus should be judged in the active Swordsman attacks where it applies. Any improvement in automatic clearing comes from the new run's hero purchases, not from the rebirth percentage itself.</p>

        <h2>Rebirth checklist</h2>
        <ul>
            <li>Confirm that you have reached at least stage 20.</li>
            <li>For the first reset, consider the recommended stage 25 checkpoint.</li>
            <li>Expect stage, Swordsman level, hero levels, and hero unlocks to reset.</li>
            <li>Remember that held gold is retained for the new run.</li>
            <li>Apply the 5% permanent gain only to main-hero tap damage in your planning.</li>
            <li>Rebuild hero DPS separately for automatic attacks and offline rewards.</li>
            <li>Continue the current run if its progress is still more useful to you than restarting now.</li>
        </ul>
        <p>Review the <a href="/guides/upgrading-guide/">upgrading guide</a> for rebuilding with retained gold, or the <a href="/guides/offline-rewards/">offline rewards guide</a> for the effect of restored hero DPS. When you are ready to reach the next checkpoint, <a href="/play/">play Tiny Heroes Tap</a>.</p>
    </article>
</main>
<?php render_footer(); ?>
