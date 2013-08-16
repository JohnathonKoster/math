<?php namespace Flare\Math;

class Math {

	/**
	 * The SolutionEngineInterface implementation.
	 *
	 * @var \Flare\Math\SolutionEngineInterface
	 */
	protected $solutionEngine;

	/**
	 * The ExecutionEngineInterface implementation.
	 *
	 * @var \Flare\Math\ExecutionEngineInterface
	 */
	protected $executionEngine;

	/**
	 * Returns a new instance of Math.
	 *
	 * @return \Flare\Math\Math
	 */
	public function __construct(\Flare\Math\SolutionEngineInterface $solutionEngine, \Flare\Math\ExecutionEngineInterface $executionEngine)
	{
		$this->solutionEngine = $solutionEngine;
		$this->executionEngine = $executionEngine;
	}

	/**
	 * Represents the ratio of the circumference of a
	 * circle to its diameter.
	 *
	 * @return double
	 */
	public function pi()
	{
		return M_PI;
	}

	/**
	 * Represents the natural logarithmic base.
	 *
	 * @return double
	 */
	public function e()
	{
		return M_E;
	}

	/**
	 * Returns the absolute value of a number.
	 *
	 * @param  float $number
	 * @return float|int
	 */
	public function abs($number)
	{
		return $this->executionEngine->abs($number);
	}

	/**
	 * Returns the arc cosine of a number.
	 *
	 * @param  float $number
	 * @return float The arc cosine of a number in radians.
	 */
	public function acos($number)
	{
		return ( (float) $this->executionEngine->acos($number) );
	}

	/**
	 * Returns the arc sine of a number.
	 *
	 * @param  float $number
	 * @return float The arc sine of a number in radians.
	 */
	public function asin($number)
	{
		return ( (float) $this->executionEngine->asin($number) );
	}

	/**
	 * Returns the arc tangent of a number.
	 *
	 * @param  float $number
	 * @param  float $y      optional
	 * @return float The arc tangent of a number in radians.
	 */
	public function atan($number)
	{
		if (func_num_args() == 2)
		{
			// If the user has passed in two parameters, let's
			// assume that they want to calculate Atan2.
			return $this->executionEngine->atan2(func_get_arg(1), func_get_arg(2));
		}

		// If the number of arguments is not two, just calculate
		// the atan as normal.
		return ( (float) $this->executionEngine->atan($number) );
	}

	/**
	 * Calculates the arc tangent of two variables.
	 *
	 * @param  float $x
	 * @param  float $y
	 * @return float
	 */
	public function atan2($x, $y)
	{
		return ( (float) $this->executionEngine->atan2($x, $y) );
	}


	/**
	 * Returns the next highest integer of a number.
	 *
	 * @return int
	 */
	public function ceiling($number)
	{
		return $this->executionEngine->ceil($number);
	}

	/**
	 * Returns the cosine of the specified angle.
	 *
	 * @param  float $angle
	 * @return float
	 */
	public function cos($angle)
	{
		return ( (float) $this->executionEngine->cos($angle) );
	}

	/**
	 * Returns the hyperbolic cosine of the angle.
	 *
	 * @param  float $angle
	 * @return float
	 */
	public function cosh($angle)
	{
		return ( (float) $this->executionEngine->cosh($angle) );
	}

	/**
	 * Returns e raised to a given power.
	 *
	 * @param  float $number
	 * @return double
	 */
	public function exp($number)
	{
		return ( (double) $this->executionEngine->exp($number) );
	}

	/**
	 * Returns the next lowest integer of a number.
	 *
	 * @param  float $number
	 * @return int
	 */
	public function floor($number)
	{
		return $this->executionEngine->floor($number);
	}

	/**
	 * Returns the logarithm of a number in a specified base.
	 *
	 * @param  double $number
	 * @param  double $base optional
	 * @return double
	 */
	public function log($number, $base = M_E)
	{
		return $this->executionEngine->log($number, $base);
	}

	/**
	 * Returns the base-10 logarithm of a number.
	 *
	 * @param  double $number
	 * @return double
	 */
	public function log10($number)
	{
		return $this->executionEngine->log10($number);
	}

	/**
	 * Returns the highest value in the array of numbers.
	 *
	 * @param  array $numbers
	 * @return number
	 */
	public function max(array $numbers)
	{
		return $this->executionEngine->max($numbers);
	}

