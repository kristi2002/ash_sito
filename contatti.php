<?php
// ============================================================
//  A.S.H. Finiture Contract — Di Ahmed Abdelaziz
//  Pagina Contatti — PHP + Bootstrap 5
// ============================================================

$site_name  = 'A.S.H. Finiture Contract';
$tagline    = 'Qualità e Precisione per Ogni Spazio';
$phone1     = '329 6447797';
$phone2     = '338 3386946';
$phone1_raw = '+393296447797';
$phone2_raw = '+393383386946';
$email      = 'ashfiniturecontract@outlook.it';
$address    = 'Via Adigrat 3/A, 62032 Camerino (MC)';

// Tutti i servizi (per menu). 'url' => null: pagina non ancora creata.
$servizi = [
    [
        'slug'   => 'cartongesso',
        'icona'  => 'bi-bricks',
        'titolo' => 'Cartongesso',
        'url'    => 'servizi/cartongesso.php',
        'descrizione' => 'Pareti divisorie, controsoffitti e contropareti su misura.',
    ],
    [
        'slug'   => 'sistemi-a-secco',
        'icona'  => 'bi-layers',
        'titolo' => 'Sistemi a Secco',
        'url'    => 'servizi/sistemi-a-secco.php',
        'descrizione' => 'Costruzioni rapide e pulite ad alte prestazioni.',
    ],
    [
        'slug'   => 'rasatura-armata',
        'icona'  => 'bi-shield-check',
        'titolo' => 'Rasatura Armata',
        'url'    => 'servizi/rasatura-armata.php',
        'descrizione' => 'Superfici uniformi e resistenti alle crepe.',
    ],
    [
        'slug'   => 'tinteggiatura',
        'icona'  => 'bi-paint-bucket',
        'titolo' => 'Tinteggiatura',
        'url'    => 'servizi/tinteggiatura.php',
        'descrizione' => 'Colori a regola d\'arte per interni ed esterni.',
    ],
    [
        'slug'   => 'intonachino',
        'icona'  => 'bi-brush',
        'titolo' => 'Intonachino',
        'url'    => 'servizi/intonachino.php',
        'descrizione' => 'Finitura materica per facciate e interni di pregio.',
    ],
    [
        'slug'   => 'carta-da-parati',
        'icona'  => 'bi-flower1',
        'titolo' => 'Carta da Parati',
        'url'    => 'servizi/carta-da-parati.php',
        'descrizione' => 'Posa professionale e grafiche personalizzate.',
    ],
];

// Link di un servizio: pagina di dettaglio se esiste, altrimenti ancora in home
function link_servizio($servizio) {
    return $servizio['url'] !== null ? $servizio['url'] : 'index.php#servizio-' . $servizio['slug'];
}

