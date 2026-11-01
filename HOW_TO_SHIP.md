# How to Update www.manycents.co.za (full process)

*Last updated 2026-11-01. Everything here describes what is actually built and live. If you change the process, change this file in the same commit.*

The short version: **edit here, run `./ship.sh "what changed"`, wait.** The server fetches the change from GitHub by itself within ten minutes and `ship.sh` tells you when it is live.

---

## 1. The picture

```
[ This PC ] --git push--> [ GitHub: luheinlategan/hosting, main ] --cPanel cron, every 10 min--> [ public_html ] --> LIVE
```

| Place | Where | Role |
|---|---|---|
| This PC | `~/manycents/hosting` | You edit here. Branch `main`. |
| GitHub | `github.com/luheinlategan/hosting`, branch `main` (**public**) | The copy the server trusts. |
| cPanel clone | `/home/manycez2q2t3/repositories/hosting` | The server's own copy; the cron job pulls into it. |
| Live files | `/home/manycez2q2t3/public_html` | What visitors get. Written only by `deploy.sh`. |
| Host | Afrihost **shared cPanel** hosting (LiteSpeed, `102.222.124.24`) | Also holds the company mail. Not the LoadMatch server. |

Nothing on This PC reaches the live site by itself, and **nothing is edited on the server**. GitHub is the middle.

Facts worth knowing:
- The repo is a submodule of `~/manycents` (`.gitmodules`), but you work in it as its own repo.
- It moved from the GitHub account `lateganluhein` to `luheinlategan` on 2026-11-01. cPanel's "Remote URL" still shows the old address and works through GitHub's redirect. **Never create a new repo called `hosting` under the old account**: it would break that redirect.
- Commits are authored as "Luhein Lategan" (global git setting). Older commits still show the old name; that is only a label.

---

## 2. What each file does

| File | Role | Deployed? |
|---|---|---|
| `index.php` | The whole site: one page with embedded CSS and JS. Starts a PHP session for the form's CSRF token. Contains `<meta name="release" content="__RELEASE__">`, which `deploy.sh` replaces with the commit. | Yes (stamped) |
| `contact.php` | The enquiry form handler: validation, CSRF, honeypot, 5 per hour per IP, the notification email, the auto-reply. | Yes |
| `.htaccess` | HTTPS redirect, caching, gzip, and a **deny** rule for `rate_limit.json`, `form_submissions.txt` and `credentials*.php`. | Yes |
| `favicon.png`, `manycents-logo.png` | Tab icon and header logo (the letterhead logo, cropped above its corner mark, transparent background). | Yes |
| `deploy.sh` | Runs **on the server**: copies the files above into `public_html`, stamps the release, deletes the old site's page and images. | It is the deployer |
| `.cpanel.yml` | Tells cPanel's "Deploy HEAD Commit" button to run `deploy.sh`. | No |
| `ship.sh` | Runs **on This PC**: checks, commit, push, wait for live, live check. | No |
| `HOW_TO_SHIP.md`, `README.md`, `CLAUDE.md` | Documentation. | No |
| `.github/workflows/test.yml` | GitHub's automatic check: PHP lint, HTML structure, form tests. | No |
| `credentials.php` | **Not in git, ever.** SMTP username and password for the backup mail route. Lives only on the server (next to `contact.php`) and on This PC. `credentials.example.php` shows the shape. | Never touched by deploys |
| `rate_limit.json`, `form_submissions.txt` | Written by `contact.php` on the server. Blocked from the web by `.htaccess`. | Never touched by deploys |

**A new file is not deployed until it is added to the `cp` line in `deploy.sh`.** Forgetting this is the classic mistake: the push succeeds, the live page 404s on the new file.

---

## 3. Making a change

1. **Edit** in `~/manycents/hosting`.
2. **Look at it** (view only; do not submit the form, it sends real email):
   ```bash
   php -S 127.0.0.1:$(portcheck --free) -t .
   ```
   Open the printed address. Stop the server when done (by the PID you started).
3. **Ship it:**
   ```bash
   ./ship.sh "what changed"
   ```
