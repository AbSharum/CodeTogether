# CodeTogether

A PHP social platform for CS students — think a small social network scoped to a class: user accounts/roles, a friends-based post feed with comments and likes, direct messages, user profiles with an "about me" and profile picture, a points/leaderboard system, an AI chat widget with selectable personalities, and a couple of mini-games/flashcards features.

This was built as a **team project** — see the repository's commit history for individual contributors; this README does not claim sole authorship.

> Note: the git history for this repo contains an old, now-untracked MariaDB data directory that was previously committed and later removed from tracking. That's a history artifact only — it does not affect the current working tree or the setup below.

## Tech stack

- **PHP 8.2** (custom hand-rolled MVC framework — no Laravel/Symfony/etc.), running on **Apache** (`mod_rewrite` enabled) via the official `php:8.2-apache` Docker image
- **MariaDB** (latest, official Docker image) for storage
- Plain HTML/CSS/JS on the front end (per-page CSS/JS under `app/public/css` and `app/public/js`, no JS framework/bundler)
- **Docker Compose** to run the app + database together

## Repository layout

The actual application lives in the **nested** `CodeTogether/CodeTogether/` directory (this outer folder is the git repo root):

- `CodeTogether/app/` — the PHP application (mounted into the container as `/var/www/html`)
  - `app/index.php` — front controller / entry point
  - `app/config/Router.php`, `Controller.php`, `DbConn.php`, `Socket.php` — routing, base controller, DB connection, and a websocket-ish helper
  - `app/controllers/` — one controller per feature/route (login, create account, home feed, posts, comments, likes, messages, profile, account settings, search, games, flash cards, AI widget, etc.)
  - `app/dao/` — data access objects (`UserDAO`, `PostDAO`, `CommentDAO`, `FriendListDAO`, `MessageDAO`, `ThreadDAO`, `RoleDAO`, ...), all using parameterized `mysqli` queries
  - `app/models/` — plain data objects (`User`, `Post`, `Comment`, `Friend`, `Message`, `Thread`, `Chat`, `Game`, ...)
  - `app/public/` — views, CSS, JS, images, and a bundled Windows PHP runtime under `LOCAL_LIBRARIES/` (used for local, non-Docker development on Windows; not needed if you use Docker)
- `CodeTogether/Dockerfile` — builds the `php:8.2-apache` image (`mysqli` + `sockets` extensions, `mod_rewrite`, dev error display enabled)
- `CodeTogether/docker-compose.yml` — defines the `php-apache` (app, ports 8080/8060) and `mariadb` (port 3305) services on a shared bridge network
- `CodeTogether/apache-config.conf` — Apache `AllowOverride All` / `Require all granted` override for `/var/www/html`
- `CodeTogether/mariadb/mariadb-init/init.sql` — schema (`role`, `user`, `friend_list`, `thread`, `thread_bridge`, `post`, `comment`, `post_likes`, `message`, `game`, `game_bridge`, `chat`, `chat_bridge`, ...), auto-run by the MariaDB container on first startup
- `CodeTogether/mariadb/mariadb-data/` — the container's persisted database files (bind-mounted; not something you edit by hand)
- `CodeTogether/docker-compose-start.sh`, `freshDb.sh`, `dbMod.sh` — convenience shell scripts (see below)
- `Documentation/` — design docs produced for the project: an ERD (`Documentation/ERD/ERD.png` / `.puml`), a class diagram (`Documentation/ClassDiagram/`), interface/implementation design write-ups (LaTeX + PDF under `Documentation/LaTex/`, `Interface Design/`, `Implementation Design/`), a system architecture diagram, and a sprint-planning doc. Refer to those files directly for the data model and architecture rather than duplicating them here.
- `Project/` — earlier prototype/scratch pages (`login.html`, `social-feed.html`, a standalone `ProfilePage/` PHP prototype) that predate/parallel the Dockerized `CodeTogether/app` — not part of the app that Docker Compose runs.

## Configuration

The app is configured entirely through environment variables, supplied via `CodeTogether/CodeTogether/.env` (loaded by `docker-compose.yml`'s `env_file:` for both services) and read in `app/config/DbConn.php` via `getenv()`:

| Variable | Used for |
|---|---|
| `MYSQL_ROOT_PASSWORD` | MariaDB root password |
| `MYSQL_DATABASE` | database name (`CodeTogetherDB`) |
| `MYSQL_USER` / `MYSQL_PASSWORD` | app DB user/password (used by `DbConn.php`; `MYSQL_HOST` defaults to `mariadb`, the compose service name) |
| `API_KEY` | key for the AI chat widget's LLM calls (`app/public/includes/ai.php`) — leave blank to disable AI chat |
| `TEACHER_KEY` / `MOD_KEY` | invite/role-elevation keys used at account creation |
| `TZ` | container timezone |

A `.env` with working local-dev values already exists in this repo at `CodeTogether/CodeTogether/.env` (this is what the original README meant by "reach out to one of the original developers for the correct `.env` file" — you may need a real `API_KEY` for the AI features to work, everything else works out of the box).

## Setup & running

Requires [Docker](https://www.docker.com/) (with Compose). All commands below are run from `CodeTogether/CodeTogether/` (the directory containing `docker-compose.yml`).

**Linux:**
```bash
./docker-compose-start.sh -d --build   # wraps `docker compose up`; needs sudo for uploads dir permissions
```

**Any OS (manual):**
```bash
mkdir -p app/public/uploads   # required if not already present
docker compose up -d --build
```

The app will be reachable at **http://localhost:8080**. MariaDB is exposed on host port **3305** (mapped to the container's 3306) if you want to connect with an external SQL client.

On first run, MariaDB executes `mariadb-init/init.sql` automatically to create the schema.

**Other scripts** (run from `CodeTogether/CodeTogether/`, Linux/WSL — they use `sudo`):
- `./freshDb.sh` — stops the containers, wipes `mariadb/mariadb-data/` and `app/public/uploads/`, and restarts with a completely fresh database.
- `./dbMod.sh` — execs into the running `mariadb` container and opens a `mariadb` client shell against `CodeTogetherDB` using the credentials from `.env`.

To stop everything: `docker compose down` (from the same directory).
