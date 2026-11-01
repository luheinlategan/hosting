<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManyCents | Coal, corridors and code</title>
    <meta name="description" content="ManyCents mines, sources, processes and trades coal across Southern Africa, moves it to Maputo, Matola and Richards Bay, and builds deterministic software for heavy industry.">
    <meta name="author" content="ManyCents Resources (Pty) Ltd">
    <meta name="theme-color" content="#0d0f0f">
    <meta name="release" content="__RELEASE__">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.manycents.co.za/">
    <meta property="og:title" content="ManyCents | Coal, corridors and code">
    <meta property="og:description" content="Coal sourcing and trading, pit-to-port logistics, and deterministic software for heavy industry.">
    <meta property="og:image" content="https://www.manycents.co.za/favicon.png">

    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FVJM7R4RHF"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-FVJM7R4RHF');
    </script>

    <style>
        :root {
            --ink: #0d0f0f;
            --ink-2: #151818;
            --ink-3: #1d2121;
            --paper: #f5f1e8;
            --paper-2: #ebe5d6;
            --gold: #c8a45c;
            --gold-hi: #e2c585;
            --gold-ink: #7d5f1e;
            --on-dark: #f1ede4;
            --muted-dark: #a9adab;
            --on-paper: #17191a;
            --muted-paper: #565a58;
            --line-dark: rgba(255, 255, 255, .11);
            --line-paper: rgba(23, 25, 26, .16);
            --serif: 'Fraunces', Georgia, 'Times New Roman', serif;
            --sans: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            --gutter: clamp(20px, 5vw, 56px);
            --max: 1180px;
            --header-h: 92px;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; scroll-padding-top: calc(var(--header-h) + 8px); }
        body {
            margin: 0;
            font-family: var(--sans);
            font-size: 1.0625rem;
            line-height: 1.65;
            color: var(--on-dark);
            background: var(--ink);
            -webkit-font-smoothing: antialiased;
        }
        img, svg { max-width: 100%; display: block; }
        a { color: inherit; }
        h1, h2, h3, h4 { font-family: var(--serif); font-weight: 500; line-height: 1.12; letter-spacing: -.01em; margin: 0; }
        p { margin: 0; }
        :focus-visible { outline: 2px solid var(--gold-hi); outline-offset: 3px; border-radius: 2px; }

        .skip { position: absolute; left: -999px; top: 8px; background: var(--gold); color: var(--ink); padding: 10px 16px; z-index: 200; font-weight: 600; text-decoration: none; }
        .skip:focus { left: 8px; }

        .wrap { max-width: var(--max); margin: 0 auto; padding: 0 var(--gutter); }
        section { padding: clamp(72px, 10vw, 128px) 0; position: relative; }
        .on-paper { background: var(--paper); color: var(--on-paper); }
        .on-ink-2 { background: var(--ink-2); border-top: 1px solid var(--line-dark); }

        .eyebrow {
            font-family: var(--sans);
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .eyebrow::before { content: ""; width: 34px; height: 1px; background: currentColor; }
        .on-paper .eyebrow { color: var(--gold-ink); }

        h2.title { font-size: clamp(2rem, 4.4vw, 3.2rem); max-width: 18ch; }
        .lead { font-size: clamp(1.08rem, 1.5vw, 1.25rem); color: var(--muted-dark); max-width: 60ch; margin-top: 22px; }
        .on-paper .lead { color: var(--muted-paper); }

        /* ---------- Header ---------- */
        header.site {
            position: sticky; top: 0; z-index: 100;
            background: rgba(13, 15, 15, .82);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--line-dark);
        }
        header.site .wrap { display: flex; align-items: center; justify-content: space-between; height: var(--header-h); }
        .brand { display: flex; align-items: center; text-decoration: none; }
        .brand img { height: calc(var(--header-h) - 16px); width: auto; }
        nav.main ul { display: flex; gap: 30px; list-style: none; margin: 0; padding: 0; align-items: center; }
        nav.main a { text-decoration: none; font-size: .93rem; color: var(--muted-dark); transition: color .2s; }
        nav.main a:hover { color: var(--on-dark); }
        nav.main a.cta { color: var(--ink); background: var(--gold); padding: 9px 18px; border-radius: 2px; font-weight: 600; }
        nav.main a.cta:hover { background: var(--gold-hi); }
        .menu-btn { display: none; background: none; border: 1px solid var(--line-dark); color: var(--on-dark); width: 44px; height: 44px; border-radius: 2px; cursor: pointer; }
        .menu-btn span { display: block; width: 18px; height: 1.5px; background: currentColor; margin: 5px auto; transition: transform .2s, opacity .2s; }

        /* ---------- Hero ---------- */
        .hero { padding: 0; min-height: min(86vh, 760px); display: flex; align-items: center; overflow: hidden; border-bottom: 1px solid var(--line-dark); }
        .hero-art { position: absolute; inset: 0; pointer-events: none; }
        .hero-art svg { position: absolute; right: 0; bottom: 0; width: 100%; height: 100%; }
        .hero-art::after { content: ""; position: absolute; inset: 0; background: linear-gradient(90deg, var(--ink) 18%, rgba(13, 15, 15, .55) 52%, rgba(13, 15, 15, 0) 100%); }
        .hero .wrap { position: relative; z-index: 2; width: 100%; padding-top: 72px; padding-bottom: 96px; }
        .hero h1 { font-size: clamp(2.8rem, 8vw, 6rem); max-width: 11ch; font-weight: 500; }
        .hero h1 em { font-style: italic; color: var(--gold); font-weight: 400; }
        .hero .lead { font-size: clamp(1.1rem, 1.7vw, 1.3rem); color: #c3c6c4; margin-top: 30px; }
        .actions { display: flex; flex-wrap: wrap; gap: 14px; margin-top: 40px; }
        .btn { display: inline-block; text-decoration: none; font-weight: 600; font-size: .98rem; padding: 14px 26px; border-radius: 2px; border: 1px solid var(--gold); transition: background .2s, color .2s; cursor: pointer; font-family: var(--sans); }
        .btn.primary { background: var(--gold); color: var(--ink); }
        .btn.primary:hover { background: var(--gold-hi); }
        .btn.ghost { background: transparent; color: var(--gold-hi); }
        .btn.ghost:hover { background: rgba(200, 164, 92, .12); }

        .strip { border-bottom: 1px solid var(--line-dark); background: var(--ink-2); padding: 0; }
        .strip ul { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(4, 1fr); }
        .strip li { padding: 26px 24px; border-left: 1px solid var(--line-dark); font-size: .93rem; color: var(--muted-dark); }
        .strip li:first-child { border-left: 0; padding-left: 0; }
        .strip li strong { display: block; color: var(--on-dark); font-family: var(--serif); font-weight: 500; font-size: 1.02rem; margin-bottom: 2px; }

        /* ---------- Group ---------- */
        .three { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px; background: var(--line-paper); border: 1px solid var(--line-paper); margin-top: 56px; }
        .pillar { background: var(--paper); padding: 40px 32px 44px; display: flex; flex-direction: column; }
        .pillar .num { font-family: var(--serif); font-size: .95rem; color: var(--gold-ink); letter-spacing: .08em; }
        .pillar h3 { font-size: 1.65rem; margin: 16px 0 14px; }
        .pillar p { color: var(--muted-paper); font-size: 1rem; }
        .pillar a { margin-top: auto; padding-top: 28px; color: var(--gold-ink); font-weight: 600; font-size: .93rem; text-decoration: none; }
        .pillar a:hover { text-decoration: underline; text-underline-offset: 4px; }

        /* ---------- Coal ---------- */
        .coal-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 56px; }
        .grade { border: 1px solid var(--line-dark); background: var(--ink-2); padding: 30px 26px; display: flex; flex-direction: column; border-top: 2px solid var(--gold); }
        .grade h3 { font-size: 1.35rem; margin-bottom: 8px; }
        .grade .for { font-size: .9rem; color: var(--muted-dark); margin-bottom: 18px; }
        .grade ul { list-style: none; margin: auto 0 0; padding: 18px 0 0; border-top: 1px solid var(--line-dark); font-size: .9rem; color: #c8cbc9; }
        .grade li { padding: 3px 0; }
        .grade li::before { content: "—"; color: var(--gold); margin-right: 10px; }
        .grade.blend { background: linear-gradient(160deg, #1f1b12, var(--ink-2) 70%); }
        .assurance { margin-top: 56px; display: grid; grid-template-columns: 1fr 1fr; gap: 56px; padding-top: 48px; border-top: 1px solid var(--line-dark); }
        .assurance h3 { font-size: 1.6rem; }
        .assurance p { color: var(--muted-dark); margin-top: 14px; }

        /* ---------- Corridor ---------- */
        .corridor-layout { display: grid; grid-template-columns: 5fr 7fr; gap: 56px; align-items: center; margin-top: 56px; }
        .routes { list-style: none; margin: 0; padding: 0; }
        .routes li { padding: 20px 0; border-top: 1px solid var(--line-paper); }
        .routes li:last-child { border-bottom: 1px solid var(--line-paper); }
        .routes h3 { font-size: 1.2rem; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .routes p { color: var(--muted-paper); font-size: .98rem; margin-top: 6px; }
        .tag { font-family: var(--sans); font-size: .68rem; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; padding: 3px 9px; border: 1px solid currentColor; border-radius: 2px; }
        .tag.live { color: #25603b; }
        .tag.dev { color: var(--gold-ink); }
        .map { background: var(--ink); border-radius: 2px; padding: 20px; }
        .map figcaption { font-size: .78rem; color: var(--muted-dark); margin-top: 12px; text-align: right; }
        .map text { font-family: var(--sans); }

        /* ---------- Software ---------- */
        .products { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 56px; }
        .product { border: 1px solid var(--line-dark); padding: 32px 30px; background: var(--ink-2); }
        .product header { display: flex; justify-content: space-between; align-items: baseline; gap: 12px; margin-bottom: 14px; }
        .product h3 { font-size: 1.45rem; }
        .product .tag { color: var(--gold); white-space: nowrap; }
        .product p { color: var(--muted-dark); font-size: 1rem; }
        .amap { margin-top: 20px; border: 1px solid rgba(200, 164, 92, .4); background: linear-gradient(120deg, #1b1810, var(--ink-2) 60%); padding: clamp(28px, 4vw, 52px); display: grid; grid-template-columns: 7fr 5fr; gap: 40px; align-items: center; }
        .amap h3 { font-size: clamp(1.5rem, 2.6vw, 2.1rem); margin-bottom: 16px; }
        .amap p { color: #c3c6c4; }
        .amap p + p { margin-top: 14px; }
        .amap .models { margin-top: 20px; display: flex; flex-wrap: wrap; gap: 8px; }
        .amap .models span { font-size: .82rem; padding: 4px 12px; border: 1px solid var(--line-dark); color: var(--on-dark); border-radius: 100px; }
        .principle { margin-top: 56px; padding-left: 24px; border-left: 2px solid var(--gold); max-width: 62ch; font-family: var(--serif); font-size: clamp(1.25rem, 2.2vw, 1.65rem); line-height: 1.4; color: var(--on-dark); }

        /* ---------- Contact ---------- */
        .contact-grid { display: grid; grid-template-columns: 5fr 7fr; gap: 64px; margin-top: 56px; }
        .details dl { margin: 0; }
        .details dt { font-size: .75rem; font-weight: 600; letter-spacing: .16em; text-transform: uppercase; color: var(--gold); margin-top: 28px; }
        .details dt:first-child { margin-top: 0; }
        .details dd { margin: 6px 0 0; color: #d6d8d6; }
        .details a { text-decoration: none; border-bottom: 1px solid rgba(200, 164, 92, .5); }
        .details a:hover { color: var(--gold-hi); }
        form.contact { display: grid; gap: 20px; grid-template-columns: 1fr 1fr; }
        .field { display: flex; flex-direction: column; gap: 7px; }
        .field.full { grid-column: 1 / -1; }
        .field label { font-size: .82rem; font-weight: 600; letter-spacing: .06em; color: var(--muted-dark); }
        .field input, .field select, .field textarea {
            font: inherit; font-size: 1rem; color: var(--on-dark); background: var(--ink-3);
            border: 1px solid rgba(255, 255, 255, .18); border-radius: 2px; padding: 13px 14px; width: 100%;
        }
        .field select { appearance: none; background-image: linear-gradient(45deg, transparent 50%, var(--gold) 50%), linear-gradient(135deg, var(--gold) 50%, transparent 50%); background-position: calc(100% - 20px) 50%, calc(100% - 14px) 50%; background-size: 6px 6px; background-repeat: no-repeat; }
        .field textarea { min-height: 150px; resize: vertical; }
        .field input:focus, .field select:focus, .field textarea:focus { outline: none; border-color: var(--gold); box-shadow: 0 0 0 3px rgba(200, 164, 92, .22); }
        .field .err { display: none; color: #f2a08f; font-size: .85rem; }
        .field.bad input, .field.bad textarea { border-color: #e0816d; }
        .field.bad .err { display: block; }
        .hp { position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden; }
        .form-foot { grid-column: 1 / -1; display: flex; align-items: center; gap: 24px; flex-wrap: wrap; }
        .form-foot small { color: var(--muted-dark); font-size: .82rem; max-width: 46ch; }
        .notice { grid-column: 1 / -1; padding: 14px 18px; border-radius: 2px; font-size: .95rem; display: none; }
        .notice.show { display: block; }
        .notice.ok { background: rgba(60, 140, 90, .16); border: 1px solid rgba(90, 180, 125, .5); }
        .notice.fail { background: rgba(200, 90, 70, .14); border: 1px solid rgba(224, 129, 109, .55); }

        footer.site { background: #080909; border-top: 1px solid var(--line-dark); padding: 40px 0 48px; font-size: .88rem; color: var(--muted-dark); }
        footer.site .wrap { display: flex; justify-content: space-between; gap: 24px; flex-wrap: wrap; }
        footer.site p + p { margin-top: 4px; }

        /* ---------- Motion ---------- */
        .js .reveal { opacity: 0; transform: translateY(18px); transition: opacity .7s ease, transform .7s ease; }
        .js .reveal.in { opacity: 1; transform: none; }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .js .reveal { opacity: 1; transform: none; transition: none; }
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 980px) {
            .coal-grid { grid-template-columns: repeat(2, 1fr); }
            .corridor-layout, .contact-grid, .amap, .assurance { grid-template-columns: 1fr; gap: 40px; }
            .strip ul { grid-template-columns: repeat(2, 1fr); }
            .strip li:nth-child(3) { border-left: 0; padding-left: 0; }
            .strip li:nth-child(n+3) { border-top: 1px solid var(--line-dark); }
        }
        @media (max-width: 760px) {
            :root { --header-h: 68px; }
            .menu-btn { display: block; }
            nav.main { position: absolute; top: var(--header-h); left: 0; right: 0; background: var(--ink); border-bottom: 1px solid var(--line-dark); display: none; }
            nav.main.open { display: block; }
            nav.main ul { flex-direction: column; align-items: stretch; gap: 0; padding: 8px var(--gutter) 20px; }
            nav.main li a { display: block; padding: 14px 0; border-bottom: 1px solid var(--line-dark); font-size: 1rem; }
            nav.main a.cta { margin-top: 14px; text-align: center; border-bottom: 0; padding: 14px; }
            .three, .products { grid-template-columns: 1fr; }
            .coal-grid { grid-template-columns: 1fr; }
            form.contact { grid-template-columns: 1fr; }
            .hero-art::after { background: linear-gradient(180deg, rgba(13, 15, 15, .96) 30%, rgba(13, 15, 15, .55) 100%); }
            .map { overflow-x: auto; }
            .map svg { min-width: 540px; }
        }
    </style>
</head>
<body>
    <a class="skip" href="#main">Skip to content</a>

    <header class="site">
        <div class="wrap">
            <a class="brand" href="#top" aria-label="ManyCents Resources, home">
                <img src="manycents-logo.png" width="511" height="188" alt="ManyCents Resources, Creator of Wealth">
            </a>
            <button class="menu-btn" id="menuBtn" aria-label="Menu" aria-expanded="false" aria-controls="mainNav"><span></span><span></span><span></span></button>
            <nav class="main" id="mainNav" aria-label="Main">
                <ul>
                    <li><a href="#group">The group</a></li>
                    <li><a href="#coal">Coal</a></li>
                    <li><a href="#corridor">Corridor</a></li>
                    <li><a href="#software">Software</a></li>
                    <li><a class="cta" href="#contact">Get in touch</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main id="main">
        <!-- ===== Hero ===== -->
        <section class="hero" id="top">
            <div class="hero-art" aria-hidden="true">
                <svg viewBox="0 0 1600 640" preserveAspectRatio="xMaxYMax slice">
<path d="M0,150.0 L25,153.1 L50,154.1 L75,152.8 L100,151.2 L125,151.3 L150,152.5 L175,152.9 L200,151.0 L225,147.6 L250,145.3 L275,145.7 L300,147.8 L325,149.5 L350,149.3 L375,148.4 L400,148.8 L425,151.2 L450,154.2 L475,155.2 L500,153.4 L525,150.5 L550,148.8 L575,148.8 L600,148.9 L625,147.1 L650,143.2 L675,139.4 L700,137.6 L725,137.7 L750,137.6 L775,135.5 L800,131.8 L825,128.8 L850,128.1 L875,129.0 L900,129.2 L925,127.0 L950,123.2 L975,119.9 L1000,118.4 L1025,117.6 L1050,115.2 L1075,110.6 L1100,105.3 L1125,102.0 L1150,101.7 L1175,102.8 L1200,103.2 L1225,102.5 L1250,102.2 L1275,104.5 L1300,109.3 L1325,114.5 L1350,117.6 L1375,118.5 L1400,119.1 L1425,121.6 L1450,126.0 L1475,130.7 L1500,134.2 L1525,137.0 L1550,140.5 L1575,145.5 L1600,150.7 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.18" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,176.6 L25,175.8 L50,173.8 L75,172.7 L100,173.3 L125,174.2 L150,173.3 L175,170.4 L200,167.5 L225,167.0 L250,168.9 L275,171.4 L300,172.3 L325,171.6 L350,171.1 L375,172.6 L400,175.4 L425,177.2 L450,176.3 L475,173.3 L500,170.8 L525,170.3 L550,170.9 L575,170.6 L600,168.2 L625,165.0 L650,163.0 L675,163.3 L700,164.1 L725,163.1 L750,159.5 L775,155.0 L800,151.9 L825,150.8 L850,150.2 L875,148.0 L900,144.1 L925,140.5 L950,139.1 L975,139.4 L1000,139.3 L1025,136.8 L1050,132.3 L1075,128.0 L1100,125.7 L1125,125.1 L1150,124.0 L1175,121.2 L1200,117.9 L1225,116.6 L1250,118.6 L1275,122.6 L1300,126.5 L1325,128.8 L1350,130.7 L1375,134.1 L1400,139.4 L1425,145.0 L1450,149.1 L1475,151.5 L1500,154.3 L1525,159.2 L1550,165.8 L1575,171.3 L1600,173.3 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.21" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,196.6 L25,194.5 L50,194.2 L75,195.1 L100,195.1 L125,193.1 L150,190.1 L175,188.7 L200,190.1 L225,192.9 L250,194.9 L275,194.8 L300,193.9 L325,194.4 L350,196.6 L375,198.8 L400,198.8 L425,196.2 L450,193.0 L475,191.6 L500,192.1 L525,192.9 L550,192.0 L575,189.6 L600,187.7 L625,187.9 L650,189.6 L675,190.3 L700,188.0 L725,183.4 L750,178.9 L775,175.9 L800,174.0 L825,171.1 L850,166.5 L875,161.6 L900,158.8 L925,159.1 L950,160.5 L975,160.6 L1000,158.2 L1025,154.7 L1050,152.1 L1075,150.7 L1100,149.1 L1125,145.3 L1150,139.6 L1175,134.5 L1200,132.4 L1225,133.4 L1250,135.8 L1275,137.7 L1300,139.4 L1325,142.8 L1350,149.0 L1375,156.8 L1400,163.2 L1425,166.8 L1450,168.7 L1475,171.7 L1500,177.3 L1525,184.0 L1550,188.9 L1575,190.4 L1600,189.8 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.23" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,215.4 L25,215.9 L50,216.6 L75,215.6 L100,213.0 L125,210.9 L150,211.4 L175,214.2 L200,217.0 L225,217.9 L250,217.0 L275,216.5 L300,217.7 L325,219.9 L350,220.8 L375,218.9 L400,215.5 L425,213.1 L450,213.1 L475,214.3 L500,214.7 L525,213.3 L550,211.5 L575,211.5 L600,213.5 L625,215.6 L650,215.3 L675,211.9 L700,207.2 L725,203.3 L750,200.5 L775,197.3 L800,192.1 L825,185.7 L850,180.7 L875,179.0 L900,180.1 L925,181.6 L950,181.3 L975,179.4 L1000,177.5 L1025,176.7 L1050,175.9 L1075,172.8 L1100,166.6 L1125,159.0 L1150,152.9 L1175,150.1 L1200,149.5 L1225,149.4 L1250,149.3 L1275,150.7 L1300,155.6 L1325,163.8 L1350,172.8 L1375,179.5 L1400,183.3 L1425,185.8 L1450,189.6 L1475,194.9 L1500,200.3 L1525,203.8 L1550,205.2 L1575,206.3 L1600,208.7 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.26" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,237.6 L25,237.7 L50,235.9 L75,233.6 L100,233.2 L125,235.4 L150,238.7 L175,240.6 L200,240.2 L225,239.1 L250,239.2 L275,240.9 L300,242.3 L325,241.4 L350,238.2 L375,235.1 L400,234.2 L425,235.4 L450,236.7 L475,236.5 L500,235.0 L525,234.5 L550,236.1 L575,239.0 L600,240.4 L625,238.8 L650,234.8 L675,230.8 L700,227.9 L725,225.1 L750,220.5 L775,213.7 L800,206.6 L825,202.2 L850,201.2 L875,202.2 L900,202.6 L925,201.6 L950,200.3 L975,200.2 L1000,200.8 L1025,199.9 L1050,195.3 L1075,187.7 L1100,179.5 L1125,173.5 L1150,169.9 L1175,167.3 L1200,164.5 L1225,162.6 L1250,163.9 L1275,169.7 L1300,178.4 L1325,187.0 L1350,193.3 L1375,197.8 L1400,202.1 L1425,207.1 L1450,211.9 L1475,215.2 L1500,216.9 L1525,218.6 L1550,222.2 L1575,227.5 L1600,232.3 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.29" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,258.5 L25,256.5 L50,255.4 L75,256.8 L100,260.1 L125,262.9 L150,263.3 L175,262.0 L200,261.1 L225,261.9 L250,263.4 L275,263.4 L300,260.9 L325,257.5 L350,255.6 L375,256.3 L400,258.2 L425,259.2 L450,258.4 L475,257.4 L500,258.3 L525,261.1 L550,263.6 L575,263.6 L600,260.8 L625,257.0 L650,254.3 L675,252.3 L700,249.3 L725,243.6 L750,236.2 L775,229.8 L800,226.4 L825,225.6 L850,225.2 L875,223.7 L900,221.8 L925,221.2 L950,222.4 L975,223.6 L1000,221.9 L1025,216.4 L1050,208.7 L1075,201.5 L1100,196.1 L1125,191.7 L1150,186.8 L1175,181.7 L1200,178.6 L1225,179.8 L1250,185.4 L1275,192.8 L1300,199.5 L1325,204.9 L1350,210.4 L1375,216.8 L1400,223.2 L1425,227.7 L1450,229.2 L1475,229.7 L1500,232.1 L1525,237.9 L1550,245.3 L1575,251.4 L1600,254.3 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.31" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,278.1 L25,278.5 L50,281.4 L75,284.7 L100,286.1 L125,285.1 L150,283.4 L175,283.1 L200,284.3 L225,285.0 L250,283.4 L275,280.2 L300,277.5 L325,277.4 L350,279.4 L375,281.3 L400,281.5 L425,280.5 L450,280.5 L475,282.6 L500,285.6 L525,286.8 L550,285.2 L575,281.8 L600,279.0 L625,277.6 L650,276.3 L675,272.8 L700,266.8 L725,260.2 L750,255.4 L775,253.1 L800,251.6 L825,249.0 L850,245.4 L875,242.7 L900,242.4 L925,243.8 L950,244.4 L975,241.8 L1000,236.2 L1025,229.9 L1050,224.6 L1075,220.2 L1100,215.0 L1125,208.3 L1150,201.6 L1175,198.0 L1200,198.6 L1225,202.5 L1250,207.1 L1275,211.0 L1300,215.2 L1325,221.4 L1350,229.4 L1375,236.9 L1400,241.4 L1425,242.7 L1450,243.4 L1475,246.9 L1500,253.8 L1525,262.0 L1550,268.5 L1575,272.7 L1600,275.8 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.34" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,302.8 L25,306.2 L50,308.5 L75,308.1 L100,306.1 L125,304.7 L150,305.1 L175,306.1 L200,305.6 L225,302.9 L250,299.9 L275,298.8 L300,300.5 L325,303.1 L350,304.3 L375,303.8 L400,303.1 L425,304.2 L450,306.9 L475,309.0 L500,308.4 L525,305.5 L550,302.4 L575,300.9 L600,300.7 L625,299.5 L650,295.8 L675,290.4 L700,285.6 L725,282.9 L750,281.1 L775,278.3 L800,273.5 L825,268.1 L850,264.7 L875,264.0 L900,264.4 L925,263.4 L950,259.8 L975,255.1 L1000,251.2 L1025,248.4 L1050,245.0 L1075,239.2 L1100,231.6 L1125,224.5 L1150,220.7 L1175,220.1 L1200,221.0 L1225,221.6 L1250,222.4 L1275,225.4 L1300,231.8 L1325,240.2 L1350,247.9 L1375,252.7 L1400,255.3 L1425,258.3 L1450,263.5 L1475,270.6 L1500,277.8 L1525,283.9 L1550,289.3 L1575,295.1 L1600,301.2 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.37" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,330.3 L25,330.9 L50,329.0 L75,326.8 L100,326.1 L125,326.9 L150,327.3 L175,325.6 L200,322.6 L225,320.8 L250,321.7 L275,324.4 L300,326.7 L325,327.0 L350,326.1 L375,326.2 L400,328.1 L425,330.5 L450,330.9 L475,328.6 L500,325.3 L525,323.2 L550,323.2 L575,323.5 L600,322.1 L625,318.5 L650,314.7 L675,312.3 L700,311.3 L725,309.5 L750,305.1 L775,298.5 L800,292.1 L825,288.1 L850,286.2 L875,284.5 L900,281.2 L925,277.1 L950,274.0 L975,272.8 L1000,272.2 L1025,269.6 L1050,263.8 L1075,256.4 L1100,250.0 L1125,246.0 L1150,243.4 L1175,240.5 L1200,237.0 L1225,234.9 L1250,236.6 L1275,242.3 L1300,249.8 L1325,256.6 L1350,262.0 L1375,267.2 L1400,273.6 L1425,281.1 L1450,288.0 L1475,293.4 L1500,298.4 L1525,304.6 L1550,312.6 L1575,320.5 L1600,325.5 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.40" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,351.9 L25,349.2 L50,347.5 L75,347.7 L100,348.5 L125,347.9 L150,345.5 L175,343.1 L200,343.1 L225,345.6 L250,348.7 L275,349.9 L300,349.3 L325,348.5 L350,349.4 L375,351.6 L400,352.8 L425,351.4 L450,348.0 L475,345.2 L500,344.7 L525,345.7 L550,346.0 L575,344.3 L600,341.5 L625,339.7 L650,339.6 L675,339.6 L700,337.1 L725,331.3 L750,323.9 L775,317.3 L800,312.8 L825,309.1 L850,304.6 L875,299.3 L900,295.0 L925,293.6 L950,294.6 L975,295.3 L1000,293.2 L1025,288.1 L1050,282.2 L1075,277.1 L1100,272.9 L1125,267.8 L1150,261.0 L1175,254.0 L1200,249.7 L1225,249.9 L1250,253.8 L1275,259.2 L1300,264.5 L1325,270.4 L1350,278.4 L1375,288.4 L1400,298.0 L1425,304.9 L1450,309.0 L1475,312.9 L1500,319.3 L1525,328.2 L1550,336.7 L1575,341.7 L1600,342.8 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.42" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,369.3 L25,368.6 L50,369.4 L75,369.8 L100,368.3 L125,365.9 L150,365.0 L175,366.9 L200,370.2 L225,372.5 L250,372.5 L275,371.3 L300,371.1 L325,372.5 L350,374.1 L375,373.7 L400,370.8 L425,367.5 L450,366.1 L475,367.0 L500,368.4 L525,368.2 L550,366.5 L575,365.0 L600,365.3 L625,366.7 L650,366.7 L675,363.2 L700,356.7 L725,349.5 L750,343.6 L775,338.5 L800,332.7 L825,325.6 L850,318.7 L875,314.8 L900,314.6 L925,316.5 L950,317.4 L975,315.5 L1000,311.9 L1025,308.1 L1050,304.6 L1075,299.9 L1100,292.4 L1125,282.6 L1150,273.2 L1175,267.4 L1200,265.9 L1225,267.1 L1250,269.4 L1275,272.9 L1300,279.3 L1325,289.5 L1350,301.7 L1375,312.7 L1400,319.9 L1425,324.1 L1450,328.1 L1475,334.3 L1500,342.3 L1525,349.8 L1550,354.6 L1575,357.3 L1600,359.8 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.45" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,390.2 L25,391.2 L50,390.8 L75,388.9 L100,387.4 L125,388.4 L150,391.5 L175,394.6 L200,395.5 L225,394.3 L250,393.1 L275,393.6 L300,395.2 L325,395.6 L350,393.5 L375,390.0 L400,387.7 L425,388.0 L450,389.9 L475,391.0 L500,390.4 L525,389.0 L550,389.1 L575,391.0 L600,392.8 L625,391.9 L650,387.5 L675,381.2 L700,375.3 L725,370.2 L750,364.6 L775,357.0 L800,348.1 L825,340.8 L850,337.3 L875,337.4 L900,338.6 L925,338.5 L950,336.7 L975,334.8 L1000,333.3 L1025,331.1 L1050,325.8 L1075,316.6 L1100,305.3 L1125,295.2 L1150,288.6 L1175,284.9 L1200,282.8 L1225,281.8 L1250,283.6 L1275,289.9 L1300,300.8 L1325,313.4 L1350,324.4 L1375,332.1 L1400,337.7 L1425,343.2 L1450,349.5 L1475,355.7 L1500,360.9 L1525,365.3 L1550,370.3 L1575,376.5 L1600,383.0 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.48" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,413.0 L25,411.9 L50,410.2 L75,410.3 L100,412.8 L125,416.2 L150,418.1 L175,417.4 L200,415.7 L225,415.0 L250,416.0 L275,416.9 L300,415.9 L325,412.8 L350,409.8 L375,409.2 L400,411.0 L425,413.1 L450,413.6 L475,412.6 L500,412.2 L525,413.7 L550,416.2 L575,417.3 L600,415.0 L625,410.2 L650,405.1 L675,401.0 L700,396.8 L725,390.6 L750,382.0 L775,372.8 L800,366.0 L825,362.8 L850,361.9 L875,361.0 L900,359.1 L925,357.3 L950,356.8 L975,357.0 L1000,355.4 L1025,349.6 L1050,340.0 L1075,329.1 L1100,319.8 L1125,312.8 L1150,306.9 L1175,301.4 L1200,297.4 L1225,297.5 L1250,303.1 L1275,312.9 L1300,323.7 L1325,333.2 L1350,341.3 L1375,349.1 L1400,357.1 L1425,364.1 L1450,368.7 L1475,371.7 L1500,375.6 L1525,382.5 L1550,392.1 L1575,401.2 L1600,407.2 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.50" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,433.3 L25,432.6 L50,434.3 L75,437.6 L100,440.3 L125,440.4 L150,438.5 L175,436.8 L200,436.9 L225,437.9 L250,437.8 L275,435.5 L300,432.3 L325,430.8 L350,432.1 L375,434.7 L400,436.3 L425,435.9 L450,435.1 L475,435.8 L500,438.2 L525,440.3 L550,439.8 L575,436.4 L600,432.1 L625,428.7 L650,426.3 L675,422.7 L700,416.4 L725,407.9 L750,399.7 L775,394.1 L800,390.8 L825,387.8 L850,384.0 L875,380.1 L900,377.9 L925,378.1 L950,378.8 L975,377.0 L1000,371.2 L1025,362.7 L1050,354.0 L1075,346.4 L1100,339.3 L1125,331.4 L1150,323.1 L1175,316.9 L1200,315.4 L1225,319.1 L1250,325.9 L1275,333.1 L1300,340.2 L1325,348.3 L1350,358.3 L1375,368.6 L1400,376.7 L1425,381.0 L1450,383.3 L1475,387.3 L1500,395.5 L1525,406.6 L1550,417.1 L1575,424.3 L1600,428.6 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.53" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,456.1 L25,458.9 L50,462.0 L75,463.0 L100,461.4 L125,459.1 L150,458.1 L175,458.7 L200,459.3 L225,458.0 L250,455.1 L275,452.9 L300,453.3 L325,455.9 L350,458.5 L375,459.1 L400,458.2 L425,458.0 L450,459.6 L475,462.0 L500,462.8 L525,460.6 L550,456.8 L575,453.7 L600,452.2 L625,451.0 L650,447.8 L675,441.8 L700,434.6 L725,428.6 L750,424.3 L775,420.2 L800,414.8 L825,408.0 L850,402.2 L875,399.3 L900,399.0 L925,398.8 L950,396.2 L975,391.0 L1000,384.8 L1025,379.3 L1050,374.0 L1075,367.1 L1100,357.8 L1125,347.9 L1150,340.4 L1175,337.2 L1200,337.8 L1225,340.1 L1250,342.8 L1275,347.1 L1300,354.8 L1325,365.7 L1350,377.3 L1375,386.4 L1400,392.0 L1425,395.9 L1450,401.4 L1475,410.0 L1500,420.6 L1525,430.6 L1550,438.7 L1575,445.5 L1600,451.9 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.56" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,483.3 L25,485.2 L50,484.3 L75,481.7 L100,479.6 L125,479.5 L150,480.4 L175,480.1 L200,477.9 L225,475.4 L250,474.9 L275,477.1 L300,480.2 L325,481.9 L350,481.5 L375,480.6 L400,481.1 L425,483.2 L450,484.7 L475,483.6 L500,480.4 L525,477.0 L550,475.6 L575,475.7 L600,475.1 L625,472.1 L650,467.1 L675,462.1 L700,458.5 L725,455.1 L750,450.0 L775,442.1 L800,433.2 L825,426.0 L850,422.1 L875,420.1 L900,417.8 L925,414.0 L950,409.8 L975,406.7 L1000,404.6 L1025,401.4 L1050,394.9 L1075,385.3 L1100,375.2 L1125,367.3 L1150,362.3 L1175,358.9 L1200,355.8 L1225,353.9 L1250,355.5 L1275,362.0 L1300,372.5 L1325,383.7 L1350,393.3 L1375,401.1 L1400,408.5 L1425,416.9 L1450,426.0 L1475,434.7 L1500,442.8 L1525,450.9 L1550,460.0 L1575,469.4 L1600,476.7 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.58" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,506.9 L25,504.5 L50,501.6 L75,500.5 L100,501.2 L125,501.8 L150,500.6 L175,498.3 L200,497.0 L225,498.4 L250,501.7 L275,504.3 L300,504.6 L325,503.5 L350,503.0 L375,504.2 L400,505.9 L425,505.9 L450,503.3 L475,499.8 L500,497.8 L525,498.1 L550,499.1 L575,498.6 L600,495.8 L625,492.3 L650,489.9 L675,488.4 L700,485.4 L725,479.0 L750,469.5 L775,459.6 L800,451.8 L825,446.4 L850,441.9 L875,436.8 L900,431.9 L925,428.9 L950,428.6 L975,429.1 L1000,427.4 L1025,421.7 L1050,413.1 L1075,404.2 L1100,396.5 L1125,389.4 L1150,381.8 L1175,373.8 L1200,367.9 L1225,366.9 L1250,371.5 L1275,379.8 L1300,389.2 L1325,398.6 L1350,408.7 L1375,420.2 L1400,432.1 L1425,442.1 L1450,449.1 L1475,454.8 L1500,462.2 L1525,472.5 L1550,483.7 L1575,492.2 L1600,495.9 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.61" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,524.0 L25,521.9 L50,522.0 L75,523.1 L100,523.0 L125,521.3 L150,519.6 L175,520.0 L200,522.9 L225,526.2 L250,527.5 L275,526.6 L300,525.3 L325,525.4 L350,526.9 L375,527.6 L400,526.0 L425,522.6 L450,519.8 L475,519.6 L500,521.2 L525,522.4 L550,521.5 L575,519.3 L600,517.8 L625,517.6 L650,517.2 L675,513.9 L700,506.5 L725,496.7 L750,487.2 L775,479.3 L800,472.3 L825,464.9 L850,457.3 L875,451.5 L900,449.5 L925,450.9 L950,452.5 L975,451.5 L1000,446.9 L1025,440.4 L1050,433.5 L1075,426.4 L1100,417.4 L1125,406.1 L1150,394.3 L1175,385.6 L1200,382.2 L1225,384.0 L1250,388.9 L1275,395.3 L1300,403.9 L1325,415.8 L1350,430.5 L1375,445.0 L1400,456.0 L1425,462.7 L1450,467.5 L1475,474.1 L1500,483.9 L1525,494.9 L1550,503.7 L1575,508.9 L1600,511.8 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.64" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,543.0 L25,544.1 L50,545.0 L75,544.2 L100,542.5 L125,542.1 L150,544.2 L175,547.7 L200,550.0 L225,549.7 L250,547.9 L275,547.0 L300,547.8 L325,548.9 L350,548.2 L375,545.3 L400,542.2 L425,541.1 L450,542.5 L475,544.7 L500,545.3 L525,544.2 L550,543.0 L575,543.3 L600,544.5 L625,544.1 L650,540.0 L675,532.4 L700,523.5 L725,515.4 L750,507.9 L775,499.5 L800,489.7 L825,480.2 L850,474.1 L875,472.5 L900,473.7 L925,474.7 L950,473.5 L975,470.2 L1000,466.3 L1025,461.9 L1050,455.4 L1075,445.0 L1100,431.5 L1125,417.8 L1150,407.6 L1175,402.1 L1200,400.3 L1225,400.8 L1250,403.8 L1275,411.1 L1300,423.4 L1325,439.2 L1350,454.6 L1375,466.3 L1400,474.1 L1425,480.1 L1450,487.0 L1475,495.4 L1500,504.3 L1525,512.2 L1550,519.1 L1575,526.1 L1600,533.5 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.67" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,566.5 L25,566.8 L50,565.6 L75,564.6 L100,565.8 L125,569.0 L150,572.0 L175,572.6 L200,570.9 L225,569.0 L250,568.8 L275,569.8 L300,570.0 L325,568.0 L350,564.8 L375,562.9 L400,563.7 L425,566.2 L450,568.1 L475,568.0 L500,566.9 L525,566.9 L550,568.5 L575,570.0 L600,568.7 L625,563.8 L650,556.9 L675,550.0 L700,543.8 L725,536.8 L750,527.4 L775,516.4 L800,506.4 L825,500.2 L850,498.0 L875,497.4 L900,496.3 L925,494.1 L950,492.0 L975,490.5 L1000,488.1 L1025,482.1 L1050,471.4 L1075,457.6 L1100,444.2 L1125,433.7 L1150,426.2 L1175,420.5 L1200,416.5 L1225,416.1 L1250,421.4 L1275,432.6 L1300,446.9 L1325,460.9 L1350,472.6 L1375,482.4 L1400,491.4 L1425,499.9 L1450,507.3 L1475,513.5 L1500,519.7 L1525,528.1 L1550,539.0 L1575,550.4 L1600,559.2 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.69" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,588.7 L25,587.6 L50,587.8 L75,590.3 L100,593.5 L125,595.1 L150,593.9 L175,591.4 L200,590.1 L225,590.5 L250,591.3 L275,590.3 L300,587.6 L325,585.1 L350,585.0 L375,587.4 L400,590.1 L425,591.1 L450,590.4 L475,589.8 L500,590.9 L525,593.0 L550,593.6 L575,591.1 L600,586.0 L625,580.6 L650,576.2 L675,571.8 L700,565.3 L725,555.8 L750,544.9 L775,535.8 L800,529.7 L825,525.8 L850,522.1 L875,517.8 L900,514.3 L925,512.8 L950,512.8 L975,511.4 L1000,505.9 L1025,496.1 L1050,484.2 L1075,472.9 L1100,463.0 L1125,453.7 L1150,444.4 L1175,436.5 L1200,433.0 L1225,435.8 L1250,443.9 L1275,454.5 L1300,465.3 L1325,476.1 L1350,487.8 L1375,500.2 L1400,511.2 L1425,518.8 L1450,523.5 L1475,528.7 L1500,537.7 L1525,550.8 L1550,564.7 L1575,575.6 L1600,581.8 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.72" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,610.3 L25,611.8 L50,614.8 L75,617.1 L100,616.7 L125,614.2 L150,611.8 L175,611.4 L200,612.2 L225,612.3 L250,610.4 L275,607.8 L300,606.8 L325,608.6 L350,611.8 L375,613.8 L400,613.7 L425,612.6 L450,612.8 L475,614.6 L500,616.2 L525,615.3 L550,611.7 L575,607.3 L600,604.0 L625,602.0 L650,599.0 L675,593.0 L700,584.3 L725,575.1 L750,567.5 L775,561.4 L800,555.2 L825,547.8 L850,540.4 L875,535.3 L900,533.6 L925,533.5 L950,532.0 L975,527.0 L1000,519.3 L1025,510.8 L1050,502.7 L1075,494.1 L1100,483.5 L1125,471.6 L1150,461.0 L1175,454.8 L1200,454.3 L1225,457.6 L1250,462.8 L1275,469.4 L1300,478.6 L1325,491.3 L1350,506.1 L1375,519.3 L1400,528.5 L1425,534.2 L1450,540.1 L1475,549.4 L1500,562.5 L1525,576.5 L1550,588.2 L1575,596.7 L1600,603.3 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.75" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,636.0 L25,638.6 L50,639.1 L75,637.0 L100,634.0 L125,632.5 L150,633.0 L175,633.8 L200,633.0 L225,630.7 L250,629.1 L275,630.0 L300,633.1 L325,636.0 L350,636.7 L375,635.7 L400,634.9 L425,635.8 L450,637.6 L475,637.9 L500,635.5 L525,631.7 L550,628.7 L575,627.7 L600,627.3 L625,625.0 L650,619.8 L675,612.8 L700,606.1 L725,600.3 L750,594.0 L775,585.3 L800,574.7 L825,564.8 L850,558.2 L875,555.2 L900,553.5 L925,550.7 L950,546.3 L975,541.4 L1000,537.1 L1025,532.5 L1050,525.2 L1075,514.3 L1100,501.2 L1125,489.3 L1150,481.0 L1175,476.5 L1200,474.0 L1225,473.2 L1250,475.2 L1275,482.4 L1300,494.8 L1325,509.9 L1350,524.1 L1375,535.4 L1400,544.3 L1425,553.2 L1450,563.6 L1475,575.2 L1500,586.8 L1525,597.8 L1550,608.3 L1575,618.6 L1600,627.3 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.77" stroke-width="1.15" stroke-linejoin="round"/>
<path d="M0,661.1 L25,659.7 L50,656.6 L75,654.1 L100,653.8 L125,654.9 L150,655.2 L175,653.6 L200,651.8 L225,651.8 L250,654.3 L275,657.7 L300,659.5 L325,658.9 L350,657.4 L375,657.2 L400,658.6 L425,659.6 L450,658.3 L475,655.0 L500,651.8 L525,650.7 L550,651.6 L575,652.0 L600,650.0 L625,645.8 L650,641.1 L675,637.2 L700,632.8 L725,625.9 L750,615.3 L775,602.7 L800,591.5 L825,583.5 L850,578.3 L875,573.8 L900,569.1 L925,565.1 L950,563.1 L975,562.5 L1000,560.7 L1025,554.9 L1050,544.6 L1075,532.1 L1100,520.4 L1125,510.5 L1150,501.7 L1175,493.3 L1200,486.7 L1225,484.7 L1250,489.2 L1275,499.7 L1300,513.1 L1325,526.7 L1350,539.8 L1375,552.9 L1400,566.2 L1425,578.4 L1450,588.5 L1475,596.9 L1500,605.9 L1525,617.4 L1550,630.4 L1575,641.8 L1600,648.5 L1600,640 L0,640 Z" fill="#0d0f0f" stroke="#c8a45c" stroke-opacity="0.80" stroke-width="1.15" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="wrap">
                <p class="eyebrow">ManyCents &middot; Durbanville, South Africa</p>
                <h1>Coal, corridors <em>and code.</em></h1>
                <p class="lead">We mine, source, process and trade coal across Southern Africa, move it to the ports of Maputo, Matola and Richards Bay, and build the software that keeps heavy industry accountable.</p>
                <div class="actions">
                    <a class="btn primary" href="#contact">Enquire about coal</a>
                    <a class="btn ghost" href="#group">Explore the group</a>
                </div>
            </div>
        </section>

        <div class="strip">
            <div class="wrap">
                <ul>
                    <li><strong>Anthracite, lean, RB thermal</strong>Blended to specification</li>
                    <li><strong>Maputo &middot; Matola &middot; Richards Bay</strong>Multi-modal export routes</li>
                    <li><strong>Mine to vessel</strong>One accountable chain</li>
                    <li><strong>Deterministic software</strong>Rules written, versioned, traceable</li>
                </ul>
            </div>
        </div>

        <!-- ===== Group ===== -->
        <section class="on-paper" id="group">
            <div class="wrap">
                <p class="eyebrow reveal">The group</p>
                <h2 class="title reveal">Three disciplines, one operating mind.</h2>
                <p class="lead reveal">ManyCents was built on a simple observation: the expensive failures in heavy industry are rarely about the rock. They are about the paperwork, the haulage queue and the number nobody could trace. We work on all three.</p>

                <div class="three reveal">
                    <article class="pillar">
                        <span class="num">01</span>
                        <h3>ManyCents Resources</h3>
                        <p>Full-cycle coal operations: mining, processing and trading across Southern Africa. We buy at source, wash and blend to specification, and sell to industrial and power buyers on an independent certificate of analysis.</p>
                        <a href="#coal">What we trade &rarr;</a>
                    </article>
                    <article class="pillar">
                        <span class="num">02</span>
                        <h3>Integrated Logistics</h3>
                        <p>Road, rail and port handling planned as a single chain, including a rail route through eSwatini to Maputo built to avoid the queue at Richards Bay.</p>
                        <a href="#corridor">The corridor &rarr;</a>
                    </article>
                    <article class="pillar">
                        <span class="num">03</span>
                        <h3>Software Studio</h3>
                        <p>Production-grade software that turns statutory liability, haulage bottlenecks and cargo-rejection penalties into engines you can audit, not black boxes you have to trust.</p>
                        <a href="#software">What we build &rarr;</a>
                    </article>
                </div>
            </div>
        </section>

        <!-- ===== Coal ===== -->
        <section id="coal">
            <div class="wrap">
                <p class="eyebrow reveal">Coal</p>
                <h2 class="title reveal">Sold on the certificate, not the brochure.</h2>
                <p class="lead reveal">Three feedstocks and the ability to combine them. Every parcel is sampled and analysed by an independent inspector, and the buyer contracts against that analysis.</p>

                <div class="coal-grid reveal">
                    <article class="grade">
                        <h3>Anthracite</h3>
                        <p class="for">High-rank, low-ash coal, available sized and unsized.</p>
                        <ul><li>Industrial heating</li><li>Metallurgy and sintering</li><li>Filtration</li></ul>
                    </article>
                    <article class="grade">
                        <h3>Lean coal</h3>
                        <p class="for">Meeting international thermal specifications.</p>
                        <ul><li>Power generation</li><li>Cement production</li><li>Industrial process heat</li></ul>
                    </article>
                    <article class="grade">
                        <h3>RB thermal</h3>
                        <p class="for">Export-grade thermal coal to seaborne RB2 and RB3 specifications.</p>
                        <ul><li>Utility-scale power</li><li>Industrial steam</li><li>Co-firing</li></ul>
                    </article>
                    <article class="grade blend">
                        <h3>Blended to spec</h3>
                        <p class="for">We engineer the product to the buyer, rather than shipping whatever came out of the ground.</p>
                        <ul><li>Calorific value</li><li>Ash and sulphur</li><li>Volatiles and sizing</li></ul>
                    </article>
                </div>

                <div class="assurance reveal">
                    <div>
                        <h3>Quality you can verify.</h3>
                        <p>Specifications are confirmed per parcel by laboratory analysis, with the sampling independent of both buyer and seller. If a number is missing, we say so, rather than estimating it.</p>
                    </div>
                    <div>
                        <h3>Who it is for.</h3>
                        <p>Power, cement, metallurgical and industrial users, and the traders and shipping partners who supply them. Enquiries are welcome for spot parcels and for term supply.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== Corridor ===== -->
        <section class="on-paper" id="corridor">
            <div class="wrap">
                <p class="eyebrow reveal">The corridor</p>
                <h2 class="title reveal">From pit to port, by road and by rail.</h2>
                <p class="lead reveal">Congestion at the traditional export route is a cost. We plan the whole chain, mine gate to vessel, and keep more than one way to get there.</p>

                <div class="corridor-layout reveal">
                    <ul class="routes">
                        <li>
                            <h3>Road to Maputo</h3>
                            <p>Direct haulage from the Mpumalanga coalfields to the Port of Maputo and the Matola terminal, with gate manifests and weighbridge reconciliation handled by our own software.</p>
                        </li>
                        <li>
                            <h3>Rail via eSwatini</h3>
                            <p>Trucks to a rail siding at Matsapha, then rail on the Goba line to Maputo. Moves the long haul off the road and lowers landed cost per tonne.</p>
                        </li>
                        <li>
                            <h3>Richards Bay</h3>
                            <p>Dual-port routing means a shipment can follow whichever route has capacity that week.</p>
                        </li>
                    </ul>

                    <figure class="map" style="margin:0">
                        <svg viewBox="0 0 700 400" role="img" aria-label="Schematic of coal routes: from the Mpumalanga coalfields by road to Maputo, by road to Matsapha in eSwatini then by rail to Maputo, and by road or rail to Richards Bay.">
                            <rect x="0" y="0" width="700" height="400" fill="none"/>
                            <!-- Coastline hint -->
                            <path d="M640 0 C 612 90, 650 150, 626 230 C 606 290, 640 340, 606 400" fill="none" stroke="#c8a45c" stroke-opacity=".16" stroke-width="1.2" stroke-dasharray="2 5"/>
                            <!-- Road: coalfields to Maputo -->
                            <path d="M96 210 C 220 110, 420 70, 570 92" fill="none" stroke="#c8a45c" stroke-width="2.4"/>
                            <text x="296" y="84" fill="#e2c585" font-size="15" transform="rotate(-9 296 84)">road</text>
                            <!-- Road: coalfields to Matsapha -->
                            <path d="M96 210 C 190 226, 260 238, 340 244" fill="none" stroke="#c8a45c" stroke-width="2.4"/>
                            <!-- Rail: Matsapha to Maputo (Goba) -->
                            <path d="M340 244 C 430 220, 500 150, 570 92" fill="none" stroke="#e2c585" stroke-width="2.4" stroke-dasharray="3 6"/>
                            <text x="470" y="196" fill="#e2c585" font-size="15" transform="rotate(-42 470 196)">rail, Goba line</text>
                            <!-- Richards Bay -->
                            <path d="M96 210 C 240 290, 420 330, 570 322" fill="none" stroke="#c8a45c" stroke-opacity=".6" stroke-width="1.6"/>
                            <text x="286" y="326" fill="#a9adab" font-size="15" transform="rotate(5 286 326)">road or rail</text>
                            <!-- Nodes -->
                            <g fill="#0d0f0f" stroke="#e2c585" stroke-width="2">
                                <circle cx="96" cy="210" r="9"/>
                                <circle cx="340" cy="244" r="7"/>
                                <circle cx="570" cy="92" r="10"/>
                                <circle cx="570" cy="322" r="8"/>
                            </g>
                            <g fill="#f1ede4" font-size="17" font-weight="600">
                                <text x="96" y="244" text-anchor="middle">Mpumalanga</text>
                                <text x="96" y="263" text-anchor="middle" font-weight="400" fill="#a9adab" font-size="14">coalfields</text>
                                <text x="340" y="278" text-anchor="middle">Matsapha</text>
                                <text x="340" y="297" text-anchor="middle" font-weight="400" fill="#a9adab" font-size="14">eSwatini</text>
                                <text x="570" y="56" text-anchor="middle">Maputo</text>
                                <text x="570" y="74" text-anchor="middle" font-weight="400" fill="#a9adab" font-size="14">and Matola</text>
                                <text x="570" y="356" text-anchor="middle">Richards Bay</text>
                            </g>
                        </svg>
                        <figcaption>Schematic, not to scale.</figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <!-- ===== Software ===== -->
        <section id="software">
            <div class="wrap">
                <p class="eyebrow reveal">ManyCents Software Studio</p>
                <h2 class="title reveal">Software built where the liability lives.</h2>
                <p class="lead reveal">We are not an AI wrapper. We run mining, haulage and blending ourselves, so we build for the failures we have actually paid for. Where a number or a rule decides money or compliance, it comes from a written, versioned rule, never from a model's guess.</p>

                <div class="products reveal">
                    <article class="product">
                        <header><h3>Mine Operating System</h3><span class="tag">Development completed</span></header>
                        <p>Total administration for a single mine: statutory appointments, SHEQ and risk, and operations. Compliance rules are authored in version control and applied by a deterministic engine, so any past decision can be reproduced to the day.</p>
                    </article>
                    <article class="product">
                        <header><h3>LoadMatch</h3><span class="tag">In production</span></header>
                        <p>Gate manifests for haulage companies. The five facts a boom gate checks become a ready truck list for security, the weighbridge and the dispatch group, then are reconciled afterwards against what was actually weighed.</p>
                    </article>
                    <article class="product">
                        <header><h3>CoA Analyser</h3><span class="tag">In production</span></header>
                        <p>Upload a laboratory certificate of analysis and get lossless, structured data and a classification against locked quality bands. Built for the pile of PDFs that arrive over WhatsApp and email.</p>
                    </article>
                    <article class="product">
                        <header><h3>Narondo</h3><span class="tag">In development</span></header>
                        <p>A coal blending engine that refuses to invent a missing figure. Every output carries an evidence grade, and every &ldquo;no&rdquo; carries a reason.</p>
                    </article>
                </div>

                <div class="amap reveal">
                    <div>
                        <p class="eyebrow">How we build</p>
                        <h3>The 7-Seat Autonomous Multi-Agent Protocol</h3>
                        <p>AMAP is an adversarial engineering harness. Seven seats, filled by frontier models, build, review and challenge each other's work under a domain Architect, and tests answer to the Architect's specification, not to the code they are testing.</p>
                        <p>The result is production software at a pace a small studio could not otherwise reach, with a paper trail for every decision.</p>
                        <div class="models" aria-label="Models used"><span>Gemini</span><span>Claude</span><span>Grok</span><span>DeepSeek</span></div>
                    </div>
                    <svg viewBox="0 0 300 300" role="img" aria-label="Seven seats arranged around a central domain Architect" style="max-width:320px;margin:0 auto;width:100%">
                        <circle cx="150" cy="150" r="104" fill="none" stroke="#c8a45c" stroke-opacity=".28"/>
                        <g stroke="#c8a45c" stroke-opacity=".35">
                            <line x1="150.0" y1="120.0" x2="150.0" y2="46.0"/>
<line x1="178.1" y1="131.3" x2="231.3" y2="85.2"/>
<line x1="185.1" y1="156.7" x2="251.4" y2="173.1"/>
<line x1="165.6" y1="177.0" x2="195.1" y2="243.7"/>
<line x1="134.4" y1="177.0" x2="104.9" y2="243.7"/>
<line x1="114.9" y1="156.7" x2="48.6" y2="173.1"/>
<line x1="121.9" y1="131.3" x2="68.7" y2="85.2"/>
                        </g>
                        <g fill="#0d0f0f" stroke="#e2c585" stroke-width="1.8">
                            <circle cx="150.0" cy="46.0" r="13"/><text x="150.0" y="50.0" text-anchor="middle" font-family="Inter, sans-serif" font-size="12" font-weight="600" fill="#e2c585" stroke="none">1</text>
<circle cx="231.3" cy="85.2" r="13"/><text x="231.3" y="89.2" text-anchor="middle" font-family="Inter, sans-serif" font-size="12" font-weight="600" fill="#e2c585" stroke="none">2</text>
<circle cx="251.4" cy="173.1" r="13"/><text x="251.4" y="177.1" text-anchor="middle" font-family="Inter, sans-serif" font-size="12" font-weight="600" fill="#e2c585" stroke="none">3</text>
<circle cx="195.1" cy="243.7" r="13"/><text x="195.1" y="247.7" text-anchor="middle" font-family="Inter, sans-serif" font-size="12" font-weight="600" fill="#e2c585" stroke="none">4</text>
<circle cx="104.9" cy="243.7" r="13"/><text x="104.9" y="247.7" text-anchor="middle" font-family="Inter, sans-serif" font-size="12" font-weight="600" fill="#e2c585" stroke="none">5</text>
<circle cx="48.6" cy="173.1" r="13"/><text x="48.6" y="177.1" text-anchor="middle" font-family="Inter, sans-serif" font-size="12" font-weight="600" fill="#e2c585" stroke="none">6</text>
<circle cx="68.7" cy="85.2" r="13"/><text x="68.7" y="89.2" text-anchor="middle" font-family="Inter, sans-serif" font-size="12" font-weight="600" fill="#e2c585" stroke="none">7</text>
                        </g>
                        <circle cx="150" cy="150" r="36" fill="#c8a45c"/>
                        <text x="150" y="147" text-anchor="middle" font-family="Inter, sans-serif" font-size="9.5" font-weight="600" fill="#0d0f0f">DOMAIN</text>
                        <text x="150" y="159" text-anchor="middle" font-family="Inter, sans-serif" font-size="9.5" font-weight="600" fill="#0d0f0f">ARCHITECT</text>
                    </svg>
                </div>
            </div>
        </section>

        <!-- ===== Contact ===== -->
        <section class="on-ink-2" id="contact">
            <div class="wrap">
                <p class="eyebrow reveal">Get in touch</p>
                <h2 class="title reveal">Tell us what you need to move, make or measure.</h2>

                <div class="contact-grid reveal">
                    <div class="details">
                        <dl>
                            <dt>Company</dt>
                            <dd>ManyCents Resources (Pty) Ltd<br>Luhein Lategan, CEO</dd>
                            <dt>Office</dt>
                            <dd>18 Bubesi House, Wellington Office Park<br>Durbanville, Western Cape 7500</dd>
                            <dt>Phone</dt>
                            <dd><a href="tel:+27609592405">+27 60 959 2405</a></dd>
                            <dt>Email</dt>
                            <dd><a href="mailto:luhein.lategan@manycents.co.za">luhein.lategan@manycents.co.za</a></dd>
                        </dl>
                    </div>

                    <form class="contact" id="contactForm" action="contact.php" method="POST" novalidate>
                        <div class="notice" id="notice" role="status" aria-live="polite"></div>
                        <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES); ?>">

                        <div class="field">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" required autocomplete="name">
                            <span class="err">Please enter your name</span>
                        </div>
                        <div class="field">
                            <label for="company">Company</label>
                            <input type="text" id="company" name="company" required autocomplete="organization">
                            <span class="err">Please enter your company</span>
                        </div>
                        <div class="field">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required autocomplete="email">
                            <span class="err">Please enter a valid email address</span>
                        </div>
                        <div class="field">
                            <label for="product">Interested in</label>
                            <select id="product" name="product">
                                <option value="">Select (optional)</option>
                                <option>Anthracite</option>
                                <option>Lean coal</option>
                                <option>RB thermal coal</option>
                                <option>Blended to specification</option>
                                <option>Logistics and corridor</option>
                                <option>Software</option>
                                <option>Something else</option>
                            </select>
                        </div>
                        <div class="field full">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" required placeholder="Volumes, specifications, timing, or the problem you want solved"></textarea>
                            <span class="err">Please enter a message</span>
                        </div>
                        <div class="form-foot">
                            <button class="btn primary" type="submit">Send enquiry</button>
                            <small>We use your details only to reply to this enquiry, in line with POPIA.</small>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="site">
        <div class="wrap">
            <div>
                <p>&copy; 2026 ManyCents. ManyCents Resources (Pty) Ltd, registration 2024/594919/07.</p>
                <p>18 Bubesi House, Wellington Office Park, Durbanville, 7500, South Africa.</p>
            </div>
            <p>Coal &middot; Corridors &middot; Code</p>
        </div>
    </footer>

    <script>
    (function () {
        document.documentElement.classList.add('js');

        // Mobile menu
        var btn = document.getElementById('menuBtn'), nav = document.getElementById('mainNav');
        btn.addEventListener('click', function () {
            var open = nav.classList.toggle('open');
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        nav.addEventListener('click', function (e) {
            if (e.target.tagName === 'A') { nav.classList.remove('open'); btn.setAttribute('aria-expanded', 'false'); }
        });

        // Reveal on scroll
        var items = document.querySelectorAll('.reveal');
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
            }, { threshold: 0.12 });
            items.forEach(function (el) { io.observe(el); });
        } else {
            items.forEach(function (el) { el.classList.add('in'); });
        }

        // Form validation (the server validates again)
        var form = document.getElementById('contactForm'), notice = document.getElementById('notice');
        function show(kind, text) {
            notice.className = 'notice show ' + kind;
            notice.textContent = text;
            notice.scrollIntoView({ block: 'center', behavior: 'smooth' });
        }
        function check(id, test) {
            var f = document.getElementById(id), box = f.closest('.field'), ok = test(f.value.trim());
            box.classList.toggle('bad', !ok);
            return ok;
        }
        form.addEventListener('submit', function (e) {
            var okName = check('name', function (v) { return v.length > 0; });
            var okCo = check('company', function (v) { return v.length > 0; });
            var okMail = check('email', function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); });
            var okMsg = check('message', function (v) { return v.length > 0; });
            if (!(okName && okCo && okMail && okMsg)) {
                e.preventDefault();
                show('fail', 'Please fix the highlighted fields and try again.');
            }
        });

        // Result of the last submission, set by contact.php
        var q = new URLSearchParams(window.location.search);
        var errors = {
            missing: 'Please fill in every required field.',
            invalid_email: 'That email address does not look right.',
            rate_limit: 'Too many enquiries from this connection. Please try again in an hour.',
            send_failed: 'We could not send your message. Please email us directly instead.',
            csrf: 'Your session expired. Please reload the page and try again.',
            spam: 'Your message could not be sent.'
        };
        if (q.has('success')) {
            show('ok', 'Thank you. We have your enquiry and will reply shortly.');
        } else if (q.has('error')) {
            show('fail', errors[q.get('error')] || 'Something went wrong. Please try again.');
        }
        if (q.has('success') || q.has('error')) { history.replaceState(null, '', window.location.pathname + '#contact'); }
    })();
    </script>
</body>
</html>
