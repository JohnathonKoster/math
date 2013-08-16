<?php namespace Flare\Math\Support;

class ClassUtility {
	
	/**
	 * Returns the user defined method names of a class.
	 *
	 * @param  mixed
	 * @return array
	 */
	public static function discoverClassMethods($class)
	{
		$methods = get_class_methods($class);

		// Remove some methods we know we don't want
		// to call later on in an expression. Pretty
		// much all of the magic methods.
		$bannedFunctions = array(
			'__construct', '__destruct', '__destruct', '__call',
			'__callStatic', '__get', '__set', '__isset', '__unset',
			'__sleep', '__wakeup', '__toString', '__invoke', '__set_state',
			'__clone',
		);

		foreach ($methods as $index => $method)
		{
			if (in_array(trim($method), $bannedFunctions))
			{
				unset($methods[$index]);
			}
		}

		return $methods;
	}

}