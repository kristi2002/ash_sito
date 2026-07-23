<?php
// ============================================================
//  A.S.H. Finiture Contract — Di Ahmed Abdelaziz
//  Pagina servizio: Sistemi di Costruzione a Secco — PHP + Bootstrap 5
// ============================================================

$site_name  = 'A.S.H. Finiture Contract';
$tagline    = 'Qualità e Precisione per Ogni Spazio';
$phone1     = '329 6447797';
$phone2     = '338 3386946';
$phone1_raw = '+393296447797';
$phone2_raw = '+393383386946';
$email      = 'ashfiniturecontract@outlook.it';
$address    = 'Via Adigrat 3/A, 62032 Camerino (MC)';

// Dati di questa pagina servizio
$servizio_titolo = 'Sistemi di costruzione a secco';
$servizio_slug   = 'sistemi-a-secco';

// Tutti i servizi (per menu e cross-linking "Altri servizi").
// 'url' => null: pagina di dettaglio non ancora creata, si punta all'ancora in home.
$servizi = [
    [
        'slug'   => 'cartongesso',
        'icona'  => 'bi-bricks',
        'titolo' => 'Cartongesso',
        'url'    => 'cartongesso.php',
        'descrizione' => 'Pareti divisorie, controsoffitti e contropareti su misura.',
    ],
    [
        'slug'   => 'sistemi-a-secco',
        'icona'  => 'bi-layers',
        'titolo' => 'Sistemi a Secco',
        'url'    => 'sistemi-a-secco.php',
        'descrizione' => 'Costruzioni rapide e pulite ad alte prestazioni.',
    ],
    [
        'slug'   => 'rasatura-armata',
        'icona'  => 'bi-shield-check',
        'titolo' => 'Rasatura Armata',
        'url'    => 'rasatura-armata.php',
        'descrizione' => 'Superfici uniformi e resistenti alle crepe.',
    ],
    [
        'slug'   => 'tinteggiatura',
        'icona'  => 'bi-paint-bucket',
        'titolo' => 'Tinteggiatura',
        'url'    => 'tinteggiatura.php',
        'descrizione' => 'Colori a regola d\'arte per interni ed esterni.',
    ],
    [
        'slug'   => 'intonachino',
        'icona'  => 'bi-brush',
        'titolo' => 'Intonachino',
        'url'    => 'intonachino.php',
        'descrizione' => 'Finitura materica per facciate e interni di pregio.',
    ],
    [
        'slug'   => 'carta-da-parati',
        'icona'  => 'bi-flower1',
        'titolo' => 'Carta da Parati',
        'url'    => 'carta-da-parati.php',
        'descrizione' => 'Posa professionale e grafiche personalizzate.',
    ],
];

// Link di un servizio: pagina di dettaglio se esiste, altrimenti ancora in home
function link_servizio($servizio) {
    return $servizio['url'] !== null ? $servizio['url'] : '../index.php#servizio-' . $servizio['slug'];
}

// Foto reali dei cantieri (dalla cartella "photo colage"), per le sezioni della pagina
$foto_cantiere = [];
foreach (['jpg', 'jpeg', 'png', 'webp'] as $estensione) {
    $trovate = glob('../photo colage/*.' . $estensione);
    if ($trovate) {
        $foto_cantiere = array_merge($foto_cantiere, $trovate);
    }
}
$foto_cantiere = array_values(array_unique($foto_cantiere));
sort($foto_cantiere);

// Percorsi pronti per l'HTML (gli spazi nei nomi file vanno codificati)
$foto_cantiere_url = array_map(function ($percorso) {
    return implode('/', array_map('rawurlencode', explode('/', $percorso)));
}, $foto_cantiere);

// Lavorazioni principali (chip nella sezione "Cosa facciamo")
$lavorazioni = [
    ['icona' => 'bi-grid-1x2',         'testo' => 'Pareti divisorie a secco'],
    ['icona' => 'bi-layers',           'testo' => 'Contropareti tecniche'],
    ['icona' => 'bi-thermometer-snow', 'testo' => 'Isolamento termico'],
    ['icona' => 'bi-soundwave',        'testo' => 'Isolamento acustico'],
    ['icona' => 'bi-plug',             'testo' => 'Predisposizione impianti'],
    ['icona' => 'bi-recycle',          'testo' => 'Cantieri puliti e veloci'],
];

