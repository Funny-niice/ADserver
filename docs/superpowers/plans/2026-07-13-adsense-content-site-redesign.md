# Tiny Heroes Tap AdSense Content Site Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Convert the single-purpose launcher into an English-first official game and player-guide site whose substantive publisher content is separated from the ad-free game client.

**Architecture:** Keep the deployment dependency-free and PHP-based. Shared configuration, game facts, rendering, and ad policy live under `includes/`; small route-specific `index.php` files compose the pages. A PowerShell checker validates structure and advertising policy, while the official PHP 8.2 container supplies syntax and preview checks because PHP is not installed locally.

**Tech Stack:** PHP 8.2, semantic HTML5, CSS, minimal vanilla JavaScript, PowerShell 7, Docker-hosted PHP CLI.

## Global Constraints

- English is the only launch language; do not create incomplete translations.
- `/play/`, `/en/`, loading, error, redirect, and pure interaction screens must never load AdSense display advertising.
- Preserve publisher ID `ca-pub-7672795271513455`, but keep display ads globally disabled through launch review.
- Use current facts: 200 stages, 20 normal monsters, 10 bosses, 10 worlds, one main hero plus five heroes, stage-20 rebirth, stage-25 first recommended rebirth, and 100 rebirth maximum.
- Hero unlocks are Archer 5, Mage 10, Paladin 15, Rogue 22, and Priest 35.
- Rebirth keeps gold, resets stage and hero progress, adds 5% main-hero tap damage, and does not affect hero DPS.
- Do not copy internal engineering audits, archived rules, or programmatically generated thin pages.
- Do not download or copy files from `Funny-niice/TinyHeroesTap`; use the existing landing image until separately approved screenshots are supplied.
- Every public content page needs one H1, unique title and description, canonical URL, skip link, global navigation, and footer.
- No placeholders, dead links, unfinished controls, direct display-ad scripts, or trailing whitespace.

---

## File Map

```text
index.php; 404.php; .htaccess; robots.txt; sitemap.xml
includes/config.php; includes/content.php; includes/render.php
assets/site.css; assets/site.js
play/index.php; game-info/index.php; faq/index.php
guides/index.php
guides/{beginners-guide,upgrading-guide,boss-battles,offline-rewards,rebirth-guide}/index.php
heroes/index.php; bosses/index.php; worlds/index.php
updates/index.php; about/index.php; contact/index.php
privacy/index.php; terms/index.php
tools/check-site.ps1
```

Shared renderer contract:

```php
render_header(array $page): void;
render_footer(): void;
render_breadcrumbs(array $items): void;
render_card_grid(array $items, string $className = ''): void;
render_ad_slot(string $slotName): void;
```

Every page descriptor uses:

```php
[
    'title' => 'Unique title',
    'description' => 'Unique description.',
    'canonical' => '/route/',
    'section' => 'home|play|guides|heroes|bosses|worlds|support',
    'allow_ads' => false,
]
```

---

### Task 1: Add the Policy Test Harness

**Files:**
- Create: `tools/check-site.ps1`

**Interfaces:**
- Produces exit `0` and `Site checks passed.`, or exit `1` with one message per violation.

- [ ] **Step 1: Write the failing page-existence test**

```powershell
$ErrorActionPreference = 'Stop'
$root = Split-Path -Parent $PSScriptRoot
$errors = [System.Collections.Generic.List[string]]::new()
$pages = @(
  'index.php','404.php','play/index.php','game-info/index.php',
  'guides/index.php','guides/beginners-guide/index.php',
  'guides/upgrading-guide/index.php','guides/boss-battles/index.php',
  'guides/offline-rewards/index.php','guides/rebirth-guide/index.php',
  'heroes/index.php','bosses/index.php','worlds/index.php','faq/index.php',
  'updates/index.php','about/index.php','contact/index.php',
  'privacy/index.php','terms/index.php'
)
foreach ($page in $pages) {
  if (-not (Test-Path (Join-Path $root $page))) { $errors.Add("Missing page: $page") }
}
if ($errors.Count) { $errors | ForEach-Object { Write-Error $_ }; exit 1 }
Write-Output 'Site checks passed.'
```

- [ ] **Step 2: Prove it fails**

Run: `pwsh -NoProfile -File tools/check-site.ps1`

