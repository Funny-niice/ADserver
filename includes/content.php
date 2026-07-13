<?php
declare(strict_types=1);

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

$worlds = [
    'Sunrise Fields','Cloud Castle','Mist Ruins','Storm Bridge','Star Tower',
    'Moon Archive','Thunder Forge','Frost Crown','Void Gate','Sky Throne',
];

$guides = [
    [
        'title' => "Beginner's Guide",
        'url' => '/guides/beginners-guide/',
        'summary' => 'Learn the tapping, hero, coin, and stage basics for a confident first run.',
    ],
    [
        'title' => 'Upgrading Guide',
        'url' => '/guides/upgrading-guide/',
        'summary' => 'Spend coins efficiently by balancing tap damage with automatic hero damage.',
    ],
    [
        'title' => 'Boss Battles Guide',
        'url' => '/guides/boss-battles/',
        'summary' => 'Prepare for timed boss encounters with practical damage and timing strategies.',
    ],
    [
        'title' => 'Offline Rewards Guide',
        'url' => '/guides/offline-rewards/',
        'summary' => 'Make steady progress between sessions by improving your automatic damage.',
    ],
    [
        'title' => 'Rebirth Guide',
        'url' => '/guides/rebirth-guide/',
        'summary' => 'Choose the right moment to restart a run and accelerate future progress.',
    ],
];
