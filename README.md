# Mini-CMS

## Install
in order to run this application just do the follwing steps:

```bash
git clone git@github.com:bastian-kurz/mini-cms.git
cd mini-cms

docker-compose up

# In a new termina  run the following commands

# Install composer dependencies within the docker container
# to fetch the dependencies for the correct php version
docker exec -it mini-cms-php composer install

# Create the database within the docker container
docker exec -it mini-cms-php php bin/console doctrine:database:create

# Make migration within the docker container
docker exec -it mini-cms-php php bin/console doctrine:migrations:migrate
```
## Frontend-URL's
| URL            | Info                                     |
|----------------|------------------------------------------|
| localhost:8080 | Default page                             |
| localhost:8080/user | Datatable with jsonplaceholder user data |
| localhost:8080/login | Login page for cms admin backend         |
| localhost:8080/api/_info/swagger.html | Swagger UI |
| localhost:8080/{isoCode}/{title} | Generic cms pages |

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
2. localhost:8080/api/content
3. localhost:8080/user
4. localhost:8080/login

Bonus: openapi.yaml in root folder