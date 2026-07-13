<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'Frequently Asked Questions',
    'description' => 'Find clear answers about Tiny Heroes Tap pricing, ads, bosses, heroes, offline rewards, rebirth, saved progress, and browsers.',
    'canonical' => '/faq/',
    'section' => 'faq',
    'allow_ads' => false,
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'FAQ'],
        ]); ?>
        <h1>Tiny Heroes Tap frequently asked questions</h1>
        <p>These answers describe the current web game rules. For longer explanations and practical examples, follow the linked player guides after the relevant answer.</p>

        <details>
            <summary>Is Tiny Heroes Tap free to play?</summary>
            <p>Yes. Tiny Heroes Tap can be started and played without paying an entry price. The normal progression loop—tapping, automatic hero attacks, earning gold, upgrading the team, fighting bosses, collecting base offline rewards, and using rebirth—is available through play. Rewarded-ad choices may offer an optional benefit in specific moments, but they do not change the game’s free-to-play status. Availability still depends on having a supported browser and access to the deployed game page.</p>
        </details>

        <details>
            <summary>Are ads mandatory?</summary>
            <p>No. Rewarded ads are voluntary choices tied to a stated benefit. During a boss battle, one may offer a single 15-second extension for that attempt. On returning from time away, another may offer to double the displayed offline reward. Declining either choice leaves ordinary play available: you can gather gold, upgrade damage, retry a boss, and claim the base offline reward without watching an ad. The website’s current content and game-entry pages also do not enable display ad placements.</p>
        </details>

        <details>
            <summary>What happens when I fail a boss battle?</summary>
            <p>A boss attempt fails when its countdown reaches zero while the boss still has health. The timed attempt ends, and the boss remains the obstacle to further stage advancement. Use the result as a damage check: note the remaining health, return to normal earning where available, spend gold on useful tap damage or automatic hero DPS, and try again after the team changes. A rewarded-ad extension can add 15 seconds once during a battle, but using it is optional.</p>
        </details>

        <details>
            <summary>Do I lose gold or progress when a boss defeats me?</summary>
            <p>A failed boss attempt does not remove the gold you already hold, erase completed stages, reset hero upgrades, or trigger rebirth. You simply do not advance past that boss until it is defeated. This lets you treat the loss as information rather than a destructive penalty. Keep the current run, improve the party, and make another attempt when its combined damage is stronger. Rebirth is a separate action with its own reset rules and is never the automatic result of a boss countdown ending.</p>
        </details>

        <details>
            <summary>When do heroes unlock?</summary>
            <p>The Swordsman is the player-controlled main hero and is available from stage 1. The five automatic companions become available in a fixed order: Archer at stage 5, Mage at stage 10, Paladin at stage 15, Rogue at stage 22, and Priest at stage 35. Reaching a milestone makes that hero available within the current run; it does not prescribe how you must spend every gold coin. Rebirth resets companion unlocks, so a new run opens them again at the same stages.</p>
        </details>

        <details>
            <summary>How do offline rewards work?</summary>
            <p>When you return after eligible time away, the game calculates a base reward using the automatic side of the current team. Companion hero DPS matters because the game does not create player taps while you are absent. Offline simulation can advance through normal encounters, but it does not defeat a boss, so progress may stop at the next boss milestone. The return flow can offer a voluntary ad to double the result; declining still lets you collect the base reward that was earned.</p>
        </details>

        <details>
            <summary>When does rebirth become available?</summary>
            <p>Rebirth becomes available when the current run reaches stage 20. Availability means the option can be chosen; it does not force an immediate restart. Stage 25 is the recommended checkpoint for a first rebirth, giving a new player another boss milestone after the feature opens. Later timing can depend on how quickly the run is still moving and whether a permanent tap-damage gain feels more useful than continuing. The game supports up to 100 rebirths.</p>
        </details>

        <details>
            <summary>What does rebirth reset, and what do I keep?</summary>
            <p>Rebirth resets stage progress, the Swordsman’s level, companion hero levels, and companion unlocks. Held gold is retained, so the next run can use that currency while rebuilding the roster. Each rebirth also adds a permanent 5% bonus to the main hero’s tap damage. That bonus does not raise companion hero DPS, which must be restored through unlocks and upgrades in the new run. Read these reset and retention rules together before confirming, because the party will not remain assembled at its old stage.</p>
        </details>

        <details>
            <summary>Where is my progress stored?</summary>
            <p>Game progress stays in the current browser unless the deployed platform explicitly provides its own save feature. Treat a different browser, device, browser profile, private window, or cleared site data as a separate storage environment. Avoid clearing the game’s local site data if you want to keep the current run, and do not assume that opening the same URL elsewhere will transfer it. Before changing devices or removing browser data, check whether the platform you are using offers an explicit export, account, or transfer option.</p>
        </details>

        <details>
            <summary>Which devices and browsers are supported?</summary>
            <p>Tiny Heroes Tap is a portrait web game intended for current browsers on mobile and desktop devices. Use an up-to-date browser with JavaScript and local site storage enabled, and keep the play area upright on a phone for the intended portrait layout. Exact behavior can vary with browser restrictions, embedded web views, privacy settings, and available memory. If the game does not load or retain progress, retry in a current standalone browser before reporting the device, browser name, page URL, and steps that produced the problem.</p>
        </details>

        <p>Need a deeper explanation? Browse the <a href="/guides/">player guides</a>, review the <a href="/game-info/">game information</a>, or <a href="/play/">play Tiny Heroes Tap</a>.</p>
    </article>
</main>
<?php render_footer(); ?>
