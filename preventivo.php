<?php
// ============================================================
//  A.S.H. Finiture Contract — Di Ahmed Abdelaziz
//  Pagina Richiedi Preventivo — PHP + Bootstrap 5
// ============================================================

$site_name  = 'A.S.H. Finiture Contract';
$tagline    = 'Qualità e Precisione per Ogni Spazio';
$phone1     = '329 6447797';
$phone2     = '338 3386946';
$phone1_raw = '+393296447797';
$phone2_raw = '+393383386946';
$email      = 'ashfiniturecontract@outlook.it';
$address    = 'Via Adigrat 3/A, 62032 Camerino (MC)';

// Tutti i servizi (per menu e per il campo "Servizio" del modulo).
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
//  GESTIONE INVIO MODULO
// ============================================================
$invio_ok         = false;
$conferma_inviata = false;
$errori           = [];
$dati = [
    'nome'      => '',
    'telefono'  => '',
    'email'     => '',
    'comune'    => '',
    'servizio'  => '',
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
        if ($dati['telefono'] === '' && $dati['email'] === '') {
            $errori[] = 'Lascia almeno un recapito: telefono o email.';
        }
        if ($dati['email'] !== '' && !filter_var($dati['email'], FILTER_VALIDATE_EMAIL)) {
            $errori[] = 'L\'indirizzo email inserito non è valido.';
        }
        if ($dati['messaggio'] === '') {
            $errori[] = 'Descrivi brevemente il lavoro da preventivare.';
        }
        $servizi_validi = array_column($servizi, 'titolo');
        $servizi_validi[] = 'Altro / non so ancora';
        if ($dati['servizio'] !== '' && !in_array($dati['servizio'], $servizi_validi, true)) {
            $errori[] = 'Il servizio selezionato non è valido.';
        }
        if (empty($_POST['privacy'])) {
            $errori[] = 'Per inviare la richiesta devi acconsentire al trattamento dei dati.';
        }

        // Allegati (facoltativi): planimetrie, foto, capitolati...
        $allegati            = [];
        $estensioni_permesse = ['pdf', 'jpg', 'jpeg', 'png', 'webp', 'doc', 'docx', 'xls', 'xlsx'];
        $max_file            = 5;
        $max_dimensione     = 8 * 1024 * 1024;  // 8 MB per file
        $max_totale         = 20 * 1024 * 1024; // 20 MB complessivi

        if (!empty($_FILES['documenti']['name'][0])) {
            $numero_file = count($_FILES['documenti']['name']);
            if ($numero_file > $max_file) {
                $errori[] = 'Puoi allegare al massimo ' . $max_file . ' documenti.';
            } else {
                $totale = 0;
                for ($i = 0; $i < $numero_file; $i++) {
                    $nome_originale = $_FILES['documenti']['name'][$i];
                    $tmp            = $_FILES['documenti']['tmp_name'][$i];
                    $errore_upload  = $_FILES['documenti']['error'][$i];
                    $dimensione     = (int) $_FILES['documenti']['size'][$i];

                    if ($errore_upload === UPLOAD_ERR_NO_FILE) {
                        continue;
                    }
                    if ($errore_upload === UPLOAD_ERR_INI_SIZE || $errore_upload === UPLOAD_ERR_FORM_SIZE) {
                        $errori[] = 'Il file "' . htmlspecialchars($nome_originale, ENT_QUOTES, 'UTF-8') . '" è troppo grande (massimo 8 MB).';
                        continue;
                    }
                    if ($errore_upload !== UPLOAD_ERR_OK || !is_uploaded_file($tmp)) {
                        $errori[] = 'Caricamento non riuscito per il file "' . htmlspecialchars($nome_originale, ENT_QUOTES, 'UTF-8') . '". Riprova.';
                        continue;
                    }
                    if ($dimensione > $max_dimensione) {
                        $errori[] = 'Il file "' . htmlspecialchars($nome_originale, ENT_QUOTES, 'UTF-8') . '" supera gli 8 MB.';
                        continue;
                    }

                    $estensione = strtolower(pathinfo($nome_originale, PATHINFO_EXTENSION));
                    if (!in_array($estensione, $estensioni_permesse, true)) {
                        $errori[] = 'Formato non supportato per "' . htmlspecialchars($nome_originale, ENT_QUOTES, 'UTF-8') . '". Sono ammessi: PDF, immagini (JPG, PNG, WEBP), Word ed Excel.';
                        continue;
                    }

                    $totale += $dimensione;
                    if ($totale > $max_totale) {
                        $errori[] = 'Gli allegati superano i 20 MB complessivi: riduci il numero o il peso dei file.';
                        break;
                    }

                    // Nome "pulito" per l'allegato in email
                    $nome_pulito = preg_replace('/[^\w.\-]+/u', '_', $nome_originale);
                    $allegati[] = ['path' => $tmp, 'nome' => $nome_pulito];
                }
            }
        }

        if (empty($errori)) {
            require_once __DIR__ . '/includes/mailer.php';
            require_once __DIR__ . '/includes/email_template.php';

            $e = function ($testo) { return htmlspecialchars($testo, ENT_QUOTES, 'UTF-8'); };

            // ---- Email di notifica per l'azienda (template brand) ----
            $dati_email = [
                'Nome'          => $e($dati['nome']),
                'Telefono'      => $dati['telefono'] !== ''
                    ? '<a href="tel:' . $e(preg_replace('/[^0-9+]/', '', $dati['telefono'])) . '" style="color:#7c5f20; font-weight:bold; text-decoration:none;">' . $e($dati['telefono']) . '</a>'
                    : '',
                'Email'         => $dati['email'] !== ''
                    ? '<a href="mailto:' . $e($dati['email']) . '" style="color:#7c5f20; font-weight:bold; text-decoration:none;">' . $e($dati['email']) . '</a>'
                    : '',
                'Comune / zona' => $e($dati['comune']),
                'Servizio'      => $e($dati['servizio']),
            ];
            $nomi_allegati = array_map(function ($a) { return $a['nome']; }, $allegati);

            $corpo = email_notifica_richiesta('preventivo', $dati_email, nl2br($e($dati['messaggio'])), $nomi_allegati);

            $oggetto = 'Richiesta preventivo — ' . $dati['nome']
                . ($dati['servizio'] !== '' ? ' (' . $dati['servizio'] . ')' : '');

            // Rispondendo alla notifica si scrive direttamente al cliente
            $opzioni = ['immagini' => email_logo_immagini()];
            if ($dati['email'] !== '') {
                $opzioni['rispondi_a'] = ['email' => $dati['email'], 'nome' => $dati['nome']];
            }

            $risultato = send_email($email, null, $oggetto, $corpo, true, $allegati, $opzioni);

            if ($risultato['success']) {
                $invio_ok = true;

                // ---- Email di conferma al cliente (se ha lasciato l'email).
                // Un eventuale errore qui non blocca l'esito: la richiesta
                // è comunque arrivata in azienda.
                if ($dati['email'] !== '') {
                    $riepilogo = [
                        'Servizio'      => $e($dati['servizio']),
                        'Comune / zona' => $e($dati['comune']),
                        'Telefono'      => $e($dati['telefono']),
                    ];
                    $conferma = email_conferma_richiesta($dati['nome'], 'preventivo', $riepilogo, nl2br($e($dati['messaggio'])));

                    $esito_conferma = send_email(
                        $dati['email'],
                        null,
                        'Abbiamo ricevuto la tua richiesta di preventivo — ' . $site_name,
                        $conferma,
                        true,
                        [],
                        ['immagini' => email_logo_immagini()]
                    );
                    $conferma_inviata = $esito_conferma['success'];
                    if (!$conferma_inviata) {
                        error_log('[preventivo] Email di conferma non inviata a ' . $dati['email'] . ': ' . $esito_conferma['error']);
                    }
                }

                // Svuota il modulo dopo l'invio riuscito
                foreach ($dati as $campo => $ignora) {
                    $dati[$campo] = '';
                }
            } else {
                $errori[] = 'Non siamo riusciti a inviare la richiesta. Riprova tra qualche minuto oppure chiamaci al <a href="tel:' . $phone1_raw . '">' . $phone1 . '</a>.';
            }
        }
    }
}

