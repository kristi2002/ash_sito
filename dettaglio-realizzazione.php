<?php
// ============================================================
//  A.S.H. Finiture Contract — Di Ahmed Abdelaziz
//  Pagina di dettaglio di una realizzazione — PHP + Bootstrap 5
//  URL: dettaglio-realizzazione.php?id=<id>
// ============================================================

// Dati condivisi (azienda, servizi, realizzazioni) con la pagina elenco
require __DIR__ . '/includes/realizzazioni-data.php';

// Individua il progetto richiesto; se non esiste, torna all'elenco
$id_richiesto = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!isset($realizzazioni_per_id[$id_richiesto])) {
    header('Location: realizzazioni.php');
    exit;
}

$progetto = $realizzazioni_per_id[$id_richiesto];
$servizio = $servizi_per_slug[$progetto['categoria']];

// Altri progetti (escluso quello corrente) per la sezione "correlati"
$correlati = array_slice(
    array_values(array_filter($realizzazioni, function ($r) use ($progetto) {
        return $r['id'] !== $progetto['id'];
    })),
    0,
    3
);

// Scheda tecnica: righe mostrate nella sidebar (solo quelle valorizzate)
$scheda = [
    ['icona' => $servizio['icona'], 'label' => 'Servizio',   'valore' => $servizio['titolo'], 'link' => $servizio['url']],
    ['icona' => 'bi-geo-alt',       'label' => 'Luogo',      'valore' => $progetto['luogo']      ?? null],
    ['icona' => 'bi-calendar3',     'label' => 'Anno',       'valore' => $progetto['anno']       ?? null],
    ['icona' => 'bi-building',      'label' => 'Tipologia',  'valore' => $progetto['tipologia']  ?? null],
    ['icona' => 'bi-rulers',        'label' => 'Superficie', 'valore' => $progetto['superficie'] ?? null],
    ['icona' => 'bi-stopwatch',     'label' => 'Durata',     'valore' => $progetto['durata']     ?? null],
];

