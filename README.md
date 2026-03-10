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