// Perché A.S.H.: la nostra firma sulle costruzioni a secco
$motivi = [
    ['icona' => 'bi-stopwatch',        'titolo' => 'Tempi rapidi',           'testo' => 'Posa veloce, senza demolizioni né tempi di asciugatura'],
    ['icona' => 'bi-house-check',      'titolo' => 'Cantiere pulito',        'testo' => 'Lavorazioni a secco: niente malte, polvere ridotta al minimo'],
    ['icona' => 'bi-thermometer-snow', 'titolo' => 'Comfort termo-acustico', 'testo' => 'Isolanti nell\'intercapedine per pareti calde e silenziose'],
    ['icona' => 'bi-patch-check',      'titolo' => 'Sistemi certificati',    'testo' => 'Lastre e strutture posate secondo le schede tecniche'],
];

// Il metodo a secco: quattro fasi, dal rilievo alla finitura
$fasi_ciclo = [
    ['fase' => '01', 'titolo' => 'Rilievo e progetto',    'testo' => 'Misure, tracciamenti e scelta della stratigrafia: lastre, isolanti e struttura si decidono prima di montare.'],
    ['fase' => '02', 'titolo' => 'Struttura metallica',   'testo' => 'Montaggio a piombo di guide e montanti in acciaio zincato: è l\'ossatura che garantisce planarità e solidità.'],
    ['fase' => '03', 'titolo' => 'Impianti e isolamento', 'testo' => 'Passaggio degli impianti nell\'intercapedine e posa dell\'isolante termo-acustico, senza tracce a muro.'],
    ['fase' => '04', 'titolo' => 'Chiusura e finitura',   'testo' => 'Avvitatura delle lastre e stuccatura di giunti e viti: superficie liscia, solida e pronta per la finitura.', 'firma' => true],
];

// Dove interveniamo: contesti tipici, raccontati come card premium con foto della tipologia
$applicazioni = [
    ['icona' => 'bi-house-door',   'titolo' => 'Abitazioni private',    'foto' => '../assets/img/servizi/spazio-abitazioni.jpg',   'testo' => 'Nuove divisioni degli spazi, contropareti isolanti e controsoffitti per rinnovare casa senza demolire.'],
    ['icona' => 'bi-building',     'titolo' => 'Involucro e cappotti',  'foto' => '../assets/img/servizi/spazio-facciate.jpg',     'testo' => 'Sistemi isolanti e contropareti che migliorano l\'efficienza energetica dell\'edificio.'],
    ['icona' => 'bi-droplet-half', 'titolo' => 'Bagni e cucine',        'foto' => '../assets/img/servizi/spazio-bagni-cucine.jpg', 'testo' => 'Lastre idrorepellenti e predisposizione degli impianti per bagni nuovi o riorganizzati.'],
    ['icona' => 'bi-briefcase',    'titolo' => 'Uffici e studi',        'foto' => '../assets/img/servizi/spazio-uffici.jpg',       'testo' => 'Nuovi layout, sale riunioni e correzione acustica con tempi di fermo ridotti al minimo.'],
    ['icona' => 'bi-shop',         'titolo' => 'Negozi e locali',       'foto' => '../assets/img/servizi/spazio-negozi.jpg',       'testo' => 'Allestimenti e ristrutturazioni rapide, anche in orari di chiusura, per non fermare l\'attività.'],
    ['icona' => 'bi-buildings',    'titolo' => 'Vani scala e condomini','foto' => '../assets/img/servizi/spazio-condomini.jpg',    'testo' => 'Controsoffitti e contropareti per le parti comuni, anche con requisiti di reazione al fuoco.'],
];

// FAQ
$faq = [
    [
        'domanda'  => 'Che differenza c\'è tra costruzione a secco e muratura tradizionale?',
        'risposta' => 'La costruzione a secco assembla strutture metalliche, isolanti e lastre senza malte né tempi di asciugatura: il cantiere è più veloce e pulito, i pesi sono ridotti e le pareti raggiungono ottime prestazioni termiche e acustiche. A parità di risultato, i tempi si riducono anche della metà.',
    ],
    [
        'domanda'  => 'Le pareti a secco sono solide? Reggono mensole e pensili?',
        'risposta' => 'Sì. La struttura in acciaio zincato e le lastre certificate danno pareti stabili e durevoli; con tasselli specifici e rinforzi predisposti in fase di montaggio si appendono senza problemi pensili, TV e mensole. Basta segnalarci in anticipo dove serviranno.',
    ],
    [
        'domanda'  => 'Quanto migliora l\'isolamento acustico con una controparete a secco?',
        'risposta' => 'Una controparete con lana minerale nell\'intercapedine migliora sensibilmente l\'abbattimento acustico rispetto alla parete esistente. Il risultato dipende dalla stratigrafia scelta: durante il sopralluogo la calibriamo sul problema reale, che siano voci, traffico o rumori di impianti.',
    ],
    [
        'domanda'  => 'Si può lavorare a secco in una casa abitata?',
        'risposta' => 'Sì, è la situazione ideale per i sistemi a secco: niente demolizioni, polvere contenuta e ambienti lavorati stanza per stanza. Proteggiamo pavimenti e mobili e riconsegniamo gli spazi puliti a fine giornata.',
    ],
];

