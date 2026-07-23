<?php
// ============================================================
//  A.S.H. Finiture Contract — Template email con brand aziendale
//
//  Genera email HTML compatibili con Gmail, Outlook (anche
//  desktop), Apple Mail e webmail italiane: layout a tabelle,
//  stili inline, logo incorporato come immagine CID (visibile
//  anche senza connessione a server esterni).
//
//  Uso tipico:
//
//      require_once __DIR__ . '/includes/mailer.php';
//      require_once __DIR__ . '/includes/email_template.php';
//
//      $html = email_conferma_richiesta('Mario', 'preventivo', $riepilogo, $messaggio);
//      send_email($clienteEmail, null, 'Oggetto', $html, true, [], [
//          'immagini' => email_logo_immagini(),
//      ]);
// ============================================================

// ---- Dati aziendali usati in header e footer delle email ----
function email_azienda(): array
{
    return [
        'nome'       => 'A.S.H. Finiture Contract',
        'tagline'    => 'Qualità e Precisione per Ogni Spazio',
        'titolare'   => 'Di Ahmed Abdelaziz',
        'telefono1'  => '329 6447797',
        'telefono1_raw' => '+393296447797',
        'telefono2'  => '338 3386946',
        'telefono2_raw' => '+393383386946',
        'whatsapp'   => 'https://wa.me/393296447797',
        'email'      => 'ashfiniturecontract@outlook.it',
        'indirizzo'  => 'Via Adigrat 3/A, 62032 Camerino (MC)',
    ];
}

// ---- Palette (stessa del sito) ------------------------------
const EMAIL_ORO        = '#c9a24b';
const EMAIL_ORO_SCURO  = '#a9822f';
const EMAIL_ORO_TESTO  = '#7c5f20';
const EMAIL_ORO_CHIARO = '#f5edd9';
const EMAIL_SCURO      = '#2e3b42';
const EMAIL_TESTO      = '#4a5158';
const EMAIL_SFONDO     = '#f0ebdf';
const EMAIL_BORDO      = '#eee6d4';
const EMAIL_FONT       = "'Montserrat', Arial, Helvetica, sans-serif";

/** CID del logo incorporato (referenziato nell'HTML come src="cid:..."). */
function email_logo_cid(): string
{
    return 'ash-logo';
}

/**
 * Immagini da incorporare nella mail (opzione 'immagini' di send_email).
 * Usa la versione ottimizzata del logo se presente, altrimenti quella piena.
 */
function email_logo_immagini(): array
{
    foreach (['logo-email.png', 'logo-mark.png'] as $file) {
        $path = dirname(__DIR__) . '/assets/img/' . $file;
        if (is_readable($path)) {
            return [['path' => $path, 'cid' => email_logo_cid(), 'nome' => 'logo.png']];
        }
    }
    return [];
}

/** Escape HTML abbreviato. */
function email_e(string $testo): string
{
    return htmlspecialchars($testo, ENT_QUOTES, 'UTF-8');
}

/**
 * Layout completo dell'email: header con logo, area contenuto, footer.
 *
 * @param string $preheader Testo di anteprima mostrato dai client accanto all'oggetto
 * @param string $contenuto HTML interno (usa gli helper email_titolo, email_paragrafo, ...)
 * @param string $notaFooter Riga facoltativa sopra il copyright (es. perché ricevi questa email)
 */
