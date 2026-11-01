#!/usr/bin/env bash
# Website release helper.
#   This PC -> GitHub -> the server pulls it by itself (cron, every 10 minutes) -> live.
#
#   ./ship.sh "what changed"   check, commit, push, then wait until the live site shows this version
#   ./ship.sh verify           check what the live site is serving right now
set -euo pipefail
cd "$(dirname "${BASH_SOURCE[0]}")"

LIVE=https://www.manycents.co.za
WAIT_MINUTES=12
die() { echo "STOP: $*" >&2; exit 1; }

# The commit the live page says it was built from (deploy.sh stamps it into <meta name="release">)
live_release() {
    curl -s -m 15 "$LIVE/" | grep -o -E 'name="release" content="[^"]*"' | sed -E 's/.*content="([^"]*)"/\1/' || true
}

verify() {
    local bad=0 body code
    ok()   { printf '  ok    %s\n' "$1"; }
    fail() { printf '  FAIL  %s\n' "$1"; bad=1; }

    body=$(curl -s -m 15 "$LIVE/") || die "cannot reach $LIVE"
    grep -q 'Coal, corridors' <<<"$body" && ok "homepage is the new site" || fail "homepage is not the new site yet"
    grep -qi 'magomba' <<<"$body" && fail "homepage still mentions Magomba" || ok "homepage has no Magomba"
    printf '  info  live release: %s\n' "$(live_release)"

    for p in index.html logo.png mining-image.png processing-image.png; do
        code=$(curl -s -o /dev/null -m 15 -w '%{http_code}' "$LIVE/$p")
        [ "$code" = 404 ] && ok "/$p is gone (404)" || fail "/$p answers $code, should be 404"
    done
    code=$(curl -s -o /dev/null -m 15 -w '%{http_code}' "$LIVE/manycents-logo.png")
    [ "$code" = 200 ] && ok "/manycents-logo.png is served" || fail "/manycents-logo.png answers $code, should be 200"
    for p in rate_limit.json form_submissions.txt credentials.php; do
        code=$(curl -s -o /dev/null -m 15 -w '%{http_code}' "$LIVE/$p")
        { [ "$code" = 403 ] || [ "$code" = 404 ]; } && ok "/$p is not readable ($code)" || fail "/$p answers $code, should be 403 or 404"
    done
    return $bad
}

if [ "${1:-}" = verify ]; then
    echo "Live check: $LIVE"
    verify && echo "All good." || die "live site does not match yet"
    exit 0
fi

msg=${1:-}
[ -n "$msg" ] || die 'usage: ./ship.sh "what changed"   or   ./ship.sh verify'
[ "$(git rev-parse --abbrev-ref HEAD)" = main ] || die "switch to the main branch first"
php -l index.php >/dev/null && php -l contact.php >/dev/null && bash -n deploy.sh
git ls-files | grep -q '^credentials\.php$' && die "credentials.php is tracked by git, never commit it"

git add -A
git diff --cached --quiet && die "nothing to commit"
echo "About to commit:"; git status --short
read -r -p "Commit and push these to GitHub (public repo)? [y/N] " answer
[[ $answer == [yY] ]] || { git reset -q; die "cancelled, nothing committed"; }
git commit -m "$msg"
git push origin main

want=$(git rev-parse --short=7 HEAD)
echo
echo "Pushed $want. The server checks GitHub every 10 minutes."
echo "Waiting up to $WAIT_MINUTES minutes for it to appear (Ctrl+C is safe; later run ./ship.sh verify)."
end=$((SECONDS + WAIT_MINUTES * 60))
while [ "$SECONDS" -lt "$end" ]; do
    if [ "$(live_release)" = "$want" ]; then
        echo; echo "Live: release $want is on the site."
        verify && echo "All good." || die "release is live but a check failed, see above"
        exit 0
    fi
    printf '.'; sleep 30
done
echo
die "release $want is not live after $WAIT_MINUTES minutes. Check HOW_TO_SHIP.md (troubleshooting), or use the two cPanel buttons."
