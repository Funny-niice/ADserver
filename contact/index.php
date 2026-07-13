<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'Contact',
    'description' => 'Contact Funny-niice about Tiny Heroes Tap bugs, guide corrections, privacy questions, or accessibility feedback.',
    'canonical' => '/contact/',
    'section' => 'contact',
    'allow_ads' => false,
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Contact'],
        ]); ?>
        <h1>Contact Funny-niice</h1>
        <p>Use <a href="<?= escape_html(CONTACT_URL) ?>">Tiny Heroes Tap GitHub Issues</a> to report game bugs, suggest corrections to this site, ask privacy questions, or share accessibility feedback. This public issue tracker is the contact channel currently provided for the game and website; the site does not publish a support email address.</p>

        <h2>What to include</h2>
        <p>A useful report includes the page URL, browser and device, clear reproduction steps, and what you expected to happen. If an image would help, attach a privacy-safe screenshot that excludes account details, notifications, names, or other personal information.</p>

        <h2>Before posting</h2>
        <p>GitHub Issues are public. Do not include passwords, authentication tokens, precise location information, or other sensitive personal data. You may search existing issues before opening a new one to see whether the same problem or correction is already being discussed.</p>

        <p><a href="<?= escape_html(CONTACT_URL) ?>">Open the public GitHub Issues contact channel</a>.</p>
    </article>
</main>
<?php render_footer(); ?>
