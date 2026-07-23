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
//          'Testo del messaggio...'        // testo (HTML o testo semplice)
//      );
//
//      if ($result['success']) {
//          // inviata
//      } else {
//          // errore: $result['error']
//      }
//
//  Con PHPMailer installato il modulo invia via SMTP usando le
//  variabili d'ambiente MAIL_* (vedi .env.example). Senza
//  PHPMailer usa la funzione mail() di PHP come fallback.
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
 * Invia una email.
 *
 * @param string|array      $to      Destinatario/i
 * @param string|array|null $cc      Copia conoscenza (opzionale)
 * @param string            $oggetto Oggetto della mail
 * @param string            $testo   Corpo del messaggio (HTML o testo)
 * @param bool              $isHtml  true se $testo è HTML (default true)
 *
 * @return array{success: bool, error: string|null}
 */
function send_email($to, $cc, string $oggetto, string $testo, bool $isHtml = true): array
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

    // PHPMailer disponibile? (composer require phpmailer/phpmailer)
    $autoload = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($autoload)) {
        require_once $autoload;
        if (class_exists(\PHPMailer\PHPMailer\PHPMailer::class)) {
            return send_email_phpmailer($to, $cc, $oggetto, $testo, $isHtml);
        }
    }

    return send_email_native($to, $cc, $oggetto, $testo, $isHtml);
}

/** Invio via PHPMailer + SMTP. */
function send_email_phpmailer(array $to, array $cc, string $oggetto, string $testo, bool $isHtml): array
{
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = mail_config('MAIL_SMTP_HOST', 'smtp.office365.com');
        $mail->Port       = (int) mail_config('MAIL_SMTP_PORT', '587');
        $mail->SMTPAuth   = true;
        $mail->Username   = mail_config('MAIL_SMTP_USER', 'ashfiniturecontract@outlook.it');
        $mail->Password   = mail_config('MAIL_SMTP_PASSWORD');
        $mail->SMTPSecure = mail_config('MAIL_SMTP_SECURE', 'tls');
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom(
            mail_config('MAIL_FROM_EMAIL', 'ashfiniturecontract@outlook.it'),
            mail_config('MAIL_FROM_NAME', 'A.S.H. Finiture Contract')
        );
        foreach ($to as $addr) {
            $mail->addAddress($addr);
        }
        foreach ($cc as $addr) {
            $mail->addCC($addr);
        }

        $mail->Subject = $oggetto;
        $mail->isHTML($isHtml);
        $mail->Body = $testo;
        if ($isHtml) {
            $mail->AltBody = strip_tags($testo);
        }

        $mail->send();
        return ['success' => true, 'error' => null];
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        return ['success' => false, 'error' => $mail->ErrorInfo ?: $e->getMessage()];
    }
}

/** Invio via mail() nativa di PHP (fallback). */
function send_email_native(array $to, array $cc, string $oggetto, string $testo, bool $isHtml): array
{
    $fromEmail = mail_config('MAIL_FROM_EMAIL', 'ashfiniturecontract@outlook.it');
    $fromName  = mail_config('MAIL_FROM_NAME', 'A.S.H. Finiture Contract');

    $headers   = [];
    $headers[] = 'From: ' . mb_encode_mimeheader($fromName, 'UTF-8') . ' <' . $fromEmail . '>';
    $headers[] = 'Reply-To: ' . $fromEmail;
    if (!empty($cc)) {
        $headers[] = 'Cc: ' . implode(', ', $cc);
    }
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-Type: ' . ($isHtml ? 'text/html' : 'text/plain') . '; charset=UTF-8';

    $subject = mb_encode_mimeheader($oggetto, 'UTF-8');
    $ok = @mail(implode(', ', $to), $subject, $testo, implode("\r\n", $headers));

    return $ok
        ? ['success' => true, 'error' => null]
        : ['success' => false, 'error' => "Invio fallito: la funzione mail() non è disponibile o il server non è configurato per l'invio email."];
}