4. Wait for "Live: release abc1234 is on the site" and "All good."

### Where common things live

| To change | Edit |
|---|---|
| Any wording on the page (hero, coal grades, corridor, software) | `index.php` |
| Contact details (address, phone, emails) | `index.php` (contact section **and** footer), and the footer of the auto-reply in `contact.php` |
| Colours, fonts, spacing | The `:root` variables at the top of `index.php` |
| Header logo | Replace `manycents-logo.png` (keep the file name, or change `index.php` and `deploy.sh`) |
| Who receives enquiries | `TO_EMAIL` in `contact.php` |
| Auto-reply wording | The block between `// Build AUTO-REPLY` and `// Try PHP mail()` in `contact.php` (HTML and plain-text versions: change both) |
| Switch the auto-reply off | `ENABLE_AUTO_REPLY` in `contact.php` |
| Add or remove an asset | The file itself, **and** `deploy.sh` (`cp` / `rm` lines) |
| Mailbox password | `credentials.php` on the server and on This PC (not git) |

---

## 4. What `ship.sh` does

```bash
./ship.sh "what changed"   # the release
./ship.sh verify           # check the live site right now, change nothing
```

The release, in order:
1. Lints `index.php` and `contact.php`, syntax-checks `deploy.sh`; stops if `credentials.php` is tracked by git or there is nothing to commit; must be on `main`.
2. `git add -A`, shows the file list, and asks **"Commit and push these to GitHub (public repo)? [y/N]"**. Read the list: this repo is public.
3. Commits with your message and pushes to `origin main`.
4. **Waits up to 12 minutes**, checking every 30 seconds, until the live page's `<meta name="release">` equals the commit you pushed. Ctrl+C is safe; run `./ship.sh verify` later.
5. Runs the live check.

`./ship.sh verify` checks: the homepage is the new site; none of the retired wording is left (the word checked is in `ship.sh`); the live release number; `/index.html`, `/logo.png`, `/mining-image.png`, `/processing-image.png` are gone (404); `/manycents-logo.png` is served; `/rate_limit.json`, `/form_submissions.txt`, `/credentials.php` are not readable (403 or 404).

---

## 5. What happens on the server

### 5.1 The cron job (normal path)

One entry in **cPanel > Cron Jobs**, set up once on 2026-11-01:

| Minute | Hour | Day | Month | Weekday |
|---|---|---|---|---|
| `*/10` | `*` | `*` | `*` | `*` |

Command (one line):
```
cd /home/manycez2q2t3/repositories/hosting && PATH=/usr/local/cpanel/3rdparty/bin:/usr/local/bin:/usr/bin:/bin GIT_TERMINAL_PROMPT=0 git pull --ff-only -q origin main && /bin/bash deploy.sh --if-changed >> /home/manycez2q2t3/deploy.log
```

Every ten minutes it pulls from GitHub, and **only if the commit changed** runs `deploy.sh`. When nothing changed it does nothing and prints nothing. Another cron entry on the same page (`actiontrack`, every 15 minutes) belongs to a different application; leave it alone.

### 5.2 What `deploy.sh` does

1. Works out the short commit hash. With `--if-changed` it stops if `~/.deployed-sha` already holds that hash.
2. Checks `index.php` and `contact.php` exist.
3. Writes `public_html/index.php` from `index.php` with `__RELEASE__` replaced by the hash (to a temporary name first, then moves it, so a visitor never gets half a file).
4. Copies `contact.php`, `.htaccess`, `favicon.png`, `manycents-logo.png`.
5. Deletes the old site: `index.html`, `logo.png`, `mining-image.png`, `processing-image.png`.
6. Records the hash in `~/.deployed-sha` and appends one line to `~/deploy.log`.

It never touches `credentials.php`, `rate_limit.json` or `form_submissions.txt`.

### 5.3 Errors

stdout goes to `~/deploy.log` (cPanel File Manager, home folder, outside the web root). Errors (stderr) go to the address in cPanel's **Cron Email** setting; if that box is empty they vanish, so keep an address there.