// Perché richiedere un preventivo ad A.S.H.
$vantaggi = [
    ['icona' => 'bi-cash-coin',      'titolo' => 'Gratuito e senza impegno', 'testo' => 'Sopralluogo e preventivo non ti costano nulla e non ti vincolano.'],
    ['icona' => 'bi-file-earmark-text', 'titolo' => 'Chiaro e dettagliato',  'testo' => 'Voci di costo trasparenti: sai sempre cosa paghi e perché.'],
    ['icona' => 'bi-stopwatch',      'titolo' => 'Risposta rapida',          'testo' => 'Ti ricontattiamo in tempi brevi, di solito entro 24-48 ore.'],
    ['icona' => 'bi-person-check',   'titolo' => 'Consulenza inclusa',       'testo' => 'Ti consigliamo materiali e soluzioni su misura per il tuo spazio.'],
];

// Come funziona: dalla richiesta al cantiere
$fasi_richiesta = [
    ['fase' => '01', 'titolo' => 'Invia la richiesta',  'testo' => 'Compila il modulo con i dettagli del lavoro: bastano due minuti.'],
    ['fase' => '02', 'titolo' => 'Ti ricontattiamo',    'testo' => 'Ti chiamiamo per capire le esigenze e fissare il sopralluogo gratuito.'],
    ['fase' => '03', 'titolo' => 'Ricevi il preventivo','testo' => 'Prepariamo un preventivo dettagliato, chiaro e senza sorprese.'],
    ['fase' => '04', 'titolo' => 'Partono i lavori',    'testo' => 'Se ti convince, concordiamo le date e iniziamo nei tempi stabiliti.'],
];

