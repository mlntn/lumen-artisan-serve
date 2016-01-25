# artisan serve... for Lumen

artisan serve for Lumen projects

# Installation

1. `composer require mlntn/lumen-artisan-serve "~1"`

2. Add the following line to the $commands array in app/Console/Kernel.php:

    `\Mlntn\Console\Commands\Serve::class,`

3. artisan serve

# Disclaimer

I didn't write most of this code. It comes straight from [laravel/framework](https://github.com/laravel/framework) by [@taylorotwell](https://github.com/taylorotwell). I did have to tweak a few things to get it going for Lumen. Enjoy!
