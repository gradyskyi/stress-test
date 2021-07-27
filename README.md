### Run service with 
```
./vendor/bin/sail up -d
```

### Install dependencies
```
docker exec -i app bash -c "composer install"
```

### Run migrations
```
docker exec -i app bash -c "php artisan migrate"
```

### Create fake data, go to
```
http://localhost/api/make-fake-data
```

### Run siege 
without cache:
```
siege -b -c8 -v -t20s localhost/products
```
with cache:
```
siege -b -c8 -v -t20s localhost/products-cache
```
with self ttl cache:
```
siege -b -c8 -v -t20s localhost/products-cache-stampede
```
with probabilistic cache invalidation:
```
siege -b -c8 -v -t20s localhost/products-cache-exp
```