<?php
/*
 * *************************************************************************
 *  * Copyright 2026-2026 (C) Damian Schönberger, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Koblenz with ♥ by Damian Schönberger
 *  *
 *  * @project     RED-Host v2
 *  * @file        charge.php
 *  * @author      Damian Schönberger (xyzdamian)
 *  * @site        www.schleyer-edv.de
 *  * @date        28.8.2026
 *
 *  Guthaben aufladen: Zahlungsmethode auswaehlen, Betrag eingeben,
 *  wird der passende Provider aufgerufen und zum Checkout weitergeleitet.
 */

$chargeError   = null;
$chargeSuccess = false;
$chargeFailed  = false;

// Zahlungsmethoden aus der DB laden
$methods = [];
try {
    $stmt = Controller::db()->query("SELECT * FROM payment_methods WHERE status = 'active' ORDER BY name ASC");
    $methods = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
    $chargeError = 'Zahlungsmethoden konnten nicht geladen werden.';
}

// Checkout erstellen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['charge'])) {
    $methodId = $_POST['method'] ?? '';
    $amount   = (float) ($_POST['amount'] ?? 0);

    $selected = array_values(array_filter($methods, function ($m) use ($methodId) {
        return $m['id'] === $methodId;
    }));

    if (empty($selected)) {
        $chargeError = 'Bitte zuerst eine Zahlungsmethode auswählen.';
    } elseif ($amount <= 0) {
        $chargeError = 'Bitte einen gültigen Betrag (größer 0) eingeben.';
    } else {
        $method   = $selected[0];
        $provider = strtolower($method['provider']);

        try {
            $description = 'Guthaben aufladen – ' . $method['name'];

            switch ($provider) {
                case 'mollie':
                    $payment = $mollie->postPayment($amount, $description, $method['type'] ?: null);
                    break;
                case 'stripe':
                    $payment = $stripe->postPayment($amount, $description, $method['type'] ?: null);
                    break;
                default:
                    $payment = null;
                    $chargeError = 'Unbekannter Provider: ' . $method['provider'];
            }

            if (!empty($payment['url'])) {
                // Transaktion merken, um nach Rückkehr den echten Status zu prüfen (einmalig).
                $_SESSION['charge_review'] = [
                    'provider' => $provider,
                    'id'       => $payment['id'],
                ];
                header('Location: ' . $payment['url']);
                exit;
            }
        } catch (Throwable $e) {
            $chargeError = 'Der Checkout konnte nicht erstellt werden (' . $e->getMessage() . ')';
        }
    }
}

// Nach Rückkehr vom Checkout: echten Status beim Provider nachfragen (einmalig).
if (isset($_SESSION['charge_review']) && empty($_GET['status'])) {
    $review = $_SESSION['charge_review'];
    unset($_SESSION['charge_review']);

    try {
        $paid = false;

        if ($review['provider'] === 'mollie') {
            $tx = $mollie->getTransaction($review['id']);
            $paid = (($tx['status'] ?? '') === 'paid');
        } elseif ($review['provider'] === 'stripe') {
            $session = $stripe->getClient()->checkout->sessions->retrieve($review['id']);
            $paid = ($session->payment_status === 'paid');
        }

        if ($paid) {
            $chargeSuccess = true;
        } else {
            $chargeFailed = true;
        }
    } catch (Throwable $e) {
        $chargeFailed = true;
    }
}

// Alert-Meldung bestimmen
$alert = '';
if ($chargeSuccess) {
    $alert = 'success';
} elseif ($chargeFailed) {
    $alert = 'error';
}

