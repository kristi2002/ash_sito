<?php
// ============================================================
//  A.S.H. Finiture Contract — Di Ahmed Abdelaziz
//  Homepage — PHP + Bootstrap 5
// ============================================================

$site_name  = 'A.S.H. Finiture Contract';
$tagline    = 'Qualità e Precisione per Ogni Spazio';
$phone1     = '329 6447797';
$phone2     = '338 3386946';
$phone1_raw = '+393296447797';
$phone2_raw = '+393383386946';
$email      = 'ashfiniturecontract@outlook.it';
$address    = 'Via Adigrat 3/A, 62032 Camerino (MC)';

// Servizi principali (slug per ancore/sottomenu + icona Bootstrap Icons + descrizione)
$servizi = [
    [
        'slug'        => 'cartongesso',
        'icona'       => 'bi-bricks',
        'titolo'      => 'Cartongesso',
        'url'         => 'servizi/cartongesso.php',
        'foto'        => 'assets/img/servizi/cartongesso-stuccatura.jpg',
        'descrizione' => 'Pareti divisorie, controsoffitti e contropareti in cartongesso: soluzioni versatili, veloci e dal risultato impeccabile.',
    ],
    [
        'slug'        => 'sistemi-a-secco',
        'icona'       => 'bi-layers',
        'titolo'      => 'Sistemi a Secco',
        'url'         => 'servizi/sistemi-a-secco.php',
        'foto'        => 'assets/img/servizi/card-sistemi-a-secco.jpg',
        'descrizione' => 'Costruzioni a secco moderne per isolamento termico e acustico, senza opere murarie invasive e con cantieri più puliti.',
    ],
    [
        'slug'        => 'rasatura-armata',
        'icona'       => 'bi-shield-check',
        'titolo'      => 'Rasatura Armata',
        'url'         => 'servizi/rasatura-armata.php',
        'foto'        => 'assets/img/servizi/card-rasatura-armata.jpg',
        'descrizione' => 'Rasature rinforzate con rete per superfici solide, uniformi e resistenti nel tempo, ideali su cappotti e supporti critici.',
    ],
    [
        'slug'        => 'tinteggiatura',
        'icona'       => 'bi-paint-bucket',
        'titolo'      => 'Tinteggiatura',
        'url'         => 'servizi/tinteggiatura.php',
        'foto'        => 'assets/img/servizi/tinteggiatura-ciclo.jpg',
        'descrizione' => 'Tinteggiature interne ed esterne con prodotti di qualità: colori uniformi, finiture curate e ambienti che si rinnovano.',
    ],
    [
        'slug'        => 'intonachino',
        'icona'       => 'bi-brush',
        'titolo'      => 'Intonachino',
        'url'         => 'servizi/intonachino.php',
        'foto'        => 'assets/img/servizi/card-intonachino.jpg',
        'descrizione' => 'Finiture decorative ad intonachino per dare carattere, materia ed eleganza alle pareti di casa e ambienti commerciali.',
    ],
    [
        'slug'        => 'carta-da-parati',
        'icona'       => 'bi-flower1',
        'titolo'      => 'Carta da Parati',
        'url'         => 'servizi/carta-da-parati.php',
        'foto'        => 'assets/img/servizi/card-carta-da-parati.jpg',
        'descrizione' => 'Posa professionale di carta da parati e rivestimenti decorativi: precisione nei dettagli per pareti uniche e di design.',
    ],
];

// Punti di forza (sezione Chi Siamo)
$punti_forza = [
    'Preventivi gratuiti e senza impegno',
    'Materiali certificati e di qualità',
    'Puntualità e rispetto delle consegne',
    'Cura artigianale di ogni dettaglio',
];

// Come lavoriamo (identico per tutti i servizi)
$fasi_lavoro = [
    ['icona' => 'bi-search',            'titolo' => 'Sopralluogo', 'testo' => 'Sopralluogo e ascolto delle esigenze.'],
    ['icona' => 'bi-file-earmark-text', 'titolo' => 'Preventivo',  'testo' => 'Preventivo chiaro e dettagliato.'],
    ['icona' => 'bi-tools',             'titolo' => 'Esecuzione',  'testo' => 'Esecuzione a regola d\'arte, con cantiere pulito.'],
    ['icona' => 'bi-patch-check',       'titolo' => 'Consegna',    'testo' => 'Consegna e verifica finale col cliente.'],
];

// Foto dei lavori per il mosaico "Realizzazioni": lette dalla cartella "photo colage".
// Basta aggiungere o togliere immagini dalla cartella per aggiornare il mosaico.
$foto_mosaico = [];
foreach (['jpg', 'jpeg', 'png', 'webp'] as $estensione) {
    $trovate = glob('photo colage/*.' . $estensione);
    if ($trovate) {
        $foto_mosaico = array_merge($foto_mosaico, $trovate);
    }
}
$foto_mosaico = array_values(array_unique($foto_mosaico));
sort($foto_mosaico);

