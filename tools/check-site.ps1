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
$crawlFiles = @('404.php','.htaccess','robots.txt','sitemap.xml')
$guidePages = @(
  'guides/beginners-guide/index.php',
  'guides/upgrading-guide/index.php',
  'guides/boss-battles/index.php',
  'guides/offline-rewards/index.php',
  'guides/rebirth-guide/index.php'
)
$sitemapRoutes = @(
  '/', '/game-info/', '/guides/',
  '/guides/beginners-guide/', '/guides/upgrading-guide/',
  '/guides/boss-battles/', '/guides/offline-rewards/',
  '/guides/rebirth-guide/', '/heroes/', '/bosses/', '/worlds/', '/faq/',
  '/updates/', '/about/', '/contact/', '/privacy/', '/terms/'
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

function Get-RenderedPage {
  param([string]$RelativePath)

  $phpPath = Join-Path $root '.tools\php72\php.exe'
  $pagePath = Join-Path $root $RelativePath
  if (-not (Test-Path -LiteralPath $phpPath -PathType Leaf) -or -not (Test-Path -LiteralPath $pagePath -PathType Leaf)) {
    return $null
  }

  $rendered = & $phpPath $pagePath 2>&1 | Out-String
  if ($LASTEXITCODE -ne 0) {
    $errors.Add("Page could not be rendered for content-quality checks: $RelativePath")
    return $null
  }

  return $rendered
}

function Get-PlainWordCount {
  param([string]$Html)

  $plainText = [regex]::Replace($Html, '<[^>]+>', ' ')
  $plainText = [System.Net.WebUtility]::HtmlDecode($plainText)
  return [regex]::Matches($plainText, "[A-Za-z0-9]+(?:['-][A-Za-z0-9]+)*").Count
}

function Assert-RenderedPageContains {
  param(
    [string]$RelativePath,
    [string[]]$ExpectedLiterals
  )

  $rendered = Get-RenderedPage $RelativePath
  if ($null -eq $rendered) { return }
  foreach ($literal in $ExpectedLiterals) {
    if (-not $rendered.Contains($literal)) {
      $errors.Add("Missing rendered content in ${RelativePath}: $literal")
    }
  }
}

function Get-CanonicalHrefs {
  param([string]$Html)

  $linkTags = [regex]::Matches(
    $Html,
    '<link\b[^>]*>',
    [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
  )
  foreach ($linkTag in $linkTags) {
    $rel = [regex]::Match(
      $linkTag.Value,
      '\brel\s*=\s*["'']([^"'']*)["'']',
      [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )
    if (-not $rel.Success -or @($rel.Groups[1].Value -split '\s+') -notcontains 'canonical') {
      continue
    }

    $href = [regex]::Match(
      $linkTag.Value,
      '\bhref\s*=\s*["'']([^"'']+)["'']',
      [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )
    if ($href.Success) {
      Write-Output ([System.Net.WebUtility]::HtmlDecode($href.Groups[1].Value))
    }
  }
}

function Assert-GuideContentQuality {
  foreach ($relativePath in $guidePages) {
    $rendered = Get-RenderedPage $relativePath
    if ($null -eq $rendered) { continue }

    $article = [regex]::Match(
      $rendered,
      '<article class="article">(.*?)</article>',
      [System.Text.RegularExpressions.RegexOptions]::Singleline
    )
    if (-not $article.Success) {
      $errors.Add("Guide article could not be checked: $relativePath")
      continue
    }

    $paragraphText = @([regex]::Matches(
      $article.Groups[1].Value,
      '<p(?:\s[^>]*)?>(.*?)</p>',
      [System.Text.RegularExpressions.RegexOptions]::Singleline
    ) | ForEach-Object { $_.Groups[1].Value }) -join ' '
    $wordCount = Get-PlainWordCount $paragraphText
    if ($wordCount -lt 700 -or $wordCount -gt 1000) {
      $errors.Add("Guide prose must contain 700-1000 words; found $wordCount words in $relativePath")
    }

    $h1Count = [regex]::Matches(
      $rendered,
      '<h1(?:\s|>)',
      [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    ).Count
    if ($h1Count -ne 1) {
      $errors.Add("Guide must render exactly one H1; found $h1Count in $relativePath")
    }

    $relatedGuides = @([regex]::Matches($article.Groups[1].Value, 'href="(/guides/[^"#?]+/)"') |
      ForEach-Object { $_.Groups[1].Value } | Select-Object -Unique)
    $ownRoute = '/' + ($relativePath -replace 'index\.php$','')
    $relatedGuides = @($relatedGuides | Where-Object { $_ -ne $ownRoute })
    if ($relatedGuides.Count -lt 2) {
      $errors.Add("Guide must link to at least two related guides: $relativePath")
    }
    if ($article.Groups[1].Value -notmatch 'href="/play/"') {
      $errors.Add("Guide must link directly to Play: $relativePath")
    }

    $expectedCanonical = 'https://tinyheroestap.com' + $ownRoute
    $guideCanonicals = @(Get-CanonicalHrefs $rendered)
    if ($guideCanonicals.Count -ne 1 -or $guideCanonicals[0] -ne $expectedCanonical) {
      $errors.Add("Guide canonical does not match its route: $relativePath")
    }
    if ($rendered -match 'adsbygoogle|pagead2|data-ad-slot') {
      $errors.Add("Guide must render without display-ad markup: $relativePath")
    }
  }
}

function Assert-RenderedRouteContracts {
  $canonicals = @{}
  foreach ($relativePath in $pages) {
    $rendered = Get-RenderedPage $relativePath
    if ($null -eq $rendered) { continue }

    $h1Count = [regex]::Matches(
      $rendered,
      '<h1(?:\s|>)',
      [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    ).Count
    if ($h1Count -ne 1) {
      $errors.Add("Route must render exactly one H1; found $h1Count in $relativePath")
    }
    if ($rendered -match 'adsbygoogle|pagead2|data-ad-slot') {
      $errors.Add("Route must render without display-ad markup: $relativePath")
    }

    $canonicalHrefs = @(Get-CanonicalHrefs $rendered)
    if ($canonicalHrefs.Count -ne 1) {
      $errors.Add("Route must render exactly one canonical link: $relativePath")
    } else {
      $canonical = $canonicalHrefs[0]
      if ($canonicals.ContainsKey($canonical)) {
        $errors.Add("Canonical URL is not unique: $canonical")
      } else {
        $canonicals[$canonical] = $relativePath
      }
    }

    $links = [regex]::Matches($rendered, 'href\s*=\s*["'']([^"'']+)["'']')
    foreach ($link in $links) {
      $target = [System.Net.WebUtility]::HtmlDecode($link.Groups[1].Value)
      if ($target -match '^[a-z][a-z0-9+.-]*:' -or $target.StartsWith('//') -or $target.StartsWith('#')) {
        continue
      }
      $target = ($target -split '[?#]', 2)[0]
      if (-not $target.EndsWith('/') -or $target -eq '/en/') {
        continue
      }
      $targetPath = if ($target -eq '/') {
        Join-Path $root 'index.php'
      } else {
        Join-Path $root (($target.Trim('/') -replace '/', '\') + '\index.php')
      }
      if (-not (Test-Path -LiteralPath $targetPath -PathType Leaf)) {
        $errors.Add("Broken local directory link in ${relativePath}: $target")
      }
    }
  }
}

function Assert-CrawlControls {
  foreach ($relativePath in $crawlFiles) {
    if (-not (Test-Path -LiteralPath (Join-Path $root $relativePath) -PathType Leaf)) {
      $errors.Add("Missing crawl or error file: $relativePath")
    }
  }

  $sitemapPath = Join-Path $root 'sitemap.xml'
  if (Test-Path -LiteralPath $sitemapPath -PathType Leaf) {
    try {
      [xml]$sitemap = Get-Content -Raw -LiteralPath $sitemapPath
      $locations = @($sitemap.SelectNodes('/*[local-name()="urlset"]/*[local-name()="url"]/*[local-name()="loc"]') |
        ForEach-Object { $_.InnerText.Trim() })
      $expectedLocations = @($sitemapRoutes | ForEach-Object { 'https://tinyheroestap.com' + $_ })
      foreach ($expectedLocation in $expectedLocations) {
        if ($locations -notcontains $expectedLocation) {
          $errors.Add("Missing sitemap location: $expectedLocation")
        }
      }
      foreach ($location in $locations) {
        if ($expectedLocations -notcontains $location) {
          $errors.Add("Unexpected sitemap location: $location")
        }
        if ($location -notmatch '^https://tinyheroestap\.com/') {
          $errors.Add("Sitemap location must use the configured HTTPS origin: $location")
        }
      }
      if (@($locations | Select-Object -Unique).Count -ne $locations.Count) {
        $errors.Add('Sitemap locations must be unique.')
      }
      $sitemapSource = Get-Content -Raw -LiteralPath $sitemapPath
      if ($sitemapSource -match '<(?:changefreq|priority)>') {
        $errors.Add('Sitemap must not use artificial changefreq or priority values.')
      }
      foreach ($disallowedRoute in @('/play/','/en/','404.php')) {
        if ($sitemapSource.Contains($disallowedRoute)) {
          $errors.Add("Disallowed sitemap route: $disallowedRoute")
        }
      }
    } catch {
      $errors.Add("Sitemap is not valid XML: $($_.Exception.Message)")
    }
  }
}

function Assert-ReferencePageContentQuality {
  $expectedRecords = @{
    'heroes/index.php' = @('Swordsman','Archer','Mage','Paladin','Rogue','Priest')
    'bosses/index.php' = @(
      'Meadow Slime King','Cloud Gate Titan','Mist Rune Colossus','Storm Bridge Roc',
      'Star Tower Hydra','Moon Archive Golem','Thunder Forge Djinn','Frost Crown Beast',
      'Void Gate Dragon','Sky Throne Warden'
    )
    'worlds/index.php' = @(
      'Sunrise Fields','Cloud Castle','Mist Ruins','Storm Bridge','Star Tower',
      'Moon Archive','Thunder Forge','Frost Crown','Void Gate','Sky Throne'
    )
  }

  foreach ($relativePath in $expectedRecords.Keys) {
    $rendered = Get-RenderedPage $relativePath
    if ($null -eq $rendered) {
      $errors.Add("Reference content could not be checked: $relativePath")
      continue
    }
    foreach ($record in $expectedRecords[$relativePath]) {
      if (-not $rendered.Contains($record)) {
        $errors.Add("Missing rendered reference record in ${relativePath}: $record")
      }
    }
  }

  $heroesRendered = Get-RenderedPage 'heroes/index.php'
  if ($null -ne $heroesRendered) {
    $heroCards = [regex]::Matches(
      $heroesRendered,
      '<article class="card hero-card">.*?</article>',
      [System.Text.RegularExpressions.RegexOptions]::Singleline
    )
    if ($heroCards.Count -ne 6) {
      $errors.Add("Heroes page must render exactly 6 hero cards; found $($heroCards.Count).")
    }
  }

  $bossesRendered = Get-RenderedPage 'bosses/index.php'
  if ($null -ne $bossesRendered) {
    $bossCards = [regex]::Matches(
      $bossesRendered,
      '<article class="card boss-card">\s*<h2>(.*?)</h2>\s*<p><strong>Base timer: (\d+) seconds\.</strong>.*?</p>\s*</article>',
      [System.Text.RegularExpressions.RegexOptions]::Singleline
    )
    if ($bossCards.Count -ne 10) {
      $errors.Add("Bosses page must render exactly 10 boss cards; found $($bossCards.Count).")
    } else {
      $expectedBossTimers = @(
        'Meadow Slime King=30','Cloud Gate Titan=22','Mist Rune Colossus=25',
        'Storm Bridge Roc=25','Star Tower Hydra=28','Moon Archive Golem=28',
        'Thunder Forge Djinn=31','Frost Crown Beast=31',
        'Void Gate Dragon=34','Sky Throne Warden=34'
      )
      $renderedBossTimers = @($bossCards | ForEach-Object {
        $name = [System.Net.WebUtility]::HtmlDecode(([regex]::Replace($_.Groups[1].Value, '<[^>]+>', ' '))).Trim()
        $name + '=' + $_.Groups[2].Value
      })
      if (($renderedBossTimers -join '|') -ne ($expectedBossTimers -join '|')) {
        $errors.Add('Boss cards must preserve the exact canonical name-to-timer mapping and order.')
      }
    }
  }

  $worldsRendered = Get-RenderedPage 'worlds/index.php'
  if ($null -ne $worldsRendered) {
    $worldCards = [regex]::Matches(
      $worldsRendered,
      '<article class="card world-card">\s*<h2>.*?</h2>\s*<p>(.*?)</p>\s*</article>',
      [System.Text.RegularExpressions.RegexOptions]::Singleline
    )
    if ($worldCards.Count -ne 10) {
      $errors.Add('Worlds page must render ten world cards with distinct descriptions.')
    } else {
      $descriptions = @()
      foreach ($card in $worldCards) {
        $description = [System.Net.WebUtility]::HtmlDecode(([regex]::Replace($card.Groups[1].Value, '<[^>]+>', ' '))).Trim()
        $descriptions += $description
        $wordCount = Get-PlainWordCount $card.Groups[1].Value
        if ($wordCount -lt 60 -or $wordCount -gt 100) {
          $errors.Add("World description must contain 60-100 words; found $wordCount words.")
        }
      }
      if (@($descriptions | Select-Object -Unique).Count -ne 10) {
        $errors.Add('Every world description must be distinct.')
      }
    }
  }

  $faqRendered = Get-RenderedPage 'faq/index.php'
  if ($null -eq $faqRendered) {
    $errors.Add('FAQ content could not be checked: faq/index.php')
  } else {
    $faqQuestions = @(
      'Is Tiny Heroes Tap free to play?',
      'Are ads mandatory?',
      'What happens when I fail a boss battle?',
      'Do I lose gold or progress when a boss defeats me?',
      'When do heroes unlock?',
      'How do offline rewards work?',
      'When does rebirth become available?',
      'What does rebirth reset, and what do I keep?',
      'Where is my progress stored?',
      'Which devices and browsers are supported?'
    )
    foreach ($question in $faqQuestions) {
      if (-not $faqRendered.Contains("<summary>$question</summary>")) {
        $errors.Add("Missing FAQ question: $question")
      }
    }

    $answers = [regex]::Matches(
      $faqRendered,
      '<details>\s*<summary>.*?</summary>\s*<p>(.*?)</p>\s*</details>',
      [System.Text.RegularExpressions.RegexOptions]::Singleline
    )
    if ($answers.Count -ne 10) {
      $errors.Add('FAQ must render ten details and summary entries.')
    } else {
      foreach ($answer in $answers) {
        $wordCount = Get-PlainWordCount $answer.Groups[1].Value
        if ($wordCount -lt 60 -or $wordCount -gt 140) {
          $errors.Add("FAQ answer must contain 60-140 words; found $wordCount words.")
        }
      }
    }
  }
}

foreach ($page in $pages) {
  if (-not (Test-Path -LiteralPath (Join-Path $root $page) -PathType Leaf)) { $errors.Add("Missing page: $page") }
}
foreach ($file in $sharedFiles) {
  if (-not (Test-Path -LiteralPath (Join-Path $root $file) -PathType Leaf)) { $errors.Add("Missing shared file: $file") }
}

Assert-CrawlControls

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

$adFreePages = @(
  'play/index.php', '404.php', 'heroes/index.php', 'bosses/index.php',
  'worlds/index.php', 'game-info/index.php', 'faq/index.php',
  'about/index.php', 'contact/index.php', 'privacy/index.php',
  'terms/index.php', 'updates/index.php'
)
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

$sourceExtensions = @('.php','.html','.htm','.js','.css','.txt','.xml','.conf','.config','.ini','.json')
$excludedSourceDirectories = '^(?:\.git|\.tools|\.superpowers|docs|tools|vendor|node_modules)[\\/]'
$sourceFiles = @(Get-ChildItem -LiteralPath $root -Recurse -File | Where-Object {
  $relativePath = $_.FullName.Substring($root.Length + 1)
  $relativePath -notmatch $excludedSourceDirectories -and
    ($sourceExtensions -contains $_.Extension.ToLowerInvariant() -or $_.Name -eq '.htaccess')
})
foreach ($sourceFile in $sourceFiles) {
  $relativePath = $sourceFile.FullName.Substring($root.Length + 1)
  $source = Get-Content -Raw -LiteralPath $sourceFile.FullName
  if ($relativePath -ne 'includes\render.php' -and $source -match 'adsbygoogle|pagead2\.googlesyndication\.com') {
    $errors.Add("Direct AdSense script reference outside includes/render.php: $relativePath")
  }
  if ($sourceFile.Extension -eq '.php' -and $source -match '[''"]allow_ads[''"]\s*=>\s*true') {
    $errors.Add("Display ads are not permitted by page policy: $relativePath")
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
  '<html lang="en">', 'name="viewport"', 'canonical_url(', "'robots'", 'name="robots"',
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
Assert-FileContains 'guides/beginners-guide/index.php' @(
  'Tap damage', 'Hero DPS', 'Every fifth stage'
)
Assert-FileContains 'guides/upgrading-guide/index.php' @(
  'Swordsman', 'Archer', 'Mage', 'Paladin', 'Rogue', 'Priest'
)
Assert-FileContains 'guides/boss-battles/index.php' @(
  '15 seconds', 'does not remove gold', 'once per battle'
)
Assert-FileContains 'guides/offline-rewards/index.php' @(
  'does not defeat a boss', 'hero DPS'
)
Assert-FileContains 'guides/rebirth-guide/index.php' @(
  'stage 20', 'stage 25', '5%', 'does not affect hero DPS'
)
Assert-FileContains 'heroes/index.php' @(
  'Building the team', 'Unlocking versus upgrading', 'Heroes after stage 40'
)
Assert-FileContains 'bosses/index.php' @(
  'The repeating boss cycle', 'Time limits are not difficulty ratings', 'How to use this field guide'
)
Assert-FileContains 'worlds/index.php' @('200-stage cycle')
Assert-FileContains 'game-info/index.php' @(
  'portrait', '200 stages', 'Swordsman', 'gold', 'optional rewarded ads', 'offline rewards', 'rebirth'
)
Assert-FileExcludes 'bosses/index.php' @('HP multiplier', 'health multiplier')
Assert-FileContains 'faq/index.php' @(
  'progress stays in the current browser unless the deployed platform explicitly provides its own save feature'
)
Assert-FileExcludes 'faq/index.php' @('cloud save', 'cloud saves')
Assert-RenderedPageContains 'about/index.php' @('independent game publisher')
Assert-RenderedPageContains 'contact/index.php' @('https://github.com/Funny-niice/ADserver/issues')
Assert-RenderedPageContains 'privacy/index.php' @('local browser storage', 'Google AdSense', 'cookies')
Assert-RenderedPageContains 'terms/index.php' @('no guarantee of uninterrupted availability')
Assert-RenderedPageContains 'updates/index.php' @('2026-07-13')
Assert-HomepageContentQuality
Assert-ReferencePageContentQuality
Assert-GuideContentQuality
Assert-RenderedRouteContracts

Assert-FileContains '.htaccess' @(
  'DirectoryIndex index.php', 'ErrorDocument 404 /404.php', 'Options -Indexes'
)
Assert-FileContains 'robots.txt' @(
  'User-agent: *', 'Allow: /', 'Disallow: /en/',
  'Sitemap: https://tinyheroestap.com/sitemap.xml'
)
Assert-FileContains '404.php' @(
  'http_response_code(404);', "'canonical' => '/404.php'", "'allow_ads' => false",
  "'robots' => 'noindex,follow'", 'href="/"', 'href="/guides/"',
  'href="/faq/"', 'href="/play/"'
)
Assert-RenderedPageContains '404.php' @(
  '<meta name="robots" content="noindex,follow">',
  'href="/"', 'href="/guides/"', 'href="/faq/"', 'href="/play/"'
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
