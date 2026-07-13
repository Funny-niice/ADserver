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
$sharedFiles = @(
  'includes/config.php','includes/content.php','includes/render.php',
  'assets/site.css','assets/site.js'
)

function Assert-FileContains {
  param(
    [string]$RelativePath,
    [string[]]$ExpectedLiterals
  )

  $path = Join-Path $root $RelativePath
  if (-not (Test-Path -LiteralPath $path -PathType Leaf)) { return }
  $source = Get-Content -Raw -LiteralPath $path
  foreach ($literal in $ExpectedLiterals) {
    if (-not $source.Contains($literal)) {
      $errors.Add("Missing shared contract in ${RelativePath}: $literal")
    }
  }
}

function Assert-FileExcludes {
  param(
    [string]$RelativePath,
    [string[]]$DisallowedLiterals
  )

  $path = Join-Path $root $RelativePath
  if (-not (Test-Path -LiteralPath $path -PathType Leaf)) { return }
  $source = Get-Content -Raw -LiteralPath $path
  foreach ($literal in $DisallowedLiterals) {
    if ($source.Contains($literal)) {
      $errors.Add("Disallowed shared contract in ${RelativePath}: $literal")
    }
  }
}

function Assert-FileContainsInOrder {
  param(
    [string]$RelativePath,
    [string[]]$ExpectedLiterals
  )

  $path = Join-Path $root $RelativePath
  if (-not (Test-Path -LiteralPath $path -PathType Leaf)) { return }
  $source = Get-Content -Raw -LiteralPath $path
  $position = -1
  foreach ($literal in $ExpectedLiterals) {
    $next = $source.IndexOf($literal, $position + 1, [System.StringComparison]::Ordinal)
    if ($next -lt 0) {
      $errors.Add("Missing or out-of-order shared contract in ${RelativePath}: $literal")
      return
    }
    $position = $next
  }
}

function Assert-HomepageContentQuality {
  $phpPath = Join-Path $root '.tools\php72\php.exe'
  $indexPath = Join-Path $root 'index.php'
  if (-not (Test-Path -LiteralPath $phpPath -PathType Leaf) -or -not (Test-Path -LiteralPath $indexPath -PathType Leaf)) {
    return
  }

  $rendered = & $phpPath $indexPath 2>&1 | Out-String
  if ($LASTEXITCODE -ne 0) {
    $errors.Add('Homepage could not be rendered for content-quality checks.')
    return
  }

  foreach ($cardType in @('hero', 'realm')) {
    $expectedCount = if ($cardType -eq 'hero') { 6 } else { 10 }
    $pattern = '<article class="card ' + $cardType + '-card">.*?<p>(.*?)</p>.*?</article>'
    $matches = [regex]::Matches($rendered, $pattern, [System.Text.RegularExpressions.RegexOptions]::Singleline)
    if ($matches.Count -ne $expectedCount) {
      $errors.Add("Homepage must render $expectedCount ${cardType} cards with content summaries.")
      continue
    }

    $summaries = @($matches | ForEach-Object {
      $plainText = [regex]::Replace($_.Groups[1].Value, '<[^>]+>', ' ')
      [System.Net.WebUtility]::HtmlDecode($plainText).Trim()
    })
    if (@($summaries | Select-Object -Unique).Count -ne $summaries.Count) {
      $errors.Add("Homepage ${cardType} card summaries must be unique.")
    }
  }

  $guideSection = [regex]::Match(
    $rendered,
    '<section class="container" aria-labelledby="guides-heading">(.*?)</section>',
    [System.Text.RegularExpressions.RegexOptions]::Singleline
  )
  if (-not $guideSection.Success -or
      [regex]::Matches($guideSection.Value, '<h2(?:\s|>)').Count -ne 1 -or
      [regex]::Matches($guideSection.Value, '<h3(?:\s|>)').Count -ne 5) {
    $errors.Add('Homepage guide section must use one H2 section heading and five H3 card headings.')
  }
}

