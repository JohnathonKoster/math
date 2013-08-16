<?php namespace Flare\Math\Drivers;

class EvalMathStack {

	/**
	 * Holds the stack items.
	 *
	 * @var array
	 */
	private $stack = array();

	/**
	 * Indicates the number of items on the stack.
	 *
	 * @var int
	 */
	private $count = 0;

	/**
	 * Returns the stack count.
	 *
	 * @return int
	 */
	public function getCount()
	{
		return $this->count;
	}

	/**
	 * Adds an item to the end of the stack.
	 *
	 * @param mixed $value The value to add.
	 * @return void
	 */
	public function push($value)
	{
		$this->stack[$this->count] = $value;
		$this->count++;
	}

	/**
	 * Gets the the last item from the stack.
	 *
	 * @return mixed|null if empty
	 */
	function pop()
	{
		if ($this->count > 0)
		{
			$this->count--;
			return $this->stack[$this->count];
		}
		return null;
	}

	/**
	 * Returns a stack item at a position from the end.
	 *
	 * @param  integer $position optional
	 * @return mixed
	 */
	public function last($position = 1)
	{
		if (isset($this->stack[$this->count - $position]))
		{
			return $this->stack[$this->count - $position];			
		}
		return null;
	}
	
}