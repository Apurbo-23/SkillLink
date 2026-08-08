<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>● SkillLink — Share Skills, Grow Together</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:    #0B0A09;
            --navy-2:  #121110;
            --navy-3:  #171615;
            --teal:    #D4AF37;
            --teal-dim:#C6A152;
            --amber:   #D4AF37;
            --white:   #F0F4FF;
            --muted:   #8A9BBF;
            --border:  rgba(255,255,255,0.08);
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--navy);
            color: var(--white);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* ── NAV ── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 5%;
            background: rgb(193, 159, 50);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
        }

        .logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.45rem;
        }

        .logo-dot {
            width: 9px; height: 9px;
            border-radius: 50%;
            background: rgb(26, 24, 24);
            display: inline-block;
            flex-shrink: 0;
        }

        .nav-links { display: flex; align-items: center; gap: 1rem; }

        .btn-primary {
            padding: 0.5rem 1.4rem;
            background: rgb(34, 33, 31);
            border: 1.5px solid rgb(12, 12, 12);
            border-radius: 8px;
            color: #fffffff7;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: background .2s, transform .15s;
        }
        .btn-primary:hover { background: var(--teal-dim); transform: translateY(-1px); }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 8rem 5% 5rem;
            position: relative;
            overflow: hidden;
        }

        /* radial glow */
        .hero::after {
            content: '';
            position: absolute;
            top: 30%; left: 50%;
            transform: translate(-50%, -50%);
            width: 700px; height: 400px;
            background: radial-gradient(ellipse, rgba(212,175,55,.18) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 1rem;
            border: 1px solid rgba(212,175,55,.35);
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--teal);
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 1.75rem;
            position: relative;
            z-index: 1;
        }

        .hero-eyebrow span.pulse {
            width: 7px; height: 7px;
            background: var(--teal);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(.7); }
        }

        .hero h1 {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.6rem, 6vw, 5rem);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -.02em;
            max-width: 820px;
            position: relative;
            z-index: 1;
            margin-bottom: 1.5rem;
        }

        .hero h1 em {
            font-style: normal;
            color: var(--teal);
        }

        .hero p {
            font-size: 1.125rem;
            color: var(--muted);
            max-width: 540px;
            margin: 0 auto 2.5rem;
            position: relative;
            z-index: 1;
            font-weight: 400;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .btn-hero {
            padding: 0.85rem 2rem;
            background: var(--teal);
            border-radius: 10px;
            color: #0B0A09;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 0 0 0 rgba(212,175,55,0);
        }
        .btn-hero:hover {
            background: var(--teal-dim);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(212,175,55,.3);
        }

        .btn-hero-outline {
            padding: 0.85rem 2rem;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: border-color .2s, background .2s;
        }
        .btn-hero-outline:hover { border-color: var(--teal); background: rgba(212,175,55,.07); }

        /* ── EXCHANGE VISUAL ── */
        .exchange {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            margin-top: 4rem;
            position: relative;
            z-index: 1;
        }

        .avatar-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.6rem;
        }

        .avatar {
            width: 72px; height: 72px;
            border-radius: 50%;
            border: 2.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--navy-2);
        }

        .avatar-icon {
            width: 26px;
            height: 26px;
            color: var(--teal);
        }

        .avatar-icon.secondary {
            color: var(--amber);
        }

        .skill-badge {
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: .03em;
        }
        .skill-badge.teal { background: rgba(212,175,55,.15); color: var(--teal); border: 1px solid rgba(212,175,55,.3); }
        .skill-badge.amber { background: rgba(212,175,55,.12); color: var(--amber); border: 1px solid rgba(212,175,55,.3); }

        .exchange-arrow {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .arrow-track {
            width: 120px;
            position: relative;
            height: 36px;
            display: flex;
            align-items: center;
        }

        .arrow-line {
            height: 1.5px;
            width: 100%;
            background: linear-gradient(90deg, var(--teal), var(--amber));
            border-radius: 2px;
        }

        .arrow-head-right, .arrow-head-left {
            position: absolute;
            width: 0; height: 0;
        }
        .arrow-head-right {
            right: -1px;
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
            border-left: 8px solid var(--amber);
        }
        .arrow-head-left {
            left: -1px;
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
            border-right: 8px solid var(--teal);
        }

        .arrow-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--teal);
            position: absolute;
            left: 0;
            animation: slideDot 2.4s ease-in-out infinite;
        }

        .arrow-dot.reverse {
            background: var(--amber);
            animation: slideDotReverse 2.4s ease-in-out infinite;
            animation-delay: 1.2s;
        }

        @keyframes slideDot {
            0%   { left: 0; opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { left: calc(100% - 8px); opacity: 0; }
        }

        @keyframes slideDotReverse {
            0%   { left: calc(100% - 8px); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { left: 0; opacity: 0; }
        }

        .exchange-label {
            font-size: 0.7rem;
            color: var(--muted);
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        /* ── STATS STRIP ── */
        .stats {
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 2.5rem 5%;
            display: flex;
            justify-content: center;
            gap: 0;
        }

        .stat {
            flex: 1;
            max-width: 220px;
            text-align: center;
            padding: 0 2rem;
            border-right: 1px solid var(--border);
        }
        .stat:last-child { border-right: none; }

        .stat-number {
            font-family: 'Syne', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--teal);
            line-height: 1;
            margin-bottom: 0.3rem;
        }

        .stat-label {
            font-size: 0.82rem;
            color: var(--muted);
            font-weight: 400;
        }

        /* ── SECTION COMMON ── */
        section { padding: 6rem 5%; }

        .section-eyebrow {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--teal);
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 1rem;
        }

        .section-sub {
            color: var(--muted);
            font-size: 1rem;
            max-width: 500px;
            line-height: 1.7;
        }

        /* ── HOW IT WORKS ── */
        .how { background: var(--navy); }

        .how-header { text-align: center; margin-bottom: 4rem; }
        .how-header .section-sub { margin: 0 auto; }

        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5px;
            background: var(--border);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            max-width: 1000px;
            margin: 0 auto;
        }

        .step {
            background: var(--navy);
            padding: 2.5rem 2rem;
            position: relative;
        }

        .step-num {
            font-family: 'Syne', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            color: rgba(212,175,55,.12);
            line-height: 1;
            margin-bottom: 1.25rem;
            letter-spacing: -.04em;
        }

        .step-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            background: rgba(212,175,55,.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            border: 1px solid rgba(0,201,167,.2);
            color: var(--teal);
        }

        .step-icon svg {
            width: 20px;
            height: 20px;
        }

        .step h3 {
            font-family: 'Syne', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .step p {
            font-size: 0.875rem;
            color: var(--muted);
            line-height: 1.65;
        }

        /* ── FOOTER ── */
        footer {
            border-top: 1px solid var(--border);
            padding: 2rem 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        footer .logo { font-size: 1.1rem; }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-links a {
            font-size: 0.82rem;
            color: var(--muted);
            text-decoration: none;
            transition: color .2s;
        }
        .footer-links a:hover { color: var(--teal); }

        .footer-copy {
            font-size: 0.78rem;
            color: var(--muted);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 640px) {
            .stats { flex-direction: column; align-items: center; }
            .stat { border-right: none; border-bottom: 1px solid var(--border); padding: 1.5rem 0; max-width: 100%; width: 100%; }
            .stat:last-child { border-bottom: none; }
            .exchange { gap: 1rem; }
            .arrow-track { width: 70px; }
            nav { padding: 1rem 4%; }
            footer { flex-direction: column; text-align: center; }
            .footer-links { justify-content: center; }
        }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav>
        <a href="/" class="logo">
            <span class="logo-dot"></span>SkillLink
        </a>
        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- HERO -->
    <div class="hero">
        <div class="hero-eyebrow">
            <span class="pulse"></span>
            Skill-sharing, reimagined
        </div>

        <h1>Teach what you know.<br><em>Learn what you love.</em></h1>

        <p>SkillLink connects people who have skills to share with people who want to learn them — no money, just mutual growth.</p>

        <div class="hero-cta">
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-hero">Start sharing skills</a>
            @endif
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn-hero-outline">I already have an account</a>
            @endif
        </div>

        <!-- Animated exchange visual -->
        <div class="exchange">
            <div class="avatar-card">
                <div class="avatar">
                    <svg class="avatar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 3l7 7-4 4-7-7 4-4z"></path>
                        <path d="M5 14l4 4"></path>
                        <path d="M4 20h16"></path>
                    </svg>
                </div>
                <div class="skill-badge teal">Design</div>
            </div>

            <div class="exchange-arrow">
                <div class="arrow-track">
                    <div class="arrow-line"></div>
                    <div class="arrow-head-right"></div>
                    <div class="arrow-head-left"></div>
                    <div class="arrow-dot"></div>
                    <div class="arrow-dot reverse"></div>
                </div>
                <div class="exchange-label">Swap</div>
            </div>

            <div class="avatar-card">
                <div class="avatar">
                    <svg class="avatar-icon secondary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                        <path d="M8 19h8"></path>
                        <path d="M10 9h4"></path>
                        <path d="M10 12h4"></path>
                    </svg>
                </div>
                <div class="skill-badge amber">Coding</div>
            </div>
        </div>
    </div>


    <!-- HOW IT WORKS -->
    <section class="how">
        <div class="how-header">
            <div class="section-eyebrow">How it works</div>
            <h2 class="section-title">Three steps to your first skill swap</h2>
            <p class="section-sub">No fees, no awkward pricing — just two people teaching each other something valuable.</p>
        </div>

        <div class="steps">
            <div class="step">
                <div class="step-num">01</div>
                <div class="step-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9.5" cy="7" r="3"></circle>
                        <path d="M17 8l2 2 4-4"></path>
                    </svg>
                </div>
                <h3>Create your profile</h3>
                <p>List the skills you can teach and the ones you want to learn. Be specific — "Figma prototyping" beats "design."</p>
            </div>
            <div class="step">
                <div class="step-num">02</div>
                <div class="step-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="6"></circle>
                        <path d="M20 20l-4.2-4.2"></path>
                    </svg>
                </div>
                <h3>Find a match</h3>
                <p>Browse members whose offerings complement your needs. Filter by category, availability, or experience level.</p>
            </div>
            <div class="step">
                <div class="step-num">03</div>
                <div class="step-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M7 10h10"></path>
                        <path d="M7 14h6"></path>
                        <path d="M5 5h14a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-3l-4 4-4-4H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"></path>
                    </svg>
                </div>
                <h3>Start exchanging</h3>
                <p>Reach out, agree on a format — sessions, async feedback, project collaboration — and start growing together.</p>
            </div>
            <div class="step">
                <div class="step-num">04</div>
                <div class="step-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 3l2.7 5.4 5.9.9-4.4 4.2 1.1 5.8L12 17.4 6.7 19.3l1.1-5.8L3.4 9.3l5.9-.9L12 3z"></path>
                    </svg>
                </div>
                <h3>Build your reputation</h3>
                <p>Every completed exchange earns you ratings and endorsements that make your next match easier to find.</p>
            </div>
        </div>
    </section>

</body>
</html>