function email_layout(string $preheader, string $contenuto, string $notaFooter = ''): string
{
    $a    = email_azienda();
    $cid  = email_logo_cid();
    $anno = date('Y');

    $nota = $notaFooter !== ''
        ? '<p style="margin:0 0 12px; font-size:11px; line-height:1.6; color:#8fa0a9;">' . $notaFooter . '</p>'
        : '';

    return '<!DOCTYPE html>
<html lang="it" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="x-apple-disable-message-reformatting">
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<title>' . email_e($a['nome']) . '</title>
</head>
<body style="margin:0; padding:0; background-color:' . EMAIL_SFONDO . '; -webkit-text-size-adjust:100%;">

    <!-- Anteprima nascosta accanto all\'oggetto -->
    <div style="display:none; max-height:0; overflow:hidden; mso-hide:all;">'
        . email_e($preheader) . '&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="' . EMAIL_SFONDO . '" style="background-color:' . EMAIL_SFONDO . ';">
        <tr>
            <td align="center" style="padding:28px 12px;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:100%;">

                    <!-- ============ HEADER ============ -->
                    <tr>
                        <td style="border-radius:16px 16px 0 0; overflow:hidden;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td height="6" bgcolor="' . EMAIL_ORO . '" style="height:6px; font-size:0; line-height:0; border-radius:16px 16px 0 0;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" bgcolor="' . EMAIL_SCURO . '" style="background-color:' . EMAIL_SCURO . '; padding:30px 24px 26px;">
                                        <img src="cid:' . $cid . '" width="96" alt="Logo ' . email_e($a['nome']) . '" style="display:block; width:96px; height:auto; margin:0 auto 14px; border:0;">
                                        <div style="font-family:' . EMAIL_FONT . '; font-size:24px; font-weight:bold; letter-spacing:1px; color:#ffffff;">
                                            A.S.H. <span style="color:' . EMAIL_ORO . ';">Finiture Contract</span>
                                        </div>
                                        <div style="font-family:' . EMAIL_FONT . '; font-size:11px; font-weight:bold; letter-spacing:3px; text-transform:uppercase; color:#e8cc82; padding-top:6px;">
                                            ' . email_e($a['tagline']) . '
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- ============ CONTENUTO ============ -->
                    <tr>
                        <td bgcolor="#ffffff" style="background-color:#ffffff; padding:34px 34px 30px; font-family:' . EMAIL_FONT . '; color:' . EMAIL_TESTO . ';">
                            ' . $contenuto . '
                        </td>
                    </tr>

                    <!-- ============ FOOTER ============ -->
                    <tr>
                        <td style="border-radius:0 0 16px 16px; overflow:hidden;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td height="4" bgcolor="' . EMAIL_ORO . '" style="height:4px; font-size:0; line-height:0;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" bgcolor="' . EMAIL_SCURO . '" style="background-color:' . EMAIL_SCURO . '; padding:26px 24px; border-radius:0 0 16px 16px;">
                                        <p style="margin:0 0 4px; font-family:' . EMAIL_FONT . '; font-size:14px; font-weight:bold; color:#ffffff;">
                                            ' . email_e($a['nome']) . '
                                        </p>
                                        <p style="margin:0 0 14px; font-family:' . EMAIL_FONT . '; font-size:11px; color:#8fa0a9;">
                                            ' . email_e($a['titolare']) . ' — ' . email_e($a['indirizzo']) . '
                                        </p>
                                        <p style="margin:0 0 14px; font-family:' . EMAIL_FONT . '; font-size:12px; line-height:1.9;">
                                            <a href="tel:' . email_e($a['telefono1_raw']) . '" style="color:' . EMAIL_ORO . '; text-decoration:none; font-weight:bold;">' . email_e($a['telefono1']) . '</a>
                                            <span style="color:#5c6d77;">&nbsp;|&nbsp;</span>
                                            <a href="tel:' . email_e($a['telefono2_raw']) . '" style="color:' . EMAIL_ORO . '; text-decoration:none; font-weight:bold;">' . email_e($a['telefono2']) . '</a>
                                            <span style="color:#5c6d77;">&nbsp;|&nbsp;</span>
                                            <a href="mailto:' . email_e($a['email']) . '" style="color:' . EMAIL_ORO . '; text-decoration:none; font-weight:bold;">' . email_e($a['email']) . '</a>
                                        </p>
                                        ' . $nota . '
                                        <p style="margin:0; font-family:' . EMAIL_FONT . '; font-size:11px; color:#8fa0a9;">
                                            &copy; ' . $anno . ' ' . email_e($a['nome']) . '. Tutti i diritti riservati.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
}

/** Titolo principale del contenuto. */
function email_titolo(string $testo): string
{
    return '<h1 style="margin:0 0 6px; font-family:' . EMAIL_FONT . '; font-size:22px; line-height:1.3; font-weight:bold; color:' . EMAIL_SCURO . ';">'
        . email_e($testo) . '</h1>'
        . '<table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>'
        . '<td width="64" height="4" bgcolor="' . EMAIL_ORO . '" style="width:64px; height:4px; font-size:0; line-height:0; border-radius:2px;">&nbsp;</td>'
        . '</tr></table><div style="height:18px; font-size:0; line-height:0;">&nbsp;</div>';
}

/** Paragrafo di testo (accetta HTML già sicuro). */
function email_paragrafo(string $html): string
{
    return '<p style="margin:0 0 16px; font-family:' . EMAIL_FONT . '; font-size:14px; line-height:1.7; color:' . EMAIL_TESTO . ';">' . $html . '</p>';
}

/**
 * Tabella riepilogo dati: righe [etichetta => valore HTML già sicuro].
 * I valori vuoti vengono saltati.
 */
