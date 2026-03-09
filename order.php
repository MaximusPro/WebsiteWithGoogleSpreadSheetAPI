<?php 
define('SITE_KEY_RECAPCHA', '6Leds4MsAAAAAHVwNKZjwf63BauT5kJWX9_MYvup');
//$SITE_KEY_RECAPCHA = '6Leds4MsAAAAAHVwNKZjwf63BauT5kJWX9_MYvup';
define('CREDENTIALS_PATH',  __DIR__ . '/credentials.json');
$var = fn($t) => $t > $now - 300;
// var_dump($var);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Заявка</title>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo SITE_KEY_RECAPCHA;?>"></script>
    <style>
        form { max-width: 400px; margin: 50px auto; }
        label { display: block; margin: 12px 0 4px; }
        input, textarea { width: 100%; padding: 8px; }
        button { margin-top: 15px; padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<h2 style="text-align:center">Оставить заявку</h2>

<form id="leadForm" method="POST" action="submit.php">
    <label>Имя</label>
    <input type="text" name="name" required>

    <label>Телефон</label>
    <input type="tel" name="phone" required>

    <label>Сообщение</label>
    <textarea name="message" rows="4" required></textarea>

    <input type="hidden" name="g-recaptcha-response" id="recaptchaToken">

    <button type="submit">Отправить</button>
</form>

<script>
    document.getElementById('leadForm').addEventListener('submit', function(e) {
        e.preventDefault();

        grecaptcha.ready(function() {
            grecaptcha.execute('6Leds4MsAAAAAHVwNKZjwf63BauT5kJWX9_MYvup', {action: 'submit_lead'})
                .then(function(token) {
                    document.getElementById('recaptchaToken').value = token;
                    document.getElementById('leadForm').submit();
                });
        });
    });
</script>

</body>
</html>