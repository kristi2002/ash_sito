<?php
// ============================================================
//  A.S.H. Finiture Contract — Di Ahmed Abdelaziz
//  Pagina Chi Siamo — PHP + Bootstrap 5
// ============================================================

$site_name  = 'A.S.H. Finiture Contract';
$tagline    = 'Qualità e Precisione per Ogni Spazio';
$phone1     = '329 6447797';
$phone2     = '338 3386946';
$phone1_raw = '+393296447797';
$phone2_raw = '+393383386946';
$email      = 'ashfiniturecontract@outlook.it';
$address    = 'Via Adigrat 3/A, 62032 Camerino (MC)';

// Tutti i servizi (per menu e card "Cosa facciamo"), con foto della card
$servizi = [
    [
        'slug'   => 'cartongesso',
        'icona'  => 'bi-bricks',
        'titolo' => 'Cartongesso',
        'url'    => 'servizi/cartongesso.php',
        'foto'   => 'assets/img/servizi/cartongesso-stuccatura.jpg',
        'descrizione' => 'Pareti divisorie, controsoffitti e contropareti su misura.',
    ],
    [
        'slug'   => 'sistemi-a-secco',
        'icona'  => 'bi-layers',
        'titolo' => 'Sistemi a Secco',
        'url'    => 'servizi/sistemi-a-secco.php',
        'foto'   => 'assets/img/servizi/card-sistemi-a-secco.jpg',
        'descrizione' => 'Costruzioni rapide e pulite ad alte prestazioni.',
    ],
    [
        'slug'   => 'rasatura-armata',
        'icona'  => 'bi-shield-check',
        'titolo' => 'Rasatura Armata',
        'url'    => 'servizi/rasatura-armata.php',
        'foto'   => 'assets/img/servizi/card-rasatura-armata.jpg',
        'descrizione' => 'Superfici uniformi e resistenti alle crepe.',
    ],
    [
        'slug'   => 'tinteggiatura',
        'icona'  => 'bi-paint-bucket',
        'titolo' => 'Tinteggiatura',
        'url'    => 'servizi/tinteggiatura.php',
        'foto'   => 'assets/img/servizi/tinteggiatura-ciclo.jpg',
        'descrizione' => 'Colori a regola d\'arte per interni ed esterni.',
    ],
    [
        'slug'   => 'intonachino',
        'icona'  => 'bi-brush',
        'titolo' => 'Intonachino',
        'url'    => 'servizi/intonachino.php',
        'foto'   => 'assets/img/servizi/card-intonachino.jpg',
        'descrizione' => 'Finitura materica per facciate e interni di pregio.',
    ],
    [
        'slug'   => 'carta-da-parati',
        'icona'  => 'bi-flower1',
        'titolo' => 'Carta da Parati',
        'url'    => 'servizi/carta-da-parati.php',
        'foto'   => 'assets/img/servizi/card-carta-da-parati.jpg',
        'descrizione' => 'Posa professionale e grafiche personalizzate.',
    ],
];

// Link di un servizio: pagina di dettaglio se esiste, altrimenti ancora in home
function link_servizio($servizio) {
    return $servizio['url'] !== null ? $servizio['url'] : 'index.php#servizio-' . $servizio['slug'];
}

// Scatti reali dai cantieri (cartella "photo colage") per la fascia fotografica
$foto_cantiere = [];
foreach (['jpg', 'jpeg', 'png', 'webp'] as $estensione) {
    $trovate = glob('photo colage/*.' . $estensione);
    if ($trovate) {
        $foto_cantiere = array_merge($foto_cantiere, $trovate);
    }
}
$foto_cantiere = array_values(array_unique($foto_cantiere));
sort($foto_cantiere);
$foto_cantiere = array_slice($foto_cantiere, 0, 8);

// Percorsi pronti per l'HTML (gli spazi nei nomi file vanno codificati)
$foto_cantiere = array_map(function ($percorso) {
    return implode('/', array_map('rawurlencode', explode('/', $percorso)));
}, $foto_cantiere);

