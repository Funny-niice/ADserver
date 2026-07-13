<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/content.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'Heroes and Unlock Stages',
    'description' => 'Meet all six Tiny Heroes Tap characters and compare the Swordsman’s tap damage with the five companions’ automatic DPS.',
    'canonical' => '/heroes/',
    'section' => 'heroes',
    'allow_ads' => false,
];

$heroDescriptions = [
    'Swordsman' => 'The starting hero turns player input into direct tap damage. Upgrade the Swordsman when active taps are the practical way to close a normal fight or beat a boss timer. This is a separate damage source from companion DPS.',
    'Archer' => 'The first unlockable companion introduces automatic damage at stage 5. Upgrade Archer when the new automatic contribution is affordable and the team needs steadier early progress, including rewards earned while away.',
    'Mage' => 'Available at stage 10, Mage adds slow, heavy automatic hits. Upgrade Mage after checking the damage gained for the gold cost; the different attack rhythm still contributes to the same automatic DPS total as Archer.',
    'Paladin' => 'Paladin becomes available at stage 15 and supplies reliable mid-game automatic damage. Upgrade Paladin when the purchase improves automatic clearing more than another affordable tap or companion upgrade before the stage-20 rebirth option.',
    'Rogue' => 'Rogue unlocks at stage 22, after the rebirth option appears. Upgrade Rogue when continuing the current run and its fast automatic attacks offer a useful gain compared with saving for another existing hero.',
    'Priest' => 'The final roster member becomes available at stage 35. Upgrade Priest when late-run automatic damage is the bottleneck, while still comparing its cost and gain with the five heroes already contributing to the team.',
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Heroes'],
        ]); ?>
        <h1>Tiny Heroes Tap hero reference</h1>
        <p>The roster combines one player-controlled main hero with five companions. Tapping makes the Swordsman deal direct damage, while unlocked companions attack automatically and contribute hero DPS. Improving one side does not silently improve the other, so the useful choice depends on whether the current run needs stronger active input, steadier automatic damage, or both.</p>

        <div class="card-grid hero-grid">
            <?php foreach ($heroes as $hero): ?>
                <article class="card hero-card">
                    <h2><?= escape_html($hero['name']) ?></h2>
                    <p><strong>Available from stage <?= escape_html((string) $hero['stage']) ?>.</strong> <?= escape_html($hero['role']) ?>. <?= escape_html($heroDescriptions[$hero['name']]) ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <h2>Building the team</h2>
        <p>The Swordsman is present from stage 1, then the companions become available in order: Archer at 5, Mage at 10, Paladin at 15, Rogue at 22, and Priest at 35. This sequence adds automatic attackers gradually while leaving direct tap damage under player control. A balanced team is not a mandatory percentage split. Watch normal clear speed and boss results, then strengthen the damage source that is currently falling behind.</p>

        <h2>What hero synergy means</h2>
        <p>There are no class-combo bonuses in the current rules. The current synergy is the combination of Swordsman tap damage and additive hero automatic DPS: active taps and the companions’ automatic contributions damage the same enemy, but one hero does not unlock a hidden multiplier for another. Upgrade timing should therefore follow observable damage gained, gold cost, and whether active or automatic progress is holding the run back.</p>

        <h2>Unlocking versus upgrading</h2>
        <p>Reaching a hero’s stage makes that character available; it does not make every possible purchase automatically correct. Gold can support the newest companion, improve heroes already attacking, or strengthen Swordsman taps. Compare what an affordable upgrade adds before spending. If you play actively, tap damage can be immediately useful. If you want steadier automatic attacks or stronger offline rewards, companion DPS deserves attention. The <a href="/guides/upgrading-guide/">upgrading guide</a> gives a repeatable way to make that comparison.</p>

        <h2>Heroes after stage 40</h2>
        <p>All six roster members are available by stage 35, so passing stage 40 does not introduce another named hero. Later progress develops the same Swordsman, Archer, Mage, Paladin, Rogue, and Priest within the current run. Rebirth resets hero levels and companion unlocks, which means a new run must open the roster again at its normal milestones. The permanent rebirth bonus applies to main-hero tap damage and does not increase companion hero DPS.</p>

        <p>See the <a href="/guides/offline-rewards/">offline rewards guide</a> for the role of companion DPS, or <a href="/play/">play Tiny Heroes Tap</a> and build the roster in stage order.</p>
    </article>
</main>
<?php render_footer(); ?>