	/**
	 * Returns the lowest value in the array of numbers.
	 *
	 * @param  array $numbers
	 * @return number
	 */
	public function min(array $numbers)
	{
		return $this->executionEngine->min($numbers);
	}

	/**
	 * Returns a base number raised to an exponent.
	 *
	 * @param  $base     number
	 * @param  $exponent number
	 * @return float
	 */
	public function pow($base, $exponent)
	{
		return $this->executionEngine->pow($base, $exponent);
	}

	/**
	 * Rounds a number to the nearest value.
	 *
	 * @param float $number
	 * @param int   $precision optional The number of digits to round to.
	 * @param int   $mode      optional The rounding mode.
	 * @return number
	 */
	public function round($number, $precision = 0, $mode = PHP_ROUND_HALF_UP)
	{
		return $this->executionEngine->round($number, $precision, $mode);
	}

	/**
	 * Returns a value indicating the sign of a number.
	 *
	 * @param  number $number
	 * @return int
	 */
	public function sign($number)
	{
		return $this->executionEngine->sign($number);
	}

	/**
	 * Returns the sine of the given angle.
	 *
	 * @param  number $angle The angle in radians.
	 * @return number 
	 */
	public function sin($angle)
	{
		return $this->executionEngine->sin($angle);
	}

	/**
	 * Returns the hyperbolic sine of of the angle.
	 *
	 * @param  number $angle
	 * @return number
	 */
	public function sinh($angle)
	{
		return $this->executionEngine->sinh($angle);
	}

	/**
	 * Returns the square root of a given number.
	 *
	 * @param  number $number
	 * @return number
	 */
	public function sqrt($number)
	{
		return $this->executionEngine->sqrt($number);
	}

	/**
	 * Returns the tangent of a specified angle.
	 *
	 * @param  number $angle The angle in radians.
	 * @return number
	 */
	public function tan($angle)
	{
		return $this->executionEngine->tan($angle);
	}

	/**
	 * Returns the hyperbolic tangent of an angle.
	 *
	 * @param  number $angle
	 * @return number
	 */
	public function tanh($angle)
	{
		return $this->executionEngine->tanh($angle);
	}

	/**
	 * Returns the integral part of a given number.
	 *
	 * @param  float $number
	 * @return int|0 on failure
	 */
	public function truncate($number)
	{
		return $this->executionEngine->intval($number);
	}

	/**
	 * Returns the sum of two numbers.
	 *
	 * @param  number $numberOne
	 * @param  number $numberTwo
	 * @return number
	 */
	public function add($numberOne, $numberTwo)
	{
		return $this->executionEngine->add($numberOne, $numberTwo);
	}

	/**
	 * Returns the difference of two numbers.
	 *
	 * @param  number $numberOne
	 * @param  number $numberTwo
	 * @return number
	 */
	public function subtract($numberOne, $numberTwo)
	{
		return $this->executionEngine->subtract($numberOne, $numberTwo);
	}

	/**
	 * Returns the product of two numbers.
	 *
	 * @param  number $numberOne
	 * @param  number $numberTwo
	 * @return number
	 */
	public function multiply($numberOne, $numberTwo)
	{
		return $this->executionEngine->multiply($numberOne, $numberTwo);
	}

	/**
	 * Returns the quotient of two numbers.
	 *
	 * @param  number $numberOne
	 * @param  number $numberTwo
	 * @return number
	 */
	public function divide($numberOne, $numberTwo)
	{
		return $this->executionEngine->divide($numberOne, $numberTwo);
	}

	/**
	 * Returns the remainder of two numbers.
	 *
	 * @param  number $numberOne
	 * @param  number $numberTwo
	 * @return number
	 */
	public function mod($numberOne, $numberTwo)
	{
		return $this->executionEngine->mod($numberOne, $numberTwo);
	}

	/**
	 * Calculates the factorial of a number.
	 *
	 * @param  number $number
	 * @return number
	 */
	public function factorial($number)
	{
		return $this->executionEngine->factorial($number);
	}

	/**
	 * Solves the given equation. 
	 *
	 * @param  string $equation
	 * @return number
	 */	
	public function solve($equation)
	{
		return $this->solutionEngine->solve($equation);
	}

}