// Punti di forza (lista accanto alla storia)
$punti_forza = [
    'Preventivi gratuiti e senza impegno',
    'Materiali certificati e di qualità',
    'Puntualità e rispetto delle consegne',
    'Cura artigianale di ogni dettaglio',
];

// I valori che guidano ogni cantiere
$valori = [
    [
        'icona'  => 'bi-gem',
        'titolo' => 'Qualità',
        'testo'  => 'Materiali certificati e tecniche aggiornate: ogni finitura è pensata per durare nel tempo.',
    ],
    [
        'icona'  => 'bi-bullseye',
        'titolo' => 'Precisione',
        'testo'  => 'Misure, livelli e dettagli curati al millimetro: la differenza si vede da vicino.',
    ],
    [
        'icona'  => 'bi-hand-thumbs-up',
        'titolo' => 'Affidabilità',
        'testo'  => 'Tempi concordati e rispettati, cantiere ordinato e comunicazione costante col cliente.',
    ],
    [
        'icona'  => 'bi-chat-square-text',
        'titolo' => 'Trasparenza',
        'testo'  => 'Preventivi chiari e dettagliati, senza sorprese: sai sempre cosa stiamo facendo e perché.',
    ],
];

// Come lavoriamo (identico per tutti i servizi)
$fasi_lavoro = [
    ['icona' => 'bi-search',            'titolo' => 'Sopralluogo', 'testo' => 'Sopralluogo e ascolto delle esigenze.'],
    ['icona' => 'bi-file-earmark-text', 'titolo' => 'Preventivo',  'testo' => 'Preventivo chiaro e dettagliato.'],
    ['icona' => 'bi-tools',             'titolo' => 'Esecuzione',  'testo' => 'Esecuzione a regola d\'arte, con cantiere pulito.'],
    ['icona' => 'bi-patch-check',       'titolo' => 'Consegna',    'testo' => 'Consegna e verifica finale col cliente.'],
];

