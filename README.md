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

define('RECAPTCHA_SECRET',  '6LehTYIsAAHYJLBUXzjsHkUzDUZ3y9t0YqNCsDeyF');
$SITE_KEY_RECAPCHA = '6LehTYIsAAHYJLBUXzjsHkUzDUZ3y9t0YqNCsDeyF';
$MAX_REQUESTS_PER_5MIN = 5;   // sequrity from spam on IP
// ===================================================
?>
```
### 3. Installation into an existing Docker LAMP / site in the www folder
Assumes you already have a running container with PHP/Apache and a volume mounted to /var/www/html.
How to download Docker see on website:
[https://docker.com/...](https://docs.docker.com/engine/install/ubuntu/)
How to install docker-compose-lamp see link on github:
[https://github.com/...](https://github.com/sprintcube/docker-compose-lamp)
#### 1. Copy project files into your site's folder:
```Bash
# On host
cp -r ./* /path/to/your/docker/www/
# or selectively
cp index.php submit.php credentials.json /path/to/your/docker/www/
```
#### 2. Install Composer dependencies (inside the container)
```Bash
#Find your container name on active list
docker ps 
# Enter the container (replace container_name with actual name, e.g. lamp_web_1)
docker exec -it container_name bash

# Inside container
cd /var/www/html

# Increase timeout (important for google/apiclient)
composer config process-timeout 1800

# Move unzip so Composer won't find it
mv /usr/bin/unzip /usr/bin/unzip.bak

# Install packages
composer install --no-interaction --prefer-dist

# give back after installing
mv /usr/bin/unzip.bak /usr/bin/unzip

```
Composer will see that unzip is missing → enable ZipArchive.
Sometimes ZipArchive in Docker works faster due to fewer system calls (but more often it's slower, so test it out).
Make sure the zip extension is enabled (required for fallback)
```Bash
# Into container
php -m | grep zip
```
If nothing appears → install:
```Bash
apt update && apt install -y libzip-dev
docker-php-ext-install zip
```
(After this, restart the container if necessary)
### 4. Testing

Open: http://localhost/index.php (or your domain/port)
Fill out and submit the form
Check:
New row appears in Google Spreadsheet
Notification arrives in Telegram
"Thank you" success page is shown