// Dati strutturati JSON-LD: CreativeWork + BreadcrumbList
$json_ld = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'CreativeWork',
        'name'        => $progetto['titolo'],
        'headline'    => $progetto['titolo'],
        'description' => $progetto['sottotitolo'],
        'image'       => $progetto['copertina'],
        'about'       => $servizio['titolo'],
        'locationCreated' => ['@type' => 'Place', 'name' => $progetto['luogo'] ?? 'Marche'],
        'creator'     => [
            '@type'     => 'LocalBusiness',
            'name'      => $site_name,
            'telephone' => $phone1_raw,
            'email'     => $email,
        ],
    ],
    [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',          'item' => 'index.php'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Realizzazioni', 'item' => 'realizzazioni.php'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $progetto['titolo']],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?php echo $progetto['titolo']; ?> | Realizzazioni — A.S.H. Finiture Contract</title>
    <meta name="description" content="<?php echo $progetto['sottotitolo']; ?> Una realizzazione di A.S.H. Finiture Contract a <?php echo $progetto['luogo']; ?>.">

    <!-- Bootstrap 5 + Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Fonts: Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="assets/img/logo-mark.png">

    <!-- Dati strutturati -->
    <?php foreach ($json_ld as $blocco): ?>
    <script type="application/ld+json"><?php echo json_encode($blocco, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
    <?php endforeach; ?>

    <style>
        /* ================= PALETTE BIANCO & ORO (come homepage) ================= */
        :root {
            --oro:        #c9a24b;
            --oro-scuro:  #a9822f;
            --oro-testo:  #7c5f20; /* oro profondo: leggibile su bianco (WCAG AA) */
            --oro-chiaro: #f5edd9;
            --crema:      #f5eee0;
            --scuro:      #2e3b42;
            --testo:      #4a5158;
        }

        * { scroll-margin-top: 84px; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--testo);
            background-color: #faf7ef;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .navbar-brand { color: var(--scuro); }

        .section-title {
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .title-underline {
            width: 70px;
            height: 4px;
            background: linear-gradient(90deg, var(--oro), var(--oro-scuro));
            border-radius: 2px;
            margin: 14px auto 0;
        }

        .title-underline.a-sinistra { margin-left: 0; }

        .text-oro { color: var(--oro-testo); }

        /* ================= NAVBAR ================= */
        .navbar {
            background: rgba(255, 255, 255, .96);
            transition: box-shadow .3s ease, padding .3s ease;
            padding-top: .9rem;
            padding-bottom: .9rem;
        }

        .navbar.scrolled {
            box-shadow: 0 4px 24px rgba(46, 59, 66, .12);
            padding-top: .4rem;
            padding-bottom: .4rem;
        }

        .navbar-brand { display: flex; align-items: center; gap: .7rem; }

        .navbar-brand img { height: 46px; width: auto; }

        .brand-text { line-height: 1.05; }

        .brand-text .brand-main {
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: .5px;
            color: var(--scuro);
        }

        .brand-text .brand-sub {
            display: block;
            font-size: .62rem;
            font-weight: 600;
            letter-spacing: 2.6px;
            text-transform: uppercase;
            color: var(--oro-testo);
        }

        .navbar .nav-link {
            font-weight: 600;
            font-size: .92rem;
            color: var(--scuro);
            margin: 0 .35rem;
            position: relative;
        }

        .navbar .nav-link::after {
            content: "";
            position: absolute;
            left: .5rem; right: .5rem; bottom: .15rem;
            height: 2px;
            background: var(--oro);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .25s ease;
        }

        .navbar .nav-link:hover::after,
        .navbar .nav-link.active::after { transform: scaleX(1); }

        /* Sottomenu Servizi */
        .menu-servizi {
            border: 1px solid #eee6d4;
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(46, 59, 66, .14);
            padding: .6rem;
            margin-top: .6rem;
        }

        .menu-servizi .dropdown-item {
            display: flex;
            align-items: center;
            gap: .7rem;
            font-weight: 600;
            font-size: .9rem;
            color: var(--scuro);
            border-radius: 9px;
            padding: .55rem .9rem;
            transition: background .2s ease, color .2s ease, transform .2s ease;
        }

        .menu-servizi .dropdown-item i {
            color: var(--oro-testo);
            font-size: 1.05rem;
            transition: color .2s ease;
        }

        .menu-servizi .dropdown-item:hover,
        .menu-servizi .dropdown-item:focus,
        .menu-servizi .dropdown-item.attivo {
            background: var(--oro-chiaro);
            color: var(--oro-testo);
            transform: translateX(4px);
        }

        .menu-servizi .dropdown-divider { border-color: #eee6d4; opacity: 1; }

        /* Posizione fissa del sottomenu: stessa posizione su hover e click (evita il micro-spostamento verticale) */
        .navbar .dropdown-menu.menu-servizi {
            top: 100%;
            left: 0;
            right: auto;
            margin-top: .6rem;
        }

        @media (min-width: 992px) {
            .navbar .dropdown:hover > .dropdown-menu {
                display: block;
                animation: comparsa .25s ease;
            }

            .menu-servizi::before {
                content: "";
                position: absolute;
                top: -.6rem;
                left: 0;
                right: 0;
                height: .6rem;
            }
        }

        @keyframes comparsa {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .btn-oro {
            background: linear-gradient(135deg, #d9b866, var(--oro));
            color: var(--scuro);
            font-weight: 700;
            border: none;
            padding: .7rem 1.6rem;
            border-radius: 50rem;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .btn-oro:hover {
            color: var(--scuro);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(169, 130, 47, .35);
        }

        .btn-outline-scuro {
            border: 2px solid var(--scuro);
            color: var(--scuro);
            font-weight: 700;
            padding: .65rem 1.6rem;
            border-radius: 50rem;
            transition: all .25s ease;
        }

        .btn-outline-scuro:hover { background: var(--scuro); color: #fff; }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: var(--oro-chiaro);
            color: var(--oro-testo);
            font-weight: 700;
            font-size: .8rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: .5rem 1.1rem;
            border-radius: 50rem;
        }

        /* ================= HERO PAGINA ================= */
        .hero-servizio {
            min-height: 60vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: var(--scuro);
            padding: 9.5rem 0 4.5rem;
        }

        .hero-servizio .hero-bg {
            position: absolute;
            inset: 0;
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
            animation: kenburns 22s ease-in-out infinite alternate;
            will-change: transform;
        }

        @keyframes kenburns {
            from { transform: scale(1); }
            to   { transform: scale(1.1) translate(-1.5%, -1%); }
        }

        .hero-servizio .hero-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(100deg, rgba(24, 30, 34, .93) 0%, rgba(24, 30, 34, .75) 45%, rgba(24, 30, 34, .4) 100%),
                linear-gradient(0deg, rgba(169, 130, 47, .18), rgba(169, 130, 47, .18));
        }

        .hero-servizio .hero-badge {
            background: rgba(255, 255, 255, .14);
            color: #ecd9a8;
            backdrop-filter: blur(4px);
        }

        .hero-servizio h1 {
            font-weight: 800;
            font-size: clamp(1.9rem, 4.2vw, 3rem);
            line-height: 1.14;
            color: #ffffff;
            letter-spacing: .5px;
        }

        .hero-servizio h1 .gold {
            background: linear-gradient(135deg, #e8cc82, var(--oro));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-servizio .lead { max-width: 640px; color: rgba(255, 255, 255, .88); }

        .hero-servizio .btn-outline-scuro { border-color: #fff; color: #fff; }

        .hero-servizio .btn-outline-scuro:hover { background: #fff; color: var(--scuro); }

        /* Meta rapide sotto al titolo (luogo · anno · servizio) */
        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: .6rem 1.4rem;
            margin-top: 1.4rem;
            color: rgba(255, 255, 255, .82);
            font-size: .88rem;
            font-weight: 600;
        }

        .hero-meta span { display: inline-flex; align-items: center; gap: .5rem; }

        .hero-meta i { color: #e8cc82; }

        /* Breadcrumb nell'hero */
        .breadcrumb-servizio {
            display: inline-flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .35rem;
            margin-bottom: 2.5rem;
            padding: 0;
            font-size: .82rem;
            font-weight: 600;
            letter-spacing: .6px;
        }

        .breadcrumb-servizio a {
            color: rgba(255, 255, 255, .85);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: color .2s ease;
        }

        .breadcrumb-servizio a:hover { color: #e8cc82; }

        .breadcrumb-servizio .separatore { color: rgba(255, 255, 255, .45); font-size: .7rem; }

        .breadcrumb-servizio .corrente { color: #e8cc82; max-width: 100%; }

        /* Animazioni d'ingresso hero */
        .fade-up {
            opacity: 0;
            transform: translateY(26px);
            animation: fadeUp .8s ease forwards;
        }

        .delay-1 { animation-delay: .15s; }
        .delay-2 { animation-delay: .35s; }
        .delay-3 { animation-delay: .55s; }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* ================= REVEAL ALLO SCROLL ================= */
        .reveal {
            opacity: 0;
            transform: translateY(34px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (prefers-reduced-motion: reduce) {
            .hero-servizio .hero-bg { animation: none; }
        }

        /* ================= DETTAGLIO PROGETTO ================= */
        #dettaglio { padding: 5.5rem 0; background: linear-gradient(180deg, #fdfbf5 0%, #faf7ef 100%); }

        /* Copertina grande del progetto */
        .progetto-copertina {
            position: relative;
            border-radius: 22px;
            overflow: hidden;
            border: 1px solid #eee6d4;
            box-shadow: 0 22px 50px rgba(46, 59, 66, .16);
            margin-bottom: 2.4rem;
        }

        .progetto-copertina img {
            display: block;
            width: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
        }

        .progetto-copertina .badge-categoria-foto {
            position: absolute;
            top: 18px;
            left: 18px;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .5rem 1rem;
            border-radius: 50rem;
            background: rgba(255, 255, 255, .94);
            color: var(--oro-testo);
            font-size: .74rem;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            box-shadow: 0 8px 20px rgba(24, 30, 34, .18);
            backdrop-filter: blur(4px);
        }

        /* Testo del racconto */
        .blocco-testo h2 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: .4rem;
        }

        .blocco-testo .occhiello {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: var(--oro-testo);
            font-weight: 700;
            font-size: .78rem;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            margin-bottom: .8rem;
        }

        .blocco-testo p { line-height: 1.9; margin-bottom: 1.1rem; }

        .blocco-sfida {
            background: var(--oro-chiaro);
            border-left: 4px solid var(--oro);
            border-radius: 0 14px 14px 0;
            padding: 1.2rem 1.4rem;
            margin-bottom: 2rem;
            font-size: .98rem;
            line-height: 1.8;
            color: var(--scuro);
        }

        .blocco-sfida strong { color: var(--oro-testo); }

        /* Lista "Cosa abbiamo fatto" */
        .lista-interventi {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: .8rem 1.6rem;
        }

        .lista-interventi li {
            display: flex;
            align-items: flex-start;
            gap: .7rem;
            font-size: .92rem;
            font-weight: 600;
            color: var(--scuro);
            line-height: 1.5;
        }

        .lista-interventi li i {
            flex-shrink: 0;
            margin-top: .1rem;
            color: var(--oro-scuro);
            font-size: 1.05rem;
        }

        @media (max-width: 575.98px) {
            .lista-interventi { grid-template-columns: 1fr; }
        }

        /* ================= SCHEDA PROGETTO (sidebar) ================= */
        .scheda-progetto {
            background: linear-gradient(160deg, #fffefb 0%, #fdf8ec 100%);
            border: 1px solid #e6d5a8;
            border-radius: 18px;
            padding: 1.7rem 1.6rem;
            box-shadow: 0 14px 34px rgba(169, 130, 47, .12);
            position: relative;
            overflow: hidden;
        }

        .scheda-progetto::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--oro-scuro), var(--oro) 45%, #e8cc82 70%, var(--oro-scuro));
        }

        @media (min-width: 992px) {
            .scheda-progetto.sticky-desktop { position: sticky; top: 100px; }
        }

        .scheda-progetto h3 {
            font-size: .82rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--scuro);
            margin-bottom: 1.1rem;
        }

        .scheda-progetto h3 i { color: var(--oro-scuro); margin-right: .4rem; }

        .scheda-lista { display: grid; gap: .2rem; }

        .scheda-riga {
            display: flex;
            align-items: flex-start;
            gap: .85rem;
            padding: .8rem 0;
            border-bottom: 1px solid #f0e5cb;
        }

        .scheda-riga:last-child { border-bottom: none; }

        .scheda-riga .ico {
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            color: #fff;
            background: linear-gradient(135deg, #d9b866, var(--oro-scuro));
            box-shadow: 0 6px 14px rgba(169, 130, 47, .3);
        }

        .scheda-riga .testo { display: flex; flex-direction: column; }

        .scheda-riga .label {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--oro-testo);
        }

        .scheda-riga .valore { font-size: .95rem; font-weight: 600; color: var(--scuro); }

        .scheda-riga a.valore { text-decoration: none; }

        .scheda-riga a.valore:hover { color: var(--oro-scuro); text-decoration: underline; }

        .scheda-progetto .btn-oro { width: 100%; text-align: center; margin-top: 1.3rem; }

        .scheda-progetto .btn-scheda-secondario {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: .7rem;
            padding: .6rem 1rem;
            border-radius: 50rem;
            border: 1px solid #e0cf9f;
            background: #fff;
            color: var(--scuro);
            font-weight: 700;
            font-size: .85rem;
            text-decoration: none;
            transition: background .25s ease, border-color .25s ease, color .25s ease;
        }

        .scheda-progetto .btn-scheda-secondario:hover {
            background: var(--oro-chiaro);
            border-color: var(--oro);
            color: var(--oro-testo);
        }

        /* ================= GALLERIA ================= */
        #galleria {
            padding: 5.5rem 0;
            background: linear-gradient(180deg, #f4edda 0%, #f9f4e8 100%);
            position: relative;
            overflow: hidden;
        }

        #galleria::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--oro-scuro) 0%, var(--oro) 25%, #e8cc82 50%, var(--oro) 75%, var(--oro-scuro) 100%);
        }

        .griglia-galleria {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        @media (max-width: 767.98px) { .griglia-galleria { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 419.98px) { .griglia-galleria { grid-template-columns: 1fr; } }

        .galleria-item {
            position: relative;
            margin: 0;
            padding: 0;
            border: none;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            cursor: zoom-in;
            box-shadow: 0 12px 30px rgba(46, 59, 66, .12);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .galleria-item img {
            display: block;
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .galleria-item::after {
            content: "\F52A"; /* bi-zoom-in */
            font-family: "bootstrap-icons";
            position: absolute;
            top: 12px;
            right: 12px;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, .92);
            color: var(--oro-testo);
            font-size: 1rem;
            opacity: 0;
            transform: scale(.8);
            transition: opacity .3s ease, transform .3s ease;
        }

        .galleria-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 40px rgba(169, 130, 47, .22);
        }

        .galleria-item:hover img { transform: scale(1.07); }

        .galleria-item:hover::after { opacity: 1; transform: scale(1); }

        .galleria-item:focus-visible { outline: 3px solid var(--oro); outline-offset: 3px; }

        /* ================= LIGHTBOX ================= */
        .lightbox {
            position: fixed;
            inset: 0;
            z-index: 1080;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(18, 22, 25, .93);
            padding: 2rem 1rem;
        }

        .lightbox.aperto { display: flex; }

        .lightbox img {
            max-width: min(1100px, 94vw);
            max-height: 84vh;
            border-radius: 12px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, .5);
            animation: fadeUp .4s ease;
        }

        .lightbox-btn {
            position: absolute;
            border: none;
            background: rgba(255, 255, 255, .12);
            color: #fff;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .25s ease, transform .2s ease;
        }

        .lightbox-btn:hover { background: var(--oro-scuro); transform: scale(1.06); }

        .lightbox-chiudi { top: 22px; right: 22px; }
        .lightbox-prec { left: 20px; top: 50%; transform: translateY(-50%); }
        .lightbox-succ { right: 20px; top: 50%; transform: translateY(-50%); }
        .lightbox-prec:hover, .lightbox-succ:hover { transform: translateY(-50%) scale(1.06); }

        .lightbox-conta {
            position: absolute;
            bottom: 22px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, .85);
            font-size: .85rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        @media (max-width: 575.98px) {
            .lightbox-prec { left: 8px; }
            .lightbox-succ { right: 8px; }
            .lightbox-btn { width: 44px; height: 44px; font-size: 1.25rem; }
        }

        /* ================= ALTRI PROGETTI ================= */
        #altri-progetti { padding: 5.5rem 0 6rem; background: var(--crema); }

        .card-progetto {
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            border: 1px solid #eee6d4;
            border-radius: 18px;
            background: #fff;
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        .card-progetto::after {
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--oro), var(--oro-scuro));
            border-radius: 0 0 4px 4px;
            transition: width .4s ease;
            z-index: 2;
        }

        .card-progetto:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 40px rgba(169, 130, 47, .16);
            border-color: var(--oro);
        }

        .card-progetto:hover::after { width: 55%; }

        .card-progetto .foto {
            position: relative;
            overflow: hidden;
            aspect-ratio: 16 / 10;
            background: var(--oro-chiaro);
        }

        .card-progetto .foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .card-progetto:hover .foto img { transform: scale(1.07); }

        .card-progetto .foto::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(24, 30, 34, 0) 55%, rgba(24, 30, 34, .32) 100%);
            opacity: 0;
            transition: opacity .35s ease;
        }

        .card-progetto:hover .foto::after { opacity: 1; }

        .card-progetto .corpo {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            padding: 1.6rem 1.6rem 1.4rem;
        }

        .card-progetto h3 {
            font-size: 1.08rem;
            font-weight: 700;
            line-height: 1.35;
            margin-bottom: .55rem;
        }

        .card-progetto .sottotitolo {
            font-size: .88rem;
            line-height: 1.7;
            margin-bottom: 1.2rem;
        }

        .card-progetto .fondo {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .8rem;
            flex-wrap: wrap;
            padding-top: 1.1rem;
            border-top: 1px solid #f0e8d6;
        }

        .card-progetto .luogo {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .78rem;
            font-weight: 600;
            color: var(--oro-testo);
            letter-spacing: .4px;
        }

        .badge-categoria {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .4rem .9rem;
            border-radius: 50rem;
            background: var(--oro-chiaro);
            border: 1px solid #ecdfc0;
            color: var(--oro-testo);
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .badge-categoria i { font-size: .85rem; }

        .card-progetto .badge-categoria {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 2;
            background: rgba(255, 255, 255, .94);
            border-color: rgba(255, 255, 255, .55);
            box-shadow: 0 4px 12px rgba(24, 30, 34, .16);
        }

        .card-progetto .fondo .link-progetto { margin-left: auto; }

        .link-progetto {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .55rem 1.3rem;
            border-radius: 50rem;
            background: linear-gradient(135deg, #d9b866, var(--oro));
            color: var(--scuro);
            font-size: .74rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            text-decoration: none;
            box-shadow: 0 6px 16px rgba(169, 130, 47, .25);
            transition: background .3s ease, color .3s ease, transform .25s ease, box-shadow .25s ease;
        }

        .link-progetto i { transition: transform .3s ease; }

        .link-progetto:hover,
        .card-progetto:hover .link-progetto {
            background: var(--scuro);
            color: #d9b866;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(46, 59, 66, .32);
        }

        .link-progetto:hover i,
        .card-progetto:hover .link-progetto i { transform: translateX(4px); }

        /* ================= CTA FINALE ================= */
        #cta-finale {
            background: linear-gradient(120deg, #6f541e 0%, #7c5f20 55%, #8a6a26 100%);
            color: #fff;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }

        #cta-finale::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--oro-scuro) 0%, var(--oro) 25%, #e8cc82 50%, var(--oro) 75%, var(--oro-scuro) 100%);
        }

        #cta-finale::after {
            content: "";
            position: absolute;
            width: 380px;
            height: 380px;
            border: 40px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
            top: -160px;
            right: -120px;
        }

        #cta-finale .container { position: relative; z-index: 1; }

        #cta-finale h2 { color: #fff; font-weight: 800; }

        .btn-bianco {
            background: #fff;
            color: var(--oro-testo);
            font-weight: 700;
            padding: .75rem 1.8rem;
            border-radius: 50rem;
            border: none;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .btn-bianco:hover {
            background: #fff;
            color: var(--oro-testo);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, .18);
        }

        /* ================= FOOTER ================= */
        footer {
            background: var(--scuro);
            color: #cfd6da;
            padding: 4.5rem 0 1.8rem;
        }

        footer h6 {
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            font-size: .85rem;
            margin-bottom: 1rem;
        }

        footer a { color: #cfd6da; text-decoration: none; transition: color .2s; }

        footer a:hover { color: var(--oro); }

        footer .brand-footer {
            display: flex;
            align-items: center;
            gap: .7rem;
            margin-bottom: 1rem;
        }

        footer .brand-footer img {
            height: 44px;
            background: #fff;
            border-radius: 10px;
            padding: 5px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, .12);
            margin-top: 3rem;
            padding-top: 1.5rem;
            font-size: .85rem;
            text-align: center;
        }

        /* ================= WHATSAPP + TORNA SU ================= */
        .btn-whatsapp {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 1050;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #25d366;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            box-shadow: 0 10px 24px rgba(37, 211, 102, .4);
            transition: transform .25s ease;
        }

        .btn-whatsapp:hover { transform: scale(1.1); color: #fff; }

        .btn-top {
            position: fixed;
            right: 26px;
            bottom: 92px;
            z-index: 1050;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: none;
            background: var(--scuro);
            color: #fff;
            font-size: 1.1rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease, transform .25s ease;
        }

        .btn-top.show { opacity: 1; pointer-events: auto; }

        .btn-top:hover { transform: translateY(-3px); background: var(--oro-scuro); }

        /* ================= MOBILE ================= */
        @media (max-width: 991.98px) {
            .hero-servizio { min-height: 0; padding: 7.5rem 0 3.2rem; }

            .navbar-collapse {
                margin-top: .7rem;
                padding: .3rem .1rem .9rem;
                border-top: 1px solid #eee6d4;
                max-height: calc(100dvh - 84px);
                overflow-y: auto;
            }

            .navbar .nav-link {
                margin: 0;
                padding: .7rem .3rem;
                font-size: 1rem;
            }

            .navbar .nav-link::after { display: none; }

            .navbar .nav-link.active { color: var(--oro-testo); }

            .navbar:has(.navbar-collapse.show) { box-shadow: 0 4px 24px rgba(46, 59, 66, .12); }

            .menu-servizi {
                box-shadow: none;
                margin: .2rem 0 .6rem;
                background: #fbf8f0;
            }

            .menu-servizi .dropdown-item { padding: .68rem .9rem; }

            .navbar .nav-item .btn-oro {
                display: block;
                width: 100%;
                text-align: center;
                margin-top: .4rem;
                padding: .75rem 1rem !important;
                font-size: .95rem;
            }

            .btn-oro:active, .btn-bianco:active { transform: scale(.97); }

            .scheda-progetto { margin-top: 2.4rem; }
        }

        @media (max-width: 575.98px) {
            #dettaglio, #galleria { padding: 3.8rem 0; }
            #altri-progetti { padding: 3.8rem 0 4.2rem; }
            #cta-finale { padding: 3.4rem 0; }

            .row.g-4 { --bs-gutter-y: 2rem; }

            #cta-finale .btn-bianco {
                display: flex;
                justify-content: center;
                width: 100%;
                padding-top: .85rem;
                padding-bottom: .85rem;
            }

            footer { padding-top: 3.2rem; }
            footer a { overflow-wrap: anywhere; }
            .footer-bottom { margin-top: 2rem; }

            .btn-whatsapp {
                right: max(16px, env(safe-area-inset-right));
                bottom: max(18px, env(safe-area-inset-bottom));
            }

            .btn-top {
                right: max(21px, env(safe-area-inset-right));
                bottom: 88px;
            }
        }
    </style>
</head>
<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/logo-mark.png" alt="Logo <?php echo $site_name; ?>">
                <span class="brand-text">
                    <span class="brand-main">A.S.H.</span>
                    <span class="brand-sub">Finiture Contract</span>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipale" aria-controls="menuPrincipale" aria-expanded="false" aria-label="Apri menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuPrincipale">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="index.php#servizi" id="menuServizi" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            Servizi
                        </a>
                        <ul class="dropdown-menu menu-servizi" aria-labelledby="menuServizi">
                            <li>
                                <a class="dropdown-item" href="index.php#servizi">
                                    <i class="bi bi-grid-3x3-gap"></i> Tutti i Servizi
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <?php foreach ($servizi as $voce): ?>
                            <li>
                                <a class="dropdown-item<?php echo $voce['slug'] === $progetto['categoria'] ? ' attivo' : ''; ?>" href="<?php echo $voce['url']; ?>">
                                    <i class="bi <?php echo $voce['icona']; ?>"></i> <?php echo $voce['titolo']; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="chi-siamo.php">Chi Siamo</a></li>
                    <li class="nav-item"><a class="nav-link active" href="realizzazioni.php">Realizzazioni</a></li>
                    <li class="nav-item"><a class="nav-link" href="contatti.php">Contatti</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-oro btn-sm px-3 py-2" href="preventivo.php">
                            <i class="bi bi-envelope-paper me-1"></i> Richiedi Preventivo
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ================= HERO + BREADCRUMB ================= -->
    <header class="hero-servizio" id="home">
        <div class="hero-bg" aria-hidden="true" style="background-image: url('<?php echo $progetto['copertina']; ?>');"></div>
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="container position-relative">
            <div class="row">
                <div class="col-lg-9">
                    <nav aria-label="Percorso di navigazione" class="fade-up">
                        <ol class="breadcrumb-servizio list-unstyled">
                            <li><a href="index.php"><i class="bi bi-house-door"></i> Home</a></li>
                            <li class="separatore" aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
                            <li><a href="realizzazioni.php">Realizzazioni</a></li>
                            <li class="separatore" aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
                            <li class="corrente" aria-current="page"><?php echo $progetto['titolo']; ?></li>
                        </ol>
                    </nav>
                    <span class="hero-badge fade-up delay-1">
                        <i class="bi <?php echo $servizio['icona']; ?>"></i> <?php echo $servizio['titolo']; ?>
                    </span>
                    <h1 class="mt-3 fade-up delay-1"><?php echo $progetto['titolo']; ?></h1>
                    <p class="lead mt-3 fade-up delay-2"><?php echo $progetto['sottotitolo']; ?></p>
                    <div class="hero-meta fade-up delay-2">
                        <?php if (!empty($progetto['luogo'])): ?>
                        <span><i class="bi bi-geo-alt-fill"></i> <?php echo $progetto['luogo']; ?></span>
                        <?php endif; ?>
                        <?php if (!empty($progetto['anno'])): ?>
                        <span><i class="bi bi-calendar3"></i> <?php echo $progetto['anno']; ?></span>
                        <?php endif; ?>
                        <?php if (!empty($progetto['tipologia'])): ?>
                        <span><i class="bi bi-building"></i> <?php echo $progetto['tipologia']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex flex-wrap gap-3 mt-4 fade-up delay-3">
                        <a href="preventivo.php" class="btn btn-oro">
                            <i class="bi bi-envelope-paper me-2"></i>Richiedi un preventivo
                        </a>
                        <a href="realizzazioni.php" class="btn btn-outline-scuro">
                            <i class="bi bi-arrow-left me-2"></i>Tutte le realizzazioni
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ================= DETTAGLIO PROGETTO ================= -->
    <section id="dettaglio">
        <div class="container">
            <div class="row g-5">
                <!-- Colonna racconto -->
                <div class="col-lg-8 reveal">
                    <div class="progetto-copertina">
                        <img src="<?php echo $progetto['copertina']; ?>" alt="<?php echo $progetto['titolo']; ?> — realizzazione di <?php echo $site_name; ?>">
                        <span class="badge-categoria-foto">
                            <i class="bi <?php echo $servizio['icona']; ?>" aria-hidden="true"></i> <?php echo $servizio['titolo']; ?>
                        </span>
                    </div>

                    <div class="blocco-testo">
                        <span class="occhiello"><i class="bi bi-flag-fill"></i> Il progetto</span>
                        <h2><?php echo $progetto['titolo']; ?></h2>
                        <div class="title-underline a-sinistra mb-4"></div>

                        <?php if (!empty($progetto['sfida'])): ?>
                        <div class="blocco-sfida">
                            <strong>La richiesta.</strong> <?php echo $progetto['sfida']; ?>
                        </div>
                        <?php endif; ?>

                        <?php foreach ($progetto['descrizione'] as $paragrafo): ?>
                        <p><?php echo $paragrafo; ?></p>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!empty($progetto['interventi'])): ?>
                    <div class="blocco-testo mt-4">
                        <span class="occhiello"><i class="bi bi-check2-square"></i> Cosa abbiamo fatto</span>
                        <h2 class="h4">Le lavorazioni</h2>
                        <div class="title-underline a-sinistra mb-4"></div>
                        <ul class="lista-interventi">
                            <?php foreach ($progetto['interventi'] as $intervento): ?>
                            <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> <?php echo $intervento; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar scheda progetto -->
                <div class="col-lg-4 reveal" style="transition-delay:.15s">
                    <aside class="scheda-progetto sticky-desktop">
                        <h3><i class="bi bi-clipboard-data"></i> Scheda del progetto</h3>
                        <div class="scheda-lista">
                            <?php foreach ($scheda as $riga): if (empty($riga['valore'])) continue; ?>
                            <div class="scheda-riga">
                                <span class="ico"><i class="bi <?php echo $riga['icona']; ?>" aria-hidden="true"></i></span>
                                <span class="testo">
                                    <span class="label"><?php echo $riga['label']; ?></span>
                                    <?php if (!empty($riga['link'])): ?>
                                    <a class="valore" href="<?php echo $riga['link']; ?>"><?php echo $riga['valore']; ?></a>
                                    <?php else: ?>
                                    <span class="valore"><?php echo $riga['valore']; ?></span>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="preventivo.php" class="btn btn-oro">
                            <i class="bi bi-envelope-paper me-2"></i>Richiedi un preventivo
                        </a>
                        <a href="<?php echo $servizio['url']; ?>" class="btn-scheda-secondario">
                            <i class="bi <?php echo $servizio['icona']; ?> me-1"></i> Scopri il servizio <?php echo $servizio['titolo']; ?>
                        </a>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= GALLERIA ================= -->
    <?php if (!empty($progetto['galleria'])): ?>
    <section id="galleria">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-images"></i> Galleria</span>
                <h2 class="section-title mt-3">Sfoglia il <span class="text-oro">cantiere</span></h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 620px;">
                    Le immagini del lavoro realizzato. Tocca una foto per ingrandirla.
                </p>
            </div>
            <div class="griglia-galleria reveal">
                <?php foreach ($progetto['galleria'] as $i => $img): ?>
                <button type="button" class="galleria-item" data-indice="<?php echo $i; ?>" aria-label="Ingrandisci la foto <?php echo $i + 1; ?> di <?php echo $progetto['titolo']; ?>">
                    <img src="<?php echo $img; ?>" alt="<?php echo $progetto['titolo']; ?> — foto <?php echo $i + 1; ?>" loading="lazy">
                </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= CTA FINALE ================= -->
    <section id="cta-finale">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8 reveal">
                    <h2 class="mb-2">Ti piacerebbe un risultato così?</h2>
                    <p class="mb-0 fs-5" style="color:rgba(255,255,255,.9)">
                        Raccontaci il tuo progetto di <strong><?php echo strtolower($servizio['titolo']); ?></strong>:
                        richiedi un <strong>preventivo gratuito</strong> e senza impegno, ti rispondiamo in tempi rapidi.
                    </p>
                </div>
                <div class="col-lg-4 reveal" style="transition-delay:.15s">
                    <div class="d-flex flex-wrap gap-3 justify-content-lg-end">
                        <a href="tel:<?php echo $phone1_raw; ?>" class="btn btn-bianco">
                            <i class="bi bi-telephone-outbound me-2"></i>Chiama Ora
                        </a>
                        <a href="preventivo.php" class="btn btn-bianco">
                            <i class="bi bi-envelope-paper me-2"></i>Richiedi Preventivo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= ALTRI PROGETTI ================= -->
    <?php if (!empty($correlati)): ?>
    <section id="altri-progetti">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-grid"></i> Continua a esplorare</span>
                <h2 class="section-title mt-3">Altre <span class="text-oro">realizzazioni</span></h2>
                <div class="title-underline"></div>
            </div>
            <div class="row g-4">
                <?php foreach ($correlati as $altro):
                    $serv_altro = $servizi_per_slug[$altro['categoria']];
                ?>
                <div class="col-md-6 col-lg-4 reveal">
                    <article class="card-progetto">
                        <div class="foto">
                            <img src="<?php echo $altro['foto']; ?>" alt="<?php echo $altro['titolo']; ?> — realizzazione di <?php echo $site_name; ?>" loading="lazy">
                            <span class="badge-categoria">
                                <i class="bi <?php echo $serv_altro['icona']; ?>" aria-hidden="true"></i>
                                <?php echo $serv_altro['titolo']; ?>
                            </span>
                        </div>
                        <div class="corpo">
                            <h3><?php echo $altro['titolo']; ?></h3>
                            <p class="sottotitolo"><?php echo $altro['sottotitolo']; ?></p>
                            <div class="fondo">
                                <span class="luogo"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> <?php echo $altro['luogo']; ?></span>
                                <a href="dettaglio-realizzazione.php?id=<?php echo $altro['id']; ?>" class="link-progetto" aria-label="Scopri di più su <?php echo $altro['titolo']; ?>">
                                    Scopri di più <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-5 reveal">
                <a href="realizzazioni.php" class="btn btn-oro">
                    <i class="bi bi-images me-2"></i>Vedi tutte le realizzazioni
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= FOOTER ================= -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="brand-footer">
                        <img src="assets/img/logo-mark.png" alt="Logo A.S.H.">
                        <div>
                            <div class="fw-bold text-white fs-5">A.S.H. <span style="color:var(--oro)">Finiture Contract</span></div>
                            <small>Di Ahmed Abdelaziz</small>
                        </div>
                    </div>
                    <p class="mb-0" style="max-width: 380px; font-size:.9rem;">
                        Specialisti in finiture edili: <?php echo strtolower($tagline); ?>.
                    </p>
                </div>
                <div class="col-6 col-lg-3">
                    <h6>Link Rapidi</h6>
                    <ul class="list-unstyled d-grid gap-2 mb-0">
                        <li><a href="index.php"><i class="bi bi-chevron-right small"></i> Home</a></li>
                        <li><a href="index.php#servizi"><i class="bi bi-chevron-right small"></i> Servizi</a></li>
                        <li><a href="chi-siamo.php"><i class="bi bi-chevron-right small"></i> Chi Siamo</a></li>
                        <li><a href="realizzazioni.php"><i class="bi bi-chevron-right small"></i> Realizzazioni</a></li>
                        <li><a href="contatti.php"><i class="bi bi-chevron-right small"></i> Contatti</a></li>
                        <li><a href="preventivo.php"><i class="bi bi-chevron-right small"></i> Richiedi Preventivo</a></li>
                    </ul>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <h6>Contatti</h6>
                    <ul class="list-unstyled d-grid gap-2 mb-0" style="font-size:.9rem;">
                        <li><i class="bi bi-telephone me-2" style="color:var(--oro)"></i><a href="tel:<?php echo $phone1_raw; ?>"><?php echo $phone1; ?></a> — <a href="tel:<?php echo $phone2_raw; ?>"><?php echo $phone2; ?></a></li>
                        <li><i class="bi bi-envelope me-2" style="color:var(--oro)"></i><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>
                        <li><i class="bi bi-geo-alt me-2" style="color:var(--oro)"></i><?php echo $address; ?></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; <?php echo date('Y'); ?> <?php echo $site_name; ?> — Di Ahmed Abdelaziz. Tutti i diritti riservati.
            </div>
        </div>
    </footer>

    <!-- ================= LIGHTBOX ================= -->
    <div class="lightbox" id="lightbox" aria-hidden="true" role="dialog" aria-label="Galleria ingrandita">
        <button type="button" class="lightbox-btn lightbox-chiudi" id="lbChiudi" aria-label="Chiudi"><i class="bi bi-x-lg"></i></button>
        <button type="button" class="lightbox-btn lightbox-prec" id="lbPrec" aria-label="Foto precedente"><i class="bi bi-chevron-left"></i></button>
        <img id="lbImg" src="" alt="">
        <button type="button" class="lightbox-btn lightbox-succ" id="lbSucc" aria-label="Foto successiva"><i class="bi bi-chevron-right"></i></button>
        <span class="lightbox-conta" id="lbConta"></span>
    </div>

    <!-- WhatsApp + Torna su -->
    <a href="https://wa.me/393296447797" target="_blank" rel="noopener" class="btn-whatsapp" aria-label="Scrivici su WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
    <button type="button" class="btn-top" id="btnTop" aria-label="Torna su"><i class="bi bi-arrow-up"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar: ombra + riduzione allo scroll
        const navbar = document.getElementById('navbar');
        const btnTop = document.getElementById('btnTop');

        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 40);
            btnTop.classList.toggle('show', window.scrollY > 500);
        });

        btnTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        // Animazione reveal allo scroll (IntersectionObserver + fallback)
        const elementiReveal = document.querySelectorAll('.reveal');

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });

            elementiReveal.forEach(el => observer.observe(el));
        } else {
            elementiReveal.forEach(el => el.classList.add('visible'));
        }

        // Chiudi il menu mobile dopo il click su un link
        document.querySelectorAll('#menuPrincipale .nav-link:not(.dropdown-toggle), #menuPrincipale .dropdown-item, #menuPrincipale .btn').forEach(el => {
            el.addEventListener('click', () => {
                const menu = document.getElementById('menuPrincipale');
                if (menu.classList.contains('show')) {
                    bootstrap.Collapse.getOrCreateInstance(menu).hide();
                }
            });
        });

        // ================= LIGHTBOX GALLERIA =================
        (function () {
            const bottoni = Array.from(document.querySelectorAll('.galleria-item'));
            if (!bottoni.length) return;

            const foto = bottoni.map(b => {
                const img = b.querySelector('img');
                return { src: img.getAttribute('src'), alt: img.getAttribute('alt') };
            });

            const lightbox = document.getElementById('lightbox');
            const lbImg    = document.getElementById('lbImg');
            const lbConta  = document.getElementById('lbConta');
            let corrente = 0;

            function mostra(i) {
                corrente = (i + foto.length) % foto.length;
                lbImg.setAttribute('src', foto[corrente].src);
                lbImg.setAttribute('alt', foto[corrente].alt);
                lbConta.textContent = (corrente + 1) + ' / ' + foto.length;
            }

            function apri(i) {
                mostra(i);
                lightbox.classList.add('aperto');
                lightbox.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }

            function chiudi() {
                lightbox.classList.remove('aperto');
                lightbox.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }

            bottoni.forEach((b, i) => b.addEventListener('click', () => apri(i)));
            document.getElementById('lbChiudi').addEventListener('click', chiudi);
            document.getElementById('lbPrec').addEventListener('click', () => mostra(corrente - 1));
            document.getElementById('lbSucc').addEventListener('click', () => mostra(corrente + 1));

            lightbox.addEventListener('click', (e) => { if (e.target === lightbox) chiudi(); });

            document.addEventListener('keydown', (e) => {
                if (!lightbox.classList.contains('aperto')) return;
                if (e.key === 'Escape') chiudi();
                else if (e.key === 'ArrowLeft') mostra(corrente - 1);
                else if (e.key === 'ArrowRight') mostra(corrente + 1);
            });
        })();
    </script>
</body>
</html>
