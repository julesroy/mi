```text
 ____            _   __  __ ___ _    ____ _                   
|  _ \ __ _ _ __( ) |  \/  |_ _( )  / ___(_) __ _ _ __   ___  
| |_) / _` | '__|/  | |\/| || ||/  | |  _| |/ _` | '_ \ / _ \ 
|  __/ (_| | |      | |  | || |    | |_| | | (_| | | | | (_) |
|_|   \__,_|_|      |_|  |_|___|    \____|_|\__,_|_| |_|\___/ 
```
---

### 📄 Description :

Ce projet sera le site utilisé par la Maison ISEN pour l'année 2025-2026. Il permettra entre autres aux utilisateurs de commander des repas, et aux membres de l'association de gérer les commandes, les stocks, les comptes utilisateurs, etc.

### 🖥️ Langages/Frameworks/Outils utilisés :

#### ⌨️ Langages :
![PHP](https://a11ybadges.com/badge?logo=php)  
![JavaScript](https://a11ybadges.com/badge?logo=javascript)  
![HTML5](https://a11ybadges.com/badge?logo=html5)  
![CSS3](https://a11ybadges.com/badge?logo=css3)  

#### 📘 Frameworks :
![Laravel](https://a11ybadges.com/badge?logo=laravel)  
![Tailwind CSS](https://a11ybadges.com/badge?logo=tailwindcss)  

#### 🪛 Outils :
![MySQL](https://a11ybadges.com/badge?logo=mysql)  
![Git](https://a11ybadges.com/badge?logo=git)  
![GitHub](https://a11ybadges.com/badge?logo=github)  
![OVH](https://a11ybadges.com/badge?logo=ovh)  

### ⬇️ Installation :

On se place à la racine du projet

Installation des dépendances :

```powershell
composer install
```

Installation des dépendances Node.JS (pour Nodemon et TailwindCSS) :

```powershell
npm install
```

Lancement projet (active le hot reloading, compile TailwindCSS) :

```powershell
npm run dev
```

### ⚡ Exécution du projet :

Avant tout, il faut créer un fichier `.env` à la racine du projet, en se basant sur l'exemple suivant : 

```text	
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:ILJ4eDbQ+dKbTb289J6Lki0Lorpfv1MXjLyMTaBLndA=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000/

APP_LOCALE=fr
APP_FALLBACK_LOCALE=fr
APP_FAKER_LOCALE=fr_FR

APP_MAINTENANCE_DRIVER=file

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=errorlog
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_PORT=3306
DB_DATABASE=maisonisen-beta_db
DB_HOST=127.0.0.1
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file

FILESYSTEM_DISK=local

CACHE_STORE=file

QUEUE_CONNECTION=sync

BROADCAST_CONNECTION=log
```

Les variables `DB_DATABASE`, `DB_USERNAME` et `DB_PASSWORD` doivent être modifiées en fonction de votre configuration MySQL en local.

Il est possible d'importer la base de données depuis le fichier `maisonisen-beta_db.sql` situé à la racine du projet. Pour cela, vous pouvez utiliser un outil comme phpMyAdmin.

En cas de problème avec la base de données ou l'exécution en local du projet, il est possible de consulter le projet à l'adresse suivante : [https://maisonisen-beta.fr](https://maisonisen-beta.fr).

### 📄 Générer la documentation :

Pour PHP, on utilise PHPDocumentor :

```powershell
php phpDocumentor.phar run
```

Pour Javascript, on utilise JSDoc :

```powershell
npx jsdoc -c jsdoc.json
```
