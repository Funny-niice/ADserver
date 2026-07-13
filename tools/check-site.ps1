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
  if ($configSource -notmatch [regex]::Escape("ADSENSE_DISPLAY_ENABLED', false")) {
    $errors.Add("Missing disabled AdSense display setting: ADSENSE_DISPLAY_ENABLED', false")
  }
}

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
