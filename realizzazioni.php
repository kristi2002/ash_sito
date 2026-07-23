<?php
// ============================================================
//  A.S.H. Finiture Contract — Di Ahmed Abdelaziz
//  Pagina Realizzazioni — PHP + Bootstrap 5
// ============================================================

$site_name  = 'A.S.H. Finiture Contract';
$tagline    = 'Qualità e Precisione per Ogni Spazio';
$phone1     = '329 6447797';
$phone2     = '338 3386946';
$phone1_raw = '+393296447797';
$phone2_raw = '+393383386946';
$email      = 'ashfiniturecontract@outlook.it';
$address    = 'Via Adigrat 3/A, 62032 Camerino (MC)';

// Tutti i servizi (per menu + filtri)
$servizi = [
    [
        'slug'   => 'cartongesso',
        'icona'  => 'bi-bricks',
        'titolo' => 'Cartongesso',
        'url'    => 'servizi/cartongesso.php',
    ],
    [
        'slug'   => 'sistemi-a-secco',
        'icona'  => 'bi-layers',
        'titolo' => 'Sistemi a Secco',
        'url'    => 'servizi/sistemi-a-secco.php',
    ],
    [
        'slug'   => 'rasatura-armata',
        'icona'  => 'bi-shield-check',
        'titolo' => 'Rasatura Armata',
        'url'    => 'servizi/rasatura-armata.php',
    ],
    [
        'slug'   => 'tinteggiatura',
        'icona'  => 'bi-paint-bucket',
        'titolo' => 'Tinteggiatura',
        'url'    => 'servizi/tinteggiatura.php',
    ],
    [
        'slug'   => 'intonachino',
        'icona'  => 'bi-brush',
        'titolo' => 'Intonachino',
        'url'    => 'servizi/intonachino.php',
    ],
    [
        'slug'   => 'carta-da-parati',
        'icona'  => 'bi-flower1',
        'titolo' => 'Carta da Parati',
        'url'    => 'servizi/carta-da-parati.php',
    ],
];

// Indice rapido: slug => servizio (per badge e link delle card)
$servizi_per_slug = array_column($servizi, null, 'slug');

// Le realizzazioni in evidenza (stile blog): ogni card è legata a un servizio
// tramite 'categoria' (slug del servizio) usata anche dai filtri.
$realizzazioni = [
    [
        'categoria'  => 'cartongesso',
        'titolo'     => 'Controsoffitto con luci LED integrate',
        'sottotitolo'=> 'Ribassamento in cartongesso con gole luminose e faretti: la zona giorno cambia volto.',
        'luogo'      => 'Appartamento privato — Camerino (MC)',
        'foto'       => 'assets/img/servizi/cartongesso-stuccatura.jpg',
    ],
    [
        'categoria'  => 'sistemi-a-secco',
        'titolo'     => 'Pareti divisorie per nuovi uffici',
        'sottotitolo'=> 'Riorganizzazione degli spazi con pareti a secco e isolamento acustico, senza opere murarie.',
        'luogo'      => 'Uffici direzionali — Macerata',
        'foto'       => 'assets/img/servizi/card-sistemi-a-secco.jpg',
    ],
    [
        'categoria'  => 'rasatura-armata',
        'titolo'     => 'Rasatura armata su cappotto termico',
        'sottotitolo'=> 'Superficie rinforzata con rete e finitura uniforme: facciata protetta e pronta alla tinteggiatura.',
        'luogo'      => 'Condominio — Tolentino (MC)',
        'foto'       => 'assets/img/servizi/card-rasatura-armata.jpg',
    ],
    [
        'categoria'  => 'tinteggiatura',
        'titolo'     => 'Tinteggiatura completa di villa bifamiliare',
        'sottotitolo'=> 'Ciclo completo interni ed esterni con prodotti certificati: colori uniformi e durevoli.',
        'luogo'      => 'Abitazione privata — Camerino (MC)',
        'foto'       => 'assets/img/servizi/tinteggiatura-ciclo.jpg',
    ],
    [
        'categoria'  => 'intonachino',
        'titolo'     => 'Intonachino decorativo per la zona giorno',
        'sottotitolo'=> 'Finitura materica a effetto naturale: carattere ed eleganza per le pareti del soggiorno.',
        'luogo'      => 'Appartamento — San Severino Marche (MC)',
        'foto'       => 'assets/img/servizi/card-intonachino.jpg',
    ],
    [
        'categoria'  => 'carta-da-parati',
        'titolo'     => 'Carta da parati di design in camera',
        'sottotitolo'=> 'Posa di precisione per una parete d\'accento: giunzioni invisibili e risultato scenografico.',
        'luogo'      => 'Abitazione privata — Matelica (MC)',
        'foto'       => 'assets/img/servizi/card-carta-da-parati.jpg',
    ],
];

