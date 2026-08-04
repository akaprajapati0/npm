# Local Docker Setup

This local stack runs all server applications:

- Nginx reverse proxy
- Next.js frontend
- Express/TypeScript backend
- MongoDB
- PHP/CodeIgniter legacy site
- MySQL

## Versions Matched From Server

- Node.js: `22.22.1`
- npm: `11.13.0`
- PM2 on server: `6.0.14`
- MongoDB: `8.0.19`
- MySQL: `8.0.46`
- PHP: `8.3.6`
- Next.js installed locally: `16.2.12`
- Backend framework installed locally: Express `5.2.1` with TypeScript `5.9.3`
- Nginx: `1.24.0`

## Start

```powershell
$env:DOCKER_CONFIG = Join-Path (Get-Location) ".docker-local"
docker compose -f docker-compose.local.yml up -d --build
```

## URLs

- Modern app through Nginx: `http://localhost`
- Backend health check through Nginx: `http://localhost/api/test`
- Backend direct: `http://localhost:5000/api/test`
- Frontend direct: `http://localhost:3000`
- Legacy PHP app through Nginx: `http://namedpatientprogram.local`

For the legacy PHP URL, add this hosts entry on your machine:

```text
127.0.0.1 namedpatientprogram.local namedpatientprogram.com www.namedpatientprogram.com
```

## Database

MongoDB:

- Container: `npp-local-mongo`
- Version: `8.0.19`
- Host port: `27017`
- App DB: `npp-db`
- Restore source: `server/db/mongodb/mongodump_2026-08-05.archive.gz`

Restore command:

```powershell
cmd.exe /c "docker exec -i npp-local-mongo mongorestore --archive --gzip --drop < server\db\mongodb\mongodump_2026-08-05.archive.gz"
```

MySQL:

- Container: `npp-local-mysql`
- Version: `8.0.46`
- Host port: `3306`
- App DB: `name_patient_program2026`
- Restore source: `server/db/mysql_dumps/db_dump_04_07_backup.sql`

Restore command:

```powershell
cmd.exe /c "docker exec -i npp-local-mysql mysql -uroot -plocalroot name_patient_program2026 < server\db\mysql_dumps\db_dump_04_07_backup.sql"
```

## Nginx

The local Nginx config mirrors the current app routing:

- `localhost /` proxies to the Next.js frontend container on port `3000`
- `namedpatientprogram.local /` serves the PHP/CodeIgniter app through PHP-FPM on port `9000`
- `/api/` proxies to the backend container on port `5000`
- `/uploads/` serves backend upload files read-only
- Public HTTP is exposed on port `80`, same as the server.

Production Nginx configs copied from the server are kept under `server/configs/nginx`.

## Stop

```powershell
docker compose -f docker-compose.local.yml down
```

## Local Setup Files

- `docker-compose.local.yml`
- `backend/Dockerfile.local`
- `frontend/Dockerfile.local`
- `docker/php/Dockerfile`
- `docker/php/database.local.php`
- `docker/nginx/default.conf`
- `.dockerignore`

Production `.env` and PHP source config files were not edited. Local-only URLs are injected by `docker-compose.local.yml`; the PHP DB config is mounted into the PHP container only.
