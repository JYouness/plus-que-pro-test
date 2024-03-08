# Plus que PRO - Test d’évaluation

## Candidat: Youness Jabboua

#### Prérequis

Ce demo project utilise Laravel Sail & Docker.
Pour plus d'information, visiter la [documentation officielle](https://laravel.com/docs/installation#docker-installation-using-sail) de Laravel

### Stack

* PHP / Laravel
* Inertia
* Vue.js
* Tailwindcss

### Installation

Cloner le projet sur votre machine locale.

Dupliquer le fichier `.env.example` avec le nom `.env` et copier le token de TMDB API vers la clé `TMBD_TOKEN`

```dotenv
###...
TMBD_TOKEN=<Placer API Token ici>
```

Et ensuite, lancer cette commande pour installer les dépendances (composer) de Laravel:

```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

Après que les dépendances soient installées, lancer Laravel Sail avec cette commande:

```shell
./vendor/bin/sail up -d
```

Une fois que les containers sont démarrés, lancer ces commandes pour finaliser l'installtion:

```shell
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan sync:trending-movies
./vendor/bin/sail yarn install
./vendor/bin/sail yarn build
```

Et voila 🎉, vous pouvez visiter la demo sur http://localhost/

### Les identifiants / mot de passe pour la connexion si besoin

Il y a une page pour se authentifier au `dashboard` en visitant le lien http://localhost/login:

```
Email: john@example.com
Password: password
```

Ces identiants sont générés par un seeder, vous pouvez toujours créer un nouveau utilisateur en visitant le lien http://localhost/register

### Synchronisation des films en tendances

Pour lancer la synchronisation manuellement, utiliser la commande:

```shell
php artisan sync:trending-movies
```

> **Note:** Cette commande se lance automatiquement en daily vers 00:00 (minuit) grâce à Laravel [Task Scheduling](https://laravel.com/docs/scheduling)

### Packages

* Jetstream: https://jetstream.laravel.com/introduction.html
* Laravel Pint: https://laravel.com/docs/pint
* Laravel Debugbar : https://github.com/barryvdh/laravel-debugbar

### Documentation & Sites

* Laravel: https://laravel.com/docs
* Vue.js: https://vuejs.org/guide/introduction
* Inertia: https://inertiajs.com/
* Tailwindcss: https://tailwindcss.com/ 
* Flowbite: https://flowbite.com/
