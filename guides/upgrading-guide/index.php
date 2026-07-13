<?php
declare(strict_types=1);

require dirname(dirname(__DIR__)) . '/includes/config.php';
require dirname(dirname(__DIR__)) . '/includes/render.php';

$page = [
    'title' => 'Gold and Upgrading Guide',
    'description' => 'Use Tiny Heroes Tap gold with purpose by balancing Swordsman tap damage, companion DPS, unlocks, and boss preparation.',
    'canonical' => '/guides/upgrading-guide/',
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
            ['label' => 'Upgrading Guide'],
        ]); ?>
        <h1>Gold and upgrading guide</h1>
        <p>Gold turns completed battles into more damage. A useful purchase is not simply the newest button or the largest displayed number; it is one that addresses what is limiting the run now. Separate active tap damage from automatic hero damage, compare the next encounter, and let that evidence guide the following spend.</p>

        <h2>What gold improves</h2>
        <p>Gold buys strength within a run. Main-hero upgrades improve the damage you create by tapping, while companion upgrades improve attacks that occur automatically. Those categories overlap in the goal of defeating enemies, but they do not behave the same way. An active player can take advantage of tap damage every second. Automatic damage keeps contributing during pauses and is the basis for offline progress. Before buying, ask whether you need faster hands-on clearing, stronger unattended attacks, or enough combined damage to pass a boss.</p>

        <h2>Investing in the Swordsman</h2>
        <p>The <strong>Swordsman</strong> is available from stage 1 and represents player-controlled damage. A Swordsman purchase pays off whenever you are present and tapping, especially when a boss survives with only a small amount of health. It contributes nothing while your finger is idle, however. That tradeoff is not a reason to neglect the Swordsman; it is a reason to match spending with your play. Frequent active sessions can extract more value from tap upgrades than a run that mostly advances through automatic attacks.</p>

        <h2>Unlocking and supporting heroes</h2>
        <p>The five companions arrive in a fixed sequence: <strong>Archer</strong> at stage 5, <strong>Mage</strong> at stage 10, <strong>Paladin</strong> at stage 15, <strong>Rogue</strong> at stage 22, and <strong>Priest</strong> at stage 35. Each adds automatic damage after becoming available. An unlock milestone is not a command to spend every coin immediately. Check the purchase cost, the damage it adds, and the upgrades your existing attackers could receive for the same gold. A new source of damage can help, but established heroes also continue attacking and may offer a practical next step.</p>

        <h2>Attack speed versus displayed DPS</h2>
        <p>Companions have different attack rhythms. Archer supplies early automatic damage, Mage uses slower heavy hits, Paladin offers reliable mid-game damage, Rogue attacks quickly, and Priest supplies late-game automatic damage. Fast hits can make health bars move smoothly, while a slower attacker may deliver larger individual blows. Use the game's damage and DPS information when comparing upgrades rather than assuming that animation speed alone decides value. Bosses care about total damage before time ends; normal enemies may make the feel of each rhythm more noticeable.</p>

        <h2>Early, middle, and later priorities</h2>
        <p>In the earliest stages, build enough tap damage to clear actively and begin supporting Archer when automatic damage becomes available. Through stages 10 and 15, Mage and Paladin broaden the team, so compare recruiting costs with upgrades to heroes already working. After stage 20, rebirth enters the decision set; Rogue at 22 and Priest at 35 still give the continuing run more automatic options. These are checkpoints for reassessment, not an optimal build. Your remaining boss health, normal clear speed, session style, and available gold provide better evidence than a fixed percentage split.</p>

        <h2>Responding to a boss wall</h2>
        <p>When a countdown expires, note the remaining health before opening the upgrade menu. If the boss was close to defeat while you tapped consistently, one or two targeted damage purchases may be enough. If a large part of the bar remains, resume normal battles and collect more gold instead of repeatedly starting the same attempt. Improve Swordsman damage when active taps are a large part of your output, companion damage when automatic attacks lag, or both when the team has fallen behind generally. Boss failure does not remove held gold.</p>

        <h2>Common upgrading mistakes</h2>
        <ul>
            <li><strong>Buying without observing:</strong> compare at least one fight before and after a purchase.</li>
            <li><strong>Reading speed as total power:</strong> attack rhythm and total DPS are related but not interchangeable.</li>
            <li><strong>Ignoring your session style:</strong> tap damage needs active input; companion damage continues automatically.</li>
            <li><strong>Forcing every unlock immediately:</strong> reaching a stage creates a choice, not an obligation.</li>
            <li><strong>Repeating a distant boss miss:</strong> use normal battles to earn enough gold for a measurable change.</li>
            <li><strong>Forgetting offline goals:</strong> improve hero DPS if away-time rewards are important to you.</li>
        </ul>

        <h2>A repeatable spending check</h2>
        <p>Watch an encounter, name the limitation, compare affordable upgrades, buy one meaningful change, and watch again. This short loop prevents habit from replacing evidence and adapts as new heroes arrive. It also leaves room for preference: an active tap-focused session and a mostly automatic session can make different purchases without either claiming a universal solution.</p>
        <p>You can make the comparison more reliable by using the same kind of enemy before and after a purchase. Notice the time needed to clear it and whether you were tapping throughout both observations. A faster result then has a clear cause. When several upgrades are bought at once, it becomes harder to learn which damage source changed the run, so deliberate single steps are especially useful when gold is limited.</p>
        <p>Read the <a href="/guides/boss-battles/">boss battles guide</a> when a timer is the immediate problem, or the <a href="/guides/offline-rewards/">offline rewards guide</a> before building for time away. To test a purchase in context, <a href="/play/">play Tiny Heroes Tap</a>.</p>
    </article>
</main>
<?php render_footer(); ?>
