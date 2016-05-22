## Laravel 5 Themes

This is a package for the Laravel 5 Framework that adds basic support for managing themes. It allows you to seperate your views & your assets files in seperate folders, and supports for theme extending! Awesome :)

Features:

- Views & Asset seperation in theme folders
- Theme inheritence: Extend any theme and create Theme hierarcies (WordPress style!)
- Generate theme via artisan console


### Installation

install with

```composer
	composer require "xtwoend/laravel-themes"
```	

Add the service provider in app/config/app.php, Providers array:

```composer
	...
	Xtwoend\Themes\Providers\ThemesServiceProvider::class,
```

also edit the Facades array and add:

```composer
	...
	'Theme' => Xtwoend\Themes\Facades\Themes::class,
```

Almost Done. You can optionally publish a configuration file to your application with

php artisan vendor:publish --provider="Xtwoend\Themes\Providers\ThemesServiceProvider"

That's it. You are now ready to start theming your applications!

Working with Themes

The default theme can be configured in the themes.php configuration file. Working with themes is very straightforward. Use:

```
	Theme:set('themename')
```

or with middleware

add middleware theme set in App\Htpp\Kernel.php

```
	protected $routeMiddleware = [
		...
		'theme' => \Xtwoend\Themes\Middleware\SetCurrentTheme::class,
	]
```

set middleware in your route

```php
	Route::group(['middleware' => 'theme:themename'], function(){
		// any route
	});
```


