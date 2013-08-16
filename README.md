# math

A math package for Laravel 4.

## Usage

After installing and registering the service provider, you can use the math library by referencing the `Math` facade:

```
// app/routes.php

Route::get('/', function()
{

	$result = Math::abs(-1);

});

```