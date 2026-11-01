#!/bin/bash
# Copies the website from this git clone into the live folder.
# Used two ways: by .cpanel.yml (cPanel's "Deploy HEAD Commit" button) and by cron (see HOW_TO_SHIP.md).
#   bash deploy.sh                 always deploy
#   bash deploy.sh --if-changed    deploy only when HEAD is not the commit already deployed (silent otherwise)
set -eu
export PATH=/usr/local/cpanel/3rdparty/bin:/usr/local/bin:/usr/bin:/bin
cd "$(dirname "$0")"

WEB=${DEPLOY_WEB:-/home/manycez2q2t3/public_html}
MARK=${DEPLOY_MARK:-/home/manycez2q2t3/.deployed-sha}   # outside the web folder
sha=$(git rev-parse --short=7 HEAD)

if [ "${1:-}" = "--if-changed" ] && [ "$(cat "$MARK" 2>/dev/null || true)" = "$sha" ]; then
    exit 0
fi

if [ ! -f index.php ] || [ ! -f contact.php ]; then
    echo "deploy.sh: index.php or contact.php is missing, nothing deployed" >&2
    exit 1
fi

# index.php goes through sed so the live page says which commit it is (<meta name="release">).
# Write to a temp name, then move, so a visitor never gets half a file.
sed "s/__RELEASE__/$sha/" index.php > "$WEB/index.php.new"
mv "$WEB/index.php.new" "$WEB/index.php"
cp contact.php .htaccess favicon.png manycents-logo.png "$WEB/"

# The old site (page and images) must not stay reachable.
rm -f "$WEB/index.html" "$WEB/logo.png" "$WEB/mining-image.png" "$WEB/processing-image.png"

# Never touched here: credentials.php, rate_limit.json, form_submissions.txt (they live only on the server).
echo "$sha" > "$MARK"
echo "$(date '+%Y-%m-%d %H:%M:%S') deployed $sha"