// ============================================================
//  GESTIONE INVIO MODULO CONTATTI
// ============================================================
$invio_ok         = false;
$conferma_inviata = false;
$errori           = [];
$dati = [
    'nome'      => '',
    'email'     => '',
    'telefono'  => '',
    'messaggio' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot anti-spam: campo invisibile che gli umani lasciano vuoto
    if (trim($_POST['azienda'] ?? '') !== '') {
        // Bot: fingiamo che sia andata a buon fine, senza inviare nulla
        $invio_ok = true;
    } else {
        foreach ($dati as $campo => $ignora) {
            $dati[$campo] = trim($_POST[$campo] ?? '');
        }

        // Validazione
        if ($dati['nome'] === '') {
            $errori[] = 'Inserisci il tuo nome.';
        }
        if ($dati['email'] === '') {
            $errori[] = 'Inserisci la tua email: ci serve per risponderti.';
        } elseif (!filter_var($dati['email'], FILTER_VALIDATE_EMAIL)) {
            $errori[] = 'L\'indirizzo email inserito non è valido.';
        }
        if ($dati['messaggio'] === '') {
            $errori[] = 'Scrivi il tuo messaggio.';
        }
        if (empty($_POST['privacy'])) {
            $errori[] = 'Per inviare il messaggio devi acconsentire al trattamento dei dati.';
        }

        if (empty($errori)) {
            require_once __DIR__ . '/includes/mailer.php';
            require_once __DIR__ . '/includes/email_template.php';

            $e = function ($testo) { return htmlspecialchars($testo, ENT_QUOTES, 'UTF-8'); };

            // ---- Email di notifica per l'azienda (template brand) ----
            $dati_email = [
                'Nome'     => $e($dati['nome']),
                'Email'    => '<a href="mailto:' . $e($dati['email']) . '" style="color:#7c5f20; font-weight:bold; text-decoration:none;">' . $e($dati['email']) . '</a>',
                'Telefono' => $dati['telefono'] !== ''
                    ? '<a href="tel:' . $e(preg_replace('/[^0-9+]/', '', $dati['telefono'])) . '" style="color:#7c5f20; font-weight:bold; text-decoration:none;">' . $e($dati['telefono']) . '</a>'
                    : '',
            ];

            $corpo = email_notifica_richiesta('contatto', $dati_email, nl2br($e($dati['messaggio'])));

            $risultato = send_email(
                $email,
                null,
                'Nuovo messaggio dal sito — ' . $dati['nome'],
                $corpo,
                true,
                [],
                [
                    'immagini'   => email_logo_immagini(),
                    // Rispondendo alla notifica si scrive direttamente al cliente
                    'rispondi_a' => ['email' => $dati['email'], 'nome' => $dati['nome']],
                ]
            );

            if ($risultato['success']) {
                $invio_ok = true;

                // ---- Email di conferma al cliente. Un eventuale errore qui
                // non blocca l'esito: il messaggio è comunque arrivato.
                $conferma = email_conferma_richiesta(
                    $dati['nome'],
                    'contatto',
                    ['Telefono' => $e($dati['telefono'])],
                    nl2br($e($dati['messaggio']))
                );
                $esito_conferma = send_email(
                    $dati['email'],
                    null,
                    'Abbiamo ricevuto il tuo messaggio — ' . $site_name,
                    $conferma,
                    true,
                    [],
                    ['immagini' => email_logo_immagini()]
                );
                $conferma_inviata = $esito_conferma['success'];
                if (!$conferma_inviata) {
                    error_log('[contatti] Email di conferma non inviata a ' . $dati['email'] . ': ' . $esito_conferma['error']);
                }

                // Svuota il modulo dopo l'invio riuscito
                foreach ($dati as $campo => $ignora) {
                    $dati[$campo] = '';
                }
            } else {
                $errori[] = 'Non siamo riusciti a inviare il messaggio. Riprova tra qualche minuto oppure chiamaci al <a href="tel:' . $phone1_raw . '">' . $phone1 . '</a>.';
            }
        }
    }
}

// Canali di contatto: le card principali della pagina
$canali = [
    [
        'icona'  => 'bi-telephone-fill',
        'titolo' => 'Telefono',
        'testo'  => 'Rispondiamo dal lunedì al sabato, anche per un semplice consiglio.',
        'righe'  => [
            ['href' => 'tel:' . $phone1_raw, 'testo' => $phone1],
            ['href' => 'tel:' . $phone2_raw, 'testo' => $phone2],
        ],
    ],
    [
        'icona'  => 'bi-whatsapp',
        'titolo' => 'WhatsApp',
        'testo'  => 'Inviaci foto degli ambienti: è il modo più rapido per un primo parere.',
        'righe'  => [
            ['href' => 'https://wa.me/393296447797', 'testo' => 'Scrivici su WhatsApp', 'esterno' => true],
        ],
    ],
    [
        'icona'  => 'bi-envelope-fill',
        'titolo' => 'Email',
        'testo'  => 'Per richieste dettagliate, capitolati e documentazione tecnica.',
        'righe'  => [
            ['href' => 'mailto:' . $email, 'testo' => $email],
            ['href' => '#scrivici', 'testo' => 'Oppure usa il modulo qui sotto'],
        ],
    ],
    [
        'icona'  => 'bi-geo-alt-fill',
        'titolo' => 'Sede Legale',
        'testo'  => 'Operiamo a Camerino, in provincia di Macerata e in tutte le Marche.',
        'righe'  => [
            ['href' => null, 'testo' => $address],
        ],
    ],
];

// Orari indicativi di reperibilità
$orari = [
    ['giorni' => 'Lunedì — Venerdì', 'ore' => '08:00 – 18:00'],
    ['giorni' => 'Sabato',           'ore' => '08:00 – 13:00'],
    ['giorni' => 'Domenica',         'ore' => 'Chiuso'],
];