Expected: exit `1`, including `Missing page: 404.php`.

- [ ] **Step 3: Add shared-file, placeholder, metadata, and ad-isolation checks**

Add assertions for `includes/config.php`, `includes/content.php`, `includes/render.php`, `assets/site.css`, and `assets/site.js`. Reject `TBD|TODO|coming soon|lorem ipsum|href="#"`; reject `adsbygoogle|pagead2|render_ad_slot` in `play/index.php`; require `ADSENSE_DISPLAY_ENABLED', false` in config; require each non-404 PHP route to call `render_header(`.

- [ ] **Step 4: Commit the failing gate**

```powershell
git add tools/check-site.ps1
git commit -m "test: add content site policy checks"
```

---

### Task 2: Add the Shared Site Platform

**Files:**
- Create: `includes/config.php`
- Create: `includes/content.php`
- Create: `includes/render.php`
- Create: `assets/site.css`
- Create: `assets/site.js`
- Modify: `tools/check-site.ps1`

**Interfaces:** Produces the shared renderer contract, plus `$heroes`, `$bosses`, `$worlds`, and `$guides`.

- [ ] **Step 1: Add and run failing shared-file assertions**

Expected: `Missing shared file: includes/config.php`.

- [ ] **Step 2: Create exact configuration**

```php
<?php
declare(strict_types=1);
const SITE_NAME = 'Tiny Heroes Tap';
const SITE_ORIGIN = 'https://tinyheroestap.com';
const ADSENSE_PUBLISHER_ID = 'ca-pub-7672795271513455';
const ADSENSE_DISPLAY_ENABLED = false;
const GAME_CLIENT_PATH = '/en/';
const CONTACT_URL = 'https://github.com/Funny-niice/ADserver/issues';
```

Confirm `SITE_ORIGIN` against production before publishing; never deploy mixed canonicals.

- [ ] **Step 3: Define canonical content data**

```php
$heroes = [
 ['name'=>'Swordsman','stage'=>1,'role'=>'Player-controlled tap damage'],
 ['name'=>'Archer','stage'=>5,'role'=>'Early automatic damage'],
 ['name'=>'Mage','stage'=>10,'role'=>'Slow, heavy automatic hits'],
 ['name'=>'Paladin','stage'=>15,'role'=>'Reliable mid-game damage'],
 ['name'=>'Rogue','stage'=>22,'role'=>'Fast automatic attacks'],
 ['name'=>'Priest','stage'=>35,'role'=>'Late-game automatic damage'],
];
$bosses = [
 ['name'=>'Meadow Slime King','time'=>30],['name'=>'Cloud Gate Titan','time'=>22],
 ['name'=>'Mist Rune Colossus','time'=>25],['name'=>'Storm Bridge Roc','time'=>25],
 ['name'=>'Star Tower Hydra','time'=>28],['name'=>'Moon Archive Golem','time'=>28],
 ['name'=>'Thunder Forge Djinn','time'=>31],['name'=>'Frost Crown Beast','time'=>31],
 ['name'=>'Void Gate Dragon','time'=>34],['name'=>'Sky Throne Warden','time'=>34],
];
$worlds = ['Sunrise Fields','Cloud Castle','Mist Ruins','Storm Bridge','Star Tower',
 'Moon Archive','Thunder Forge','Frost Crown','Void Gate','Sky Throne'];
```

Define `$guides` with title, URL, and one-sentence summary for the five guide routes.

- [ ] **Step 4: Implement the renderer**

Escape dynamic output with `htmlspecialchars($value, ENT_QUOTES, 'UTF-8')`. Output `<html lang="en">`, viewport, unique metadata, canonical, stylesheet, skip link, navigation, and footer. Navigation order is Home, Guides, Heroes, Bosses, Worlds, FAQ, Play. Footer links to About, Contact, Privacy, Terms, Updates, and GitHub. `render_ad_slot()` returns without output unless the global flag and page flag are both true.

- [ ] **Step 5: Implement styling and mobile navigation**

Use the current navy/sky/violet/gold palette, `72rem` container, `65ch` article width, responsive card grids, visible focus, accessible skip link, and one-column layout below `56rem`. JavaScript only toggles mobile navigation `aria-expanded` and `data-open`; core content remains available without JavaScript.

- [ ] **Step 6: Verify and commit**