// Percorsi pronti per l'HTML (gli spazi nei nomi file vanno codificati)
$foto_mosaico_url = array_map(function ($percorso) {
    return implode('/', array_map('rawurlencode', explode('/', $percorso)));
}, $foto_mosaico);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?php echo $site_name; ?> — Specialisti in Finiture Edili a Camerino (MC)</title>
    <meta name="description" content="A.S.H. Finiture Contract di Ahmed Abdelaziz: specialisti in finiture edili. Cartongesso, sistemi a secco, rasatura armata, tinteggiatura, intonachino e carta da parati a Camerino (MC) e provincia.">

    <!-- Bootstrap 5 + Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Fonts: Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="assets/img/logo-mark.png">

    <style>
        /* ================= PALETTE BIANCO & ORO ================= */
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
            background-color: #faf7ef; /* bianco caldo: toglie l'effetto "tutto bianco" */
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

            /* Ponte invisibile sul distacco tra bottone e menu: evita che
               l'hover si interrompa attraversando lo spazio vuoto */
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

        /* ================= HERO ================= */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: var(--scuro);
        }

        /* Immagine di sfondo con zoom lento (effetto "video") */
        .hero-bg {
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

        /* Overlay scuro + velatura oro per leggibilità del testo */
        .hero-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(100deg, rgba(24, 30, 34, .92) 0%, rgba(24, 30, 34, .72) 45%, rgba(24, 30, 34, .35) 100%),
                linear-gradient(0deg, rgba(169, 130, 47, .18), rgba(169, 130, 47, .18));
        }

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

        .hero .hero-badge {
            background: rgba(255, 255, 255, .14);
            color: #ecd9a8;
            backdrop-filter: blur(4px);
        }

        .hero h1 {
            font-weight: 800;
            font-size: clamp(2.2rem, 5vw, 3.6rem);
            line-height: 1.12;
            color: #ffffff;
        }

        .hero h1 .gold {
            background: linear-gradient(135deg, #e8cc82, var(--oro));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero .lead { max-width: 560px; color: rgba(255, 255, 255, .88); }

        .hero .btn-outline-scuro {
            border-color: #fff;
            color: #fff;
        }

        .hero .btn-outline-scuro:hover { background: #fff; color: var(--scuro); }

        .hero-info a, .hero-info span { color: #fff !important; }

        .hero-info i { color: var(--oro) !important; }

        .hero-scroll {
            position: absolute;
            bottom: 26px;
            left: 50%;
            transform: translateX(-50%);
            color: #e8cc82;
            font-size: 1.6rem;
            animation: rimbalzo 2s infinite;
        }

        @keyframes rimbalzo {
            0%, 100% { transform: translate(-50%, 0); }
            50%      { transform: translate(-50%, 10px); }
        }

        /* Animazioni d'ingresso hero */
        .fade-up {
            opacity: 0;
            transform: translateY(26px);
            animation: fadeUp .8s ease forwards;
        }

        .delay-1 { animation-delay: .15s; }
        .delay-2 { animation-delay: .35s; }
        .delay-3 { animation-delay: .55s; }
        .delay-4 { animation-delay: .75s; }

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

        /* ================= SERVIZI ================= */
        /* Sezione ben staccata dall'hero (spaziatura corretta) */
        #servizi { padding: 7rem 0 5.5rem; background: linear-gradient(180deg, #fdfbf5 0%, #faf7ef 100%); }

        .card-servizio {
            position: relative;
            border: 1px solid #eee6d4;
            border-radius: 18px;
            background: linear-gradient(180deg, #ffffff 0%, #fdfaf3 100%);
            height: 100%;
            padding: 2.6rem 2rem 2.2rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        /* Foto di cantiere in trasparenza: emerge al passaggio del mouse */
        .card-servizio::before {
            content: "";
            position: absolute;
            inset: 0;
            background: var(--card-foto, url('assets/img/card-servizio-bg.jpg')) center/cover no-repeat;
            opacity: .09;
            transform: scale(1.01);
            transition: opacity .45s ease, transform .45s ease;
            pointer-events: none;
        }

        .card-servizio:hover::before {
            opacity: .22;
            transform: scale(1.05);
        }

        /* Contenuto sopra la foto di sfondo */
        .card-servizio > * { position: relative; z-index: 1; }

        /* Linea oro che si espande dal centro in alto */
        .card-servizio::after {
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
        }

        .card-servizio:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 40px rgba(169, 130, 47, .16);
            border-color: var(--oro);
        }

        .card-servizio:hover::after { width: 55%; }

        .icona-servizio {
            width: 78px;
            height: 78px;
            margin: 0 auto 1.3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--oro-scuro);
            background: var(--oro-chiaro);
            border: 1px solid #ecdfc0;
            box-shadow: 0 8px 22px rgba(201, 162, 75, .14);
            transition: transform .3s ease, background .3s ease, color .3s ease, box-shadow .3s ease;
        }

        .card-servizio:hover .icona-servizio {
            background: linear-gradient(135deg, var(--oro), var(--oro-scuro));
            color: #fff;
            transform: rotate(-6deg) scale(1.06);
            box-shadow: 0 12px 28px rgba(169, 130, 47, .3);
        }

        .card-servizio h5 {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-size: 1.02rem;
        }

        /* Sottolineatura oro sotto il titolo (richiama la title-underline) */
        .card-servizio h5::after {
            content: "";
            display: block;
            width: 42px;
            height: 3px;
            margin: .7rem auto .2rem;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--oro), var(--oro-scuro));
            transition: width .35s ease;
        }

        .card-servizio:hover h5::after { width: 70px; }

        .card-servizio p { font-size: .9rem; margin-bottom: 1.4rem; }

        /* Bottone "Scopri di più": pill oro con testo scuro, si inverte al hover */
        .link-servizio {
            margin-top: auto;
            align-self: center;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .6rem 1.5rem;
            border-radius: 50rem;
            background: linear-gradient(135deg, #d9b866, var(--oro));
            color: var(--scuro);
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            text-decoration: none;
            box-shadow: 0 6px 16px rgba(169, 130, 47, .25);
            transition: background .3s ease, color .3s ease, transform .25s ease, box-shadow .25s ease;
        }

        .link-servizio i { transition: transform .3s ease; }

        .link-servizio:hover,
        .card-servizio:hover .link-servizio {
            background: var(--scuro);
            color: #d9b866;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(46, 59, 66, .32);
        }

        .link-servizio:hover i,
        .card-servizio:hover .link-servizio i { transform: translateX(4px); }

        /* ================= CHI SIAMO ================= */
        #chi-siamo { padding: 5.5rem 0; background: var(--crema); }

        .box-logo {
            background: #fff;
            border: 1px solid #eee6d4;
            border-radius: 22px;
            box-shadow: 0 22px 50px rgba(46, 59, 66, .10);
            padding: 3rem;
            text-align: center;
            position: relative;
        }

        .box-logo::after {
            content: "";
            position: absolute;
            inset: 14px;
            border: 1px solid var(--oro-chiaro);
            border-radius: 14px;
            pointer-events: none;
        }

        .box-logo img { max-width: 78%; height: auto; }

        /* Foto Chi Siamo: centrata, riempie il box dentro la cornice interna */
        .box-logo .foto-chi-siamo {
            display: block;
            width: 100%;
            max-width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            object-position: center;
            margin: 0 auto;
            border-radius: 14px;
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

        /* ================= COME LAVORIAMO ================= */
        #come-lavoriamo { padding: 5.5rem 0; background: #faf7ef; position: relative; }

        /* Bordo oro in alto (come le sezioni della homepage) */
        #come-lavoriamo::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--oro-scuro) 0%, var(--oro) 25%, #e8cc82 50%, var(--oro) 75%, var(--oro-scuro) 100%);
        }

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

        .fase-step:hover h5::after { width: 70px; }

        .fase-step p {
            font-size: .9rem;
            margin: 0 auto;
            max-width: 240px;
            line-height: 1.7;
        }

        /* ================= REALIZZAZIONI ================= */
        #realizzazioni {
            padding: 5.5rem 0 6.5rem;
            background: linear-gradient(180deg, #f7f1e2 0%, #faf7ef 46%);
            position: relative;
            overflow: hidden;
        }

        /* Bordo oro in alto: divide le sezioni chiare e richiama la palette */
        #realizzazioni::before,
        #contatti::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--oro-scuro) 0%, var(--oro) 25%, #e8cc82 50%, var(--oro) 75%, var(--oro-scuro) 100%);
        }

        /* Anello decorativo oro, come nella fascia preventivo */
        #realizzazioni::after {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            border: 38px solid rgba(201, 162, 75, .10);
            border-radius: 50%;
            bottom: -150px;
            left: -130px;
        }

        #realizzazioni .container { position: relative; z-index: 1; }

        /* Mosaico fotografico con effetto "video": zoom lento continuo (ken burns)
           e dissolvenza tra le foto, che ruotano una tessera alla volta */
        .mosaico {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-auto-rows: clamp(130px, 18vw, 200px);
            grid-auto-flow: dense;
            gap: 14px;
        }

        .mosaico-item {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            border: 2px solid #ecdfc0;
            background: var(--oro-chiaro);
            cursor: pointer;
            margin: 0; /* azzera il margine di <figure> */
            transition: border-color .3s ease, box-shadow .3s ease, transform .3s ease;
        }

        .mosaico-item:hover {
            border-color: var(--oro);
            box-shadow: 0 14px 32px rgba(169, 130, 47, .28);
            transform: translateY(-4px);
        }

        .mosaico-item--grande { grid-column: span 2; grid-row: span 2; }
        .mosaico-item--alto   { grid-row: span 2; }
        .mosaico-item--largo  { grid-column: span 2; }

        .mosaico-item img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 1;
            transition: opacity 1.1s ease;
            animation: kenburns-mosaico 16s ease-in-out infinite alternate;
            will-change: transform, opacity;
        }

        .mosaico-item img.in-dissolvenza { opacity: 0; }

        /* Tempi sfalsati tra le tessere: il movimento risulta più naturale */
        .mosaico-item:nth-child(2n) img { animation-duration: 20s; animation-direction: alternate-reverse; }
        .mosaico-item:nth-child(3n) img { animation-delay: -7s; }

        @keyframes kenburns-mosaico {
            from { transform: scale(1.02); }
            to   { transform: scale(1.14) translate(1.5%, -1%); }
        }

        /* Velo scuro + lente d'ingrandimento al passaggio del mouse */
        .mosaico-item::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(24, 30, 34, 0) 50%, rgba(24, 30, 34, .38) 100%);
            opacity: 0;
            transition: opacity .35s ease;
            pointer-events: none;
        }

        .mosaico-item:hover::after { opacity: 1; }

        .mosaico-item .lente {
            position: absolute;
            right: 12px;
            bottom: 12px;
            z-index: 2;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .92);
            color: var(--oro-testo);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            opacity: 0;
            transform: translateY(6px);
            transition: opacity .3s ease, transform .3s ease;
            pointer-events: none;
        }

        .mosaico-item:hover .lente { opacity: 1; transform: translateY(0); }

        @media (max-width: 767.98px) {
            .mosaico {
                grid-template-columns: repeat(2, 1fr);
                grid-auto-rows: clamp(110px, 26vw, 160px);
                gap: 10px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .mosaico-item img { animation: none; }
        }

        /* Lightbox: foto a schermo intero con frecce e contatore */
        .lightbox {
            position: fixed;
            inset: 0;
            z-index: 2000;
            background: rgba(18, 22, 25, .94);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease;
        }

        .lightbox.aperta { opacity: 1; pointer-events: auto; }

        .lightbox img {
            max-width: min(92vw, 1100px);
            max-height: 82vh;
            border-radius: 12px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, .5);
        }

        .lightbox button {
            position: absolute;
            border: none;
            border-radius: 50%;
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            background: rgba(255, 255, 255, .12);
            color: #fff;
            transition: background .25s ease, transform .25s ease;
        }

        .lightbox button:hover { background: var(--oro-scuro); transform: scale(1.08); }

        .lightbox .chiudi { top: 20px; right: 20px; }

        .lightbox .precedente { left: 16px; top: 50%; transform: translateY(-50%); }

        .lightbox .successiva { right: 16px; top: 50%; transform: translateY(-50%); }

        .lightbox .precedente:hover,
        .lightbox .successiva:hover { transform: translateY(-50%) scale(1.08); }

        .lightbox .contatore {
            position: absolute;
            bottom: 22px;
            left: 50%;
            transform: translateX(-50%);
            color: #ecd9a8;
            font-weight: 600;
            font-size: .9rem;
            letter-spacing: 1.5px;
        }

        /* ================= CTA PREVENTIVO ================= */
        #preventivo {
            background: linear-gradient(120deg, #6f541e 0%, #7c5f20 55%, #8a6a26 100%);
            color: #fff;
            padding: 4.5rem 0;
            position: relative;
            overflow: hidden;
        }

        #preventivo::before {
            content: "";
            position: absolute;
            width: 380px;
            height: 380px;
            border: 40px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
            top: -160px;
            right: -120px;
        }

        #preventivo h2 { color: #fff; font-weight: 800; }

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

        /* ================= CONTATTI ================= */
        /* Sfondo crema + bordo oro in alto: stacca la sezione dal mosaico e dal footer */
        #contatti { padding: 5.5rem 0 6.5rem; background: var(--crema); position: relative; }

        .card-contatto {
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
        .card-contatto::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--oro), var(--oro-scuro));
        }

        .card-contatto:hover {
            transform: translateY(-6px);
            border-color: var(--oro);
            box-shadow: 0 16px 36px rgba(169, 130, 47, .22);
        }

        /* Icona dentro un badge circolare oro (richiama le card servizio) */
        .card-contatto i {
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

        .card-contatto:hover i {
            background: linear-gradient(135deg, var(--oro), var(--oro-scuro));
            color: #fff;
            transform: rotate(-6deg) scale(1.06);
        }

        .card-contatto a { color: var(--testo); text-decoration: none; }

        .card-contatto a:hover { color: var(--oro-testo); }

        .cornice-mappa {
            border-radius: 24px;
            box-shadow: 0 18px 40px rgba(46, 59, 66, .18);
        }

        .mappa {
            display: block;
            border: 0;
            width: 100%;
            height: 340px;
            border-radius: 24px;
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
            .hero { min-height: 92vh; min-height: 92svh; padding: 7.5rem 0 4.5rem; }

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
            .btn-oro:active, .btn-bianco:active, .link-servizio:active { transform: scale(.97); }
        }

        /* Su schermi touch la foto di cantiere nelle card resta leggermente
           più visibile: l'effetto hover del mouse non esiste */
        @media (hover: none) {
            .card-servizio::before { opacity: .13; }
        }

        /* ================= MOBILE: TELEFONI ================= */
        @media (max-width: 575.98px) {
            /* Ritmo verticale più compatto: meno vuoto tra le sezioni */
            #servizi { padding: 3.8rem 0 3.4rem; }
            #chi-siamo, #come-lavoriamo, #realizzazioni, #contatti { padding: 3.8rem 0; }
            #preventivo { padding: 3.2rem 0; }

            /* Righe impilate: gutter orizzontale standard e respiro ridotto */
            .row.g-5 { --bs-gutter-x: 1.5rem; --bs-gutter-y: 2.4rem; }

            .hero h1 { font-size: 2.35rem; }
            .hero .lead { font-size: 1.05rem; }

            /* CTA a tutta larghezza: più facili da premere */
            .hero .btn-oro,
            .hero .btn-outline-scuro,
            #preventivo .btn-bianco {
                display: flex;
                justify-content: center;
                width: 100%;
                padding-top: .85rem;
                padding-bottom: .85rem;
            }

            /* Card più snelle: il contenuto respira anche su schermi stretti */
            .card-servizio { padding: 2rem 1.4rem 1.8rem; }
            .box-logo { padding: 2rem 1.5rem; }
            .fase-step { padding: 0; }
            .mappa { height: 300px; }

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

            /* Lightbox: chiudi in alto, frecce in basso al centro (zona pollice) */
            .lightbox img { max-width: 96vw; max-height: 72vh; }

            .lightbox .chiudi { top: max(14px, env(safe-area-inset-top)); right: 14px; }

            .lightbox .contatore {
                top: max(26px, env(safe-area-inset-top));
                bottom: auto;
                left: 20px;
                transform: none;
            }

            .lightbox .precedente,
            .lightbox .successiva {
                top: auto;
                bottom: max(20px, env(safe-area-inset-bottom));
                transform: none;
                width: 54px;
                height: 54px;
                background: rgba(255, 255, 255, .16);
            }

            .lightbox .precedente { left: calc(50% - 66px); }

            .lightbox .successiva { right: calc(50% - 66px); }

            .lightbox .precedente:hover,
            .lightbox .successiva:hover { transform: scale(1.06); }
        }
    </style>