function email_tabella_dati(array $coppie): string
{
    $righe = '';
    foreach ($coppie as $etichetta => $valoreHtml) {
        if ($valoreHtml === '' || $valoreHtml === null) {
            continue;
        }
        $righe .= '<tr>'
            . '<td width="160" valign="top" style="padding:10px 14px; font-family:' . EMAIL_FONT . '; font-size:11px; font-weight:bold; letter-spacing:1px; text-transform:uppercase; color:' . EMAIL_ORO_TESTO . '; background-color:' . EMAIL_ORO_CHIARO . '; border-bottom:1px solid #ffffff;">'
            . email_e($etichetta) . '</td>'
            . '<td valign="top" style="padding:10px 14px; font-family:' . EMAIL_FONT . '; font-size:14px; line-height:1.6; color:' . EMAIL_SCURO . '; background-color:#fdfbf5; border-bottom:1px solid ' . EMAIL_BORDO . ';">'
            . $valoreHtml . '</td>'
            . '</tr>';
    }
    if ($righe === '') {
        return '';
    }
    return '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid ' . EMAIL_BORDO . '; border-radius:10px; margin:0 0 18px;">'
        . $righe . '</table>';
}

/** Riquadro evidenziato con il messaggio del cliente. */
function email_riquadro_messaggio(string $titolo, string $testoHtml): string
{
    return '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 18px;"><tr>'
        . '<td style="padding:16px 18px; background-color:#fdfbf5; border-left:4px solid ' . EMAIL_ORO . '; border-radius:0 10px 10px 0;">'
        . '<p style="margin:0 0 6px; font-family:' . EMAIL_FONT . '; font-size:11px; font-weight:bold; letter-spacing:1px; text-transform:uppercase; color:' . EMAIL_ORO_TESTO . ';">'
        . email_e($titolo) . '</p>'
        . '<p style="margin:0; font-family:' . EMAIL_FONT . '; font-size:14px; line-height:1.7; color:' . EMAIL_TESTO . ';">' . $testoHtml . '</p>'
        . '</td></tr></table>';
}

/** Bottone "a prova di client" (link con padding, niente immagini). */
function email_bottone(string $url, string $testo, bool $scuro = false): string
{
    $bg     = $scuro ? EMAIL_SCURO : EMAIL_ORO;
    $colore = $scuro ? '#ffffff' : EMAIL_SCURO;
    return '<table role="presentation" cellpadding="0" cellspacing="0" border="0" style="display:inline-table; margin:0 8px 10px 0;"><tr>'
        . '<td align="center" bgcolor="' . $bg . '" style="background-color:' . $bg . '; border-radius:30px;">'
        . '<a href="' . email_e($url) . '" style="display:inline-block; padding:12px 26px; font-family:' . EMAIL_FONT . '; font-size:13px; font-weight:bold; color:' . $colore . '; text-decoration:none;">'
        . $testo . '</a>'
        . '</td></tr></table>';
}

/** Elenco numerato dei prossimi passi (per l\'email di conferma). */
function email_passi(array $passi): string
{
    $righe = '';
    foreach ($passi as $i => $passo) {
        $righe .= '<tr>'
            . '<td width="34" valign="top" style="padding:0 12px 14px 0;">'
            . '<table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>'
            . '<td align="center" width="30" height="30" bgcolor="' . EMAIL_ORO . '" style="width:30px; height:30px; border-radius:15px; font-family:' . EMAIL_FONT . '; font-size:13px; font-weight:bold; color:' . EMAIL_SCURO . ';">'
            . ($i + 1) . '</td>'
            . '</tr></table>'
            . '</td>'
            . '<td valign="top" style="padding:4px 0 14px; font-family:' . EMAIL_FONT . '; font-size:14px; line-height:1.6; color:' . EMAIL_TESTO . ';">'
            . '<strong style="color:' . EMAIL_SCURO . ';">' . email_e($passo['titolo']) . '</strong><br>'
            . email_e($passo['testo'])
            . '</td>'
            . '</tr>';
    }
    return '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:4px 0 8px;">' . $righe . '</table>';
}

// ============================================================
//  EMAIL PRONTE ALL'USO
// ============================================================

/**
 * Email di notifica per l'azienda: nuova richiesta dal sito.
 *
 * @param string $tipo         'preventivo' oppure 'contatto'
 * @param array  $dati         [etichetta => valore HTML già sicuro]
 * @param string $messaggioHtml Messaggio del cliente (HTML già sicuro, con nl2br)
 * @param array  $allegatiNomi  Nomi file degli allegati (testo semplice)
 */