// Dati strutturati JSON-LD: ContactPage + BreadcrumbList
$json_ld = [
    [
        '@context'   => 'https://schema.org',
        '@type'      => 'ContactPage',
        'name'       => 'Richiedi Preventivo — ' . $site_name,
        'description'=> 'Richiedi un preventivo gratuito per finiture edili a Camerino (MC) e provincia di Macerata.',
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
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Richiedi Preventivo'],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Richiedi Preventivo Gratuito | A.S.H. Finiture Contract — Camerino (MC)</title>
    <meta name="description" content="Richiedi un preventivo gratuito e senza impegno per cartongesso, tinteggiature e finiture edili a Camerino (MC) e provincia di Macerata. Rispondiamo in 24-48 ore.">

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

        /* ================= MODULO PREVENTIVO ================= */
        #richiesta { padding: 5.5rem 0; background: linear-gradient(180deg, #fdfbf5 0%, #faf7ef 100%); }

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

        .card-modulo .form-control,
        .card-modulo .form-select {
            border: 1px solid #ecdfc0;
            border-radius: 12px;
            padding: .7rem .95rem;
            font-size: .92rem;
            color: var(--scuro);
            background-color: #fffdf8;
            transition: border-color .25s ease, box-shadow .25s ease;
        }

        .card-modulo .form-control:focus,
        .card-modulo .form-select:focus {
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

        /* Campo "Allega documenti": bottone del file input in stile oro */
        .card-modulo input[type="file"]::file-selector-button {
            background: var(--oro-chiaro);
            color: var(--oro-testo);
            font-weight: 700;
            font-size: .82rem;
            border: 1px solid #ecdfc0;
            border-radius: 8px;
            padding: .45rem 1rem;
            margin-right: .9rem;
            transition: background .25s ease, color .25s ease;
        }

        .card-modulo input[type="file"]::file-selector-button:hover {
            background: linear-gradient(135deg, #d9b866, var(--oro));
            color: var(--scuro);
        }

        .nota-allegati {
            font-size: .76rem;
            line-height: 1.6;
            color: #8b9199;
            margin-top: .45rem;
        }

        .nota-allegati i { color: var(--oro-scuro); }

        /* Honeypot: fuori schermo, invisibile agli utenti */
        .campo-azienda {
            position: absolute;
            left: -9999px;
            width: 1px;
            height: 1px;
            overflow: hidden;
        }

        /* Colonna laterale: vantaggi del preventivo A.S.H. */
        .card-vantaggio {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            background: #fff;
            border: 1px solid #eee6d4;
            border-radius: 16px;
            padding: 1.2rem 1.3rem;
            overflow: hidden;
            box-shadow: 0 10px 26px rgba(169, 130, 47, .10);
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        .card-vantaggio:hover {
            transform: translateY(-4px);
            border-color: var(--oro);
            box-shadow: 0 16px 36px rgba(169, 130, 47, .22);
        }

        .card-vantaggio .icona-vantaggio {
            flex-shrink: 0;
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #fff;
            background: linear-gradient(135deg, #d9b866, var(--oro-scuro));
            box-shadow: 0 8px 18px rgba(169, 130, 47, .35);
        }

        .card-vantaggio h5 {
            font-size: .88rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: .25rem;
        }

        .card-vantaggio p {
            margin: 0;
            font-size: .82rem;
            line-height: 1.6;
        }

        /* Riquadro contatto diretto nella colonna laterale */
        .card-diretto {
            position: relative;
            background: linear-gradient(160deg, #fbf1d9 0%, #fdf8ec 100%);
            border: 1px solid var(--oro);
            border-radius: 16px;
            padding: 1.4rem 1.3rem;
            overflow: hidden;
        }

        .card-diretto h5 {
            font-size: .88rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .card-diretto p { font-size: .82rem; line-height: 1.6; }

        /* Recapiti come bottoni: tutta la riga è cliccabile, su desktop e telefono */
        .card-diretto a.recapito {
            display: flex;
            align-items: center;
            gap: .8rem;
            background: #fff;
            border: 1px solid #ecdfc0;
            border-radius: 12px;
            padding: .75rem 1rem;
            color: var(--oro-testo);
            font-weight: 700;
            font-size: .9rem;
            text-decoration: none;
            transition: background .25s ease, border-color .25s ease, transform .25s ease, box-shadow .25s ease;
        }

        .card-diretto a.recapito i {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            color: #fff;
            background: linear-gradient(135deg, #d9b866, var(--oro-scuro));
            box-shadow: 0 6px 14px rgba(169, 130, 47, .3);
            transition: transform .25s ease;
        }

        .card-diretto a.recapito .freccia {
            margin-left: auto;
            width: auto;
            height: auto;
            background: none;
            box-shadow: none;
            color: var(--oro-scuro);
            font-size: .85rem;
            transition: transform .25s ease;
        }

        .card-diretto a.recapito:hover {
            background: var(--oro-chiaro);
            border-color: var(--oro);
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(169, 130, 47, .22);
        }

        .card-diretto a.recapito:hover i { transform: rotate(-6deg) scale(1.08); }

        .card-diretto a.recapito:hover .freccia { transform: translateX(4px) rotate(0) scale(1); }

        /* WhatsApp: icona nel suo verde ufficiale */
        .card-diretto a.recapito i.bi-whatsapp { background: #25d366; box-shadow: 0 6px 14px rgba(37, 211, 102, .35); }

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

        /* ================= COME FUNZIONA ================= */
        #come-funziona {
            padding: 5.5rem 0;
            background: linear-gradient(180deg, #f4edda 0%, #f9f4e8 100%);
            position: relative;
            overflow: hidden;
        }

        /* Bordo oro in alto (come le sezioni della homepage) */
        #come-funziona::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--oro-scuro) 0%, var(--oro) 25%, #e8cc82 50%, var(--oro) 75%, var(--oro-scuro) 100%);
        }

        /* Bagliore dorato di fondo */
        #come-funziona .bagliore {
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
            .card-modulo { padding: 1.8rem 1.3rem; }

            /* Campi con testo ad almeno 16px: evita lo zoom automatico su iPhone */
            .card-modulo .form-control,
            .card-modulo .form-select {
                font-size: 1rem;
                padding: .78rem 1rem;
            }

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
            #richiesta, #come-funziona { padding: 3.6rem 0; }

            /* Righe impilate: gutter orizzontale standard e respiro ridotto */
            .row.g-5 { --bs-gutter-x: 1.5rem; --bs-gutter-y: 2.4rem; }

            /* Bottone di invio a tutta larghezza: più facile da premere */
            .card-modulo button[type="submit"],
            .card-modulo .btn-oro {
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
                    <li class="nav-item"><a class="nav-link" href="contatti.php">Contatti</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-oro btn-sm px-3 py-2" href="#richiesta">
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
                            <li class="corrente" aria-current="page">Richiedi Preventivo</li>
                        </ol>
                    </nav>
                    <span class="hero-badge fade-up delay-1 mt-3">
                        <i class="bi bi-envelope-paper"></i> Gratuito e senza impegno
                    </span>
                    <h1 class="mt-3 fade-up delay-1">
                        Richiedi il tuo <span class="gold">preventivo gratuito</span>
                    </h1>
                    <p class="lead mt-3 fade-up delay-2">
                        Raccontaci il lavoro che hai in mente: ti ricontattiamo entro 24-48 ore
                        con sopralluogo e preventivo dettagliato, senza alcun impegno.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-4 fade-up delay-3">
                        <a href="#richiesta" class="btn btn-oro">
                            <i class="bi bi-pencil-square me-2"></i>Compila il modulo
                        </a>
                        <a href="tel:<?php echo $phone1_raw; ?>" class="btn btn-outline-scuro">
                            <i class="bi bi-telephone me-2"></i><?php echo $phone1; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ================= MODULO + VANTAGGI ================= -->
    <section id="richiesta">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-pencil-square"></i> Due minuti del tuo tempo</span>
                <h2 class="section-title mt-3">Compila la <span class="text-oro">richiesta</span></h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 640px;">
                    Più dettagli ci dai, più preciso sarà il preventivo. Se hai foto degli
                    ambienti puoi anche inviarcele su WhatsApp dopo la richiesta.
                </p>
            </div>
            <div class="row g-4 g-lg-5">
                <div class="col-lg-7 reveal">
                    <div class="card-modulo">
                        <?php if ($invio_ok): ?>
                        <div class="avviso ok" role="status">
                            <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                            <div>
                                Richiesta inviata con successo! Ti ricontatteremo al più presto,
                                di solito entro 24-48 ore.
                                <?php if ($conferma_inviata): ?>
                                Ti abbiamo inviato una email di conferma con il riepilogo
                                della richiesta: se non la vedi, controlla la cartella spam.
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

                        <form method="post" action="preventivo.php#richiesta" enctype="multipart/form-data" novalidate>
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
                                    <label class="form-label" for="telefono">Telefono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="333 1234567"
                                           value="<?php echo htmlspecialchars($dati['telefono'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="mario.rossi@email.it"
                                           value="<?php echo htmlspecialchars($dati['email'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="comune">Comune / Zona del lavoro</label>
                                    <input type="text" class="form-control" id="comune" name="comune" placeholder="Camerino (MC)"
                                           value="<?php echo htmlspecialchars($dati['comune'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="servizio">Servizio di interesse</label>
                                    <select class="form-select" id="servizio" name="servizio">
                                        <option value="">— Seleziona un servizio —</option>
                                        <?php foreach ($servizi as $servizio): ?>
                                        <option value="<?php echo $servizio['titolo']; ?>"<?php echo $dati['servizio'] === $servizio['titolo'] ? ' selected' : ''; ?>>
                                            <?php echo $servizio['titolo']; ?> — <?php echo $servizio['descrizione']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                        <option value="Altro / non so ancora"<?php echo $dati['servizio'] === 'Altro / non so ancora' ? ' selected' : ''; ?>>
                                            Altro / non so ancora
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="messaggio">Descrivi il lavoro *</label>
                                    <textarea class="form-control" id="messaggio" name="messaggio" rows="5" required
                                              placeholder="Es: vorrei tinteggiare un appartamento di 90 mq su due camere, soggiorno e corridoio..."><?php echo htmlspecialchars($dati['messaggio'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="documenti">Allega documenti <span class="fw-normal text-lowercase">(facoltativo)</span></label>
                                    <input type="file" class="form-control" id="documenti" name="documenti[]" multiple
                                           accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx,.xls,.xlsx">
                                    <p class="nota-allegati mb-0">
                                        <i class="bi bi-paperclip" aria-hidden="true"></i>
                                        Planimetrie, foto degli ambienti o capitolati: fino a 5 file
                                        (PDF, immagini, Word, Excel), massimo 8 MB ciascuno.
                                    </p>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="privacy" name="privacy" value="1" required>
                                        <label class="form-check-label" for="privacy">
                                            Acconsento al trattamento dei miei dati personali per essere ricontattato
                                            in merito alla mia richiesta di preventivo. *
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-oro w-100">
                                        <i class="bi bi-send me-2"></i>Invia la richiesta
                                    </button>
                                    <p class="text-center mt-3 mb-0" style="font-size:.78rem; color:#8b9199;">
                                        * Campi obbligatori — Rispondiamo di solito entro 24-48 ore.
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 reveal" style="transition-delay:.15s">
                    <div class="d-grid gap-3">
                        <?php foreach ($vantaggi as $vantaggio): ?>
                        <div class="card-vantaggio">
                            <span class="icona-vantaggio"><i class="bi <?php echo $vantaggio['icona']; ?>" aria-hidden="true"></i></span>
                            <div>
                                <h5><?php echo $vantaggio['titolo']; ?></h5>
                                <p><?php echo $vantaggio['testo']; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="card-diretto">
                            <h5><i class="bi bi-lightning-charge-fill me-1" aria-hidden="true"></i> Preferisci parlarne a voce?</h5>
                            <p class="mb-3">
                                Chiamaci o scrivici su WhatsApp: un primo confronto telefonico
                                è spesso il modo più veloce per inquadrare il lavoro.
                            </p>
                            <div class="d-flex flex-column gap-2">
                                <a class="recapito" href="tel:<?php echo $phone1_raw; ?>" aria-label="Chiama il numero <?php echo $phone1; ?>">
                                    <i class="bi bi-telephone-fill" aria-hidden="true"></i> <?php echo $phone1; ?>
                                    <i class="bi bi-chevron-right freccia" aria-hidden="true"></i>
                                </a>
                                <a class="recapito" href="tel:<?php echo $phone2_raw; ?>" aria-label="Chiama il numero <?php echo $phone2; ?>">
                                    <i class="bi bi-telephone-fill" aria-hidden="true"></i> <?php echo $phone2; ?>
                                    <i class="bi bi-chevron-right freccia" aria-hidden="true"></i>
                                </a>
                                <a class="recapito" href="https://wa.me/393296447797" target="_blank" rel="noopener">
                                    <i class="bi bi-whatsapp" aria-hidden="true"></i> Scrivici su WhatsApp
                                    <i class="bi bi-chevron-right freccia" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= COME FUNZIONA ================= -->
    <section id="come-funziona">
        <div class="bagliore" aria-hidden="true"></div>
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="hero-badge"><i class="bi bi-diagram-3"></i> Il percorso</span>
                <h2 class="section-title mt-3">Dalla richiesta <span class="text-oro">al cantiere</span></h2>
                <div class="title-underline"></div>
                <p class="mt-3 mx-auto" style="max-width: 660px;">
                    Un percorso chiaro in quattro passi: sai sempre a che punto siamo
                    e cosa succede dopo, senza sorprese.
                </p>
            </div>
            <div class="row g-4 pt-2">
                <?php foreach ($fasi_richiesta as $i => $fs): ?>
                <div class="col-md-6 col-lg-3 reveal" style="transition-delay: <?php echo $i * 0.12; ?>s">
                    <div class="card-fase">
                        <span class="fase"><?php echo $fs['fase']; ?></span>
                        <h5><?php echo $fs['titolo']; ?></h5>
                        <p><?php echo $fs['testo']; ?></p>
                        <div class="barra-fase"><span style="width: <?php echo ($i + 1) * 25; ?>%"></span></div>
                    </div>
                </div>
                <?php endforeach; ?>
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