</head>
<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="#home">
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
                    <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#servizi" id="menuServizi" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Servizi
                        </a>
                        <ul class="dropdown-menu menu-servizi" aria-labelledby="menuServizi">
                            <li>
                                <a class="dropdown-item" href="#servizi">
                                    <i class="bi bi-grid-3x3-gap"></i> Tutti i Servizi
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <?php foreach ($servizi as $servizio): ?>
                            <li>
                                <a class="dropdown-item" href="<?php echo $servizio['url'] ?? '#servizio-' . $servizio['slug']; ?>">
                                    <i class="bi <?php echo $servizio['icona']; ?>"></i> <?php echo $servizio['titolo']; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="chi-siamo.php">Chi Siamo</a></li>
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

    <!-- ================= HERO ================= -->
    <header class="hero" id="home">
        <div class="hero-bg" aria-hidden="true"></div>
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="container position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <span class="hero-badge fade-up">
                        <i class="bi bi-award"></i> Di Ahmed Abdelaziz
                    </span>
                    <h1 class="mt-4 fade-up delay-1">
                        Specialisti in<br>
                        <span class="gold">Finiture Edili</span>
                    </h1>
                    <p class="lead mt-4 fade-up delay-2">
                        <?php echo $tagline; ?>: cartongesso, sistemi a secco, rasatura armata,
                        tinteggiatura, intonachino e carta da parati. Trasformiamo i tuoi ambienti
                        con cura artigianale e materiali di qualità.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-4 fade-up delay-3">
                        <a href="#servizi" class="btn btn-oro">
                            <i class="bi bi-tools me-2"></i>I Nostri Servizi
                        </a>
                        <a href="#contatti" class="btn btn-outline-scuro">
                            <i class="bi bi-chat-dots me-2"></i>Contattaci
                        </a>
                    </div>
                    <div class="d-flex flex-wrap gap-4 mt-5 fade-up delay-4 hero-info">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-telephone-fill fs-5"></i>
                            <a class="text-decoration-none fw-semibold" href="tel:<?php echo $phone1_raw; ?>"><?php echo $phone1; ?></a>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt-fill fs-5"></i>
                            <span class="fw-semibold">Camerino (MC)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="#servizi" class="hero-scroll" aria-label="Scorri ai servizi"><i class="bi bi-chevron-double-down"></i></a>
    </header>

    <!-- ================= SERVIZI ================= -->
    <section id="servizi">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-stars"></i> Cosa facciamo</span>
                <h2 class="section-title mt-3">I Nostri Servizi Principali</h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 640px;">
                    Sei specializzazioni, un unico obiettivo: finiture perfette.
                    Seguiamo ogni fase del lavoro, dalla preparazione delle superfici all'ultimo dettaglio.
                </p>
            </div>
            <div class="row g-4">
                <?php foreach ($servizi as $i => $servizio): ?>
                <div class="col-md-6 col-lg-4 reveal" id="servizio-<?php echo $servizio['slug']; ?>" style="transition-delay: <?php echo ($i % 3) * 0.12; ?>s">
                    <div class="card-servizio"<?php if (!empty($servizio['foto'])): ?> style="--card-foto: url('<?php echo $servizio['foto']; ?>')"<?php endif; ?>>
                        <div class="icona-servizio"><i class="bi <?php echo $servizio['icona']; ?>"></i></div>
                        <h5><?php echo $servizio['titolo']; ?></h5>
                        <p><?php echo $servizio['descrizione']; ?></p>
                        <a href="<?php echo $servizio['url'] ?? '#preventivo'; ?>" class="link-servizio" aria-label="Scopri di più su <?php echo $servizio['titolo']; ?>">Scopri di più <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ================= CHI SIAMO ================= -->
    <section id="chi-siamo">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 reveal">
                    <div class="box-logo">
                        <img src="assets/img/chi-siamo.jpg" alt="Il team A.S.H. studia i disegni di un progetto in cantiere" class="foto-chi-siamo">
                        <h4 class="mt-4 mb-0 fw-bold">A.S.H.</h4>
                        <p class="text-oro fw-semibold mb-0" style="letter-spacing:2px; font-size:.85rem;">FINITURE CONTRACT</p>
                    </div>
                </div>
                <div class="col-lg-7 reveal" style="transition-delay:.15s">
                    <span class="hero-badge"><i class="bi bi-person-badge"></i> Chi Siamo</span>
                    <h2 class="section-title mt-3">Passione e precisione,<br><span class="text-oro">in ogni finitura</span></h2>
                    <p class="mt-4">
                        <strong>A.S.H. Finiture Contract</strong> è l'impresa di <strong>Ahmed Abdelaziz</strong>,
                        specializzata nelle finiture edili per abitazioni, uffici e attività commerciali.
                        Con sede a <strong>Camerino (MC)</strong>, seguiamo ogni progetto con serietà e
                        attenzione al dettaglio: dal cartongesso alla carta da parati, ogni superficie
                        viene trattata come un lavoro su misura.
                    </p>
                    <p>
                        Il nostro motto è semplice: <em>"<?php echo $tagline; ?>"</em>.
                        Perché la differenza, in un cantiere, la fanno le mani e la cura di chi lavora.
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

    <!-- ================= CTA PREVENTIVO ================= -->
    <section id="preventivo">
        <div class="container position-relative">
            <div class="row align-items-center g-4">
                <div class="col-lg-8 reveal">
                    <h2 class="mb-2">Hai un progetto in mente?</h2>
                    <p class="mb-0 fs-5" style="color:rgba(255,255,255,.9)">
                        Richiedi subito un <strong>preventivo gratuito</strong> e senza impegno:
                        ti rispondiamo in tempi rapidi.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end reveal" style="transition-delay:.15s">
                    <a href="tel:<?php echo $phone1_raw; ?>" class="btn btn-bianco mb-3 mb-lg-0 me-lg-2">
                        <i class="bi bi-telephone-outbound me-2"></i>Chiama Ora
                    </a>
                    <a href="preventivo.php" class="btn btn-bianco">
                        <i class="bi bi-envelope-paper me-2"></i>Richiedi Preventivo
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= REALIZZAZIONI ================= -->
    <section id="realizzazioni">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-images"></i> I nostri lavori</span>
                <h2 class="section-title mt-3">Le Nostre Realizzazioni</h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 640px;">
                    Una selezione dei nostri cantieri: cartongesso, finiture e tinteggiature
                    raccontate dalle foto dei lavori completati. Clicca su una foto per ingrandirla.
                </p>
            </div>
            <?php if (!empty($foto_mosaico_url)): ?>
            <div class="mosaico reveal" id="mosaicoRealizzazioni">
                <?php foreach (array_slice($foto_mosaico_url, 0, 11) as $i => $src):
                    $classe = '';
                    if ($i === 0) { $classe = ' mosaico-item--grande'; }
                    elseif ($i === 3) { $classe = ' mosaico-item--alto'; }
                    elseif ($i === 6) { $classe = ' mosaico-item--largo'; }
                ?>
                <figure class="mosaico-item<?php echo $classe; ?>" data-foto="<?php echo $i; ?>">
                    <img src="<?php echo $src; ?>" alt="Lavoro realizzato da <?php echo $site_name; ?>" loading="lazy">
                    <span class="lente"><i class="bi bi-arrows-fullscreen"></i></span>
                </figure>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="text-center text-muted reveal">Le foto dei nostri lavori saranno disponibili a breve.</p>
            <?php endif; ?>
            <div class="text-center mt-5 reveal">
                <a href="realizzazioni.php" class="btn btn-oro">
                    <i class="bi bi-images me-2"></i>Vedi tutte le realizzazioni
                </a>
            </div>
        </div>
    </section>

    <!-- ================= CONTATTI ================= -->
    <section id="contatti">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-chat-left-heart"></i> Parliamone</span>
                <h2 class="section-title mt-3">Contatti</h2>
                <div class="title-underline"></div>
            </div>
            <div class="row g-4 mb-5">
                <div class="col-md-4 reveal">
                    <div class="card-contatto">
                        <i class="bi bi-telephone-fill"></i>
                        <h5 class="mt-3 fw-bold">Telefono</h5>
                        <p class="mb-1"><a href="tel:<?php echo $phone1_raw; ?>"><?php echo $phone1; ?></a></p>
                        <p class="mb-0"><a href="tel:<?php echo $phone2_raw; ?>"><?php echo $phone2; ?></a></p>
                    </div>
                </div>
                <div class="col-md-4 reveal" style="transition-delay:.12s">
                    <div class="card-contatto">
                        <i class="bi bi-envelope-fill"></i>
                        <h5 class="mt-3 fw-bold">Email</h5>
                        <p class="mb-0"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
                    </div>
                </div>
                <div class="col-md-4 reveal" style="transition-delay:.24s">
                    <div class="card-contatto">
                        <i class="bi bi-geo-alt-fill"></i>
                        <h5 class="mt-3 fw-bold">Sede Legale</h5>
                        <p class="mb-0"><?php echo $address; ?></p>
                    </div>
                </div>
            </div>
            <div class="reveal cornice-mappa">
                <iframe class="mappa"
                        src="https://maps.google.com/maps?q=<?php echo urlencode($address); ?>&t=&z=14&ie=UTF8&iwloc=&output=embed"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Mappa sede A.S.H. Finiture Contract"></iframe>
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
                        <li><a href="#home"><i class="bi bi-chevron-right small"></i> Home</a></li>
                        <li><a href="#servizi"><i class="bi bi-chevron-right small"></i> Servizi</a></li>
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

    <!-- Lightbox galleria Realizzazioni -->
    <div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Galleria fotografica dei lavori">
        <button type="button" class="chiudi" aria-label="Chiudi la galleria"><i class="bi bi-x-lg"></i></button>
        <button type="button" class="precedente" aria-label="Foto precedente"><i class="bi bi-chevron-left"></i></button>
        <img src="" alt="Foto del lavoro ingrandita" id="lightboxImg">
        <button type="button" class="successiva" aria-label="Foto successiva"><i class="bi bi-chevron-right"></i></button>
        <div class="contatore" id="lightboxContatore"></div>
    </div>

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

        // Evidenzia la voce di menu della sezione visibile
        const sezioni = document.querySelectorAll('section[id], header[id]');
        const linkNav = document.querySelectorAll('.navbar .nav-link');

        const spy = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    linkNav.forEach(l => l.classList.toggle('active', l.getAttribute('href') === '#' + entry.target.id));
                }
            });
        }, { rootMargin: '-45% 0px -50% 0px' });

        sezioni.forEach(s => spy.observe(s));

        // Chiudi il menu mobile dopo il click su un link
        // (il toggle "Servizi" è escluso: deve solo aprire il sottomenu)
        document.querySelectorAll('#menuPrincipale .nav-link:not(.dropdown-toggle), #menuPrincipale .dropdown-item, #menuPrincipale .btn').forEach(el => {
            el.addEventListener('click', () => {
                const menu = document.getElementById('menuPrincipale');
                if (menu.classList.contains('show')) {
                    bootstrap.Collapse.getOrCreateInstance(menu).hide();
                }
            });
        });

        // ================= MOSAICO REALIZZAZIONI =================
        // Tutte le foto della cartella "photo colage" (percorsi già codificati dal PHP)
        const fotoMosaico = <?php echo json_encode($foto_mosaico_url, JSON_UNESCAPED_SLASHES); ?>;
        const mosaico = document.getElementById('mosaicoRealizzazioni');

        if (mosaico && fotoMosaico.length) {
            const tessere = Array.from(mosaico.querySelectorAll('.mosaico-item'));
            // Foto attualmente mostrata da ogni tessera (all'avvio: 0, 1, 2, ...)
            const fotoCorrente = tessere.map((t, i) => i % fotoMosaico.length);
            let prossimaFoto = tessere.length % fotoMosaico.length;
            let prossimaTessera = 0;
            let mosaicoVisibile = false;

            const riduciMovimento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // Effetto "video": a turno una tessera sfuma sulla foto successiva della coda,
            // così tutte le foto della cartella scorrono nel mosaico
            function cambiaFoto() {
                if (!mosaicoVisibile || fotoMosaico.length <= tessere.length) return;

                const tessera = tessere[prossimaTessera];
                const indiceTessera = prossimaTessera;
                const indiceFoto = prossimaFoto;
                prossimaTessera = (prossimaTessera + 1) % tessere.length;
                prossimaFoto = (prossimaFoto + 1) % fotoMosaico.length;

                const vecchia = tessera.querySelector('img');
                const nuova = new Image();
                nuova.alt = vecchia.alt;
                nuova.className = 'in-dissolvenza';
                nuova.addEventListener('load', () => {
                    tessera.insertBefore(nuova, vecchia.nextSibling);
                    requestAnimationFrame(() => requestAnimationFrame(() => {
                        nuova.classList.remove('in-dissolvenza');
                        vecchia.classList.add('in-dissolvenza');
                    }));
                    setTimeout(() => vecchia.remove(), 1250);
                    fotoCorrente[indiceTessera] = indiceFoto;
                });
                nuova.src = fotoMosaico[indiceFoto];
            }

            if (!riduciMovimento) {
                // La rotazione parte solo quando il mosaico è sullo schermo
                new IntersectionObserver((entries) => {
                    entries.forEach(e => { mosaicoVisibile = e.isIntersecting; });
                }, { threshold: 0.2 }).observe(mosaico);

                setInterval(cambiaFoto, 3800);
            }

            // ---- Lightbox ----
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightboxImg');
            const lightboxContatore = document.getElementById('lightboxContatore');
            let indiceLightbox = 0;

            function mostraFoto(i) {
                indiceLightbox = (i + fotoMosaico.length) % fotoMosaico.length;
                lightboxImg.src = fotoMosaico[indiceLightbox];
                lightboxContatore.textContent = (indiceLightbox + 1) + ' / ' + fotoMosaico.length;
            }

            function apriLightbox(i) {
                mostraFoto(i);
                lightbox.classList.add('aperta');
                document.body.style.overflow = 'hidden';
            }

            function chiudiLightbox() {
                lightbox.classList.remove('aperta');
                document.body.style.overflow = '';
            }

            tessere.forEach((tessera, i) => {
                tessera.addEventListener('click', () => apriLightbox(fotoCorrente[i]));
            });

            lightbox.querySelector('.chiudi').addEventListener('click', chiudiLightbox);
            lightbox.querySelector('.precedente').addEventListener('click', () => mostraFoto(indiceLightbox - 1));
            lightbox.querySelector('.successiva').addEventListener('click', () => mostraFoto(indiceLightbox + 1));
            lightbox.addEventListener('click', (e) => { if (e.target === lightbox) chiudiLightbox(); });

            // Swipe sinistra/destra per cambiare foto (telefoni)
            let toccoX = null;
            lightbox.addEventListener('touchstart', (e) => { toccoX = e.changedTouches[0].clientX; }, { passive: true });
            lightbox.addEventListener('touchend', (e) => {
                if (toccoX === null) return;
                const delta = e.changedTouches[0].clientX - toccoX;
                toccoX = null;
                if (Math.abs(delta) > 45) mostraFoto(indiceLightbox + (delta < 0 ? 1 : -1));
            }, { passive: true });

            document.addEventListener('keydown', (e) => {
                if (!lightbox.classList.contains('aperta')) return;
                if (e.key === 'Escape') chiudiLightbox();
                if (e.key === 'ArrowLeft') mostraFoto(indiceLightbox - 1);
                if (e.key === 'ArrowRight') mostraFoto(indiceLightbox + 1);
            });
        }
    </script>
</body>
</html>
