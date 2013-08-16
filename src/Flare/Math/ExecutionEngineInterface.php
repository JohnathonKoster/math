<?php namespace Flare\Math;

interface ExecutionEngineInterface {
	
	/**
	 * Returns the absolute value of a number.
	 *
	 * @param  float $number
	 * @return float|int
	 */
	public function abs($number);

	/**
	 * Returns the arc cosine of a number.
	 *
	 * @param  float $number
	 * @return float The arc cosine of a number in radians.
	 */
	public function acos($number);

	/**
	 * Returns the arc sine of a number.
	 *
	 * @param  float $number
	 * @return float The arc sine of a number in radians.
	 */
	public function asin($number);

	/**
	 * Returns the arc tangent of a number.
	 *
	 * @param  float $number
	 * @param  float $y      optional
	 * @return float The arc tangent of a number in radians.
	 */
	public function atan($number);

	/**
	 * Calculates the arc tangent of two variables.
	 *
	 * @param  float $x
	 * @param  float $y
	 * @return float
	 */
	public function atan2($x, $y);

	/**
	 * Returns the next highest integer of a number.
	 *
	 * @return int
	 */
	public function ceiling($number);

	/**
	 * Returns the cosine of the specified angle.
	 *
	 * @param  float $angle
	 * @return float
	 */
	public function cos($angle);

	/**
	 * Returns the hyperbolic cosine of the angle.
	 *
	 * @param  float $angle
	 * @return float
	 */
	public function cosh($angle);

	/**
	 * Returns e raised to a given power.
	 *
	 * @param  float $number
	 * @return double
	 */
	public function exp($number);

	/**
	 * Returns the next lowest integer of a number.
	 *
	 * @param  float $number
	 * @return int
	 */
	public function floor($number);

	/**
	 * Returns the logarithm of a number in a specified base.
	 *
	 * @param  double $number
	 * @param  double $base optional
	 * @return double
	 */
	public function log($number, $base = M_E);

	/**
	 * Returns the base-10 logarithm of a number.
	 *
	 * @param  double $number
	 * @return double
	 */
	public function log10($number);

	/**
	 * Returns the highest value in the array of numbers.
	 *
	 * @param  array $numbers
	 * @return number
	 */
	public function max(array $numbers);

	/**
	 * Returns the lowest value in the array of numbers.
	 *
	 * @param  array $numbers
	 * @return number
	 */
	public function min(array $numbers);

	/**
	 * Returns a base number raised to an exponent.
	 *
	 * @param  $base     number
	 * @param  $exponent number
	 * @return float
	 */
	public function pow($base, $exponent);

	/**
	 * Rounds a number to the nearest value.
	 *
	 * @param float $number
	 * @param int   $precision optional The number of digits to round to.
	 * @param int   $mode      optional The rounding mode.
	 * @return number
	 */
	public function round($number, $precision = 0, $mode = PHP_ROUND_HALF_UP);

	/**
	 * Returns a value indicating the sign of a number.
	 *
	 * @param  number $number
	 * @return int
	 */
	public function sign($number);

	/**
	 * Returns the sine of the given angle.
	 *
	 * @param  number $angle The angle in radians.
	 * @return number 
	 */
	public function sin($angle);

	/**
	 * Returns the hyperbolic sine of of the angle.
	 *
	 * @param  number $angle
	 * @return number
	 */
	public function sinh($angle);

	/**
	 * Returns the square root of a given number.
	 *
	 * @param  number $number
	 * @return number
	 */
	public function sqrt($number);

	/**
	 * Returns the tangent of a specified angle.
	 *
	 * @param  number $angle The angle in radians.
	 * @return number
	 */
	public function tan($angle);

	/**
	 * Returns the hyperbolic tangent of an angle.
	 *
	 * @param  number $angle
	 * @return number
	 */
	public function tanh($angle);

	/**
	 * Returns the integral part of a given number.
	 *
	 * @param  float $number
	 * @return int|0 on failure
	 */
	public function truncate($number);

}