### 5.4 The manual backup: the two buttons

**cPanel > Git Version Control > `hosting` > Manage > Pull or Deploy**: click **Update from Remote**, then **Deploy HEAD Commit**. `.cpanel.yml` makes the button run the same `deploy.sh`. Use it when you cannot wait for the next cron run, or when the cron job is not working.

---

## 6. Rollback

A rollback is always a new commit, because only the newest commit is ever deployed.

```bash
git log --oneline -5
git revert <bad-commit>
./ship.sh "revert: why"
```

For something urgent, use the two buttons after the push instead of waiting for the cron.

---

## 7. Troubleshooting

| Symptom | Likely cause | What to do |
|---|---|---|
| `ship.sh` says the release is not live after 12 minutes | Cron not running, clone dirty, wrong `git` path | Check `~/deploy.log`; look for a cron error email; use the two buttons; send the message cPanel shows |
| `./ship.sh verify` says "homepage is not the new site" | The deploy has not happened yet | Wait for the next 10-minute tick, or press the buttons |
| New file 404s on the live site | It is not in `deploy.sh` | Add a `cp` line, ship again |
| **Deploy HEAD Commit** greyed out | The cPanel clone has uncommitted changes or no `.cpanel.yml` in HEAD | Send the exact message; never edit files in the clone |
| **Update from Remote** fails | The old-address redirect, or a diverged clone | Send the message cPanel shows |
| Cron entry errors by email | `git` not at the PATH given, or no network | The email shows the line; the buttons still work |
| Page shows the old version | Browser cache | Ctrl+F5; compare `./ship.sh verify`'s "live release" with `git log -1 --format=%h` |
| Enquiry never arrives | Mail route, spam folder | See 7.1 |
| Auto-reply never arrives | Recipient's spam folder, or the relay | See 7.1 |
| GitHub's check is red | PHP syntax error, or the form tests | Open the run in the Actions tab |

### 7.1 Email checks

The form tries PHP `mail()` first, with `office@manycents.co.za` as the envelope sender (the `-f` flag), and uses authenticated SMTP (`credentials.php`) only if `mail()` fails. So a working test does **not** prove the SMTP password is right.

To see what happened to a message: **cPanel > Email > Track Delivery**, tick Show Successes, Deferred, Failures and In-Progress, and search the recipient. "Accepted" there means Afrihost's outgoing relay took it; Gmail's own decision (inbox, spam, Promotions) is invisible from cPanel, so check the recipient's folders. On 2026-11-01 a reply that left with the server account as the envelope sender was the cause of a missing auto-reply; setting `-f office@manycents.co.za` fixed it.

Sender checks for the domain (SPF, DKIM, DMARC) are published and correct; do not edit mail DNS for a website change.

---

## 8. Hard rules

1. **Never edit files in cPanel File Manager.** The next deploy overwrites them and git will not know.
2. **`credentials.php` never goes into git.** It stays only on the server and on This PC.
3. **The repo is public.** Nothing private goes in: no passwords, no names of deals or counterparties, no figures you would not put on a billboard.
4. **Keep `<meta name="release" content="__RELEASE__">` in `index.php`.** `deploy.sh` and `ship.sh` use it to know which version is live.
5. **Keep the `.htaccess` deny block** for `rate_limit.json`, `form_submissions.txt` and `credentials*.php`.
6. **Do not edit the mail DNS records** or the cPanel mail settings as part of a website change.
7. Do not run the form tests against production: they post to the real handler and send real mail.

---

## 9. History

- **2026-11-01** Site rebuilt from scratch ("Coal, corridors and code"): all content of the previous site removed; the letterhead logo in the header; contact section with CEO and Admin Office emails; auto-reply reworded and sent with `-f office@manycents.co.za`. Repo moved to `luheinlategan/hosting`. Deploy changed from two manual button clicks to a ten-minute cron job with `deploy.sh`, a commit stamp on the page, and `ship.sh` that waits for it.
- **Before:** an earlier single-page coal site; files uploaded by hand or by the cPanel buttons.