function email_notifica_richiesta(string $tipo, array $dati, string $messaggioHtml, array $allegatiNomi = []): string
{
    $titolo = $tipo === 'preventivo'
        ? 'Nuova richiesta di preventivo'
        : 'Nuovo messaggio dal sito';

    $contenuto  = email_titolo($titolo);
    $contenuto .= email_paragrafo('È arrivata una nuova richiesta dal modulo '
        . ($tipo === 'preventivo' ? '<strong>Richiedi Preventivo</strong>' : '<strong>Contatti</strong>')
        . ' del sito. Ecco i dettagli:');
    $contenuto .= email_tabella_dati($dati);
    $contenuto .= email_riquadro_messaggio(
        $tipo === 'preventivo' ? 'Descrizione del lavoro' : 'Messaggio',
        $messaggioHtml
    );

    if (!empty($allegatiNomi)) {
        $contenuto .= email_paragrafo('<strong style="color:' . EMAIL_SCURO . ';">Documenti allegati:</strong> '
            . email_e(implode(', ', $allegatiNomi)));
    }

    $contenuto .= email_paragrafo('<em>Puoi rispondere direttamente a questa email: la risposta arriverà al cliente.</em>');

    return email_layout($titolo . ' dal sito web', $contenuto);
}

/**
 * Email di conferma per il cliente: richiesta ricevuta.
 *
 * @param string $nome          Nome del cliente
 * @param string $tipo          'preventivo' oppure 'contatto'
 * @param array  $riepilogo     [etichetta => valore HTML già sicuro] (può essere vuoto)
 * @param string $messaggioHtml Messaggio inviato dal cliente (HTML già sicuro)
 */
function email_conferma_richiesta(string $nome, string $tipo, array $riepilogo, string $messaggioHtml): string
{
    $a         = email_azienda();
    $preventivo = ($tipo === 'preventivo');

    $contenuto  = email_titolo($preventivo
        ? 'Richiesta ricevuta, grazie ' . $nome . '!'
        : 'Messaggio ricevuto, grazie ' . $nome . '!');

    $contenuto .= email_paragrafo($preventivo
        ? 'Abbiamo ricevuto la tua <strong>richiesta di preventivo</strong> e la stiamo già esaminando. Ti ricontatteremo al più presto, di solito <strong>entro 24-48 ore</strong>.'
        : 'Abbiamo ricevuto il tuo <strong>messaggio</strong> e ti risponderemo al più presto, di solito <strong>entro 24-48 ore</strong>.');

    if ($preventivo) {
        $contenuto .= email_paragrafo('<strong style="color:' . EMAIL_SCURO . ';">Cosa succede adesso?</strong>');
        $contenuto .= email_passi([
            ['titolo' => 'Ti ricontattiamo',    'testo' => 'Ti chiamiamo o ti scriviamo per capire meglio le tue esigenze.'],
            ['titolo' => 'Sopralluogo gratuito', 'testo' => 'Se serve, fissiamo un sopralluogo senza alcun impegno.'],
            ['titolo' => 'Ricevi il preventivo', 'testo' => 'Ti inviamo un preventivo chiaro, dettagliato e senza sorprese.'],
        ]);
    }

    if (!empty($riepilogo) || $messaggioHtml !== '') {
        $contenuto .= email_paragrafo('<strong style="color:' . EMAIL_SCURO . ';">Riepilogo della tua richiesta</strong>');
        $contenuto .= email_tabella_dati($riepilogo);
        if ($messaggioHtml !== '') {
            $contenuto .= email_riquadro_messaggio($preventivo ? 'Il lavoro che ci hai descritto' : 'Il tuo messaggio', $messaggioHtml);
        }
    }

    $contenuto .= email_paragrafo('Hai urgenza o vuoi aggiungere qualcosa (foto, misure, dettagli)? Chiamaci o scrivici su WhatsApp:');
    $contenuto .= '<div style="padding:2px 0 6px;">'
        . email_bottone('tel:' . $a['telefono1_raw'], '&#128222;&nbsp; Chiamaci ora')
        . email_bottone($a['whatsapp'], '&#128172;&nbsp; Scrivici su WhatsApp', true)
        . '</div>';
    $contenuto .= email_paragrafo('A presto,<br><strong style="color:' . EMAIL_SCURO . ';">' . email_e($a['nome']) . '</strong><br><span style="font-size:12px; color:#8b9199;">' . email_e($a['titolare']) . '</span>');

    return email_layout(
        $preventivo
            ? 'Abbiamo ricevuto la tua richiesta di preventivo: ti ricontattiamo entro 24-48 ore.'
            : 'Abbiamo ricevuto il tuo messaggio: ti rispondiamo entro 24-48 ore.',
        $contenuto,
        'Ricevi questa email perché è stato compilato un modulo sul sito di ' . email_e($a['nome'])
            . ' con questo indirizzo. Se non hai inviato tu la richiesta, puoi ignorare questo messaggio.'
    );
}
