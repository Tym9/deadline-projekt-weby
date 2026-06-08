    <style>
        /* ── Tokeny ─────────────────────────────────────────────── */
        :root {
            --cream: #faf7f2;
            --ink: #1c1917;
            --muted: #78716c;
            --border: #e7e3db;
            --accent: #b45309;
            --accent-light: #fef3c7;
            --card-bg: #ffffff;
            --radius: 12px;
            --nav-bg: #151311;
            --nav-accent: #f59e0b;
        }
 
        /* ── Základní typografie ────────────────────────────────── */
        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--cream);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            line-height: 1.7;
        }

        main {
            padding-bottom: 3rem;
        }
 
        h1, h2, h3, h4, .display-font {
            font-family: 'Playfair Display', serif;
        }

        .site-navbar {
            background: linear-gradient(135deg, var(--nav-bg), #2a2218);
            box-shadow: 0 10px 30px rgba(21, 19, 17, .18);
        }

        .site-navbar .navbar-brand,
        .site-navbar .nav-link {
            color: rgba(255, 255, 255, .86);
        }

        .site-navbar .nav-link:hover,
        .site-navbar .nav-link:focus,
        .site-navbar .nav-link.active {
            color: #fff;
        }

        .site-navbar .nav-link.active {
            position: relative;
        }

        .site-navbar .nav-link.active::after {
            content: '';
            position: absolute;
            left: .65rem;
            right: .65rem;
            bottom: .3rem;
            height: 2px;
            border-radius: 999px;
            background: var(--nav-accent);
        }

        .btn-login {
            border: 1px solid rgba(255, 255, 255, .2);
            color: #fff;
            border-radius: 999px;
            padding: .45rem 1rem;
            background: rgba(255, 255, 255, .06);
        }

        .btn-login:hover,
        .btn-login:focus {
            background: var(--nav-accent);
            color: #1f1300;
        }

        .hero-panel {
            background: linear-gradient(135deg, rgba(255, 255, 255, .95), rgba(255, 248, 233, .92));
            border: 1px solid rgba(231, 227, 219, .95);
            border-radius: 24px;
            padding: clamp(1.5rem, 3vw, 2.5rem);
            box-shadow: 0 18px 40px rgba(28, 25, 23, .06);
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--accent);
            background: var(--accent-light);
            padding: .4rem .75rem;
            border-radius: 999px;
        }

        .hero-cta .btn {
            border-radius: 999px;
        }
 
        /* ── Karty knih ─────────────────────────────────────────── */
        .books-grid {
            row-gap: 1.5rem;
        }

        .book-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
 
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(28,25,23,.10);
            color: inherit;
        }
 
        .book-card .cover-wrap {
            position: relative;
            aspect-ratio: 3/4;
            overflow: hidden;
            background: var(--border);
        }

        .book-card .cover-fallback {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            background: radial-gradient(circle at top, #fde68a, #d97706 72%);
            color: rgba(255, 255, 255, .92);
            font-size: 3rem;
        }
 
        .book-card .cover-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s ease;
        }
 
        .book-card:hover .cover-wrap img {
            transform: scale(1.04);
        }
 
        .book-card .cover-wrap .badge-rating {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255,255,255,.92);
            color: var(--accent);
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            font-size: .8rem;
            padding: .25rem .55rem;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 4px;
            backdrop-filter: blur(4px);
        }
 
        .book-card .card-body {
            padding: 1rem 1.1rem 1.2rem;
            display: flex;
            flex-direction: column;
            gap: .3rem;
            flex: 1;
        }
 
        .book-card .card-genre {
            font-size: .72rem;
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--accent);
        }
 
        .book-card .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.3;
            margin: 0;
            color: var(--ink);
        }

        .book-card .card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: .45rem;
            font-size: .75rem;
            color: var(--muted);
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .18rem .55rem;
            background: #fff;
        }
 
        .book-card .card-desc {
            font-size: .85rem;
            color: var(--muted);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
 
        .book-card .card-author {
            font-size: .8rem;
            color: var(--muted);
            margin-top: auto;
            padding-top: .4rem;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 5px;
        }
 
        /* ── Filtrovací sekce ───────────────────────────────────── */
        .filter-bar {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1.1rem 1.4rem;
            box-shadow: 0 12px 28px rgba(28, 25, 23, .04);
        }
 
        .filter-bar .form-select,
        .filter-bar .form-control {
            border-color: var(--border);
            background-color: var(--cream);
            font-size: .88rem;
        }
 
        .filter-bar .form-select:focus,
        .filter-bar .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 .2rem rgba(180,83,9,.15);
        }
 
        .btn-filter {
            background: var(--ink);
            color: #fff;
            border: none;
            font-size: .88rem;
            font-weight: 500;
            padding: .45rem 1.2rem;
            border-radius: 8px;
            transition: background .15s;
        }
 
        .btn-filter:hover {
            background: var(--accent);
            color: #fff;
        }
 
        .btn-reset {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
            font-size: .88rem;
            padding: .45rem 1rem;
            border-radius: 8px;
            transition: color .15s, border-color .15s;
        }
 
        .btn-reset:hover {
            color: var(--ink);
            border-color: var(--ink);
        }

        .section-title {
            font-size: 1.45rem;
            margin-bottom: 0.35rem;
        }

        .section-subtitle {
            color: var(--muted);
            margin-bottom: 0;
        }

        .empty-state {
            border: 1px dashed var(--border);
            border-radius: 20px;
            background: rgba(255, 255, 255, .65);
            padding: 2rem;
            text-align: center;
            color: var(--muted);
        }
 
        /* ── Hero nadpis ────────────────────────────────────────── */
        .page-hero {
            padding: 3rem 0 1.8rem;
        }
 
        .page-hero h1 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            color: var(--ink);
            line-height: 1.15;
        }
 
        .page-hero p {
            color: var(--muted);
            font-size: 1rem;
            max-width: 520px;
        }
 
        /* ── Bootstrap alerts ───────────────────────────────────── */
        .alert { border-radius: var(--radius); font-size: .9rem; }
 
        /* ── Načítací animace karet ─────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
 
        .book-card {
            animation: fadeUp .4s ease both;
        }

        .fade-delay-1 { animation-delay: .05s; }
        .fade-delay-2 { animation-delay: .1s; }
        .fade-delay-3 { animation-delay: .15s; }
        .fade-delay-4 { animation-delay: .2s; }
    </style>