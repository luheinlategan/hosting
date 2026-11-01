# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

ManyCents Resources corporate website - A static HTML marketing site with PHP contact form handling.

**Tech Stack:** HTML5, CSS (embedded), Vanilla JavaScript, PHP

**Live URL:** https://www.manycents.co.za

## Files

```
index.php       - Main single-page website (embedded CSS/JS, CSRF token)
contact.php     - Form handler with SMTP email + spam prevention
.htaccess       - Apache config (HTTPS redirect, caching, gzip)
rate_limit.json - IP-based rate limiting state
deploy.sh       - Server-side deploy (cron + cPanel button); stamps the release
ship.sh         - This PC: check, commit, push, wait until live, verify
HOW_TO_SHIP.md  - The full update process (read this before changing anything)
```

## Deployment

No build process. See `HOW_TO_SHIP.md`: push to GitHub, then cPanel Git Version Control pulls and deploys (`.cpanel.yml`). Never edit files in cPanel File Manager.

## Contact Form

**POST /contact.php**

Fields: name, company, email, product (optional), message, website (honeypot)

Response redirects to `/?success=true` or `/?error=<type>`:
- `missing` - Required fields empty
- `invalid_email` - Email validation failed
- `spam` - Honeypot triggered
- `rate_limit` - Exceeded 5 submissions/hour per IP
- `send_failed` - Email delivery failed

## Key Patterns

- **Email:** SMTP to mail.manycents.co.za:465, falls back to PHP mail()
- **Spam Prevention:** Hidden honeypot field + IP rate limiting (5/hour)
- **Validation:** Frontend (HTML5 + JS) and backend (PHP filter_var)
- **Analytics:** Google Analytics G-FVJM7R4RHF

## Configuration (in contact.php)

```php
SMTP_HOST: mail.manycents.co.za
SMTP_PORT: 465
TO_EMAIL: luhein.lategan@manycents.co.za
MAX_SUBMISSIONS_PER_HOUR: 5
ENABLE_AUTO_REPLY: true
```
