# How to Ship a Change to www.manycents.co.za

Same idea as LoadMatch: nothing on this PC reaches the live site by itself. GitHub is the middle, and the server only changes when it pulls.

```
[ This PC ] --git push--> [ GitHub: lateganluhein/hosting, main ] --cPanel pulls--> [ public_html ] --> LIVE
```

| Place | Path | Role |
|---|---|---|
| This PC | `~/manycents/hosting` | You edit here |
| GitHub | `lateganluhein/hosting`, branch `main` (public) | The copy cPanel trusts |
| cPanel clone | `/home/manycez2q2t3/repositories/hosting` | Pulled by cPanel |
| Live files | `/home/manycez2q2t3/public_html` | Copied from the clone by `.cpanel.yml` |

## 1. On this PC: change, look, push

```bash
cd ~/manycents/hosting
php -S 127.0.0.1:$(portcheck --free) -t .      # view only; do not submit the form, it sends real mail
./ship.sh "what changed"                        # lints, shows the file list, asks, commits, pushes
```

## 2. In cPanel: pull and deploy

Git Version Control > `hosting` > Manage > **Pull or Deploy**:

1. **Update from Remote**
2. **Deploy HEAD Commit**

`.cpanel.yml` copies `index.php`, `contact.php`, `.htaccess`, `favicon.png` into `public_html` and removes the old Magomba page and images.

## 3. Verify live

```bash
./ship.sh verify
```

Then hard-refresh the browser (Ctrl+F5) and click through the page and the contact form once.

## Rollback

`git log --oneline -5`, then `git revert <bad-commit>`, `./ship.sh "revert: why"`, and repeat step 2. cPanel only deploys the newest commit, so a rollback is always a new commit.
Before the very first deploy of the new site, download a copy of `public_html` once (cPanel > File Manager > Compress > Download).

## Hard rules

1. **Never edit files in cPanel File Manager.** The next deploy overwrites them and git will not know.
2. **`credentials.php` never goes into git.** It lives only on the server (next to `contact.php`) and on this PC. `.cpanel.yml` does not touch it.
3. **The repo is public.** Nothing private goes in: no passwords, no deal names, no figures you would not put on a billboard.
4. `rate_limit.json` and `form_submissions.txt` are written by `contact.php` on the server. `.htaccess` blocks them from the web. Keep that block.
5. If **Deploy HEAD Commit** is greyed out, the cPanel clone has uncommitted changes or no `.cpanel.yml` in HEAD. Send the message cPanel shows.
