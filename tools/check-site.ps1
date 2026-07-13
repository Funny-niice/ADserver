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

$playPath = Join-Path $root 'play/index.php'
if (Test-Path -LiteralPath $playPath -PathType Leaf) {
  $playSource = Get-Content -Raw -LiteralPath $playPath
  foreach ($pattern in @('adsbygoogle','pagead2','render_ad_slot')) {
    if ($playSource -match [regex]::Escape($pattern)) {
      $errors.Add("Ad code is not isolated from play/index.php: $pattern")
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
  '$heroes = [', '$bosses = [', '$worlds = [', '$guides = [',
  "'Swordsman'", "'Priest'", "'Meadow Slime King'", "'Sky Throne Warden'",
  "'Sunrise Fields'", "'Sky Throne'", "'/guides/beginners-guide/'",
  "'/guides/upgrading-guide/'", "'/guides/boss-battles/'",
  "'/guides/offline-rewards/'", "'/guides/rebirth-guide/'"
)
Assert-FileContains 'includes/render.php' @(
  'function escape_html(', 'function render_header(', 'function render_footer(',
  'function render_ad_slot(', "htmlspecialchars(`$value, ENT_QUOTES, 'UTF-8')",
  '<html lang="en">', 'name="viewport"', 'rel="canonical"',
  'href="/assets/site.css"', 'class="skip-link"', 'aria-expanded="false"',
  "if (!ADSENSE_DISPLAY_ENABLED || !`$pageEnabled)"
)
Assert-FileContains 'assets/site.css' @(
  '--navy:', '--sky:', '--violet:', '--gold:', 'max-width: 72rem;',
  'max-width: 65ch;', ':focus-visible', '.skip-link',
  '@media (max-width: 56rem)', 'grid-template-columns: 1fr;'
)
Assert-FileContains 'assets/site.js' @(
  "querySelector('[data-nav-toggle]')", "setAttribute('aria-expanded'", 'dataset.open'
)

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