// Dati strutturati JSON-LD: CollectionPage + BreadcrumbList
$json_ld = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'CollectionPage',
        'name'        => 'Realizzazioni — ' . $site_name,
        'description' => 'I lavori realizzati da A.S.H. Finiture Contract: cartongesso, sistemi a secco, rasatura armata, tinteggiatura, intonachino e carta da parati a Camerino (MC) e in tutte le Marche.',
        'mainEntity'  => [
            '@type'           => 'ItemList',
            'itemListElement' => array_map(function ($r, $i) {
                return [
                    '@type'    => 'ListItem',
                    'position' => $i + 1,
                    'name'     => $r['titolo'],
                ];
            }, $realizzazioni, array_keys($realizzazioni)),
        ],
    ],
    [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'index.php'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Realizzazioni'],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Realizzazioni | A.S.H. Finiture Contract — Camerino (MC)</title>
    <meta name="description" content="Scopri le realizzazioni di A.S.H. Finiture Contract: i progetti di cartongesso, sistemi a secco, rasatura armata, tinteggiatura, intonachino e carta da parati a Camerino (MC) e provincia.">

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
        .menu-servizi .dropdown-item:focus {
            background: var(--oro-chiaro);
            color: var(--oro-testo);
            transform: translateX(4px);
        }

        .menu-servizi .dropdown-divider { border-color: #eee6d4; opacity: 1; }

        /* Su desktop il sottomenu si apre anche al passaggio del mouse */
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
            min-height: 58vh;
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
            background: url('assets/img/hero.jpg') center center / cover no-repeat;
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
                linear-gradient(100deg, rgba(24, 30, 34, .92) 0%, rgba(24, 30, 34, .72) 45%, rgba(24, 30, 34, .35) 100%),
                linear-gradient(0deg, rgba(169, 130, 47, .18), rgba(169, 130, 47, .18));
        }

        .hero-servizio .hero-badge {
            background: rgba(255, 255, 255, .14);
            color: #ecd9a8;
            backdrop-filter: blur(4px);
        }

        .hero-servizio h1 {
            font-weight: 800;
            font-size: clamp(2.1rem, 4.6vw, 3.3rem);
            line-height: 1.12;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero-servizio h1 .gold {
            background: linear-gradient(135deg, #e8cc82, var(--oro));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-servizio .lead { max-width: 620px; color: rgba(255, 255, 255, .88); }

        .hero-servizio .btn-outline-scuro { border-color: #fff; color: #fff; }

        .hero-servizio .btn-outline-scuro:hover { background: #fff; color: var(--scuro); }

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

        .breadcrumb-servizio .corrente { color: #e8cc82; }

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

        /* ================= PROGETTI (STILE BLOG) ================= */
        #progetti { padding: 5.5rem 0 6.5rem; background: var(--crema); position: relative; }

        /* Bordo oro in alto: divide le sezioni e richiama la palette */
        #progetti::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--oro-scuro) 0%, var(--oro) 25%, #e8cc82 50%, var(--oro) 75%, var(--oro-scuro) 100%);
        }

        /* Filtri per servizio: pillole oro */
        .filtri-servizi {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: .6rem;
        }

        .filtri-servizi .chip {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .55rem 1.2rem;
            border-radius: 50rem;
            border: 1px solid #e4d8bc;
            background: #fff;
            color: var(--scuro);
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            transition: background .25s ease, color .25s ease, border-color .25s ease, transform .25s ease, box-shadow .25s ease;
        }

        .filtri-servizi .chip i { color: var(--oro-scuro); transition: color .25s ease; }

        .filtri-servizi .chip:hover {
            border-color: var(--oro);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(169, 130, 47, .18);
        }

        .filtri-servizi .chip.attivo {
            background: linear-gradient(135deg, #d9b866, var(--oro));
            border-color: var(--oro);
            color: var(--scuro);
            box-shadow: 0 8px 20px rgba(169, 130, 47, .28);
        }

        .filtri-servizi .chip.attivo i { color: var(--scuro); }

        .conteggio-progetti {
            font-size: .85rem;
            font-weight: 600;
            letter-spacing: .5px;
        }

        /* Card progetto stile blog: foto sopra, testo sotto, badge + bottone in fondo */
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

        /* Linea oro che si espande dal centro in alto (come le card servizio) */
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

        /* Velo scuro dal basso: fa risaltare la foto al passaggio del mouse */
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

        .card-progetto .luogo {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .78rem;
            font-weight: 600;
            color: var(--oro-testo);
            letter-spacing: .4px;
        }

        /* Etichetta "In evidenza": visibile solo sul progetto in primo piano */
        .tag-evidenza {
            display: none;
            align-items: center;
            gap: .45rem;
            align-self: flex-start;
            padding: .35rem .95rem;
            margin-bottom: .85rem;
            border-radius: 50rem;
            background: linear-gradient(135deg, #d9b866, var(--oro));
            color: var(--scuro);
            font-size: .66rem;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .col-progetto.featured .tag-evidenza { display: inline-flex; }

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

        /* Fondo card: badge categoria a sinistra + bottone a destra */
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

        /* Nelle card la categoria vive sopra la foto, sempre leggibile */
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

        /* Progetto in evidenza: il primo risultato occupa tutta la riga */
        .col-progetto.featured {
            flex: 0 0 auto;
            width: 100%;
        }

        @media (min-width: 992px) {
            .col-progetto.featured .card-progetto {
                display: grid;
                grid-template-columns: 1.25fr 1fr;
            }

            .col-progetto.featured .foto {
                aspect-ratio: auto;
                height: 100%;
                min-height: 400px;
            }

            .col-progetto.featured .corpo {
                padding: 2.5rem 2.6rem 2.1rem;
                justify-content: center;
            }

            .col-progetto.featured h3 {
                font-size: 1.55rem;
                margin-bottom: .8rem;
            }

            .col-progetto.featured .sottotitolo {
                font-size: .98rem;
                margin-bottom: 1.6rem;
            }
        }

        /* Bottone "Scopri di più": pill oro, si inverte al hover (come homepage) */
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

        /* Ricomparsa morbida delle card dopo un filtro */
        .col-progetto.riappari .card-progetto { animation: fadeUp .45s ease both; }

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

        /* ================= MOBILE: MENU E TABLET ================= */
        @media (max-width: 991.98px) {
            .hero-servizio { min-height: 0; padding: 7.5rem 0 3.2rem; }

            /* Menu a discesa: pannello comodo, voci grandi da toccare */
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

            /* Nel menu aperto niente sottolineatura animata: si evidenzia col colore */
            .navbar .nav-link::after { display: none; }

            .navbar .nav-link.active { color: var(--oro-testo); }

            /* Ombra sotto la barra quando il menu è aperto */
            .navbar:has(.navbar-collapse.show) { box-shadow: 0 4px 24px rgba(46, 59, 66, .12); }

            /* Sottomenu Servizi: pannello piatto color crema, senza ombre */
            .menu-servizi {
                box-shadow: none;
                margin: .2rem 0 .6rem;
                background: #fbf8f0;
            }

            .menu-servizi .dropdown-item { padding: .68rem .9rem; }

            /* Bottone preventivo: a tutta larghezza, comodo per il pollice */
            .navbar .nav-item .btn-oro {
                display: block;
                width: 100%;
                text-align: center;
                margin-top: .4rem;
                padding: .75rem 1rem !important;
                font-size: .95rem;
            }

            /* Feedback immediato al tocco */
            .btn-oro:active, .btn-bianco:active { transform: scale(.97); }
        }

        /* ================= MOBILE: TELEFONI ================= */
        @media (max-width: 575.98px) {
            /* Ritmo verticale più compatto: meno vuoto tra le sezioni */
            #progetti { padding: 3.8rem 0 4.2rem; }
            #cta-finale { padding: 3.4rem 0; }

            /* Righe impilate: gutter orizzontale standard e respiro ridotto */
            .row.g-5 { --bs-gutter-x: 1.5rem; --bs-gutter-y: 2.4rem; }

            /* CTA a tutta larghezza: più facili da premere */
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

            /* Pulsanti flottanti: rispettano le aree sicure di iPhone */
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
                        <a class="nav-link dropdown-toggle" href="index.php#servizi" id="menuServizi" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Servizi
                        </a>
                        <ul class="dropdown-menu menu-servizi" aria-labelledby="menuServizi">
                            <li>
                                <a class="dropdown-item" href="index.php#servizi">
                                    <i class="bi bi-grid-3x3-gap"></i> Tutti i Servizi
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <?php foreach ($servizi as $servizio): ?>
                            <li>
                                <a class="dropdown-item" href="<?php echo $servizio['url']; ?>">
                                    <i class="bi <?php echo $servizio['icona']; ?>"></i> <?php echo $servizio['titolo']; ?>
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
        <div class="hero-bg" aria-hidden="true"></div>
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="container position-relative">
            <div class="row">
                <div class="col-lg-9">
                    <nav aria-label="Percorso di navigazione" class="fade-up">
                        <ol class="breadcrumb-servizio list-unstyled">
                            <li><a href="index.php"><i class="bi bi-house-door"></i> Home</a></li>
                            <li class="separatore" aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
                            <li class="corrente" aria-current="page">Realizzazioni</li>
                        </ol>
                    </nav>
                    <span class="hero-badge fade-up delay-1 mt-3">
                        <i class="bi bi-images"></i> I nostri lavori
                    </span>
                    <h1 class="mt-3 fade-up delay-1">
                        Le Nostre <span class="gold">Realizzazioni</span>
                    </h1>
                    <p class="lead mt-3 fade-up delay-2">
                        I cantieri completati raccontati progetto per progetto: cartongesso,
                        sistemi a secco, rasatura armata, tinteggiatura, intonachino
                        e carta da parati. Ogni lavoro racconta la nostra idea di qualità.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-4 fade-up delay-3">
                        <a href="#progetti" class="btn btn-oro">
                            <i class="bi bi-grid me-2"></i>Sfoglia i progetti
                        </a>
                        <a href="preventivo.php" class="btn btn-outline-scuro">
                            <i class="bi bi-envelope-paper me-2"></i>Richiedi un preventivo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ================= PROGETTI IN EVIDENZA (STILE BLOG) ================= -->
    <section id="progetti">
        <div class="container">
            <div class="text-center mb-4 reveal">
                <span class="hero-badge"><i class="bi bi-journal-richtext"></i> Diario dei cantieri</span>
                <h2 class="section-title mt-3">Gli Ultimi <span class="text-oro">Progetti</span></h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 640px;">
                    Una selezione dei lavori più recenti, raccontati uno per uno.
                    Filtra per servizio per vedere solo ciò che ti interessa.
                </p>
            </div>

            <!-- Filtri per servizio -->
            <div class="filtri-servizi mb-2 reveal" role="group" aria-label="Filtra le realizzazioni per servizio">
                <button type="button" class="chip attivo" data-filtro="tutti">
                    <i class="bi bi-grid-3x3-gap"></i> Tutti
                </button>
                <?php foreach ($servizi as $servizio): ?>
                <button type="button" class="chip" data-filtro="<?php echo $servizio['slug']; ?>">
                    <i class="bi <?php echo $servizio['icona']; ?>"></i> <?php echo $servizio['titolo']; ?>
                </button>
                <?php endforeach; ?>
            </div>
            <p class="text-center conteggio-progetti mb-4 reveal" id="conteggioProgetti" aria-live="polite"></p>

            <!-- Card progetti -->
            <div class="row g-4" id="grigliaProgetti">
                <?php foreach ($realizzazioni as $i => $progetto):
                    $servizio = $servizi_per_slug[$progetto['categoria']];
                ?>
                <div class="col-md-6 col-lg-4 col-progetto reveal" data-categoria="<?php echo $progetto['categoria']; ?>" style="transition-delay: <?php echo ($i % 3) * 0.12; ?>s">
                    <article class="card-progetto">
                        <div class="foto">
                            <img src="<?php echo $progetto['foto']; ?>" alt="<?php echo $progetto['titolo']; ?> — realizzazione di <?php echo $site_name; ?>" loading="lazy">
                            <span class="badge-categoria">
                                <i class="bi <?php echo $servizio['icona']; ?>" aria-hidden="true"></i>
                                <?php echo $servizio['titolo']; ?>
                            </span>
                        </div>
                        <div class="corpo">
                            <span class="tag-evidenza"><i class="bi bi-star-fill" aria-hidden="true"></i> In evidenza</span>
                            <h3><?php echo $progetto['titolo']; ?></h3>
                            <p class="sottotitolo"><?php echo $progetto['sottotitolo']; ?></p>
                            <div class="fondo">
                                <span class="luogo"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> <?php echo $progetto['luogo']; ?></span>
                                <a href="<?php echo $servizio['url']; ?>" class="link-progetto" aria-label="Scopri di più su <?php echo $progetto['titolo']; ?>">
                                    Scopri di più <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ================= CTA FINALE ================= -->
    <section id="cta-finale">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8 reveal">
                    <h2 class="mb-2">Ti piacerebbe un risultato così?</h2>
                    <p class="mb-0 fs-5" style="color:rgba(255,255,255,.9)">
                        Raccontaci il tuo progetto: richiedi un <strong>preventivo gratuito</strong>
                        e senza impegno, ti rispondiamo in tempi rapidi.
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

        // ================= FILTRI PROGETTI =================
        const chips = document.querySelectorAll('.filtri-servizi .chip');
        const colonneProgetti = document.querySelectorAll('#grigliaProgetti .col-progetto');
        const conteggio = document.getElementById('conteggioProgetti');

        function applicaFiltro(filtro) {
            let visibili = 0;

            chips.forEach(chip => chip.classList.toggle('attivo', chip.dataset.filtro === filtro));

            colonneProgetti.forEach(colonna => {
                const mostra = filtro === 'tutti' || colonna.dataset.categoria === filtro;
                colonna.classList.toggle('d-none', !mostra);
                colonna.classList.toggle('riappari', mostra);
                colonna.classList.remove('featured');
                if (mostra) visibili++;
            });

            // Il primo risultato visibile diventa il progetto "in evidenza"
            const primaVisibile = Array.from(colonneProgetti).find(c => !c.classList.contains('d-none'));
            if (primaVisibile) primaVisibile.classList.add('featured');

            conteggio.textContent = visibili === 1
                ? '1 progetto trovato'
                : visibili + ' progetti trovati';

            // Ricorda il filtro nell'indirizzo (condivisibile via link)
            const url = new URL(window.location);
            if (filtro === 'tutti') {
                url.searchParams.delete('categoria');
            } else {
                url.searchParams.set('categoria', filtro);
            }
            history.replaceState(null, '', url);
        }

        chips.forEach(chip => {
            chip.addEventListener('click', () => applicaFiltro(chip.dataset.filtro));
        });

        // All'apertura: applica l'eventuale filtro passato nell'URL (?categoria=...)
        const filtroIniziale = new URLSearchParams(window.location.search).get('categoria');
        const filtriValidi = Array.from(chips).map(chip => chip.dataset.filtro);
        applicaFiltro(filtriValidi.includes(filtroIniziale) ? filtroIniziale : 'tutti');

    </script>
</body>
</html>
