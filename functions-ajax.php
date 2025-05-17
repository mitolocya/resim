<?php
// Hata gösterimini aktifleştir
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Doğru dosya yollarını belirle
$rootPath = dirname(dirname(__DIR__)); // Ana dizine çık

// Gerekli dosyaları include et
require_once $rootPath . '/includes/database.php';
require_once $rootPath . '/includes/log.php';
require_once $rootPath . '/admin/includes/PHPMailer/src/PHPMailer.php';
require_once $rootPath . '/admin/includes/PHPMailer/src/SMTP.php';
require_once $rootPath . '/admin/includes/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Veritabanı bağlantısını kontrol et
if (!$conn || mysqli_connect_errno()) {
    error_log("Veritabanı bağlantı hatası: " . mysqli_connect_error());
    echo json_encode(['success' => false, 'message' => 'Veritabanı bağlantı hatası.']);
    exit;
}

// Mail ayarlarını çek
$query = "SELECT * FROM mail_settings WHERE id = 1";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    error_log("Mail ayarları çekilemedi.");
    echo json_encode(['success' => false, 'message' => 'Mail ayarları bulunamadı.']);
    exit;
}
$mail_settings = mysqli_fetch_assoc($result);

// Debug için mail ayarlarını logla
error_log("Mail ayarları yüklendi: " . print_r($mail_settings, true));

// AJAX işlemleri için CORS ve güvenlik başlıkları
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Form adımlarını yükleme işlemi
if (isset($_POST['action']) && $_POST['action'] === 'load_step_content') {
    $step = isset($_POST['step']) ? intval($_POST['step']) : 0;

    ob_start();
    switch ($step) {
        case 2:
            require_once __DIR__ . '/sales-step2.php';
            render_sales_step2();
            break;
        case 3:
            require_once __DIR__ . '/sales-step3.php';
            render_sales_step3();
            break;
        default:
            echo '<p>Geçersiz adım numarası.</p>';
    }
    echo ob_get_clean();
    exit;
}

// Form verilerini gönderme işlemi
if (isset($_POST['action']) && $_POST['action'] === 'submit_form_data') {
    // Debug için POST verilerini logla
    error_log("POST verileri: " . print_r($_POST, true));

    $formData = json_decode(stripslashes($_POST['formData']), true);

    // Debug için form verilerini logla
    error_log("Form verileri decode edildi: " . print_r($formData, true));

    if (!isset($formData) || empty($formData)) {
        error_log("Form verileri eksik: " . json_encode($_POST));
        echo json_encode(['success' => false, 'message' => 'Form verileri eksik.']);
        exit;
    }

    // E-posta içeriği
    $subject = 'Yeni Araç Satış Başvurusu';
    $to = $mail_settings['from_email'];

    // HTML E-posta tasarımı
    $message = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; margin: 0; padding: 0; }
            .email-container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border: 1px solid #ddd; }
            .email-header { background-color: #4CAF50; color: #ffffff; text-align: center; padding: 20px; font-size: 1.5rem; }
            .email-section { padding: 20px; border-bottom: 1px solid #eeeeee; }
            .email-section h2 { font-size: 1.2rem; color: #4CAF50; margin-bottom: 10px; }
            .email-section p { margin: 5px 0; font-size: 1rem; }
            .email-footer { background-color: #f1f1f1; text-align: center; padding: 10px; font-size: 0.9rem; color: #555; }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="email-header">Yeni Araç Satış Başvurusu</div>
            <div class="email-section">
                <h2>Araç Bilgileri</h2>
                <p><strong>Marka:</strong> ' . htmlspecialchars($formData['brand'] ?? 'Bilinmiyor') . '</p>
                <p><strong>Model:</strong> ' . htmlspecialchars($formData['model'] ?? 'Bilinmiyor') . '</p>
                <p><strong>Bouwjaar:</strong> ' . htmlspecialchars($formData['year'] ?? 'Bilinmiyor') . '</p>
                <p><strong>KM-Stand:</strong> ' . htmlspecialchars($formData['kmstand'] ?? 'Bilinmiyor') . '</p>
                <p><strong>Transmissie:</strong> ' . htmlspecialchars($formData['transmission'] ?? 'Bilinmiyor') . '</p>
                <p><strong>Brandstof:</strong> ' . htmlspecialchars($formData['fuel'] ?? 'Bilinmiyor') . '</p>
            </div>
            <div class="email-section">
                <h2>İletişim Bilgileri</h2>
                <p><strong>Voornaam:</strong> ' . htmlspecialchars($formData['first_name'] ?? 'Bilinmiyor') . '</p>
                <p><strong>Achternaam:</strong> ' . htmlspecialchars($formData['last_name'] ?? 'Bilinmiyor') . '</p>
                <p><strong>Email:</strong> ' . htmlspecialchars($formData['email'] ?? 'Bilinmiyor') . '</p>
                <p><strong>Telefoon:</strong> ' . htmlspecialchars($formData['phone'] ?? 'Bilinmiyor') . '</p>
                <p><strong>Gemeente:</strong> ' . htmlspecialchars($formData['city'] ?? 'Bilinmiyor') . '</p>
                <p><strong>Extra Informatie:</strong> ' . htmlspecialchars($formData['extra_info'] ?? 'Yok') . '</p>
            </div>
            <div class="email-footer">Bu e-posta, sistem tarafından otomatik olarak oluşturulmuştur.</div>
        </div>
    </body>
    </html>';

    // PHPMailer ile e-posta gönderimi
    $mail = new PHPMailer(true);
    try {
        // Debug modu
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Debugoutput = function($str, $level) {
            error_log("PHPMailer Debug: [$level] $str");
        };

        // SMTP ayarları
        $mail->isSMTP();
        $mail->Host = $mail_settings['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $mail_settings['smtp_username'];
        $mail->Password = $mail_settings['smtp_password'];
        $mail->SMTPSecure = $mail_settings['smtp_encryption'];
        $mail->Port = $mail_settings['smtp_port'];

        // Debug için SMTP ayarlarını logla
        error_log("SMTP Ayarları: Host={$mail_settings['smtp_host']}, Port={$mail_settings['smtp_port']}, User={$mail_settings['smtp_username']}");

        // Gönderici ve alıcı
        $mail->setFrom($mail_settings['from_email'], $mail_settings['from_name']);
        $mail->addAddress($to);
        $mail->addReplyTo($formData['email'] ?? 'noreply@vindin.be', $formData['first_name'] . ' ' . $formData['last_name']);

        // E-posta içeriği
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->CharSet = 'UTF-8';

        // SMTP bağlantısını test et
        if (!$mail->smtpConnect()) {
            throw new Exception('SMTP bağlantısı kurulamadı.');
        }

        // Gönder
        $mail->send();
        error_log("Mail başarıyla gönderildi: " . $to);
        echo json_encode(['success' => true, 'message' => 'Form başarıyla gönderildi.']);
    } catch (Exception $e) {
        error_log("PHPMailer Hatası: " . $mail->ErrorInfo);
        echo json_encode(['success' => false, 'message' => 'E-posta gönderimi başarısız: ' . $mail->ErrorInfo]);
    } finally {
        $mail->smtpClose();
    }
    exit;
}
?>