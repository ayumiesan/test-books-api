### Installation

Run docker
```
docker-compose up -d
```

Update dependencies
```
composer install
```

Create and initialise database
```
docker-compose exec app php app/console doctrine:migrations:migrate
docker-compose exec app php app/console doctrine:fixtures:load -n
```

### Access

Access to application (dev) : `localhost:10090/app_dev.php`

Access to phpmyadmin : `localhost:10002/app_dev.php`
