# Bootstrap package for Evolution CMS 2.0

install:

```
php artisan package:installrequire "mnoskov/evocms-bootstrap" "*"
php artisan vendor:publish
php artisan migrate --path vendor/mnoskov/evocms-bootstrap/migrations
```
