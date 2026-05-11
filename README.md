# DeviseApp — Backend API

API REST Laravel pour la gestion de devises et droits d'accès.

## Prérequis

- PHP 8.2+
- Composer
- MySQL 8.0+

## Installation

```bash
# 1. Cloner le projet
git clone <url-du-repo> && cd deviseApp-back

# 2. Installer les dépendances
composer install

# 3. Copier le fichier d'environnement
cp .env.example .env

# 4. Générer la clé applicative
php artisan key:generate

# 5. Configurer la base de données dans .env
# DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Lancer les migrations && seed
php artisan migrate
php artisan db:seed

# 7. Démarrer le serveur
php artisan serve
```

L'API est accessible sur **http://localhost:8000**.
