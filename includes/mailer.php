<?php
// ============================================================
//  A.S.H. Finiture Contract — Modulo invio email
//
//  Uso (da qualsiasi controller/pagina):
//
//      require_once __DIR__ . '/includes/mailer.php';
//
//      $result = send_email(
//          'cliente@example.com',          // destinatario (string o array)
//          'copia@example.com',            // cc (string, array o null)
//          'Oggetto della mail',           // oggetto
//          'Testo del messaggio...',       // testo (HTML o testo semplice)
//          true,                           // isHtml
//          [],                             // allegati
//          [                               // opzioni (facoltative)
//              'rispondi_a' => ['email' => 'cliente@example.com', 'nome' => 'Mario Rossi'],
//              'immagini'   => [['path' => '/percorso/logo.png', 'cid' => 'logo']],
//          ]
//      );
//
//      if ($result['success']) {
//          // inviata
//      } else {
//          // errore: $result['error']
//      }
//
//  Con PHPMailer installato il modulo invia via SMTP usando le
//  variabili d'ambiente MAIL_* (vedi .env.example). Funziona con
//  Gmail, Outlook/Office365, Aruba e qualsiasi altro provider SMTP.
//  Senza PHPMailer usa la funzione mail() di PHP come fallback.
// ============================================================

// ---- Configurazione ----------------------------------------
// I valori arrivano dalle variabili d'ambiente (in produzione le
// imposti su Coolify -> Environment Variables; in locale nel file
// .env, vedi .env.example). Il secondo argomento è il default.
// ------------------------------------------------------------

// Carica il file .env (solo sviluppo locale — in produzione le
// variabili sono già nell'ambiente e il file non esiste).
(function () {
    $envFile = dirname(__DIR__) . '/.env';
    if (!is_file($envFile)) {
        return;
    }
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim(trim($value), "\"'");
        if (getenv($key) === false) {
            putenv("$key=$value");
        }
    }
})();

/** Legge una variabile d'ambiente con valore di default. */
function mail_config(string $key, string $default = ''): string
{
    $value = getenv($key);
    return ($value === false || $value === '') ? $default : $value;
}

/**
 * Mittente effettivo: MAIL_FROM_EMAIL se impostata, altrimenti
 * l'utente SMTP. Con Gmail e Outlook il mittente DEVE coincidere
 * con la casella autenticata, altrimenti l'invio viene rifiutato
 * (SendAsDenied) o il "From" viene riscritto dal provider.
 */
function mail_from_email(): string
{
    return mail_config('MAIL_FROM_EMAIL', mail_config('MAIL_SMTP_USER', 'ashfiniturecontract@outlook.it'));
}

function mail_from_name(): string
{
    return mail_config('MAIL_FROM_NAME', 'A.S.H. Finiture Contract');
}

/**
 * Converte un corpo HTML in testo semplice leggibile (per la
 * versione alternativa della mail, usata da client testuali e
 * utile anche per i filtri antispam).
 */
function mail_html_to_text(string $html): string
{
    $testo = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $html);
    $testo = preg_replace('/<br\s*\/?>/i', "\n", $testo);
    $testo = preg_replace('/<\/(p|div|tr|h[1-6]|li|table)>/i', "\n", $testo);
    $testo = strip_tags($testo);
    $testo = html_entity_decode($testo, ENT_QUOTES, 'UTF-8');
    $testo = preg_replace('/[ \t]+/', ' ', $testo);
    $testo = preg_replace('/\n{3,}/', "\n\n", $testo);
    return trim($testo);
}

/**
 * Normalizza l'opzione 'rispondi_a' in [email, nome] oppure null.
 */
function mail_normalizza_rispondi_a($rispondiA): ?array
{
    if (is_string($rispondiA) && $rispondiA !== '') {
        $rispondiA = ['email' => $rispondiA, 'nome' => ''];
    }
    if (!is_array($rispondiA) || empty($rispondiA['email'])) {
        return null;
    }
    if (!filter_var($rispondiA['email'], FILTER_VALIDATE_EMAIL)) {
        return null;
    }
    return ['email' => $rispondiA['email'], 'nome' => (string) ($rispondiA['nome'] ?? '')];
}

/**
 * Invia una email.
 *
 * @param string|array      $to       Destinatario/i
 * @param string|array|null $cc       Copia conoscenza (opzionale)
 * @param string            $oggetto  Oggetto della mail
 * @param string            $testo    Corpo del messaggio (HTML o testo)
 * @param bool              $isHtml   true se $testo è HTML (default true)
 * @param array             $allegati Allegati: array di ['path' => percorso file, 'nome' => nome file]
 * @param array             $opzioni  Opzioni extra:
 *                                    - 'rispondi_a': string|['email' =>, 'nome' =>] indirizzo Reply-To
 *                                    - 'immagini':   array di ['path' =>, 'cid' =>, 'nome' =>]
 *                                                    immagini incorporate nel corpo (es. logo,
 *                                                    referenziate nell'HTML come src="cid:...")
 *
 * @return array{success: bool, error: string|null}
 */
