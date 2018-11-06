# Simple PHP Image Optimisation
PHP image optimisation using Windows binaries jpegtran (jpg), pngquant (png), gifsicle (gif)

Simply execute in commande line the binary path with file as argument 

#composer
```php
composer require tlissak/imageoptimisation
```


usage :
```php
$imageoptimize = new ImageOptimisation('image.jpg') ;
$imageoptimize->optimize() ;
```