foreach ($page in $pages) {
  if (-not (Test-Path -LiteralPath (Join-Path $root $page) -PathType Leaf)) { $errors.Add("Missing page: $page") }
}
foreach ($file in $sharedFiles) {
  if (-not (Test-Path -LiteralPath (Join-Path $root $file) -PathType Leaf)) { $errors.Add("Missing shared file: $file") }
}

$placeholderPatterns = @('TBD','TODO','coming soon','lorem ipsum','href="#"')
$siteFiles = @($pages + $sharedFiles) |
  Where-Object { Test-Path -LiteralPath (Join-Path $root $_) -PathType Leaf } |
  Select-Object -Unique
foreach ($file in $siteFiles) {
  $source = Get-Content -Raw -LiteralPath (Join-Path $root $file)
  foreach ($pattern in $placeholderPatterns) {
    if ($source -match [regex]::Escape($pattern)) {
      $errors.Add("Disallowed placeholder in ${file}: $pattern")
    }
  }
}

$adFreePages = @('play/index.php', '404.php')
foreach ($page in $pages) {
  $pagePath = Join-Path $root $page
  if (Test-Path -LiteralPath $pagePath -PathType Leaf) {
    $pageSource = Get-Content -Raw -LiteralPath $pagePath
    foreach ($pattern in @('adsbygoogle', 'pagead2')) {
      if ($pageSource -match [regex]::Escape($pattern)) {
        $errors.Add("Ad code is not isolated from ${page}: $pattern")
      }
    }
    if ($pageSource -match '[''"]allow_ads[''"]\s*=>\s*true') {
      $errors.Add("Display ads are not permitted by page policy: $page")
    }
    if ($pageSource -match '[''"]allow_ads[''"]\s*=>\s*false' -and $pageSource.Contains('render_ad_slot')) {
      $errors.Add("Ad slot call is not permitted on ad-free page: $page")
    }
  }
}
foreach ($page in $adFreePages) {
  $pagePath = Join-Path $root $page
  if (Test-Path -LiteralPath $pagePath -PathType Leaf) {
    $pageSource = Get-Content -Raw -LiteralPath $pagePath
    if ($pageSource -notmatch '[''"]allow_ads[''"]\s*=>\s*false') {
      $errors.Add("Missing ad-free page policy: $page")
    }
  }
}

$configPath = Join-Path $root 'includes/config.php'
if (Test-Path -LiteralPath $configPath -PathType Leaf) {
  $configSource = Get-Content -Raw -LiteralPath $configPath
  if ($configSource -notmatch 'const\s+ADSENSE_DISPLAY_ENABLED\s*=\s*false\s*;') {
    $errors.Add('Missing disabled AdSense display setting: const ADSENSE_DISPLAY_ENABLED = false;')
  }
}