function send_email($to, $cc, string $oggetto, string $testo, bool $isHtml = true, array $allegati = [], array $opzioni = []): array
{
    $to = array_filter((array) $to);
    $cc = array_filter((array) ($cc ?? []));

    if (empty($to)) {
        return ['success' => false, 'error' => 'Nessun destinatario specificato.'];
    }
    foreach (array_merge($to, $cc) as $addr) {
        if (!filter_var($addr, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => "Indirizzo email non valido: $addr"];
        }
    }
    foreach ($allegati as $allegato) {
        if (empty($allegato['path']) || !is_readable($allegato['path'])) {
            return ['success' => false, 'error' => 'Allegato non leggibile: ' . ($allegato['nome'] ?? $allegato['path'] ?? '?')];
        }
    }
    // Immagini incorporate non leggibili: si ignora senza bloccare l'invio
    // (la mail parte comunque, al massimo senza logo).
    $opzioni['immagini'] = array_values(array_filter(
        (array) ($opzioni['immagini'] ?? []),
        function ($img) {
            return !empty($img['path']) && !empty($img['cid']) && is_readable($img['path']);
        }
    ));

    // PHPMailer disponibile? (composer require phpmailer/phpmailer)
    $autoload = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($autoload)) {
        require_once $autoload;
        if (class_exists(\PHPMailer\PHPMailer\PHPMailer::class)) {
            return send_email_phpmailer($to, $cc, $oggetto, $testo, $isHtml, $allegati, $opzioni);
        }
    }

    return send_email_native($to, $cc, $oggetto, $testo, $isHtml, $allegati, $opzioni);
}

/** Invio via PHPMailer + SMTP. */
function send_email_phpmailer(array $to, array $cc, string $oggetto, string $testo, bool $isHtml, array $allegati = [], array $opzioni = []): array
{
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host     = mail_config('MAIL_SMTP_HOST', 'smtp.office365.com');
        $mail->Port     = (int) mail_config('MAIL_SMTP_PORT', '587');
        $mail->SMTPAuth = true;
        $mail->Username = mail_config('MAIL_SMTP_USER', 'ashfiniturecontract@outlook.it');
        $mail->Password = mail_config('MAIL_SMTP_PASSWORD');
        $mail->CharSet  = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->Timeout  = 20;      // niente attese infinite se l'SMTP non risponde
        $mail->XMailer  = ' ';     // non pubblicizzare la versione di PHPMailer

        // Cifratura: 'tls' = STARTTLS (porta 587), 'ssl' = SMTPS (porta 465),
        // 'none' = nessuna. Se porta e cifratura non combaciano (errore di
        // configurazione frequente) si corregge in automatico.
        $secure = strtolower(mail_config('MAIL_SMTP_SECURE', 'tls'));
        if ($mail->Port === 465 && $secure !== 'ssl') {
            $secure = 'ssl';
        } elseif ($mail->Port === 587 && $secure === 'ssl') {
            $secure = 'tls';
        }
        if ($secure === 'ssl') {
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        } elseif ($secure === 'none') {
            $mail->SMTPSecure  = '';
            $mail->SMTPAutoTLS = false;
        } else {
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        }

        // Ultima spiaggia per server con certificati non validi
        // (MAIL_SMTP_ALLOW_INSECURE=1). Da NON usare con Gmail/Outlook.
        if (mail_config('MAIL_SMTP_ALLOW_INSECURE') === '1') {
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];
        }

        // Log dettagliato del dialogo SMTP nel log errori PHP (MAIL_DEBUG=1)
        if (mail_config('MAIL_DEBUG') === '1') {
            $mail->SMTPDebug   = 2;
            $mail->Debugoutput = 'error_log';
        }

        $fromEmail = mail_from_email();
        $mail->setFrom($fromEmail, mail_from_name());
        // Envelope sender (Return-Path) allineato alla casella autenticata:
        // aiuta i controlli SPF e la consegna su Gmail/Outlook.
        $mail->Sender = $mail->Username ?: $fromEmail;

        foreach ($to as $addr) {
            $mail->addAddress($addr);
        }
        foreach ($cc as $addr) {
            $mail->addCC($addr);
        }

        $rispondiA = mail_normalizza_rispondi_a($opzioni['rispondi_a'] ?? null);
        if ($rispondiA !== null) {
            $mail->addReplyTo($rispondiA['email'], $rispondiA['nome']);
        }

        $mail->Subject = $oggetto;
        $mail->isHTML($isHtml);
        $mail->Body = $testo;
        if ($isHtml) {
            $mail->AltBody = mail_html_to_text($testo);
        }
        foreach ($opzioni['immagini'] as $img) {
            $mail->addEmbeddedImage($img['path'], $img['cid'], $img['nome'] ?? basename($img['path']));
        }
        foreach ($allegati as $allegato) {
            $mail->addAttachment($allegato['path'], $allegato['nome'] ?? '');
        }

        $mail->send();
        return ['success' => true, 'error' => null];
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        $errore = $mail->ErrorInfo ?: $e->getMessage();
        error_log('[mailer] Invio SMTP fallito (' . $mail->Host . ':' . $mail->Port . '): ' . $errore);
        return ['success' => false, 'error' => $errore];
    }
}

