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
//  Se installi PHPMailer (consigliato) il modulo lo usa
//  automaticamente via SMTP:
//      composer require phpmailer/phpmailer
//  e compila le costanti MAIL_SMTP_* qui sotto.
//  Senza PHPMailer usa la funzione mail() di PHP.
// ============================================================

// ---- Configurazione ----------------------------------------
const MAIL_FROM_EMAIL = 'ashfiniturecontract@outlook.it';
const MAIL_FROM_NAME  = 'A.S.H. Finiture Contract';

// SMTP (usato solo se PHPMailer è installato)
const MAIL_SMTP_HOST     = 'smtp.office365.com';
const MAIL_SMTP_PORT     = 587;
const MAIL_SMTP_USER     = 'ashfiniturecontract@outlook.it';
const MAIL_SMTP_PASSWORD = '';   // <-- inserisci la password / app password
const MAIL_SMTP_SECURE   = 'tls'; // 'tls' (porta 587) o 'ssl' (porta 465)
// ------------------------------------------------------------

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
        $mail->Host       = MAIL_SMTP_HOST;
        $mail->Port       = MAIL_SMTP_PORT;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_SMTP_USER;
        $mail->Password   = MAIL_SMTP_PASSWORD;
        $mail->SMTPSecure = MAIL_SMTP_SECURE;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
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
    $headers   = [];
    $headers[] = 'From: ' . mb_encode_mimeheader(MAIL_FROM_NAME, 'UTF-8') . ' <' . MAIL_FROM_EMAIL . '>';
    $headers[] = 'Reply-To: ' . MAIL_FROM_EMAIL;
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
