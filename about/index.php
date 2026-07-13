<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/render.php';

$page = [
    'title' => 'About',
    'description' => 'Learn who publishes Tiny Heroes Tap, what this official site provides, and where to find the public project repositories.',
    'canonical' => '/about/',
    'section' => 'about',
    'allow_ads' => false,
];

render_header($page);
?>
<main id="main-content" class="site-main">
    <article class="article">
        <?php render_breadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'About'],
        ]); ?>
        <h1>About Tiny Heroes Tap</h1>
        <p>Funny-niice is the independent game publisher behind Tiny Heroes Tap and this official website. The site gives players a direct route to the playable browser client alongside clear information about how the game works.</p>

        <h2>What this site publishes</h2>
        <p>The <a href="/play/">play page</a> provides access to the game client. The reference pages, FAQ, and player guides explain current game systems such as hero progression, boss battles, offline rewards, and rebirth. These guides are manually maintained editorial content, written to help players make sense of the live game rather than to generate large numbers of repetitive pages.</p>

        <h2>Open project work</h2>
        <p>Funny-niice publishes project work through <a href="https://github.com/Funny-niice">public GitHub repositories</a>. The source repository for this website is <a href="https://github.com/Funny-niice/ADserver">Funny-niice/ADserver</a>. Repository-specific files and notices describe any permissions that apply to source code or other materials there.</p>

        <h2>Questions and corrections</h2>
        <p>To report a game bug, request a content correction, or raise a privacy or accessibility concern, use the public channel described on the <a href="/contact/">Contact page</a>. No separate support email or company identity is represented on this site.</p>
    </article>
</main>
<?php render_footer(); ?>
