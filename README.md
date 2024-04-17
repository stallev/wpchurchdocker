# 🚀 Run Existing WordPress Site Locally With Docker

## Overview 🌟
Easily set up a local development environment for your existing WordPress site using Docker. This solution is ideal for developing and testing in an environment that mirrors your live site.

## Requirements 🛠️
- Docker and Docker Compose installed.

## Containers 📦
1. **WordPress Container**: 
   - **Volumes**:
     - `site/wp-content`: Place your production `wp-content` folder here. It includes themes, plugins, uploads, etc. 🎨

2. **Database (DB) Container**:
   - **Volumes**:
     - `mysqldumps/backup.sql`: Put your production database snapshot here. It's imported automatically on first run. 🔄
     - `init/migrate.sh`: URL migration script, runs automatically. 🌐

## Setup 🔧
1. **Clone/Download**: Get the project files. 👨‍💻
2. **Database Prep**: Create a dump from the live database and save it as `mysqldumps/backup.sql`. 🗃️
3. **Content Prep**: Copy `wp-content` from your site to `site/wp-content`. 📂
4. **Change Urls**: Change first previous name to next domain name in the sql dump file.
5. **Configuration**: Set variables in `.env`. 📝
6. **Run**: In the project root, execute:

```
sudo docker-compose up -d && docker exec -ti wordpress '/prep.sh'
```

Access your site at `http://localhost` (or server IP ) and the admin panel at `http://localhost/wp-admin`. 🌍