// Dati strutturati JSON-LD: Service + FAQPage + BreadcrumbList
$json_ld = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        'name'        => 'Sistemi di Costruzione a Secco',
        'serviceType' => 'Sistemi a secco: pareti divisorie, contropareti isolanti, controsoffitti e isolamento termo-acustico',
        'description' => 'Costruzioni a secco per pareti, contropareti isolanti e controsoffitti con comfort termo-acustico a Camerino (MC) e provincia di Macerata.',
        'areaServed'  => ['Camerino', 'Provincia di Macerata', 'Marche'],
        'provider'    => [
            '@type'     => 'LocalBusiness',
            'name'      => $site_name,
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
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(function ($f) {
            return [
                '@type'          => 'Question',
                'name'           => $f['domanda'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['risposta']],
            ];
        }, $faq),
    ],
    [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',        'item' => '../index.php'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Servizi',     'item' => '../index.php#servizi'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Sistemi a Secco'],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Sistemi di Costruzione a Secco a Camerino e Macerata | A.S.H. Finiture Contract</title>
    <meta name="description" content="Sistemi di costruzione a secco: pareti divisorie, contropareti isolanti, controsoffitti e comfort termo-acustico. Sopralluogo e preventivo gratuiti a Camerino (MC) e provincia.">

    <!-- Bootstrap 5 + Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Fonts: Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="../assets/img/logo-mark.png">

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

        /* ================= HERO PAGINA SERVIZIO ================= */
        .hero-servizio {
            min-height: 68vh;
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
            background: url('../assets/img/hero.jpg') center center / cover no-repeat;
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

        /* ================= COSA FACCIAMO ================= */
        /* Cosa facciamo + Perché sceglierci: un unico racconto su fondo bianco,
           con foto incorniciate allo stesso modo e badge flottanti speculari */
        #cosa-facciamo { padding: 5.5rem 0 3rem; background: linear-gradient(180deg, #fdfbf5 0%, #faf7ef 100%); }

        #cosa-facciamo p { line-height: 1.85; }

        /* Chip delle lavorazioni principali */
        .chips-lavorazioni { display: flex; flex-wrap: wrap; gap: .6rem; }

        .chip-lavorazione {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: #fff;
            border: 1px solid #ecdfc0;
            border-radius: 9px;
            padding: .55rem 1.05rem;
            font-size: .82rem;
            font-weight: 600;
            color: var(--scuro);
            transition: background .25s ease, border-color .25s ease, transform .25s ease;
        }

        .chip-lavorazione i { color: var(--oro-scuro); }

        .chip-lavorazione:hover {
            background: var(--oro-chiaro);
            border-color: var(--oro);
            transform: translateY(-2px);
        }

        /* Composizione fotografica: foto grande + foto piccola sovrapposta + badge */
        .composizione-foto {
            position: relative;
            margin-bottom: 2.6rem;
        }

        .composizione-foto .foto-principale {
            display: block;
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            border-radius: 22px;
            border: 1px solid #eee6d4;
            box-shadow: 0 22px 50px rgba(46, 59, 66, .14);
        }

        .composizione-foto .foto-secondaria {
            position: absolute;
            left: -4%;
            bottom: -2.4rem;
            width: 44%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 18px;
            border: 6px solid #fff;
            box-shadow: 0 18px 40px rgba(46, 59, 66, .22);
        }

        .badge-qualita {
            position: absolute;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(255, 255, 255, .94);
            color: var(--oro-testo);
            font-weight: 700;
            font-size: .78rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: .55rem 1.1rem;
            border-radius: 50rem;
            box-shadow: 0 10px 24px rgba(46, 59, 66, .18);
            backdrop-filter: blur(4px);
        }

        .composizione-foto .badge-qualita { top: 18px; right: 18px; }

        .mini-mosaico-wrap { position: relative; }

        .mini-mosaico-wrap .badge-qualita { top: 18px; left: 18px; }

        @media (max-width: 991.98px) {
            .composizione-foto .foto-secondaria { left: 0; }
        }

        /* ================= PERCHÉ A.S.H. ================= */
        #perche-noi { padding: 3rem 0 5.5rem; background: #faf7ef; }

        /* Bordo oro in alto (come le sezioni della homepage) */
        #ciclo::before,
        #applicazioni::before,
        #cta-finale::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--oro-scuro) 0%, var(--oro) 25%, #e8cc82 50%, var(--oro) 75%, var(--oro-scuro) 100%);
        }

        /* Mini mosaico di foto reali dei cantieri, con colonne sfalsate */
        .mini-mosaico {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            padding-bottom: 1.6rem;
        }

        /* Stessa cornice bianca e stessa ombra della composizione fotografica sopra */
        .mini-mosaico figure {
            margin: 0;
            overflow: hidden;
            border-radius: 18px;
            border: 6px solid #fff;
            background: #fff;
            box-shadow: 0 18px 40px rgba(46, 59, 66, .14);
            transition: border-color .3s ease, box-shadow .3s ease, transform .3s ease;
        }

        .mini-mosaico figure:nth-child(even) { transform: translateY(1.6rem); }

        .mini-mosaico figure:hover {
            border-color: var(--oro);
            box-shadow: 0 14px 32px rgba(169, 130, 47, .28);
        }

        .mini-mosaico img {
            display: block;
            width: 100%;
            aspect-ratio: 4 / 5;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .mini-mosaico figure:hover img { transform: scale(1.06); }

        /* Griglia dei motivi: tessere calde oro/crema, dal taglio premium */
        .card-motivo {
            position: relative;
            background: #fff;
            border: 1px solid #eee6d4;
            border-radius: 16px;
            padding: 1.5rem 1.3rem 1.3rem;
            height: 100%;
            overflow: hidden;
            box-shadow: 0 10px 26px rgba(169, 130, 47, .10);
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        /* Filo oro sempre visibile sul bordo alto */
        .card-motivo::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--oro-scuro), var(--oro) 45%, #e8cc82 70%, var(--oro-scuro));
        }

        /* Bagliore dorato nell'angolo in alto a destra (leggero, su fondo bianco) */
        .card-motivo::after {
            content: "";
            position: absolute;
            top: -46px;
            right: -46px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201, 162, 75, .10), transparent 70%);
            transition: transform .4s ease;
        }

        .card-motivo:hover {
            transform: translateY(-5px);
            border-color: var(--oro);
            box-shadow: 0 18px 40px rgba(169, 130, 47, .25);
        }

        .card-motivo:hover::after { transform: scale(1.4); }

        .card-motivo .icona-motivo {
            position: relative;
            z-index: 1;
            width: 50px;
            height: 50px;
            margin-bottom: .9rem;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            background: linear-gradient(135deg, #d9b866, var(--oro-scuro));
            box-shadow: 0 8px 18px rgba(169, 130, 47, .35);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .card-motivo:hover .icona-motivo {
            transform: rotate(-6deg) scale(1.06);
            box-shadow: 0 12px 24px rgba(169, 130, 47, .45);
        }

        .card-motivo h5 {
            font-size: .92rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: .35rem;
        }

        .card-motivo p {
            margin: 0;
            font-size: .82rem;
            line-height: 1.6;
        }

        /* ================= CICLO DI TINTEGGIATURA IN 4 FASI ================= */
        /* Sezione chiara premium, in linea con il resto della pagina */
        #ciclo {
            padding: 5.5rem 0;
            background: linear-gradient(180deg, #f4edda 0%, #f9f4e8 100%);
            position: relative;
            overflow: hidden;
        }

        /* Bagliore dorato di fondo */
        #ciclo .bagliore {
            position: absolute;
            top: -180px;
            right: -140px;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201, 162, 75, .16), transparent 65%);
            pointer-events: none;
        }

        .card-fase {
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            background: linear-gradient(160deg, #fffefb 0%, #fdf8ec 100%);
            border: 1px solid #e6d5a8;
            border-radius: 18px;
            padding: 1.8rem 1.5rem 1.5rem;
            box-shadow: 0 12px 30px rgba(169, 130, 47, .10);
            transition: transform .3s ease, background .3s ease, border-color .3s ease, box-shadow .3s ease;
        }

        .card-fase:hover {
            transform: translateY(-6px);
            border-color: var(--oro);
            box-shadow: 0 20px 44px rgba(169, 130, 47, .22);
        }

        /* Numero della fase in oro sfumato */
        .card-fase .fase {
            font-size: 2.1rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: .8rem;
            background: linear-gradient(135deg, var(--oro), var(--oro-scuro));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .card-fase h5 {
            color: var(--scuro);
            font-size: .95rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: .5rem;
        }

        .card-fase p {
            font-size: .85rem;
            line-height: 1.65;
            margin: 0 0 1.2rem;
        }

        /* Barra di avanzamento: cresce dalla fase 01 alla 04 */
        .card-fase .barra-fase {
            margin-top: auto;
            height: 4px;
            border-radius: 2px;
            background: rgba(169, 130, 47, .15);
            overflow: hidden;
        }

        .card-fase .barra-fase span {
            display: block;
            height: 100%;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--oro-scuro), var(--oro));
        }

        /* Fase 04: la card firma, con badge e bordo oro pieno */
        .card-fase.firma {
            background: linear-gradient(160deg, #fbf1d9 0%, #fdf8ec 100%);
            border-color: var(--oro);
        }

        .badge-firma {
            position: absolute;
            top: -12px;
            right: 16px;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: linear-gradient(135deg, #d9b866, var(--oro-scuro));
            color: #fff;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            padding: .35rem .8rem;
            border-radius: 50rem;
            box-shadow: 0 8px 18px rgba(169, 130, 47, .35);
        }

        /* Colonna fotografica del ciclo: il cantiere accanto alle 4 fasi */
        .foto-ciclo {
            position: relative;
            height: 100%;
            min-height: 420px;
            border-radius: 22px;
            overflow: hidden;
            border: 1px solid #e6d5a8;
            box-shadow: 0 22px 50px rgba(169, 130, 47, .18);
        }

        .foto-ciclo img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .foto-ciclo .velo {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(24, 30, 34, .74) 100%);
        }

        .foto-ciclo .badge-qualita { top: 18px; left: 18px; }

        .foto-ciclo .didascalia {
            position: absolute;
            left: 1.4rem;
            right: 1.4rem;
            bottom: 1.2rem;
            color: #fff;
        }

        .foto-ciclo .didascalia h5 {
            color: #fff;
            font-size: .95rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: .3rem;
        }

        .foto-ciclo .didascalia p {
            margin: 0;
            font-size: .82rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, .85);
        }

        @media (max-width: 991.98px) {
            .foto-ciclo { min-height: 300px; }
        }

        /* ================= DOVE INTERVENIAMO ================= */
        /* Sezione premium su fondo avorio: card numerate con filo oro */
        #applicazioni {
            padding: 5.5rem 0 6rem;
            background: linear-gradient(180deg, #f4edda 0%, #f9f4e8 100%);
            position: relative;
            overflow: hidden;
        }

        /* Anello decorativo oro, come nelle altre sezioni di pregio */
        #applicazioni::after {
            content: "";
            position: absolute;
            width: 340px;
            height: 340px;
            border: 36px solid rgba(201, 162, 75, .10);
            border-radius: 50%;
            top: -140px;
            right: -120px;
            pointer-events: none;
        }

        #applicazioni .container { position: relative; z-index: 1; }

        .card-applicazione {
            position: relative;
            height: 100%;
            background: linear-gradient(160deg, #fffefb 0%, #fdf8ec 100%);
            border: 1px solid #e6d5a8;
            border-radius: 18px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(169, 130, 47, .10);
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        /* Filo oro sul bordo alto, firma delle card premium */
        .card-applicazione::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            z-index: 2;
            background: linear-gradient(90deg, var(--oro-scuro), var(--oro) 45%, #e8cc82 70%, var(--oro-scuro));
        }

        .card-applicazione:hover {
            transform: translateY(-6px);
            border-color: var(--oro);
            box-shadow: 0 20px 44px rgba(169, 130, 47, .22);
        }

        /* Foto della tipologia di spazio, in testa alla card */
        .card-applicazione .foto-applicazione {
            aspect-ratio: 16 / 10;
            overflow: hidden;
        }

        .card-applicazione .foto-applicazione img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .card-applicazione:hover .foto-applicazione img { transform: scale(1.06); }

        .card-applicazione .corpo-applicazione {
            position: relative;
            padding: 0 1.6rem 1.7rem;
        }

        .card-applicazione .icona-applicazione {
            width: 54px;
            height: 54px;
            margin-top: -27px; /* a cavallo tra foto e testo */
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
            border: 3px solid #fffefb;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff;
            background: linear-gradient(135deg, #d9b866, var(--oro-scuro));
            box-shadow: 0 8px 18px rgba(169, 130, 47, .35);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .card-applicazione:hover .icona-applicazione {
            transform: rotate(-6deg) scale(1.06);
            box-shadow: 0 12px 24px rgba(169, 130, 47, .45);
        }

        .card-applicazione h5 {
            font-size: .95rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: .45rem;
        }

        .card-applicazione p {
            margin: 0;
            font-size: .85rem;
            line-height: 1.7;
        }

        /* ================= FAQ ================= */
        #faq { padding: 5.5rem 0; background: linear-gradient(180deg, #faf6ec 0%, #faf7ef 100%); }

        .accordion-faq .accordion-item {
            border: 1px solid #eee6d4;
            border-radius: 14px !important;
            margin-bottom: 1rem;
            overflow: hidden;
            background: #fff;
        }

        .accordion-faq .accordion-button {
            font-weight: 700;
            color: var(--scuro);
            font-size: .98rem;
            padding: 1.15rem 1.4rem;
            background: #fff;
        }

        .accordion-faq .accordion-button:not(.collapsed) {
            background: var(--oro-chiaro);
            color: var(--oro-testo);
            box-shadow: none;
        }

        .accordion-faq .accordion-button:focus {
            box-shadow: 0 0 0 .2rem rgba(201, 162, 75, .25);
        }

        .accordion-faq .accordion-button::after {
            filter: sepia(1) saturate(3) hue-rotate(-10deg);
        }

        .accordion-faq .accordion-body {
            padding: 1.2rem 1.4rem;
            line-height: 1.8;
        }

        /* ================= CTA FINALE ================= */
        #cta-finale {
            background: linear-gradient(120deg, #6f541e 0%, #7c5f20 55%, #8a6a26 100%);
            color: #fff;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
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

        #cta-finale .contatto-cta {
            display: flex;
            align-items: center;
            gap: .9rem;
            margin-bottom: .9rem;
        }

        #cta-finale .contatto-cta i {
            flex-shrink: 0;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            background: rgba(255, 255, 255, .14);
            color: #ecd9a8;
        }

        #cta-finale .contatto-cta a,
        #cta-finale .contatto-cta span {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        #cta-finale .contatto-cta a:hover { color: #ecd9a8; }

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
            #cosa-facciamo { padding: 3.8rem 0 2.4rem; }
            #perche-noi { padding: 2.4rem 0 3.8rem; }
            #ciclo, #applicazioni, #faq { padding: 3.8rem 0; }
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
            <a class="navbar-brand" href="../index.php">
                <img src="../assets/img/logo-mark.png" alt="Logo <?php echo $site_name; ?>">
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
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="../index.php#servizi" id="menuServizi" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Servizi
                        </a>
                        <ul class="dropdown-menu menu-servizi" aria-labelledby="menuServizi">
                            <li>
                                <a class="dropdown-item" href="../index.php#servizi">
                                    <i class="bi bi-grid-3x3-gap"></i> Tutti i Servizi
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <?php foreach ($servizi as $servizio): ?>
                            <li>
                                <a class="dropdown-item<?php echo $servizio['slug'] === $servizio_slug ? ' attivo' : ''; ?>" href="<?php echo link_servizio($servizio); ?>">
                                    <i class="bi <?php echo $servizio['icona']; ?>"></i> <?php echo $servizio['titolo']; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../index.php#chi-siamo">Chi Siamo</a></li>
                    <li class="nav-item"><a class="nav-link" href="../realizzazioni.php">Realizzazioni</a></li>
                    <li class="nav-item"><a class="nav-link" href="../contatti.php">Contatti</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-oro btn-sm px-3 py-2" href="../preventivo.php">
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
                            <li><a href="../index.php"><i class="bi bi-house-door"></i> Home</a></li>
                            <li class="separatore" aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
                            <li><a href="../index.php#servizi">Servizi</a></li>
                            <li class="separatore" aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
                            <li class="corrente" aria-current="page">Sistemi a Secco</li>
                        </ol>
                    </nav>
                    <span class="hero-badge fade-up delay-1 mt-3">
                        <i class="bi bi-layers"></i> Il nostro servizio
                    </span>
                    <h1 class="mt-3 fade-up delay-1">
                        Sistemi <span class="gold">a secco</span>
                    </h1>
                    <p class="lead mt-3 fade-up delay-2">
                        Pareti, contropareti e controsoffitti montati a secco: cantieri rapidi e puliti, comfort termico e acustico che si sente.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-4 fade-up delay-3">
                        <a href="#cta-finale" class="btn btn-oro">
                            <i class="bi bi-envelope-paper me-2"></i>Richiedi un preventivo
                        </a>
                        <a href="tel:<?php echo $phone1_raw; ?>" class="btn btn-outline-scuro">
                            <i class="bi bi-telephone me-2"></i><?php echo $phone1; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ================= COSA FACCIAMO ================= -->
    <section id="cosa-facciamo">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 reveal">
                    <span class="hero-badge"><i class="bi bi-stars"></i> Cosa facciamo</span>
                    <h2 class="section-title mt-3">Costruire meglio,<br><span class="text-oro">senza demolire</span></h2>
                    <div class="title-underline a-sinistra"></div>
                    <p class="mt-4">
                        Trasformiamo gli spazi con <strong>strutture a secco leggere e certificate</strong>:
                        niente malte, niente attese di asciugatura, <strong>cantieri rapidi e puliti</strong>.
                        Ogni progetto parte da un sopralluogo gratuito con proposta su misura.
                    </p>
                    <div class="chips-lavorazioni mt-4">
                        <?php foreach ($lavorazioni as $lavorazione): ?>
                        <span class="chip-lavorazione">
                            <i class="bi <?php echo $lavorazione['icona']; ?>" aria-hidden="true"></i>
                            <?php echo $lavorazione['testo']; ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-6 reveal" style="transition-delay:.15s">
                    <div class="composizione-foto">
                        <img class="foto-principale"
                             src="<?php echo $foto_cantiere_url[12] ?? '../assets/img/card-servizio-bg.jpg'; ?>"
                             alt="Parete realizzata con sistema a secco da A.S.H. Finiture Contract"
                             loading="lazy">
                        <?php if (isset($foto_cantiere_url[13])): ?>
                        <img class="foto-secondaria"
                             src="<?php echo $foto_cantiere_url[13]; ?>"
                             alt="Dettaglio di una struttura a secco in un cantiere A.S.H."
                             loading="lazy">
                        <?php endif; ?>
                        <span class="badge-qualita">
                            <i class="bi bi-patch-check-fill" aria-hidden="true"></i> Lavori a regola d'arte
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= PERCHÉ A.S.H. ================= -->
    <section id="perche-noi">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 reveal">
                    <div class="mini-mosaico-wrap">
                        <span class="badge-qualita">
                            <i class="bi bi-camera-fill" aria-hidden="true"></i> Dai nostri cantieri
                        </span>
                        <div class="mini-mosaico">
                            <?php foreach (array_slice($foto_cantiere_url, 14, 4) as $i => $src): ?>
                            <figure>
                                <img src="<?php echo $src; ?>"
                                     alt="Costruzione a secco realizzata da A.S.H. Finiture Contract"
                                     loading="lazy">
                            </figure>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 reveal" style="transition-delay:.15s">
                    <span class="hero-badge"><i class="bi bi-award"></i> Perché sceglierci</span>
                    <h2 class="section-title mt-3">La nostra firma,<br><span class="text-oro">in ogni struttura</span></h2>
                    <div class="title-underline a-sinistra"></div>
                    <p class="mt-4">
                        Foto dai nostri cantieri: la qualità si vede, non si racconta.
                    </p>
                    <div class="row g-3 mt-1">
                        <?php foreach ($motivi as $motivo): ?>
                        <div class="col-sm-6">
                            <div class="card-motivo">
                                <span class="icona-motivo"><i class="bi <?php echo $motivo['icona']; ?>" aria-hidden="true"></i></span>
                                <h5><?php echo $motivo['titolo']; ?></h5>
                                <p><?php echo $motivo['testo']; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="../realizzazioni.php" class="btn btn-oro mt-4">
                        <i class="bi bi-images me-2"></i>Guarda le nostre realizzazioni
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= IL METODO A SECCO IN 4 FASI ================= -->
    <section id="ciclo">
        <div class="bagliore" aria-hidden="true"></div>
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-gem"></i> Metodo professionale</span>
                <h2 class="section-title mt-3">Il nostro metodo <span class="text-oro">in 4 fasi</span></h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 660px;">
                    Un sistema a secco rende quanto la cura con cui viene montato.
                    Ogni intervento segue un metodo preciso in quattro fasi &mdash;
                    ed è nella chiusura e nella stuccatura finale che si vede la differenza.
                </p>
            </div>
            <div class="row g-4 pt-2 align-items-stretch">
                <div class="col-lg-5 reveal">
                    <div class="foto-ciclo">
                        <img src="<?php echo $foto_cantiere_url[18] ?? '../assets/img/servizi/spazio-abitazioni.jpg'; ?>"
                             alt="Montaggio di una struttura a secco in un cantiere A.S.H."
                             loading="lazy">
                        <div class="velo" aria-hidden="true"></div>
                        <span class="badge-qualita">
                            <i class="bi bi-layers" aria-hidden="true"></i> Il metodo in cantiere
                        </span>
                        <div class="didascalia">
                            <h5>Strato dopo strato</h5>
                            <p>Dalla struttura metallica alla lastra finale: prestazioni e planarità nascono da un montaggio rispettato.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4 h-100">
                        <?php foreach ($fasi_ciclo as $i => $fs): ?>
                        <div class="col-md-6 reveal" style="transition-delay: <?php echo $i * 0.12; ?>s">
                            <div class="card-fase<?php echo !empty($fs['firma']) ? ' firma' : ''; ?>">
                                <?php if (!empty($fs['firma'])): ?>
                                <span class="badge-firma"><i class="bi bi-star-fill" aria-hidden="true"></i> La nostra firma</span>
                                <?php endif; ?>
                                <span class="fase"><?php echo $fs['fase']; ?></span>
                                <h5><?php echo $fs['titolo']; ?></h5>
                                <p><?php echo $fs['testo']; ?></p>
                                <div class="barra-fase"><span style="width: <?php echo ($i + 1) * 25; ?>%"></span></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= DOVE INTERVENIAMO ================= -->
    <section id="applicazioni">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-geo-fill"></i> Dove interveniamo</span>
                <h2 class="section-title mt-3">Ogni spazio, <span class="text-oro">la sua soluzione</span></h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 640px;">
                    Dalla singola stanza all'intero edificio: questi sono i contesti
                    in cui i sistemi a secco danno il meglio.
                </p>
            </div>
            <div class="row g-4">
                <?php foreach ($applicazioni as $i => $applicazione): ?>
                <div class="col-md-6 col-lg-4 reveal" style="transition-delay: <?php echo ($i % 3) * 0.12; ?>s">
                    <div class="card-applicazione">
                        <div class="foto-applicazione">
                            <img src="<?php echo $applicazione['foto']; ?>"
                                 alt="<?php echo $applicazione['titolo']; ?> — sistemi a secco A.S.H. Finiture Contract"
                                 loading="lazy">
                        </div>
                        <div class="corpo-applicazione">
                            <span class="icona-applicazione"><i class="bi <?php echo $applicazione['icona']; ?>" aria-hidden="true"></i></span>
                            <h5><?php echo $applicazione['titolo']; ?></h5>
                            <p><?php echo $applicazione['testo']; ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-5 reveal">
                <a href="#cta-finale" class="btn btn-oro">
                    <i class="bi bi-envelope-paper me-2"></i>Richiedi un preventivo
                </a>
            </div>
        </div>
    </section>

    <!-- ================= CTA FINALE ================= -->
    <section id="cta-finale">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7 reveal">
                    <h2 class="mb-2">Hai un progetto da realizzare a secco?</h2>
                    <p class="fs-5 mb-4" style="color:rgba(255,255,255,.9)">
                        <em>"<?php echo $tagline; ?>"</em> — richiedi subito un
                        <strong>preventivo gratuito</strong> e senza impegno per il tuo progetto a secco.
                    </p>
                    <div class="contatto-cta">
                        <i class="bi bi-telephone-fill" aria-hidden="true"></i>
                        <span>
                            <a href="tel:<?php echo $phone1_raw; ?>"><?php echo $phone1; ?></a>
                            &nbsp;/&nbsp;
                            <a href="tel:<?php echo $phone2_raw; ?>"><?php echo $phone2; ?></a>
                        </span>
                    </div>
                    <div class="contatto-cta">
                        <i class="bi bi-envelope-fill" aria-hidden="true"></i>
                        <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                    </div>
                    <div class="contatto-cta mb-0">
                        <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
                        <span>Camerino, provincia di Macerata e Marche</span>
                    </div>
                </div>
                <div class="col-lg-5 text-lg-end reveal" style="transition-delay:.15s">
                    <a href="tel:<?php echo $phone1_raw; ?>" class="btn btn-bianco mb-3 mb-lg-0 me-lg-2">
                        <i class="bi bi-telephone-outbound me-2"></i>Chiama Ora
                    </a>
                    <a href="https://wa.me/393296447797" target="_blank" rel="noopener" class="btn btn-bianco">
                        <i class="bi bi-whatsapp me-2"></i>WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FAQ ================= -->
    <section id="faq">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-question-circle"></i> Domande frequenti</span>
                <h2 class="section-title mt-3">FAQ sui Sistemi a Secco</h2>
                <div class="title-underline"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9 reveal">
                    <div class="accordion accordion-faq" id="accordionFaq">
                        <?php foreach ($faq as $i => $f): ?>
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="faqTitolo<?php echo $i; ?>">
                                <button class="accordion-button<?php echo $i > 0 ? ' collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faqRisposta<?php echo $i; ?>" aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-controls="faqRisposta<?php echo $i; ?>">
                                    <?php echo $f['domanda']; ?>
                                </button>
                            </h3>
                            <div id="faqRisposta<?php echo $i; ?>" class="accordion-collapse collapse<?php echo $i === 0 ? ' show' : ''; ?>" aria-labelledby="faqTitolo<?php echo $i; ?>" data-bs-parent="#accordionFaq">
                                <div class="accordion-body"><?php echo $f['risposta']; ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
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
                        <img src="../assets/img/logo-mark.png" alt="Logo A.S.H.">
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
                        <li><a href="../index.php"><i class="bi bi-chevron-right small"></i> Home</a></li>
                        <li><a href="../index.php#servizi"><i class="bi bi-chevron-right small"></i> Servizi</a></li>
                        <li><a href="../index.php#chi-siamo"><i class="bi bi-chevron-right small"></i> Chi Siamo</a></li>
                        <li><a href="../realizzazioni.php"><i class="bi bi-chevron-right small"></i> Realizzazioni</a></li>
                        <li><a href="../contatti.php"><i class="bi bi-chevron-right small"></i> Contatti</a></li>
                        <li><a href="../preventivo.php"><i class="bi bi-chevron-right small"></i> Richiedi Preventivo</a></li>
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
