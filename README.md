# Lead Form → Google Sheets + Telegram Notification

A simple and reliable contact form for websites that:
- Saves submissions to a Google Spreadsheet
- Instantly sends a notification to the admin in Telegram
- Protected from spam via IP limiting (5 requests per 5 minutes)
- Works in Docker (LAMP, OpenServer-like stack)

## Features

- Name, phone, message fields
- Automatic logging: date + IP
- Formatted Telegram notification
- "Thank you" success page after submission
- Basic protection against multiple submissions from the same IP

## Requirements

- Docker + docker-compose (or existing LAMP container)
- PHP 8.1+
- Composer
- Google Cloud account (Sheets API + Service Account)
- Telegram bot and chat ID

## Installation & Setup

### 1. Clone the repository

```bash
git clone https://github.com/MaximusPro/WebsiteWithGoogleSpreadSheetAPI.git
cd WebsiteWithGoogleSpreadSheetAPI
```
### 2. Configure Google Sheets and Telegram

#### 1. Create a Google Spreadsheet
Copy the Spreadsheet ID from the URL
Add headers in the first row:
```Code
Date | Name | Phone | Message | IP
```
#### 2. Create a Service Account in Google Cloud
→ Enable Google Sheets API on links: 
```Code
https://console.cloud.google.com/apis/api/sheets.googleapis.com/metrics?project=<your_project>
```
→ Create key → download JSON → rename to credentials.json
→ Share the spreadsheet with the client_email from the JSON file (role Editor)
#### 3. Create a Telegram bot via @BotFather
Get the TOKEN
Send any message to the bot → get your CHAT_ID via:
```Code
https://api.telegram.org/bot<TOKEN>/getUpdates
```
Create config.php with your values
For example:
```php
<?php
 define("ROOT", dirname(__FILE__) . '/');
 define("HOST", 'http://'. $_SERVER["HTTP_HOST"]. '/');
 define("ABS_PATH", dirname(__DIR__). '/');

// ==================== Settings ====================
define('SPREADSHEET_ID',    '2DIIIKLJlkjncfzxmvn2sjKJcnJMLMNxmcb23');
define('SHEET_NAME',        'Sheet1');           // calling sheet
define('CREDENTIALS_PATH',  __DIR__ . '/credentials.json');

define('TELEGRAM_TOKEN',    '1234567890:DGDLGJLGDLJWIRSOGJDLHUZZP');
define('TELEGRAM_CHAT_ID',  '1234567890');         // your chat id

define('RECAPTCHA_SECRET',  '6Leds4MsAAAAAI1IUtvpKI9PdJjo_qDRUmO8lcYF');
$SITE_KEY_RECAPCHA = '6LehTYIsAAAAABUXzjsHkUzDUZ3y9t0YqNCsDeyF';
$MAX_REQUESTS_PER_5MIN = 5;   // sequrity from spam on IP
// ===================================================
?>
```

