# Mini-CMS

## Install
in order to run this application just do the follwing steps:

```bash
git clone git@github.com:bastian-kurz/mini-cms.git
cd mini-cms

# This could run some minutes to build all images at the first time
docker-compose up

# In a new terminal  run the following commands

# Install composer dependencies within the docker container
# to fetch the dependencies for the correct php version
docker exec -it mini-cms-php composer install

# Create the database within the docker container
docker exec -it mini-cms-php php bin/console doctrine:database:create

# Make migration within the docker container
docker exec -it mini-cms-php php bin/console doctrine:migrations:migrate --no-interaction
```

is everything up and running it should look like this:
```bash
bastian.kurz@NB00242 mini-cms % docker ps
CONTAINER ID   IMAGE                           COMMAND                  CREATED        STATUS        PORTS                            NAMES
c0f60c52b7ae   mini-cms-golang                 "./server"               11 hours ago   Up 11 hours   0.0.0.0:8000->8081/tcp           mini-cms-golang
2e7e0a3b2a76   mini-cms-nginx                  "/docker-entrypoint.…"   2 days ago     Up 11 hours   8080/tcp, 0.0.0.0:8080->80/tcp   mini-cms-nginx
bfcd89721ff5   mini-cms-php-fpm                "/bin/sh -c 'chown -…"   2 days ago     Up 11 hours   9000/tcp                         mini-cms-php
3ecfd0d417ac   mini-cms-mysql                  "docker-entrypoint.s…"   3 days ago     Up 11 hours   0.0.0.0:9018->3306/tcp           mini-cms-mysql
```

## Frontend-URL's
| URL                                   | Info                                     |
|---------------------------------------|------------------------------------------|
| localhost:8080                        | Default page                             |
| localhost:8080/user                   | Datatable with jsonplaceholder user data |
| localhost:8080/login                  | Login page for cms admin backend         |
| localhost:8080/api/_info/swagger.html | Swagger UI                               |
| localhost:8080/{isoCode}/{title}      | Generic cms pages                        |

## Backend Users
| email          | password      | scopes               |
|----------------|---------------|----------------------|
| admin@admin.de | adminPassword | ROLE_ADMIN,ROLE_USER |
| user@user.de   | userPassword  | ROLE_USER            |

## OpenApi YAML
```bash
path: ./openapi.yaml
```

## PHPUnit
```bash
# Run PHPUnit tests within docker container
docker exec -it mini-cms-php ./vendor/bin/phpunit
```

## Exercises
1. localhost:8080/de/impressum && localhost:8080/en/imprint
2. GET localhost:8080/api/content
3. localhost:8080/user
4. localhost:8080/login

## Bonus1
openapi.yaml is in root folder
## Bonus2
Golang - API will start on PORT 8000 and has the same /api/content endpoints like the php one


## Golang Endpoints
| Method | URL                               | Body                                                                    | Info               |
|--------|-----------------------------------|-------------------------------------------------------------------------|--------------------|
| GET    | localhost://8000/api/content      |                                                                         | Show list          |
| GET    | localhost://8000/api/content/{id} |                                                                         | Show single result |
| POST   | localhost://8000/api/content      | ```{"isoCode": "UN","title": "Unit-Test","text": "Unit-Test-Text"}```   | Add new record     |
| PATCH  | localhost://8000/api/content/{id} | ```{"isoCode": "UD","title": "Unit-Test2","text": "Unit-Test-Text3"}``` | Update record      |
| DELETE | localhost://8000/api/content/{id} |                                                                         | Delete record      |