/** Invio via mail() nativa di PHP (fallback). */
function send_email_native(array $to, array $cc, string $oggetto, string $testo, bool $isHtml, array $allegati = [], array $opzioni = []): array
{
    $fromEmail = mail_from_email();
    $fromName  = mail_from_name();

    $headers   = [];
    $headers[] = 'From: ' . mb_encode_mimeheader($fromName, 'UTF-8') . ' <' . $fromEmail . '>';

    $rispondiA = mail_normalizza_rispondi_a($opzioni['rispondi_a'] ?? null);
    if ($rispondiA !== null) {
        $headers[] = 'Reply-To: '
            . ($rispondiA['nome'] !== '' ? mb_encode_mimeheader($rispondiA['nome'], 'UTF-8') . ' ' : '')
            . '<' . $rispondiA['email'] . '>';
    } else {
        $headers[] = 'Reply-To: ' . $fromEmail;
    }
    if (!empty($cc)) {
        $headers[] = 'Cc: ' . implode(', ', $cc);
    }
    $headers[] = 'MIME-Version: 1.0';

    $tipoTesto = ($isHtml ? 'text/html' : 'text/plain') . '; charset=UTF-8';
    $immagini  = $opzioni['immagini'];

    // Parte "corpo": semplice, oppure multipart/related se ci sono
    // immagini incorporate (logo referenziato come cid: nell'HTML).
    $costruisci_corpo = function () use ($tipoTesto, $testo, $immagini) {
        if (empty($immagini)) {
            return ['Content-Type: ' . $tipoTesto, $testo];
        }
        $rel   = 'ashrel_' . md5(uniqid((string) mt_rand(), true));
        $parte = "--$rel\r\n"
            . "Content-Type: $tipoTesto\r\n"
            . "Content-Transfer-Encoding: 8bit\r\n\r\n"
            . $testo . "\r\n";
        foreach ($immagini as $img) {
            $contenuto = file_get_contents($img['path']);
            if ($contenuto === false) {
                continue;
            }
            $mime  = function_exists('mime_content_type') ? (mime_content_type($img['path']) ?: 'application/octet-stream') : 'image/png';
            $nome  = basename($img['nome'] ?? $img['path']);
            $parte .= "--$rel\r\n"
                . 'Content-Type: ' . $mime . '; name="' . $nome . "\"\r\n"
                . "Content-Transfer-Encoding: base64\r\n"
                . 'Content-ID: <' . $img['cid'] . ">\r\n"
                . "Content-Disposition: inline; filename=\"$nome\"\r\n\r\n"
                . chunk_split(base64_encode($contenuto)) . "\r\n";
        }
        $parte .= "--$rel--";
        return ['Content-Type: multipart/related; boundary="' . $rel . '"', $parte];
    };

    if (empty($allegati)) {
        [$tipoCorpo, $corpo] = $costruisci_corpo();
        $headers[] = $tipoCorpo;
    } else {
        // Messaggio multipart/mixed: corpo (+ eventuali immagini) + allegati
        $confine   = 'ash_' . md5(uniqid((string) mt_rand(), true));
        $headers[] = 'Content-Type: multipart/mixed; boundary="' . $confine . '"';

        [$tipoCorpo, $parteCorpo] = $costruisci_corpo();

        $corpo  = "--$confine\r\n";
        $corpo .= $tipoCorpo . "\r\n";
        if (empty($immagini)) {
            $corpo .= "Content-Transfer-Encoding: 8bit\r\n";
        }
        $corpo .= "\r\n" . $parteCorpo . "\r\n";

        foreach ($allegati as $allegato) {
            $nome      = basename($allegato['nome'] ?? $allegato['path']);
            $contenuto = file_get_contents($allegato['path']);
            if ($contenuto === false) {
                continue;
            }
            $corpo .= "--$confine\r\n";
            $corpo .= 'Content-Type: application/octet-stream; name="' . $nome . "\"\r\n";
            $corpo .= "Content-Transfer-Encoding: base64\r\n";
            $corpo .= 'Content-Disposition: attachment; filename="' . $nome . "\"\r\n\r\n";
            $corpo .= chunk_split(base64_encode($contenuto)) . "\r\n";
        }
        $corpo .= "--$confine--";
    }

    $subject = mb_encode_mimeheader($oggetto, 'UTF-8');
    $ok = @mail(implode(', ', $to), $subject, $corpo, implode("\r\n", $headers));

    if (!$ok) {
        error_log('[mailer] Invio con mail() nativa fallito: funzione non disponibile o server non configurato.');
    }

    return $ok
        ? ['success' => true, 'error' => null]
        : ['success' => false, 'error' => "Invio fallito: la funzione mail() non è disponibile o il server non è configurato per l'invio email."];
}
