# How to Ship a Change to www.manycents.co.za

Same idea as LoadMatch: nothing on this PC reaches the live site by itself. GitHub is the middle, and the server fetches from it on its own.

```
[ This PC ] --git push--> [ GitHub: luheinlategan/hosting, main ] --cron, every 10 min--> [ public_html ] --> LIVE
```

| Place | Path | Role |
|---|---|---|
| This PC | `~/manycents/hosting` | You edit here |
| GitHub | `luheinlategan/hosting`, branch `main` (public) | The copy the server trusts |
| cPanel clone | `/home/manycez2q2t3/repositories/hosting` | Pulled by the cron job |
| Live files | `/home/manycez2q2t3/public_html` | Written by `deploy.sh` |

## Every time

```bash
cd ~/manycents/hosting
php -S 127.0.0.1:$(portcheck --free) -t .      # view only; do not submit the form, it sends real mail
./ship.sh "what changed"                        # checks, shows the file list, asks, commits, pushes, then waits
```

`ship.sh` waits (up to 12 minutes) until the live page says it is the commit you just pushed, then runs the live check. Ctrl+C is safe; check later with `./ship.sh verify`.

## What runs on the server

`deploy.sh` copies `index.php` (stamped with the commit in `<meta name="release">`), `contact.php`, `.htaccess`, `favicon.png` and `manycents-logo.png` into `public_html`, and removes the old Magomba page and images. It never touches `credentials.php`, `rate_limit.json` or `form_submissions.txt`.

It is started by either of two things, both running the same script:

1. **Cron (normal).** cPanel > Cron Jobs, one entry, set up once:
   - Minute `*/10`, Hour `*`, Day `*`, Month `*`, Weekday `*`
   - Command (one line):
     ```
     cd /home/manycez2q2t3/repositories/hosting && PATH=/usr/local/cpanel/3rdparty/bin:/usr/local/bin:/usr/bin:/bin GIT_TERMINAL_PROMPT=0 git pull --ff-only -q origin main && /bin/bash deploy.sh --if-changed >> /home/manycez2q2t3/deploy.log
     ```
   When nothing changed it does nothing and prints nothing. When something changed it adds one line to `~/deploy.log`. Errors go to the cPanel contact email.
2. **The buttons (backup).** Git Version Control > `hosting` > Manage > Pull or Deploy: **Update from Remote**, then **Deploy HEAD Commit** (`.cpanel.yml` runs `deploy.sh`). Use this when you cannot wait for the next cron run.

## If it does not go live

- `./ship.sh verify` shows the live release. Compare it with `git log -1 --format=%h`.
- Look at `~/deploy.log` (cPanel File Manager, home folder). The last line is the last deploy.
- Look for a cron error email. Usual causes: the clone has local changes, or the PATH line is wrong.
- Fastest fix: use the two buttons.

## Rollback

`git log --oneline -5`, then `git revert <bad-commit>`, `./ship.sh "revert: why"`. A rollback is always a new commit, because only the newest commit is ever deployed.

## Hard rules

1. **Never edit files in cPanel File Manager.** The next deploy overwrites them and git will not know.
2. **`credentials.php` never goes into git.** It lives only on the server (next to `contact.php`) and on this PC.
3. **The repo is public.** Nothing private goes in: no passwords, no deal names, no figures you would not put on a billboard.
4. `rate_limit.json` and `form_submissions.txt` are written by `contact.php` on the server. `.htaccess` blocks them from the web. Keep that block.
5. The line `<meta name="release" content="__RELEASE__">` in `index.php` must stay: `deploy.sh` and `ship.sh` use it to know which version is live.
