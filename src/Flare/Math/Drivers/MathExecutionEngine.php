<?php namespace Flare\Math\Drivers;

use \Flare\Math\ExecutionEngineInterface as Engine;

class MathExecutionEngine implements Engine {


	/**
	 * Returns the absolute value of a number.
	 *
	 * @param  float $number
	 * @return float|int
	 */
	public function abs($number)
	{
		return abs($number);
	}

	/**
	 * Returns the arc cosine of a number.
	 *
	 * @param  float $number
	 * @return float The arc cosine of a number in radians.
	 */
	public function acos($number)
	{
		return ( (float) acos($number) );
	}

	/**
	 * Returns the arc sine of a number.
	 *
	 * @param  float $number
	 * @return float The arc sine of a number in radians.
	 */
	public function asin($number)
	{
		return ( (float) asin($number) );
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
			return $this->atan2(func_get_arg(1), func_get_arg(2));
		}

		// If the number of arguments is not two, just calculate
		// the atan as normal.
		return ( (float) atan($number) );
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
		return ( (float) atan2($x, $y) );
	}


	/**
	 * Returns the next highest integer of a number.
	 *
	 * @return int
	 */
	public function ceiling($number)
	{
		return ceil($number);
	}

	/**
	 * Returns the cosine of the specified angle.
	 *
	 * @param  float $angle
	 * @return float
	 */
	public function cos($angle)
	{
		return ( (float) cos($angle) );
	}

	/**
	 * Returns the hyperbolic cosine of the angle.
	 *
	 * @param  float $angle
	 * @return float
	 */
	public function cosh($angle)
	{
		return ( (float) cosh($angle) );
	}

	/**
	 * Returns e raised to a given power.
	 *
	 * @param  float $number
	 * @return double
	 */
	public function exp($number)
	{
		return ( (double) exp($number) );
	}

	/**
	 * Returns the next lowest integer of a number.
	 *
	 * @param  float $number
	 * @return int
	 */
	public function floor($number)
	{
		return floor($number);
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
		return log($number, $base);
	}

	/**
	 * Returns the base-10 logarithm of a number.
	 *
	 * @param  double $number
	 * @return double
	 */
	public function log10($number)
	{
		return log10($number);
	}

	/**
	 * Returns the highest value in the array of numbers.
	 *
	 * @param  array $numbers
	 * @return number
	 */
	public function max(array $numbers)
	{
		return max($numbers);
	}

	/**
	 * Returns the lowest value in the array of numbers.
	 *
	 * @param  array $numbers
	 * @return number
	 */
	public function min(array $numbers)
	{
		return min($numbers);
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
		return pow($base, $exponent);
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
		return round($number, $precision, $mode);
	}

	/**
	 * Returns a value indicating the sign of a number.
	 *
	 * @param  number $number
	 * @return int
	 */
	public function sign($number)
	{
		if ($number > 0)
		{
			return 1;
		}
		elseif ($number < 0)
		{
			return -1;
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Returns the sine of the given angle.
	 *
	 * @param  number $angle The angle in radians.
	 * @return number 
	 */
	public function sin($angle)
	{
		return sin($angle);
	}

	/**
	 * Returns the hyperbolic sine of of the angle.
	 *
	 * @param  number $angle
	 * @return number
	 */
	public function sinh($angle)
	{
		return sinh($angle);
	}

	/**
	 * Returns the square root of a given number.
	 *
	 * @param  number $number
	 * @return number
	 */
	public function sqrt($number)
	{
		return sqrt($number);
	}

	/**
	 * Returns the tangent of a specified angle.
	 *
	 * @param  number $angle The angle in radians.
	 * @return number
	 */
	public function tan($angle)
	{
		return tan($angle);
	}

	/**
	 * Returns the hyperbolic tangent of an angle.
	 *
	 * @param  number $angle
	 * @return number
	 */
	public function tanh($angle)
	{
		return tanh($angle);
	}

	/**
	 * Returns the integral part of a given number.
	 *
	 * @param  float $number
	 * @return int|0 on failure
	 */
	public function truncate($number)
	{
		return intval($number);
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
		return $numberOne + $numberTwo;
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
		return $numberOne - $numberTwo;
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
		return $numberOne * $numberTwo;
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
		return $numberOne / $numberTwo;
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
		return $numberOne % $numberTwo;
	}

	/**
	 * Calculates the factorial of a number.
	 *
	 * @param  number $number
	 * @return number
	 */
	public function factorial($number)
	{
		// Handle 0
		if ($number == 0)
		{
			return 1;
		}

		$temp = $number;

		while ($temp > 1)
		{
			$number = $this->multiply($number, $this->subtract($temp, 1));
			$temp = $this->subtract($temp, 1);
		}
		return $number;		
	}

}