```powershell
pwsh -NoProfile -File tools/check-site.ps1
docker run --rm -v "${PWD}:/app" -w /app php:8.2-cli sh -lc 'find includes -name "*.php" -print0 | xargs -0 -n1 php -l'
git add includes assets/site.css assets/site.js tools/check-site.ps1
git commit -m "feat: add shared content site platform"
```

Expected: PHP syntax passes; static test still fails only for public pages not yet created.

---

### Task 3: Replace the Homepage and Isolate Play

**Files:**
- Modify: `index.php`
- Create: `play/index.php`
- Modify: `tools/check-site.ps1`

**Interfaces:** Produces substantive `/` and ad-free `/play/`; play iframe consumes `GAME_CLIENT_PATH`.

- [ ] **Step 1: Add failing assertions**

Require homepage headings `How the adventure works`, `Meet the heroes`, `Boss battles`, `Explore ten sky realms`, and `Player guides`. Require play iframe source to use `GAME_CLIENT_PATH` and reject all ad symbols in the play source.

- [ ] **Step 2: Replace the homepage**

Use shared rendering with title `Tiny Heroes Tap — Official Game and Player Guides`, canonical `/`, and `allow_ads => false`. Add: a hero with existing image and links to Play/Beginner Guide; a five-step gameplay loop; six hero cards; boss mechanics; all ten realms; and five guide cards. Write 800–1,200 words of factual, manually edited English copy rather than promotional repetition.

- [ ] **Step 3: Create the play wrapper**

```php
<?php
declare(strict_types=1);
require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/render.php';
$page = ['title'=>'Play Tiny Heroes Tap','description'=>'Launch the Tiny Heroes Tap web game.',
 'canonical'=>'/play/','section'=>'play','allow_ads'=>false];
render_header($page);
?>
<main id="main-content" class="play-page">
 <div class="container"><h1>Play Tiny Heroes Tap</h1>
 <p>If the game does not load, <a href="<?= htmlspecialchars(GAME_CLIENT_PATH, ENT_QUOTES, 'UTF-8') ?>">open the client directly</a>.</p></div>
 <iframe class="game-frame" src="<?= htmlspecialchars(GAME_CLIENT_PATH, ENT_QUOTES, 'UTF-8') ?>" title="Tiny Heroes Tap game client" allow="autoplay; fullscreen"></iframe>
 <nav class="container" aria-label="Game help"><a href="/guides/beginners-guide/">Beginner’s guide</a> <a href="/guides/boss-battles/">Boss help</a> <a href="/contact/">Report a problem</a></nav>
</main>
<?php render_footer(); ?>
```

- [ ] **Step 4: Verify and commit**

```powershell
pwsh -NoProfile -File tools/check-site.ps1
rg -n "adsbygoogle|pagead2|render_ad_slot" play
git add index.php play tools/check-site.ps1
git commit -m "feat: add content homepage and ad-free game page"
```

Expected: `rg` returns no matches under `play`.

---

### Task 4: Publish Five Core Guides

**Files:**
- Create: `guides/index.php`
- Create: `guides/beginners-guide/index.php`
- Create: `guides/upgrading-guide/index.php`
- Create: `guides/boss-battles/index.php`
- Create: `guides/offline-rewards/index.php`
- Create: `guides/rebirth-guide/index.php`
- Modify: `tools/check-site.ps1`

**Interfaces:** Produces six indexable launch pages using shared breadcrumbs and guide cards.

- [ ] **Step 1: Add failing fact assertions**

Require Beginner: `Tap damage`, `Hero DPS`, `Every fifth stage`; Upgrading: all six hero names; Boss: `15 seconds`, `does not remove gold`, `once per battle`; Offline: `does not defeat a boss`, `hero DPS`; Rebirth: `stage 20`, `stage 25`, `5%`, `does not affect hero DPS`.

- [ ] **Step 2: Create hub and two progression guides**

Hub uses H1 `Tiny Heroes Tap player guides`, 120–180 word introduction, and all guide cards. Beginner sections: first battle; tap vs DPS; stages; first gold; first boss; team unlocks; slowing progress; checklist. Upgrading sections: what gold improves; Swordsman; unlocking heroes; speed vs DPS; early/mid/late priorities; boss wall; mistakes.

- [ ] **Step 3: Create Boss, Offline, and Rebirth guides**

