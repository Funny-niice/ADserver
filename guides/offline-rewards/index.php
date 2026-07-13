<?php
declare(strict_types=1);

require dirname(dirname(__DIR__)) . '/includes/config.php';
require dirname(dirname(__DIR__)) . '/includes/render.php';

$page = [
    'title' => 'Offline Rewards Guide',
    'description' => 'Learn how away time, hero DPS, boss stops, optional reward doubling, and return spending work in Tiny Heroes Tap.',
    'canonical' => '/guides/offline-rewards/',
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
            ['label' => 'Offline Rewards Guide'],
        ]); ?>
        <h1>Offline rewards guide</h1>
        <p>Offline rewards turn part of the time between sessions into progress. They depend on the automatic side of your team, not imaginary taps made while the game is closed. Understanding where that simulation stops helps you set realistic expectations and spend the returning gold well.</p>

        <h2>What happens while you are away</h2>
        <p>When you leave and later return, the game evaluates eligible away time and presents the resulting reward. You do not need to leave the game visibly running and you do not have to tap during the absence. The calculation represents what automatic attacks can accomplish, so the state of the run before leaving matters. Stronger companions give the system more damage to work with, while a run built only around active taps has less unattended power.</p>

        <h2>Why progress stops at a boss</h2>
        <p>Offline simulation can advance through normal encounters, but it <strong>does not defeat a boss</strong>. Bosses use timed, active battles and form a boundary for away progress. If your next stage is a boss milestone, returning at that wall is expected even when the party has excellent automatic damage. This rule prevents offline time from silently resolving a countdown that you did not play. Prepare and challenge the boss after returning, then future away progress can continue beyond it.</p>

        <h2>The role of hero DPS</h2>
        <p>Companion <strong>hero DPS</strong> is the engine of offline progress. Archer, Mage, Paladin, Rogue, and Priest attack automatically after they have been unlocked and supported. Swordsman tap damage remains valuable during active play, but no player taps are generated while away. If offline rewards are a priority for your play style, compare companion upgrades before ending a session. This is not a claim that tap upgrades are bad; it simply matches an automatic system with the damage source it can actually use.</p>

        <h2>Understanding the base reward</h2>
        <p>The return panel shows the base reward earned from the eligible absence and the current run's automatic capability. Treat that displayed amount as the reliable answer for the session rather than estimating a universal rate. Your stage position, available hero DPS, and the boss boundary can change what the game is able to simulate. A short absence and a long one therefore should not be compared without considering the state in which each session was left.</p>

        <h2>Optional reward doubling</h2>
        <p>The return flow can offer an optional rewarded-ad choice to double the offline reward. Accepting is voluntary. The base reward remains the earned amount when you continue without the ad, so ordinary offline progress is not locked behind viewing one. Decide based on whether the extra gold is useful to this run and whether you want to watch the reward. Avoid planning around a guaranteed doubling if you prefer an ad-free session; build decisions can be made from the base amount alone.</p>

        <h2>Spending gold after returning</h2>
        <p>Pause before distributing the whole reward. First check whether the run stopped immediately before a boss. If it did, buy damage that helps the upcoming timed battle: tap damage for active input, hero DPS for the automatic baseline, or a measured combination. If you returned among normal stages, you can strengthen companions for the next absence or improve the Swordsman for current play. Buy a meaningful step, observe the result, and then decide where the remainder belongs instead of following a fixed ratio.</p>

        <h2>Preparing the next absence</h2>
        <p>Before closing, spend gold you intend to invest in automatic damage, because held currency cannot attack enemies. Note the current stage and whether a multiple of five is next. A nearby boss may cap simulated movement quickly even when the team is strong. If convenient, clear that boss actively before leaving. This is preparation, not a requirement: the base reward can still be useful when you stop at a boss, and the held gold remains available when you return.</p>
        <p>A simple before-and-after note can clarify the system. Record the stage, the next boss milestone, and the companion damage shown before leaving. On return, compare the reached stage and base gold with that starting point. The notes help separate a normal boss stop from weak automatic damage and make the next upgrade decision concrete.</p>

        <h2>Troubleshooting a smaller-than-expected reward</h2>
        <ul>
            <li><strong>Check the stage:</strong> the simulation may have reached a boss and stopped normally.</li>
            <li><strong>Check companion strength:</strong> tap damage is not substituted for hero DPS while away.</li>
            <li><strong>Check the absence:</strong> a brief break produces less opportunity than an extended one.</li>
            <li><strong>Check the displayed base amount:</strong> optional doubling is separate from what was earned.</li>
            <li><strong>Check whether you recently rebirthed:</strong> stage and hero progress reset, so the rebuilt team may differ from the prior run.</li>
        </ul>
        <p>If something still looks wrong, compare one controlled absence after improving a companion. Record the stage before leaving, return after a similar interval, and inspect where progress stopped. That simple comparison gives better evidence than assuming every session should pay the same amount.</p>
        <p>Use the <a href="/guides/upgrading-guide/">upgrading guide</a> to compare active and automatic spending, or the <a href="/guides/boss-battles/">boss battles guide</a> when offline progress leaves you at a countdown. To prepare the current run, <a href="/play/">play Tiny Heroes Tap</a>.</p>
    </article>
</main>
<?php render_footer(); ?>
