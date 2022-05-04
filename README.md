## Installation

Clone project :
`git clone git@github.com:rmdeias/Dilitrust.git`

###  Run docker compose

`docker-compose up -d`

### Install vendor

`docker-compose exec php composer install`

### Prepare DB

docker-compose exec php bin/console doctrine:migrations:mig

### Asset build

/!\ Require node on local
```shell
yarn install
yarn build
```

### Clear cache
docker-compose exec php bin/console doctrine:cache:clear

###

The site is available on http://localhost:8080