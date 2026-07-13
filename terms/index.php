<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'Terms of Use',
    'description' => 'Read the terms that apply when using the Tiny Heroes Tap website, browser game, guides, links, and optional advertising features.',
    'canonical' => '/terms/',
    'section' => 'terms',
    'allow_ads' => false,
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Terms of Use'],
        ]); ?>
        <h1>Terms of Use</h1>
        <p><strong>Effective date: 2026-07-13.</strong> These terms apply to your use of the Tiny Heroes Tap website, browser game, and published guides. By using them, you agree to follow these terms and applicable law.</p>

        <h2>Personal play and site use</h2>
        <p>You may access the site, play the game, and use the guides for personal, lawful entertainment and reference. Access does not grant permission to misrepresent yourself as Funny-niice, publish an unofficial copy as an official service, or use the materials in a way that violates applicable law.</p>

        <h2>Prohibited abuse</h2>
        <p>Do not attempt to disrupt the site, bypass security controls, introduce malicious code, probe systems without authorization, overload the service, or interfere with another visitor's access. Do not use automated requests in a way that unreasonably burdens the service.</p>

        <h2>Intellectual property and repositories</h2>
        <p>Game names, artwork, site text, code, and other materials may be protected by intellectual property laws. Access to the site does not transfer ownership. Source code or assets made available through a public repository are governed by the license and notices, if any, provided with that repository; these terms do not replace them.</p>

        <h2>Optional ads</h2>
        <p>The game may offer optional rewarded-ad choices tied to a stated in-game benefit. You may decline those offers and continue ordinary play. Website display ads are currently disabled. Advertising features, providers, or availability may change, and no specific ad or reward opportunity is guaranteed to be available.</p>

        <h2>Third-party services and links</h2>
        <p>The site links to services operated by others, including GitHub, and may use an advertising provider if advertising is enabled. Third-party services control their own content, availability, terms, and privacy practices. A link does not make Funny-niice responsible for that separate service.</p>

        <h2>Saved progress</h2>
        <p>Game progress is kept in the local browser environment unless the platform explicitly provides another save feature. Clearing site storage, changing browsers or devices, using a private window, browser restrictions, or technical failures may make progress unavailable. You are responsible for considering those limits before removing browser data.</p>

        <h2>Availability and changes</h2>
        <p>The website, game, content, and features may be corrected, updated, suspended, or removed. There is no guarantee of uninterrupted availability, preservation of local progress, or continued support for a particular browser, device, third-party service, or optional feature.</p>

        <h2>Disclaimer</h2>
        <p>The site, game, and guides are provided on an "as available" basis. Although the guides are manually maintained, they may contain mistakes or lag behind a game change. To the extent permitted by law, no warranties are made about accuracy, fitness for a particular purpose, compatibility, or freedom from errors.</p>

        <h2>Limitation of liability</h2>
        <p>To the extent permitted by applicable law, Funny-niice is not liable for indirect, incidental, special, or consequential loss arising from use of, or inability to use, the site or game, including loss of locally stored progress. Nothing in these terms excludes rights or liability that applicable law does not allow to be excluded.</p>

        <h2>Changes to these terms</h2>
        <p>These terms may be revised to reflect changes to the site, game, or applicable requirements. The effective date will be updated when a revised version is published. Review the current page when you return to the service.</p>

        <h2>Contact</h2>
        <p>Questions about these terms can be submitted through <a href="<?= escape_html(CONTACT_URL) ?>">Tiny Heroes Tap GitHub Issues</a>. It is a public channel, so do not include sensitive personal information.</p>
    </article>
</main>
<?php render_footer(); ?>