Boss sections: trigger; countdown; failure; optional one-time 15-second extension; no-ad preparation; tap/DPS preparation; checklist. Offline sections: away time; stopping at Boss; hero DPS; base reward; optional doubling; spend returning gold; troubleshooting. Rebirth sections: stage 20; stage 25; reset; retained gold; 5% bonus; unaffected hero DPS; timing; checklist.

Each guide must contain 700–1,000 words of manually reviewed prose, direct links to two related guides, one link to Play, and no untested “optimal build” claims.

- [ ] **Step 4: Verify and commit**

```powershell
pwsh -NoProfile -File tools/check-site.ps1
docker run --rm -v "${PWD}:/app" -w /app php:8.2-cli sh -lc 'find guides -name "*.php" -print0 | xargs -0 -n1 php -l'
git add guides tools/check-site.ps1
git commit -m "feat: publish core player guides"
```

---

### Task 5: Publish Game Reference Pages and FAQ

**Files:**
- Create: `heroes/index.php`
- Create: `bosses/index.php`
- Create: `worlds/index.php`
- Create: `game-info/index.php`
- Create: `faq/index.php`
- Modify: `tools/check-site.ps1`

**Interfaces:** Consumes canonical data arrays and produces five content pages without thin child pages.

- [ ] **Step 1: Add failing record assertions**

Require all six heroes, ten bosses, and ten world names in their respective rendered sources. Require all FAQ questions from Step 3.

- [ ] **Step 2: Create Heroes, Bosses, Worlds, and Game Info**

Heroes: explain tap vs automatic DPS; render six cards; add `Building the team`, `Unlocking versus upgrading`, and `Heroes after stage 40`. Bosses: render names and base timers; add `The repeating boss cycle`, `Time limits are not difficulty ratings`, and `How to use this field guide`; omit internal HP multipliers. Worlds: describe every realm in 60–100 original words and explain the 200-stage cycle. Game Info: genre, portrait play, 200 stages, roster, gold economy, optional rewarded ads, offline rewards, and rebirth.

- [ ] **Step 3: Create the FAQ**

Use `<details><summary>` and 60–140 word answers for: free-to-play status; whether ads are mandatory; boss failure; boss loss consequences; hero unlocks; offline rewards; rebirth availability; rebirth reset/retention; progress storage; supported devices/browsers. Do not claim cloud save; say progress stays in the current browser unless the deployed platform explicitly provides its own save feature.

- [ ] **Step 4: Verify and commit**

```powershell
pwsh -NoProfile -File tools/check-site.ps1
docker run --rm -v "${PWD}:/app" -w /app php:8.2-cli sh -lc 'find heroes bosses worlds game-info faq -name "*.php" -print0 | xargs -0 -n1 php -l'
git add heroes bosses worlds game-info faq tools/check-site.ps1
git commit -m "feat: add game reference content"
```

---

### Task 6: Add Transparency and Legal Pages

**Files:**
- Create: `about/index.php`
- Create: `contact/index.php`
- Create: `privacy/index.php`
- Create: `terms/index.php`
- Create: `updates/index.php`
- Modify: `tools/check-site.ps1`

**Interfaces:** Uses `CONTACT_URL`; produces footer-linked transparency pages.

- [ ] **Step 1: Add failing assertions**

Require About: `independent game publisher`; Contact: exact GitHub Issues URL; Privacy: `local browser storage`, `Google AdSense`, `cookies`; Terms: `no guarantee of uninterrupted availability`; Updates: `2026-07-13`.

- [ ] **Step 2: Write About and Contact**

Identify Funny-niice as the independent publisher; explain the playable client and manually maintained guides; link public GitHub repositories. Contact routes bugs, corrections, privacy, and accessibility feedback to GitHub Issues and asks for URL, browser/device, reproduction steps, and a privacy-safe screenshot. Do not invent email.

- [ ] **Step 3: Write Privacy and Terms**

Privacy dated 2026-07-13 includes: information provided; local game progress; server logs; Cookies and Google AdSense; choices; children; requests; changes. State display ads are disabled now and describe cookies/consent if AdSense is enabled. Terms cover personal play, prohibited abuse, IP, optional ads, third parties, saved progress, availability, disclaimer, liability, changes, and contact.