Assert-FileContains 'includes/config.php' @(
  "const SITE_NAME = 'Tiny Heroes Tap';",
  "const SITE_ORIGIN = 'https://tinyheroestap.com';",
  "const ADSENSE_PUBLISHER_ID = 'ca-pub-7672795271513455';",
  "const GAME_CLIENT_PATH = '/en/';",
  "const CONTACT_URL = 'https://github.com/Funny-niice/ADserver/issues';"
)
Assert-FileContains 'includes/content.php' @(
  '$heroes = [', '$bosses = [', '$worlds = [', '$guides = ['
)
Assert-FileContainsInOrder 'includes/content.php' @(
  "['name'=>'Swordsman','stage'=>1,'role'=>'Player-controlled tap damage']",
  "['name'=>'Archer','stage'=>5,'role'=>'Early automatic damage']",
  "['name'=>'Mage','stage'=>10,'role'=>'Slow, heavy automatic hits']",
  "['name'=>'Paladin','stage'=>15,'role'=>'Reliable mid-game damage']",
  "['name'=>'Rogue','stage'=>22,'role'=>'Fast automatic attacks']",
  "['name'=>'Priest','stage'=>35,'role'=>'Late-game automatic damage']",
  "['name'=>'Meadow Slime King','time'=>30]", "['name'=>'Cloud Gate Titan','time'=>22]",
  "['name'=>'Mist Rune Colossus','time'=>25]", "['name'=>'Storm Bridge Roc','time'=>25]",
  "['name'=>'Star Tower Hydra','time'=>28]", "['name'=>'Moon Archive Golem','time'=>28]",
  "['name'=>'Thunder Forge Djinn','time'=>31]", "['name'=>'Frost Crown Beast','time'=>31]",
  "['name'=>'Void Gate Dragon','time'=>34]", "['name'=>'Sky Throne Warden','time'=>34]",
  "'Sunrise Fields','Cloud Castle','Mist Ruins','Storm Bridge','Star Tower'",
  "'Moon Archive','Thunder Forge','Frost Crown','Void Gate','Sky Throne'",
  "'title' => `"Beginner's Guide`"", "'url' => '/guides/beginners-guide/'",
  "'summary' => 'Learn the tapping, hero, coin, and stage basics for a confident first run.'",
  "'title' => 'Upgrading Guide'", "'url' => '/guides/upgrading-guide/'",
  "'summary' => 'Spend coins efficiently by balancing tap damage with automatic hero damage.'",
  "'title' => 'Boss Battles Guide'", "'url' => '/guides/boss-battles/'",
  "'summary' => 'Prepare for timed boss encounters with practical damage and timing strategies.'",
  "'title' => 'Offline Rewards Guide'", "'url' => '/guides/offline-rewards/'",
  "'summary' => 'Make steady progress between sessions by improving your automatic damage.'",
  "'title' => 'Rebirth Guide'", "'url' => '/guides/rebirth-guide/'",
  "'summary' => 'Choose the right moment to restart a run and accelerate future progress.'"
)
Assert-FileContains 'includes/render.php' @(
  'function escape_html(', 'function render_header(array $page): void', 'function render_footer(): void',
  'function render_breadcrumbs(array $items): void',
  "function render_card_grid(array `$items, string `$className = ''): void",
  'function render_ad_slot(string $slotName): void', "htmlspecialchars(`$value, ENT_QUOTES, 'UTF-8')",
  '<html lang="en">', 'name="viewport"', 'rel="canonical"',
  'href="/assets/site.css"', 'class="skip-link"', 'aria-expanded="false"',
  "'allow_ads'", "if (!ADSENSE_DISPLAY_ENABLED || !`$pageAllowsAds)"
)
Assert-FileExcludes 'includes/render.php' @('<main ', '</main>')
Assert-FileContains 'assets/site.css' @(
  '--navy:', '--sky:', '--violet:', '--gold:', 'max-width: 72rem;',
  'max-width: 65ch;', ':focus-visible', '.skip-link',
  '@media (max-width: 56rem)', 'grid-template-columns: 1fr;'
)
Assert-FileContains 'assets/site.js' @(
  "querySelector('[data-nav-toggle]')", "setAttribute('aria-expanded'", 'dataset.open'
)
Assert-FileContains 'index.php' @(
  'How the adventure works', 'Meet the heroes', 'Boss battles',
  'Explore ten sky realms', 'Player guides'
)
Assert-FileExcludes 'index.php' @(
  'Consider what the current run needs before dividing coins',
  'Continue clearing its normal encounters, invest battle earnings'
)
Assert-FileContains 'play/index.php' @(
  'class="game-frame"',
  'src="<?= htmlspecialchars(GAME_CLIENT_PATH, ENT_QUOTES, ''UTF-8'') ?>"'
)
Assert-FileExcludes 'play/index.php' @(
  'adsbygoogle', 'pagead2', 'render_ad_slot'
)
Assert-HomepageContentQuality

foreach ($page in ($pages | Where-Object { $_ -ne '404.php' })) {
  $pagePath = Join-Path $root $page
  if (Test-Path -LiteralPath $pagePath -PathType Leaf) {
    $source = Get-Content -Raw -LiteralPath $pagePath
    if ($source -notmatch [regex]::Escape('render_header(')) {
      $errors.Add("Missing render_header call: $page")
    }
  }
}

if ($errors.Count) {
  $errors | ForEach-Object { [Console]::Error.WriteLine($_) }
  exit 1
}
Write-Output 'Site checks passed.'