$pageTitle = 'Guthaben aufladen';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> – RED-Host</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --red: #e3001b;
            --red-light: #ff4d5e;
            --ink: #14161c;
            --muted: #6b7280;
            --bg: #121212;
            --card: #f6f7fb;
        }
        body {
            font-family: 'Inter', 'Segoe UI', Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at 12% 10%, rgba(227, 0, 27, 0.08), transparent 42%),
                radial-gradient(circle at 90% 85%, rgba(227, 0, 27, 0.06), transparent 45%),
                var(--bg);
            color: var(--ink);
            min-height: 100vh;
            padding: 40px 16px;
        }
        .container { max-width: 560px; margin: 0 auto; }

        .card {
            background: var(--card);
            border: 1px solid rgba(20, 22, 28, 0.05);
            border-radius: 20px;
            padding: 36px 32px;
            box-shadow:
                0 1px 2px rgba(20, 22, 28, 0.04),
                0 16px 40px rgba(20, 22, 28, 0.08);
        }

        h1 { font-size: 22px; font-weight: 800; letter-spacing: -0.3px; margin-bottom: 6px; }
        .sub { font-size: 13.5px; color: var(--muted); margin-bottom: 24px; }

        .methods { list-style: none; display: grid; gap: 10px; margin-bottom: 22px; }
        .method {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border: 1.5px solid rgba(20, 22, 28, 0.12);
            border-radius: 12px;
            cursor: pointer;
            background: #ffffff;
            transition: border-color 0.15s, background 0.15s;
        }
        .method:hover { border-color: var(--red); }
        .method input { accent-color: var(--red); width: 18px; height: 18px; }
        .method .meta { display: flex; flex-direction: column; }
        .method .name { font-weight: 700; font-size: 15px; }
        .method .provider { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; }

        .field { margin-bottom: 22px; }
        .field label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 7px; }
        .field input {
            width: 100%;
            padding: 13px 15px;
            border: 1.5px solid rgba(20, 22, 28, 0.15);
            border-radius: 10px;
            font-size: 15px;
            background: #ffffff;
            color: var(--ink);
        }
        .field input:focus { outline: none; border-color: var(--red); }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(90deg, var(--red), var(--red-light));
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.15s;
        }
        .btn:hover { opacity: 0.92; }

        .error {
            margin-top: 18px;
            padding: 13px 15px;
            border-radius: 10px;
            background: rgba(227, 0, 27, 0.08);
            border: 1px solid rgba(227, 0, 27, 0.25);
            color: var(--red);
            font-size: 13.5px;
        }
        .empty {
            padding: 20px;
            text-align: center;
            color: var(--muted);
            font-size: 14px;
            border: 1.5px dashed rgba(20, 22, 28, 0.15);
            border-radius: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1><?= $pageTitle ?></h1>
        <p class="sub">Wähle eine Zahlungsmethode und gib den gewünschten Betrag ein.</p>

        <form method="post" action="">
            <?php if (empty($methods)): ?>
                <div class="empty">Zurzeit sind keine Zahlungsmethoden verfügbar.</div>
            <?php else: ?>
                <ul class="methods">
                    <?php foreach ($methods as $method): ?>
                        <li class="method">
                            <input type="radio" name="method" id="method_<?= htmlspecialchars($method['id']) ?>"
                                   value="<?= htmlspecialchars($method['id']) ?>">
                            <div class="meta">
                                <span class="name"><?= htmlspecialchars($method['name']) ?></span>
                                <span class="provider"><?= htmlspecialchars($method['provider']) ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="field">
                <label for="amount">Betrag (EUR)</label>
                <input type="number" name="amount" id="amount" step="0.01" min="0.01" placeholder="10.00" required>
            </div>

            <button type="submit" name="charge" value="1" class="btn" <?= empty($methods) ? 'disabled' : '' ?>>
                Aufladen &amp; Bezahlen
            </button>
        </form>

        <?php if (!empty($chargeError)): ?>
            <div class="error"><?= htmlspecialchars($chargeError) ?></div>
        <?php endif; ?>
    </div>
</div>

<?php if ($alert === 'success'): ?>
<script>
    Swal.fire({
        title: 'Erfolgreich',
        text: 'Die Zahlung wurde erfolgreich abgeschlossen.',
        icon: 'success',
        confirmButtonColor: '#e3001b'
    });
</script>
<?php elseif ($alert === 'error'): ?>
<script>
    Swal.fire({
        title: 'Fehlgeschlagen',
        text: 'Die Zahlung wurde abgebrochen oder ist fehlgeschlagen. Bitte versuche es erneut.',
        icon: 'error',
        confirmButtonColor: '#e3001b'
    });
</script>
<?php endif; ?>
</body>
</html>
