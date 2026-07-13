<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiny Heroes Tap - Game Portal</title>
    <meta name="description" content="Enter Tiny Heroes Tap and begin a sky castle adventure.">
    <meta name="google-adsense-account" content="ca-pub-7672795271513455">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7672795271513455"
     crossorigin="anonymous"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #071b34;
            --panel: rgba(7, 25, 47, 0.82);
            --line: rgba(255, 255, 255, 0.14);
            --text: #fff8e8;
            --muted: #dbe9ff;
            --gold: #ffd95e;
            --violet: #8f62ff;
            --sky: #35a7ff;
        }

        html {
            min-height: 100%;
            background: var(--bg);
        }

        body {
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background:
                linear-gradient(rgba(5, 16, 32, 0.62), rgba(5, 16, 32, 0.9)),
                url("/assets/landing/ui_loading_screen.png") center / cover fixed,
                linear-gradient(135deg, #071b34 0%, #0b3563 48%, #05101f 100%);
            overflow-x: hidden;
        }

        .page {
            position: relative;
            display: grid;
            min-height: 100vh;
            place-items: center;
            padding: 28px;
        }

        .page::before {
            position: absolute;
            inset: 0;
            content: "";
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.055) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.055) 1px, transparent 1px);
            background-size: 52px 52px;
            mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.75), transparent 78%);
        }

        .hero {
            position: relative;
            display: grid;
            width: min(1120px, 100%);
            min-height: min(680px, calc(100vh - 56px));
            align-items: center;
            grid-template-columns: minmax(0, 0.94fr) minmax(320px, 1.06fr);
            gap: 46px;
        }

        .copy {
            max-width: 610px;
            z-index: 1;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            color: var(--gold);
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0;
        }

        .eyebrow::before {
            width: 34px;
            height: 2px;
            content: "";
            background: var(--gold);
        }

        h1 {
            max-width: 11ch;
            font-size: clamp(48px, 8vw, 86px);
            line-height: 0.92;
            font-weight: 900;
            letter-spacing: 0;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.55);
        }

        .summary {
            max-width: 560px;
            margin-top: 24px;
            color: var(--muted);
            font-size: 18px;
            line-height: 1.8;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
            margin-top: 34px;
        }

        .start-button {
            display: inline-flex;
            min-height: 58px;
            align-items: center;
            justify-content: center;
            padding: 0 34px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 8px;
            color: #1c1306;
            background: linear-gradient(180deg, #ffe08f, var(--gold) 56%, #d79422);
            box-shadow: 0 18px 34px rgba(246, 195, 95, 0.22), inset 0 1px 0 rgba(255, 255, 255, 0.55);
            font-size: 18px;
            font-weight: 800;
            text-decoration: none;
            transition: transform 160ms ease, box-shadow 160ms ease, filter 160ms ease;
        }

        .start-button:hover,
        .start-button:focus-visible {
            transform: translateY(-2px);
            filter: brightness(1.06);
            box-shadow: 0 22px 42px rgba(246, 195, 95, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.65);
            outline: none;
        }

        .sub-link {
            color: var(--muted);
            font-size: 15px;
            text-decoration: none;
            border-bottom: 1px solid rgba(200, 194, 182, 0.48);
        }

        .sub-link:hover,
        .sub-link:focus-visible {
            color: var(--text);
            outline: none;
            border-bottom-color: var(--text);
        }

        .showcase {
            position: relative;
            min-height: 620px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background:
                linear-gradient(150deg, rgba(255, 255, 255, 0.18), transparent 34%),
                linear-gradient(180deg, rgba(53, 167, 255, 0.18), rgba(7, 25, 47, 0.88)),
                var(--panel);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.42);
            overflow: hidden;
        }

        .showcase::before {
            position: absolute;
            inset: 26px;
            content: "";
            border: 1px solid rgba(246, 195, 95, 0.24);
            border-radius: 6px;
        }

        .game-art {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            filter: saturate(1.08) contrast(1.02);
        }

        .showcase::after {
            position: absolute;
            inset: 0;
            content: "";
            pointer-events: none;
            background: linear-gradient(to top, rgba(4, 12, 24, 0.18), transparent 38%);
        }

        .stats {
            position: absolute;
            left: 28px;
            right: 28px;
            bottom: 26px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .stat {
            min-height: 74px;
            padding: 14px 12px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            background: rgba(6, 16, 30, 0.58);
            backdrop-filter: blur(8px);
        }

        .stat strong {
            display: block;
            margin-bottom: 5px;
            color: var(--gold);
            font-size: 18px;
        }

        .stat span {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.45;
        }

        @media (max-width: 860px) {
            .page {
                padding: 20px;
            }

            .hero {
                min-height: auto;
                grid-template-columns: 1fr;
                gap: 28px;
                padding: 38px 0;
            }

            .summary {
                font-size: 16px;
            }

            .showcase {
                min-height: 580px;
            }
        }

        @media (max-width: 520px) {
            .page {
                padding: 18px;
            }

            h1 {
                font-size: 44px;
            }

            .actions {
                align-items: stretch;
                flex-direction: column;
            }

            .start-button {
                width: 100%;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .showcase {
                min-height: 560px;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="hero" aria-label="Game showcase">
            <div class="copy">
                <p class="eyebrow">Sky Castle Adventure</p>
                <h1>Tiny Heroes Tap</h1>
                <p class="summary">
                    Rally your heroes and step into a bright sky castle quest. Tap to battle, collect coins, face shadowy bosses, and jump straight into the game world.
                </p>
                <div class="actions">
                    <a class="start-button" href="/en" aria-label="Start game and enter the game client">Start Game</a>
                    <a class="sub-link" href="/en">Enter Game Client</a>
                </div>
            </div>

            <div class="showcase" aria-hidden="true">
                <img class="game-art" src="/assets/landing/ui_loading_screen.png" alt="">
                <div class="stats">
                    <div class="stat">
                        <strong>Adventure</strong>
                        <span>Explore the sky castle</span>
                    </div>
                    <div class="stat">
                        <strong>Collect</strong>
                        <span>Gather coin rewards</span>
                    </div>
                    <div class="stat">
                        <strong>Battle</strong>
                        <span>Challenge shadow bosses</span>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