// Dati strutturati JSON-LD: AboutPage + LocalBusiness + BreadcrumbList
$json_ld = [
    [
        '@context'   => 'https://schema.org',
        '@type'      => 'AboutPage',
        'name'       => 'Chi Siamo — ' . $site_name,
        'description'=> 'La storia e i valori di A.S.H. Finiture Contract di Ahmed Abdelaziz: finiture edili a Camerino (MC) e in tutte le Marche.',
        'mainEntity' => [
            '@type'     => 'LocalBusiness',
            'name'      => $site_name,
            'founder'   => ['@type' => 'Person', 'name' => 'Ahmed Abdelaziz'],
            'telephone' => $phone1_raw,
            'email'     => $email,
            'slogan'    => $tagline,
            'address'   => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => 'Via Adigrat 3/A',
                'postalCode'      => '62032',
                'addressLocality' => 'Camerino',
                'addressRegion'   => 'MC',
                'addressCountry'  => 'IT',
            ],
        ],
    ],
    [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'index.php'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Chi Siamo'],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Chi Siamo | A.S.H. Finiture Contract — Camerino (MC)</title>
    <meta name="description" content="Scopri A.S.H. Finiture Contract di Ahmed Abdelaziz: storia, valori e metodo di lavoro degli specialisti in finiture edili a Camerino (MC) e provincia di Macerata.">

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
            --crema:      #faf8f3;
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
        .menu-servizi .dropdown-item:focus {
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
            background: url('assets/img/chi-siamo.jpg') center center / cover no-repeat;
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

        /* ================= LA NOSTRA STORIA ================= */
        #storia { padding: 5.5rem 0; background: linear-gradient(180deg, #fdfbf5 0%, #faf7ef 100%); }

        /* Foto in cornice bianca con filo oro interno (come la homepage) */
        .box-foto {
            background: #fff;
            border: 1px solid #eee6d4;
            border-radius: 22px;
            box-shadow: 0 22px 50px rgba(46, 59, 66, .10);
            padding: 1.2rem;
            position: relative;
        }

        .box-foto::after {
            content: "";
            position: absolute;
            inset: 14px;
            border: 1px solid var(--oro-chiaro);
            border-radius: 14px;
            pointer-events: none;
        }

        .box-foto img {
            display: block;
            width: 100%;
            aspect-ratio: 4 / 5;
            object-fit: cover;
            object-position: center;
            border-radius: 14px;
        }

        /* Targhetta col motto sovrapposta alla foto */
        .targhetta-motto {
            position: absolute;
            left: 50%;
            bottom: -26px;
            transform: translateX(-50%);
            z-index: 1;
            width: max-content;
            max-width: 88%;
            background: linear-gradient(135deg, #d9b866, var(--oro-scuro));
            color: #fff;
            font-weight: 700;
            font-size: .85rem;
            letter-spacing: .6px;
            text-align: center;
            padding: .85rem 1.6rem;
            border-radius: 50rem;
            box-shadow: 0 14px 30px rgba(169, 130, 47, .38);
        }

        .lista-forza { list-style: none; padding: 0; margin: 0; }

        .lista-forza li {
            display: flex;
            align-items: center;
            gap: .8rem;
            font-weight: 600;
            color: var(--scuro);
            padding: .45rem 0;
        }

        .lista-forza li i { color: var(--oro-scuro); font-size: 1.25rem; }

        /* ================= I NOSTRI VALORI ================= */
        #valori { padding: 5.5rem 0; background: var(--crema); position: relative; }

        #valori::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--oro-scuro) 0%, var(--oro) 25%, #e8cc82 50%, var(--oro) 75%, var(--oro-scuro) 100%);
        }

        .card-valore {
            position: relative;
            overflow: hidden;
            border: 1px solid #eee6d4;
            border-radius: 18px;
            background: #fff;
            padding: 2.4rem 1.5rem 2.2rem;
            text-align: center;
            height: 100%;
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        /* Barra oro sul bordo alto della card */
        .card-valore::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--oro), var(--oro-scuro));
        }

        .card-valore:hover {
            transform: translateY(-6px);
            border-color: var(--oro);
            box-shadow: 0 16px 36px rgba(169, 130, 47, .22);
        }

        /* Icona dentro un badge circolare oro (richiama le card servizio) */
        .card-valore > i {
            width: 72px;
            height: 72px;
            margin: 0 auto;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            color: var(--oro-scuro);
            background: var(--oro-chiaro);
            border: 1px solid #ecdfc0;
            box-shadow: 0 8px 22px rgba(201, 162, 75, .16);
            transition: background .3s ease, color .3s ease, transform .3s ease;
        }

        .card-valore:hover > i {
            background: linear-gradient(135deg, var(--oro), var(--oro-scuro));
            color: #fff;
            transform: rotate(-6deg) scale(1.06);
        }

        .card-valore p {
            font-size: .87rem;
            line-height: 1.7;
            margin-bottom: 0;
        }

        /* ================= COME LAVORIAMO ================= */
        #come-lavoriamo { padding: 5.5rem 0; background: #faf7ef; position: relative; }

        /* Percorso in 4 fasi: icone collegate da una linea oro continua (desktop) */
        .percorso-fasi { position: relative; }

        @media (min-width: 992px) {
            .percorso-fasi::before {
                content: "";
                position: absolute;
                top: 39px;
                left: 13%;
                right: 13%;
                height: 3px;
                border-radius: 2px;
                background: linear-gradient(90deg, #e8cc82, var(--oro) 50%, var(--oro-scuro));
            }
        }

        .fase-step { text-align: center; padding: 0 .8rem; }

        .fase-step .icona-fase {
            position: relative;
            z-index: 1;
            width: 78px;
            height: 78px;
            margin: 0 auto 1.3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.9rem;
            color: var(--oro-scuro);
            background: #fff;
            border: 2px solid #ecdfc0;
            box-shadow: 0 8px 22px rgba(201, 162, 75, .18);
            transition: background .3s ease, color .3s ease, transform .3s ease, border-color .3s ease;
        }

        .fase-step:hover .icona-fase {
            background: linear-gradient(135deg, var(--oro), var(--oro-scuro));
            border-color: var(--oro-scuro);
            color: #fff;
            transform: rotate(-6deg) scale(1.08);
        }

        .fase-step h5 {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-size: .98rem;
            margin-bottom: .55rem;
        }

        /* Sottolineatura oro sotto il titolo (richiama la title-underline) */
        .fase-step h5::after {
            content: "";
            display: block;
            width: 42px;
            height: 3px;
            margin: .6rem auto 0;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--oro), var(--oro-scuro));
            transition: width .35s ease;
        }

        .fase-step:hover h5::after { width: 64px; }

        .fase-step p { font-size: .88rem; margin-bottom: 0; }

        /* ================= DAL CANTIERE (FASCIA FOTO) ================= */
        #dal-cantiere { padding: 5.5rem 0; background: linear-gradient(180deg, #faf7ef 0%, #fdfbf5 100%); }

        .banda-cantiere {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .banda-cantiere a {
            position: relative;
            display: block;
            overflow: hidden;
            border-radius: 16px;
            aspect-ratio: 1 / 1;
            background: var(--oro-chiaro);
            box-shadow: 0 3px 10px rgba(46, 59, 66, .07);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .banda-cantiere img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .banda-cantiere a:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 34px rgba(169, 130, 47, .26);
        }

        .banda-cantiere a:hover img { transform: scale(1.08); }

        @media (max-width: 767.98px) {
            .banda-cantiere { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        }

        /* ================= COSA FACCIAMO ================= */
        #cosa-facciamo { padding: 5.5rem 0; background: var(--crema); position: relative; }

        #cosa-facciamo::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--oro-scuro) 0%, var(--oro) 25%, #e8cc82 50%, var(--oro) 75%, var(--oro-scuro) 100%);
        }

        /* Card servizio con foto: linea oro che si espande dal centro in alto */
        .card-specialita {
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            border: 1px solid #eee6d4;
            border-radius: 18px;
            background: #fff;
            color: var(--testo);
            text-decoration: none;
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        .card-specialita::after {
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

        .card-specialita:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 40px rgba(169, 130, 47, .16);
            border-color: var(--oro);
            color: var(--testo);
        }

        .card-specialita:hover::after { width: 55%; }

        .card-specialita .foto {
            position: relative;
            overflow: hidden;
            aspect-ratio: 16 / 10;
            background: var(--oro-chiaro);
        }

        .card-specialita .foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .card-specialita:hover .foto img { transform: scale(1.07); }

        .card-specialita .corpo {
            position: relative;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            padding: 2.2rem 1.5rem 1.5rem;
        }

        /* Icona a cavallo tra foto e testo */
        .card-specialita .icona {
            position: absolute;
            top: -27px;
            left: 1.5rem;
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--oro-scuro);
            background: #fff;
            border: 1px solid #ecdfc0;
            box-shadow: 0 8px 20px rgba(201, 162, 75, .22);
            transition: background .3s ease, color .3s ease, transform .3s ease;
        }

        .card-specialita:hover .icona {
            background: linear-gradient(135deg, var(--oro), var(--oro-scuro));
            color: #fff;
            transform: rotate(-6deg) scale(1.06);
        }

        .card-specialita h5 {
            font-size: 1.02rem;
            font-weight: 700;
            margin-bottom: .45rem;
        }

        .card-specialita p {
            font-size: .85rem;
            line-height: 1.65;
            margin-bottom: 1rem;
        }

        .card-specialita .scopri {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--oro-testo);
        }

        .card-specialita .scopri i { transition: transform .25s ease; }

        .card-specialita:hover .scopri i { transform: translateX(4px); }

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
            .targhetta-motto { font-size: .78rem; padding: .7rem 1.3rem; }

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
            #storia, #valori, #come-lavoriamo, #dal-cantiere, #cosa-facciamo { padding: 3.8rem 0; }
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

        @media (prefers-reduced-motion: reduce) {
            .hero-servizio .hero-bg { animation: none; }
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
                            <?php foreach ($servizi as $servizio): ?>
                            <li>
                                <a class="dropdown-item" href="<?php echo link_servizio($servizio); ?>">
                                    <i class="bi <?php echo $servizio['icona']; ?>"></i> <?php echo $servizio['titolo']; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link active" href="chi-siamo.php">Chi Siamo</a></li>
                    <li class="nav-item"><a class="nav-link" href="realizzazioni.php">Realizzazioni</a></li>
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
                            <li class="corrente" aria-current="page">Chi Siamo</li>
                        </ol>
                    </nav>
                    <span class="hero-badge fade-up delay-1 mt-3">
                        <i class="bi bi-person-badge"></i> La nostra storia
                    </span>
                    <h1 class="mt-3 fade-up delay-1">
                        Chi è <span class="gold">A.S.H. Finiture</span>
                    </h1>
                    <p class="lead mt-3 fade-up delay-2">
                        L'impresa di Ahmed Abdelaziz, specializzata in finiture edili:
                        passione artigiana, materiali di qualità e cura del dettaglio
                        in ogni cantiere.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-4 fade-up delay-3">
                        <a href="preventivo.php" class="btn btn-oro">
                            <i class="bi bi-envelope-paper me-2"></i>Richiedi un preventivo
                        </a>
                        <a href="contatti.php" class="btn btn-outline-scuro">
                            <i class="bi bi-chat-left-text me-2"></i>Contattaci
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ================= LA NOSTRA STORIA ================= -->
    <section id="storia">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 reveal">
                    <div class="box-foto">
                        <img src="assets/img/chi-siamo.jpg" alt="Il team A.S.H. studia i disegni di un progetto in cantiere">
                        <div class="targhetta-motto">"<?php echo $tagline; ?>"</div>
                    </div>
                </div>
                <div class="col-lg-7 reveal" style="transition-delay:.15s">
                    <span class="hero-badge"><i class="bi bi-book"></i> La nostra storia</span>
                    <h2 class="section-title mt-3">Passione e precisione,<br><span class="text-oro">in ogni finitura</span></h2>
                    <div class="title-underline a-sinistra"></div>
                    <p class="mt-4">
                        <strong>A.S.H. Finiture Contract</strong> è l'impresa di <strong>Ahmed Abdelaziz</strong>,
                        specializzata nelle finiture edili per abitazioni, uffici e attività commerciali.
                        Con sede a <strong>Camerino (MC)</strong>, operiamo in provincia di Macerata
                        e in tutte le Marche, seguendo ogni progetto con serietà e attenzione al dettaglio.
                    </p>
                    <p>
                        Dal <strong>cartongesso</strong> alla <strong>carta da parati</strong>, passando per
                        sistemi a secco, rasatura armata, tinteggiatura e intonachino: ogni superficie
                        viene trattata come un lavoro su misura, perché la differenza, in un cantiere,
                        la fanno le mani e la cura di chi lavora.
                    </p>
                    <ul class="lista-forza mt-4">
                        <?php foreach ($punti_forza as $punto): ?>
                        <li><i class="bi bi-check-circle-fill"></i> <?php echo $punto; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= I NOSTRI VALORI ================= -->
    <section id="valori">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-stars"></i> Ciò che ci guida</span>
                <h2 class="section-title mt-3">I nostri <span class="text-oro">valori</span></h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 640px;">
                    Quattro principi semplici che applichiamo ogni giorno,
                    dal primo sopralluogo alla consegna finale.
                </p>
            </div>
            <div class="row g-4">
                <?php foreach ($valori as $i => $valore): ?>
                <div class="col-md-6 col-lg-3 reveal" style="transition-delay: <?php echo $i * 0.12; ?>s">
                    <div class="card-valore">
                        <i class="bi <?php echo $valore['icona']; ?>" aria-hidden="true"></i>
                        <h5 class="mt-3 fw-bold"><?php echo $valore['titolo']; ?></h5>
                        <p><?php echo $valore['testo']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ================= COME LAVORIAMO ================= -->
    <section id="come-lavoriamo">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-diagram-3"></i> Il nostro metodo</span>
                <h2 class="section-title mt-3">Come Lavoriamo</h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 640px;">
                    Un percorso chiaro in quattro fasi, dal primo contatto alla consegna finale.
                </p>
            </div>
            <div class="row g-5 percorso-fasi">
                <?php foreach ($fasi_lavoro as $i => $fase): ?>
                <div class="col-md-6 col-lg-3 reveal" style="transition-delay: <?php echo $i * 0.12; ?>s">
                    <div class="fase-step">
                        <div class="icona-fase"><i class="bi <?php echo $fase['icona']; ?>"></i></div>
                        <h5><?php echo $fase['titolo']; ?></h5>
                        <p><?php echo $fase['testo']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ================= DAL CANTIERE (FASCIA FOTO) ================= -->
    <?php if (!empty($foto_cantiere)): ?>
    <section id="dal-cantiere">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-camera"></i> Dal cantiere</span>
                <h2 class="section-title mt-3">Il lavoro, visto <span class="text-oro">da vicino</span></h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 640px;">
                    Qualche scatto autentico dai nostri cantieri: superfici, dettagli
                    e finiture così come le consegniamo ai clienti.
                </p>
            </div>
            <div class="banda-cantiere reveal">
                <?php foreach ($foto_cantiere as $src): ?>
                <a href="realizzazioni.php" aria-label="Guarda le realizzazioni di <?php echo $site_name; ?>">
                    <img src="<?php echo $src; ?>" alt="Lavoro realizzato da <?php echo $site_name; ?>" loading="lazy">
                </a>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-4 reveal">
                <a href="realizzazioni.php" class="btn btn-oro">
                    <i class="bi bi-images me-2"></i>Guarda tutte le realizzazioni
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= COSA FACCIAMO ================= -->
    <section id="cosa-facciamo">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-tools"></i> Le nostre specialità</span>
                <h2 class="section-title mt-3">Cosa <span class="text-oro">facciamo</span></h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 640px;">
                    Sei specialità, un unico standard: il lavoro fatto a regola d'arte.
                </p>
            </div>
            <div class="row g-4">
                <?php foreach ($servizi as $i => $servizio): ?>
                <div class="col-md-6 col-lg-4 reveal" style="transition-delay: <?php echo ($i % 3) * 0.12; ?>s">
                    <a class="card-specialita" href="<?php echo link_servizio($servizio); ?>">
                        <div class="foto">
                            <img src="<?php echo $servizio['foto']; ?>" alt="<?php echo $servizio['titolo']; ?> — lavorazione di <?php echo $site_name; ?>" loading="lazy">
                        </div>
                        <div class="corpo">
                            <span class="icona"><i class="bi <?php echo $servizio['icona']; ?>" aria-hidden="true"></i></span>
                            <h5><?php echo $servizio['titolo']; ?></h5>
                            <p><?php echo $servizio['descrizione']; ?></p>
                            <span class="scopri">Scopri di più <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                        </div>
                    </a>
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
                    <h2 class="mb-2">Vuoi conoscerci di persona?</h2>
                    <p class="mb-0 fs-5" style="color:rgba(255,255,255,.9)">
                        Richiedi un <strong>sopralluogo gratuito</strong>: veniamo a vedere
                        gli spazi e ti proponiamo la soluzione migliore, senza impegno.
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
    </script>
</body>
</html>