// Dati strutturati JSON-LD: ContactPage + LocalBusiness + BreadcrumbList
$json_ld = [
    [
        '@context'   => 'https://schema.org',
        '@type'      => 'ContactPage',
        'name'       => 'Contatti — ' . $site_name,
        'description'=> 'Contatta A.S.H. Finiture Contract: telefono, WhatsApp, email e sede a Camerino (MC).',
        'mainEntity' => [
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
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'index.php'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Contatti'],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Contatti | A.S.H. Finiture Contract — Camerino (MC)</title>
    <meta name="description" content="Contatta A.S.H. Finiture Contract: telefono, WhatsApp ed email per finiture edili a Camerino (MC) e provincia di Macerata. Sopralluogo e preventivo gratuiti.">

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

        /* ================= CANALI DI CONTATTO ================= */
        #canali { padding: 5.5rem 0 4.5rem; background: linear-gradient(180deg, #fdfbf5 0%, #faf7ef 100%); }

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
        .card-contatto > i {
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

        .card-contatto:hover > i {
            background: linear-gradient(135deg, var(--oro), var(--oro-scuro));
            color: #fff;
            transform: rotate(-6deg) scale(1.06);
        }

        .card-contatto a { color: var(--testo); text-decoration: none; font-weight: 600; }

        .card-contatto a:hover { color: var(--oro-testo); }

        .card-contatto .descrizione {
            font-size: .84rem;
            line-height: 1.65;
            margin-bottom: 1rem;
        }

        /* ================= MODULO "SCRIVICI" ================= */
        #scrivici { padding: 1rem 0 5.5rem; background: #faf7ef; }

        /* Card del modulo: bianca, con filo oro sul bordo alto */
        .card-modulo {
            position: relative;
            background: #fff;
            border: 1px solid #eee6d4;
            border-radius: 22px;
            padding: 2.4rem 2rem;
            overflow: hidden;
            box-shadow: 0 22px 50px rgba(46, 59, 66, .12);
        }

        .card-modulo::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--oro-scuro), var(--oro) 45%, #e8cc82 70%, var(--oro-scuro));
        }

        .card-modulo .form-label {
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: var(--scuro);
        }

        .card-modulo .form-control {
            border: 1px solid #ecdfc0;
            border-radius: 12px;
            padding: .7rem .95rem;
            font-size: .92rem;
            color: var(--scuro);
            background-color: #fffdf8;
            transition: border-color .25s ease, box-shadow .25s ease;
        }

        .card-modulo .form-control:focus {
            border-color: var(--oro);
            box-shadow: 0 0 0 .2rem rgba(201, 162, 75, .2);
        }

        .card-modulo .form-control::placeholder { color: #b3aa97; }

        .card-modulo .form-check-input:checked {
            background-color: var(--oro-scuro);
            border-color: var(--oro-scuro);
        }

        .card-modulo .form-check-input:focus {
            border-color: var(--oro);
            box-shadow: 0 0 0 .2rem rgba(201, 162, 75, .2);
        }

        .card-modulo .form-check-label { font-size: .82rem; line-height: 1.6; }

        /* Honeypot: fuori schermo, invisibile agli utenti */
        .campo-azienda {
            position: absolute;
            left: -9999px;
            width: 1px;
            height: 1px;
            overflow: hidden;
        }

        /* Avvisi esito invio */
        .avviso {
            border-radius: 14px;
            padding: 1rem 1.2rem;
            font-size: .9rem;
            font-weight: 600;
            display: flex;
            align-items: flex-start;
            gap: .7rem;
            margin-bottom: 1.4rem;
        }

        .avviso i { font-size: 1.15rem; flex-shrink: 0; }

        .avviso.ok {
            background: #eef7ea;
            color: #35682d;
            border: 1px solid #cbe5c2;
        }

        .avviso.errore {
            background: #fbeeec;
            color: #8f3125;
            border: 1px solid #eccfc9;
        }

        .avviso ul { margin: .3rem 0 0; padding-left: 1.1rem; font-weight: 500; }

        /* ================= MAPPA + ORARI ================= */
        #dove-siamo { padding: 3rem 0 6rem; background: #faf7ef; }

        .cornice-mappa {
            border-radius: 24px;
            box-shadow: 0 18px 40px rgba(46, 59, 66, .18);
        }

        .mappa {
            display: block;
            border: 0;
            width: 100%;
            height: 100%;
            min-height: 380px;
            border-radius: 24px;
        }

        /* Pannello orari: tessera calda oro/crema con filo oro in alto */
        .card-orari {
            position: relative;
            height: 100%;
            background: linear-gradient(160deg, #fffefb 0%, #fdf8ec 100%);
            border: 1px solid #e6d5a8;
            border-radius: 18px;
            padding: 2rem 1.7rem;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(169, 130, 47, .10);
        }

        .card-orari::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--oro-scuro), var(--oro) 45%, #e8cc82 70%, var(--oro-scuro));
        }

        .card-orari h5 {
            font-size: .95rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .card-orari .icona-orari {
            width: 50px;
            height: 50px;
            margin-bottom: 1rem;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            background: linear-gradient(135deg, #d9b866, var(--oro-scuro));
            box-shadow: 0 8px 18px rgba(169, 130, 47, .35);
        }

        .card-orari ul { margin: 0; padding: 0; list-style: none; }

        .card-orari li {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            font-size: .88rem;
            padding: .7rem 0;
            border-bottom: 1px dashed #e6d5a8;
        }

        .card-orari li:last-child { border-bottom: 0; }

        .card-orari li .ore { font-weight: 700; color: var(--oro-testo); white-space: nowrap; }

        .nota-orari {
            font-size: .8rem;
            line-height: 1.6;
            background: var(--oro-chiaro);
            color: var(--oro-testo);
            border-radius: 12px;
            padding: .8rem 1rem;
            margin-top: 1.2rem;
        }

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
            #canali { padding: 3.8rem 0 3.2rem; }
            #scrivici { padding: .6rem 0 3.6rem; }
            #dove-siamo { padding: 2.6rem 0 4rem; }
            #cta-finale { padding: 3.4rem 0; }

            /* Modulo: card compatta e bottone comodo per il pollice */
            .card-modulo { padding: 1.8rem 1.3rem; }

            .card-modulo .form-control {
                font-size: 1rem;
                padding: .78rem 1rem;
            }

            .card-modulo button[type="submit"] {
                display: flex;
                justify-content: center;
                width: 100%;
                padding-top: .85rem;
                padding-bottom: .85rem;
            }

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
                    <li class="nav-item"><a class="nav-link" href="chi-siamo.php">Chi Siamo</a></li>
                    <li class="nav-item"><a class="nav-link" href="realizzazioni.php">Realizzazioni</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contatti.php">Contatti</a></li>
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
                            <li class="corrente" aria-current="page">Contatti</li>
                        </ol>
                    </nav>
                    <span class="hero-badge fade-up delay-1 mt-3">
                        <i class="bi bi-chat-left-heart"></i> Parliamone
                    </span>
                    <h1 class="mt-3 fade-up delay-1">
                        Contatta <span class="gold">A.S.H. Finiture</span>
                    </h1>
                    <p class="lead mt-3 fade-up delay-2">
                        Telefono, WhatsApp o email: raccontaci il tuo progetto e ti rispondiamo
                        in tempi rapidi, con sopralluogo e preventivo gratuiti.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-4 fade-up delay-3">
                        <a href="preventivo.php" class="btn btn-oro">
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

    <!-- ================= CANALI DI CONTATTO ================= -->
    <section id="canali">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-stars"></i> Come raggiungerci</span>
                <h2 class="section-title mt-3">Tutti i nostri <span class="text-oro">canali</span></h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 640px;">
                    Scegli il canale che preferisci: rispondiamo sempre di persona,
                    senza segreterie né attese.
                </p>
            </div>
            <div class="row g-4">
                <?php foreach ($canali as $i => $canale): ?>
                <div class="col-md-6 col-lg-3 reveal" style="transition-delay: <?php echo $i * 0.12; ?>s">
                    <div class="card-contatto">
                        <i class="bi <?php echo $canale['icona']; ?>" aria-hidden="true"></i>
                        <h5 class="mt-3 fw-bold"><?php echo $canale['titolo']; ?></h5>
                        <p class="descrizione"><?php echo $canale['testo']; ?></p>
                        <?php foreach ($canale['righe'] as $riga): ?>
                        <p class="mb-1">
                            <?php if ($riga['href'] !== null): ?>
                            <a href="<?php echo $riga['href']; ?>"<?php echo !empty($riga['esterno']) ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo $riga['testo']; ?></a>
                            <?php else: ?>
                            <?php echo $riga['testo']; ?>
                            <?php endif; ?>
                        </p>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ================= MODULO SCRIVICI ================= -->
    <section id="scrivici">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-send"></i> Scrivici dal sito</span>
                <h2 class="section-title mt-3">Inviaci un <span class="text-oro">messaggio</span></h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 640px;">
                    Compila il modulo e ti rispondiamo via email al più presto.
                    Riceverai subito una conferma di ricezione nella tua casella.
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 reveal">
                    <div class="card-modulo">
                        <?php if ($invio_ok): ?>
                        <div class="avviso ok" role="status">
                            <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                            <div>
                                Messaggio inviato con successo! Ti risponderemo al più presto,
                                di solito entro 24-48 ore.
                                <?php if ($conferma_inviata): ?>
                                Ti abbiamo inviato una email di conferma: se non la vedi,
                                controlla la cartella spam.
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php elseif (!empty($errori)): ?>
                        <div class="avviso errore" role="alert">
                            <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                            <div>
                                Controlla i campi del modulo:
                                <ul>
                                    <?php foreach ($errori as $err): ?>
                                    <li><?php echo $err; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>

                        <form method="post" action="contatti.php#scrivici" novalidate>
                            <!-- Honeypot anti-spam: da lasciare vuoto -->
                            <div class="campo-azienda" aria-hidden="true">
                                <label for="azienda">Azienda</label>
                                <input type="text" id="azienda" name="azienda" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="nome">Nome e Cognome *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Mario Rossi" required
                                           value="<?php echo htmlspecialchars($dati['nome'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="telefono">Telefono <span class="fw-normal text-lowercase">(facoltativo)</span></label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="333 1234567"
                                           value="<?php echo htmlspecialchars($dati['telefono'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="email-modulo">Email *</label>
                                    <input type="email" class="form-control" id="email-modulo" name="email" placeholder="mario.rossi@email.it" required
                                           value="<?php echo htmlspecialchars($dati['email'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="messaggio">Il tuo messaggio *</label>
                                    <textarea class="form-control" id="messaggio" name="messaggio" rows="5" required
                                              placeholder="Scrivici la tua richiesta: ti rispondiamo al più presto..."><?php echo htmlspecialchars($dati['messaggio'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="privacy" name="privacy" value="1" required>
                                        <label class="form-check-label" for="privacy">
                                            Acconsento al trattamento dei miei dati personali per
                                            ricevere una risposta al mio messaggio. *
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-oro w-100">
                                        <i class="bi bi-send me-2"></i>Invia il messaggio
                                    </button>
                                    <p class="text-center mt-3 mb-0" style="font-size:.78rem; color:#8b9199;">
                                        * Campi obbligatori — Per un preventivo dettagliato usa il
                                        <a href="preventivo.php" style="color:var(--oro-testo); font-weight:600;">modulo preventivo</a>.
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= DOVE SIAMO + ORARI ================= -->
    <section id="dove-siamo">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-8 reveal">
                    <div class="cornice-mappa h-100">
                        <iframe class="mappa"
                                src="https://maps.google.com/maps?q=<?php echo urlencode($address); ?>&t=&z=14&ie=UTF8&iwloc=&output=embed"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Mappa sede A.S.H. Finiture Contract"></iframe>
                    </div>
                </div>
                <div class="col-lg-4 reveal" style="transition-delay:.15s">
                    <div class="card-orari">
                        <span class="icona-orari"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
                        <h5>Orari di reperibilità</h5>
                        <ul class="mt-3">
                            <?php foreach ($orari as $orario): ?>
                            <li>
                                <span><?php echo $orario['giorni']; ?></span>
                                <span class="ore"><?php echo $orario['ore']; ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="nota-orari">
                            <i class="bi bi-info-circle me-1" aria-hidden="true"></i>
                            Siamo spesso in cantiere: se non rispondiamo subito,
                            scrivici su WhatsApp e ti richiamiamo appena possibile.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= CTA FINALE ================= -->
    <section id="cta-finale">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8 reveal">
                    <h2 class="mb-2">Preferisci un preventivo scritto?</h2>
                    <p class="mb-0 fs-5" style="color:rgba(255,255,255,.9)">
                        Compila il modulo online in due minuti: ti ricontattiamo con un
                        <strong>preventivo gratuito</strong> e senza impegno.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end reveal" style="transition-delay:.15s">
                    <a href="preventivo.php" class="btn btn-bianco">
                        <i class="bi bi-envelope-paper me-2"></i>Richiedi Preventivo
                    </a>
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
