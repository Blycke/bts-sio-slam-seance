# 📋 Récapitulatif des commandes d'installation

Ce document rassemble toutes les commandes nécessaires pour *lancer et mettre en place* l'environnement BiblioTech Laravel en suivant les guides `README.md` et les différents fichiers `docs/*.md`.

---

## 🚀 1. Codespace GitHub (option recommandée)

> Utiliser un Codespace supprime le besoin d'installer quoi que ce soit localement.

1. Aller sur le dépôt GitHub.
2. Cliquer sur **"< > Code" → "Codespaces"**.
3. Créer un nouveau Codespace sur la branche `main`.
4. Attendre 30 s que l'environnement soit prêt (configuration automatique via `.devcontainer`).
5. Dans le terminal du Codespace :
   ```bash
   # (le `postCreateCommand` s'exécute automatiquement)
   # démarrer le serveur si besoin :
   php artisan serve --host=0.0.0.0 --port=8000
   # autres commandes utiles
   php artisan route:list
   php artisan tinker
   php artisan optimize:clear
   tail -f storage/logs/laravel.log
   ```
6. Pour ouvrir l'app, cliquer sur l'icône 🌐 dans l'onglet PORTS du Codespace (port 8000).


## ⚡ 2. Installation locale automatique (scripts)

**Windows**
```powershell
# installation complète
scripts\install.bat
# démarrage du serveur
scripts\start.bat
```

**Linux/Mac/WSL**
```bash
bash scripts/install.sh    # installe dépendances, configure .env, crée base, migre/seeds
bash scripts/start.sh      # démarre laravel serve
```

**PowerShell (Windows)**
```powershell
scripts\install.ps1
scripts\start.ps1
```

> Le script shell vérifie PHP/composer, crée `.env`, génère la clé, crée la DB SQLite,
> exécute `php artisan migrate --force` et `db:seed`, puis nettoie les caches.


## 🔧 3. Installation manuelle (sans script)

```bash
# 1. Cloner le projet
git clone https://github.com/votre-org/bibliotech.git
cd bibliotech

# 2. Installer PHP 8.3+ et extensions requises (session, fileinfo, dom, xmlwriter, tokenizer, iconv, pdo_sqlite, etc.)
# Exemple sur Linux (Alpine dans le container) :
sudo apk add php83 php83-cli php83-phar php83-openssl php83-pdo_sqlite \
             php83-mbstring php83-xml php83-curl php83-zip \
             php83-dom php83-fileinfo php83-iconv php83-session \
             php83-tokenizer php83-xmlwriter
sudo ln -s /usr/bin/php83 /usr/bin/php

# 3. Installer Composer
sudo php -r "copy('https://getcomposer.org/installer','composer-setup.php');"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
sudo ln -s /usr/local/bin/composer /usr/bin/composer

# 4. Installer dépendances PHP
composer install --no-interaction --optimize-autoloader

# 5. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 6. Créer base SQLite
mkdir -p database
touch database/database.sqlite

# 7. Migrer et seed
php artisan migrate
php artisan db:seed --class=DatabaseSeeder

# 8. Démarrer le serveur
php artisan serve
```

## 🐳 4. Docker (optionnel, avancé)

```bash
# lancer MailHog et PostgreSQL éventuels
docker-compose up mailhog
php artisan serve
```

---

## 🔎 Commandes utiles supplémentaires

```bash
php artisan route:list           # liste des routes
php artisan tinker               # console interactive
php artisan optimize:clear       # vider caches
php artisan storage:link         # lien public/storage
php artisan migrate:fresh --seed # reconstruire la base
npm install && npm run build     # compiler les assets (si Node installé)
```

> En Codespace, les extensions recommandées (Intelephense, Blade, etc.) et
> configurations `.vscode/settings.json` sont pré‑configurées.

---

Ce résumé doit permettre à toute personne de reproduire rapidement l'installation et
le lancement de l'application BiblioTech, quel que soit l'environnement choisi.

Bonne découverte ! 🎉
