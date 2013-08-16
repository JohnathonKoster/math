# math

A math package for Laravel 4.

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

The math package provides the following functions 


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