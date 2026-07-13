<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'Privacy Policy',
    'description' => 'Read how Tiny Heroes Tap handles information, local game progress, server logs, cookies, advertising, and privacy requests.',
    'canonical' => '/privacy/',
    'section' => 'privacy',
    'allow_ads' => false,
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Privacy Policy'],
        ]); ?>
        <h1>Privacy Policy</h1>
        <p><strong>Effective date: 2026-07-13.</strong> This policy describes the current Tiny Heroes Tap website and playable browser game published by Funny-niice. It does not invent an account system or private support channel that the site does not provide.</p>

        <h2>Information you provide</h2>
        <p>The site does not offer player accounts or a private contact form. If you choose to contact Funny-niice through GitHub Issues, the text, attachments, GitHub profile information, and other details you submit are handled by GitHub and may be visible publicly. Do not post sensitive personal information.</p>

        <h2>Local game progress</h2>
        <p>Tiny Heroes Tap uses local browser storage to retain game progress in the browser environment where you play. This data can include progress and settings needed to resume the game. It is not presented as a cloud save, and it may not follow you to another device, browser, profile, or private window. Clearing site data can remove it.</p>

        <h2>Server logs</h2>
        <p>The services that deliver the website may automatically create technical logs, such as requested URLs, timestamps, IP addresses, browser information, and error or security events. Those records may be used to deliver the site, diagnose failures, protect the service, and investigate abuse. Hosting providers may process such records under their own terms and policies.</p>

        <h2>Cookies and Google AdSense</h2>
        <p>Display ads are disabled on this website now. The site therefore does not currently enable Google AdSense display placements. Tiny Heroes Tap may separately present an optional rewarded-ad choice inside a clearly identified game flow; choosing or declining such a reward does not change the website display-ad setting.</p>
        <p>If display advertising is enabled in the future, Google AdSense and its advertising partners may use cookies, local storage, device information, or similar technologies to deliver and measure ads. Where required, an appropriate consent or choice mechanism would be presented before non-essential advertising storage is used, and this policy would be updated to describe the active practice.</p>

        <h2>Your choices</h2>
        <p>You can decline optional rewarded-ad offers and continue ordinary play. Browser controls can be used to remove local game data or manage cookies and site storage, although removing game storage may erase saved progress. You can also choose not to submit a GitHub issue or can edit or delete a submission when GitHub provides those controls.</p>

        <h2>Children</h2>
        <p>The site is not designed to collect personal information from children. Children should not submit personal details through a public issue. A parent or guardian who believes a child has posted personal information can make a request through the contact channel below.</p>

        <h2>Privacy requests</h2>
        <p>For a privacy question or request concerning this site, use <a href="<?= escape_html(CONTACT_URL) ?>">Tiny Heroes Tap GitHub Issues</a>. Because that channel is public, describe the request without posting sensitive data. Requests concerning information held by GitHub, an advertiser, or another provider may also need to be directed to that provider.</p>

        <h2>Changes to this policy</h2>
        <p>This policy may change when the site, game, or service providers change. The effective date above will be revised when a new version is published, and significant site changes may also be recorded on the <a href="/updates/">Updates page</a>.</p>
    </article>
</main>
<?php render_footer(); ?>
