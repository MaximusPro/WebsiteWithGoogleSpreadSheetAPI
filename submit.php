<html>
<?php
require('config.php');
//header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method permission denied.');
}

// 1. Защита от спама по IP (файловая, на 5 минут)
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$cache_file = __DIR__ . '/ip_cache.json';
$cache = file_exists($cache_file) ? json_decode(file_get_contents($cache_file), true) : [];
$now = time();

if (isset($cache[$ip])) {
    $requests = array_filter($cache[$ip], fn($t) => $t > $now - 300);
    if (count($requests) >= $MAX_REQUESTS_PER_5MIN) {
        die('Too many requests. Try again in 5 minutes.');
    }
    $cache[$ip] = $requests;
}
$cache[$ip][] = $now;
file_put_contents($cache_file, json_encode($cache, JSON_PRETTY_PRINT));

// 2. Данные из формы
$name    = trim($_POST['name']    ?? '');
$phone   = trim($_POST['phone']   ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($phone)) {
    die('Fill necessary fields: name and phone!');
}

// 3. Запись в Google Sheets
require_once 'vendor/autoload.php';

try {
    $client = new Google_Client();
    $client->setAuthConfig(CREDENTIALS_PATH);
    $client->addScope(Google_Service_Sheets::SPREADSHEETS);
    
    // Добавляем отладку
    $client->setLogger(new Monolog\Logger('google', [new Monolog\Handler\StreamHandler('php://stderr')]));
    $client->setHttpClient(new GuzzleHttp\Client(['verify' => false])); // если SSL проблемы

    $service = new Google_Service_Sheets($client);

    $row = [
        date('Y-m-d H:i:s'),
        $name,
        $phone,
        $message,
        $ip
    ];

    $values = [$row];
    $body = new Google_Service_Sheets_ValueRange(['values' => $values]);

    $params = [
        'valueInputOption' => 'USER_ENTERED',
        'insertDataOption' => 'INSERT_ROWS'
    ];

    $range = SHEET_NAME . '!A:E';

    $response = $service->spreadsheets_values->append(SPREADSHEET_ID, $range, $body, $params);
    
    // Если дошло сюда — успех
    error_log("Successfully added line: " . print_r($response, true));

} catch (\Google\Service\Exception $e) {
    $errorMessage = $e->getMessage();
    error_log("Google API Exception: " . $errorMessage);
    die('ERROR Google Sheets API: ' . htmlspecialchars($errorMessage));
} catch (Exception $e) {
    error_log("Общая ошибка: " . $e->getMessage());
    die('Error writing to table: ' . htmlspecialchars($e->getMessage()));
}

// 4. Отправка в Telegram
$tg_text = "<b>New order!</b>\n\n" .
           "Date: " . date('d.m.Y H:i') . "\n" .
           "Name: " . htmlspecialchars($name) . "\n" .
           "Phone: " . htmlspecialchars($phone) . "\n" .
           "Massage: " . htmlspecialchars($message) . "\n" .
           "IP: " . $ip;

$tg_url = "https://api.telegram.org/bot" . TELEGRAM_TOKEN .
          "/sendMessage?chat_id=" . TELEGRAM_CHAT_ID .
          "&text=" . urlencode($tg_text) .
          "&parse_mode=HTML";

@file_get_contents($tg_url);  // тихо отправляем, ошибки не показываем пользователю

// 5. Успешный ответ

echo '<meta http-equiv="refresh" content="2;url=success-order.php">';
?>
</html>
<!-- <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка принята</title>
    <style>
        body { font-family: system-ui, sans-serif; text-align: center; padding: 80px 20px; background: #f8f9fa; }
        h2 { color: #28a745; }
        a { color: #007bff; text-decoration: none; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h2>Спасибо! Ваша заявка принята.</h2>
    <p>Мы свяжемся с вами в ближайшее время.</p>
    <a href="./index.php">Вернуться на главную</a>
</body>
</html> -->