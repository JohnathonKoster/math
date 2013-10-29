# math

A math package for Laravel 4.

## Installation

The easiest way to install `math` for Laravel 4 is to use Composer. Add this to your `composer.json` file:

```
"flare/math": "*"
```

After your have added that run the `composer update` command to have the math package downloaded and placed in your vendor folder.

### Registering the Service Provider

After you have downloaded math using Composer, add this to your providers array in the `app.php` config file:

```
'Flare\Math\MathServiceProvider',
```

### Registering the Facade (optional)

To register the facade for the math package, add this entry to your aliases in the `app.php` configuration file:

```
'Math'			  => 'Flare\Math\Facades\Math',
```

After this, you should be all set to go! Enjoy!

## Usage

After installing and registering the service provider, you can use the math library by referencing the `Math` facade:

```
// app/routes.php

Route::get('/', function()
{

	// Calculate the absolute value of -1
	$result = Math::abs(-1);

});

```

### The `Math::solve()` Function

The math package provides a `solve()` function through the `Math` facade. This function can be used to solve equations or expressions entered by the user.

**Example**
```
// app/routes.php

Route::get('/', function()
{

	// Create a new function f(x) = 2 + x
	Math::solve('f(x) = 2 + x');

	// Reference our previous function and pass in 23.
	$result = Math::solve('f(23)');

	// Result is equal to 25.
	echo $result;

});
```

We can also use *all* of the general math functions that are listed below:
```
// app/routes.php

Route::get('/', function()
{

	// Outputs 9.3326215443944E+157
	echo Math::solve('abs(factorial(100))');

});

```



### General Math Functions

The math package currently provides the following functions from the `ExecutionEngineInterface` and be accessed through the Math object aliased through the `Math` facade.

* `abs($number)` - Returns the absolute value of a number.
* `acos($number)` - Returns the arc cosine of a number.
* `asin($number)` - Returns the arc sine of a number.
* `atan($number)` - Returns the arc tangent of a number.
* `atan2($x, $y)` - Calculates the arc tangent of two variables.
* `ceiling($number)` - ceiling($number)
* `cos($angle)` - Returns the cosine of the specified angle.
* `cosh($angle)` - Returns the hyperbolic cosine of the angle.
* `exp($number)` - Returns e raised to given power.
* `floor($number)` - Returns the next lowest integer of a number.
* `log($number, $base = M_E)` - Returns the logarithm of a number in a specified base.
* `log10($number)` - Returns the base-10 logarithm of a number.
* `max(array $numbers)` - Returns the highest value in the array of numbers.
* `min(array $numbers)` - Returns the lowest value in the array of numbers.
* `pow($base, $exponent)` - Returns a base number raised to an exponent.
* `round($number, $precision = 0, $mode = PHP_ROUND_HALF_UP)` - Rounds a number to the nearest value.
* `sign($number)` - Returns a value indicating the sign of a number.
* `sin($angle)` - Returns the sine of the given angle.
* `sinh($angle)` - Returns the hyperbolic sine of of the angle.
* `sqrt($number)` - Returns the square root of a given number.
* `tan($angle)` - Returns the tangent of a specified angle.
* `tanh($angle)` - Returns the hyperbolic tangent of an angle.
* `truncate($number)` - Returns the integral part of a given number.
* `add($numberOne, $numberTwo)` - Returns the sum of two numbers.
* `subtract($numberOne, $numberTwo` - Returns the difference of two numbers.
* `multiply($numberOne, $numberTwo)` - Returns the product of two numbers.
* `divide($numberOne, $numberTwo)` - Returns the quotient of two numbers.
* `mod($numberOne, $numberTwo)` - Returns the remainder of two numbers.
* `factorial($number)` - Calculates the factorial of a number.

## Drivers

### ExecutionEngineInterface

The math package allows you to write your own driver that will change how it performs the actual math operations. For example, you could create a new driver using the functions in the `BCMath` or the `GMP` math extensions. Just create a new driver that implements the `Flare\Math\ExecutionEngineInterface` contract.

There is a default driver that uses your systems default math operations: `Flare\Math\Drivers\MathExecutionEngine`

If you create a new driver, you may register it with the IoC like so:

```

class MyNewEngine implements \Flare\Math\ExecutionEngineInterface {
	
	// You will have to implement quite a few methods.

}

// app/routes.php

App::bind('ExecutionEngineInterface', new MyNewEngine());

```

After this the math package will now use your driver implementation.


### SolutionEngineInterface

The math package defines a code contract `Flare\Math\SolutionEngineInterface`. Your implementations of this will allow you to change the behavior of the `Math::solve($expression)` function.

For example, you could write a driver that does API calls to WolframAplha to provide answers to expressions entered by the user.

There is a default implementation that can be found at `Flare\Math\Drivers\EvalMathDriver`.
