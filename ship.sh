#!/usr/bin/env bash
# Website release helper. Same idea as LoadMatch's HOW_TO_SHIP.md:
#   This PC -> GitHub -> cPanel pulls and deploys -> live.
#
#   ./ship.sh "what changed"   check, commit and push to GitHub, then print the cPanel steps
#   ./ship.sh verify           check what the live site is serving right now
set -euo pipefail
cd "$(dirname "${BASH_SOURCE[0]}")"

LIVE=https://www.manycents.co.za
die() { echo "STOP: $*" >&2; exit 1; }

verify() {
    local bad=0 body code
    ok()   { printf '  ok    %s\n' "$1"; }
    fail() { printf '  FAIL  %s\n' "$1"; bad=1; }

    body=$(curl -s -m 15 "$LIVE/") || die "cannot reach $LIVE"
    grep -q 'Coal, corridors' <<<"$body" && ok "homepage is the new site" || fail "homepage is not the new site yet"
    grep -qi 'magomba' <<<"$body" && fail "homepage still mentions Magomba" || ok "homepage has no Magomba"

    for p in index.html logo.png mining-image.png processing-image.png; do
        code=$(curl -s -o /dev/null -m 15 -w '%{http_code}' "$LIVE/$p")
        [ "$code" = 404 ] && ok "/$p is gone (404)" || fail "/$p answers $code, should be 404"
    done
    for p in rate_limit.json form_submissions.txt; do
        code=$(curl -s -o /dev/null -m 15 -w '%{http_code}' "$LIVE/$p")
        { [ "$code" = 403 ] || [ "$code" = 404 ]; } && ok "/$p is not readable ($code)" || fail "/$p answers $code, should be 403 or 404"
    done
    code=$(curl -s -o /dev/null -m 15 -w '%{http_code}' "$LIVE/credentials.php")
    { [ "$code" = 403 ] || [ "$code" = 404 ]; } && ok "/credentials.php is not readable ($code)" || fail "/credentials.php answers $code, should be 403 or 404"
    return $bad
}

if [ "${1:-}" = verify ]; then
    echo "Live check: $LIVE"
    verify && echo "All good." || die "live site does not match yet (did you Update from Remote and Deploy HEAD Commit in cPanel?)"
    exit 0
fi

msg=${1:-}
[ -n "$msg" ] || die 'usage: ./ship.sh "what changed"   or   ./ship.sh verify'
[ "$(git rev-parse --abbrev-ref HEAD)" = main ] || die "switch to the main branch first"
php -l index.php >/dev/null && php -l contact.php >/dev/null
git ls-files | grep -q '^credentials\.php$' && die "credentials.php is tracked by git, never commit it"

git add -A
echo "About to commit:"; git status --short
read -r -p "Commit and push these to GitHub (public repo)? [y/N] " answer
[[ $answer == [yY] ]] || { git reset -q; die "cancelled, nothing committed"; }
git commit -m "$msg"
git push origin main

cat <<'EOF'

Pushed to GitHub. GitHub is not the website yet. Now in cPanel:
  Git Version Control > hosting > Manage > Pull or Deploy
    1. Update from Remote
    2. Deploy HEAD Commit
Then run:  ./ship.sh verify
EOF