- [ ] **Step 4: Write Updates, verify, and commit**

Publish only one truthful entry, `Official site content redesign`, dated 2026-07-13. Then run syntax/static checks and commit:

```powershell
git add about contact privacy terms updates tools/check-site.ps1
git commit -m "feat: add publisher transparency pages"
```

---

### Task 7: Add Crawl Controls and Error Handling

**Files:**
- Create: `404.php`
- Create: `.htaccess`
- Create: `robots.txt`
- Create: `sitemap.xml`
- Modify: `includes/render.php`
- Modify: `tools/check-site.ps1`

**Interfaces:** Produces a noindex ad-free 404 and a sitemap containing substantive content only.

- [ ] **Step 1: Add failing crawl assertions**

Require all four files; require sitemap entries for every content page and five guides; reject `/play/`, `/en/`, and `404.php`; parse sitemap with `[xml]`.

- [ ] **Step 2: Create 404 and Apache policy**

404 sends status 404, uses `allow_ads => false`, outputs `noindex,follow`, and links Home, Guides, FAQ, and Play.

```apache
DirectoryIndex index.php
ErrorDocument 404 /404.php
Options -Indexes
```

- [ ] **Step 3: Create crawler files**

```text
User-agent: *
Allow: /
Disallow: /en/
Sitemap: https://tinyheroestap.com/sitemap.xml
```

Sitemap uses one HTTPS origin, includes all substantive content routes and five guides, excludes Play/client/error routes, and omits artificial priority/change-frequency values.

- [ ] **Step 4: Strengthen and run the final static gate**

Reject direct AdSense script references outside `includes/render.php`; reject any `allow_ads => true`; validate local directory link targets; require no more than one literal H1 per route; require unique canonicals; validate sitemap XML.

```powershell
pwsh -NoProfile -File tools/check-site.ps1
docker run --rm -v "${PWD}:/app" -w /app php:8.2-cli sh -lc 'find . -name "*.php" -print0 | xargs -0 -n1 php -l'
git diff --check
```

Expected: `Site checks passed.`, all PHP files report no syntax errors, and `git diff --check` is silent.

- [ ] **Step 5: Commit**

```powershell
git add 404.php .htaccess robots.txt sitemap.xml includes/render.php tools/check-site.ps1
git commit -m "feat: finish crawl and policy safeguards"
```

---

### Task 8: Browser QA and Release Gate

**Files:**
- Modify only files that fail a documented check.

**Interfaces:** Produces verified desktop/mobile behavior; does not push or submit AdSense review.

- [ ] **Step 1: Start preview**

```powershell
docker run --rm -d --name adserver-preview -p 8080:8080 -v "${PWD}:/app" -w /app php:8.2-cli php -S 0.0.0.0:8080
```

- [ ] **Step 2: Inspect desktop 1440×900 and mobile 390×844**

Verify Home, all Guides, Heroes, Bosses, Worlds, FAQ, About, Privacy, and Play; no horizontal scrolling; visible keyboard focus and skip link; correct mobile menu ARIA state; Play fallback remains available when `/en/` is absent; no network request to `pagead2.googlesyndication.com`.

- [ ] **Step 3: Run final automated evidence**

```powershell
pwsh -NoProfile -File tools/check-site.ps1
docker run --rm -v "${PWD}:/app" -w /app php:8.2-cli sh -lc 'find . -name "*.php" -print0 | xargs -0 -n1 php -l'
git diff --check
docker rm -f adserver-preview
git status --short --branch
```

Expected: all automated checks pass, preview container stops, and working tree is clean.

- [ ] **Step 4: Publisher release review**

Confirm the actual production origin and update `SITE_ORIGIN`, robots, and sitemap together if it differs. Manually approve English copy, privacy text, existing image use, and `/en/` client path. Do not enable ads, push, deploy, or request AdSense review without separate authorization.

---

## Completion Gate

- Static checker exits 0 and every PHP file passes PHP 8.2 syntax.
- Display-ad network requests are absent while the kill switch is false.
- Play, client, errors, redirects, and behavioral screens remain ad-free.
- All launch page groups are complete, cross-linked, mobile-readable, and placeholder-free.
- Sitemap contains only substantive content routes.
- Public facts agree with current runtime configuration.
- Publisher confirms production origin, copy, privacy notice, image rights, and client path.
