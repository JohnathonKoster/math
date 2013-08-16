<?php namespace Flare\Math\Drivers;

use \Flare\Math\SolutionEngineInterface as Engine;
use \Flare\Math\Drivers\EvalMathStack as Stack;

/*
|--------------------------------------------------------------------------
| EvalMathDriver
|--------------------------------------------------------------------------
|
| This driver is an adaptation of the EvalMath class written by Miles Kaufmann
|
| LICENSE
|    Redistribution and use in source and binary forms, with or without
|    modification, are permitted provided that the following conditions are
|    met:
|    
|    1   Redistributions of source code must retain the above copyright
|        notice, this list of conditions and the following disclaimer.
|    2.  Redistributions in binary form must reproduce the above copyright
|        notice, this list of conditions and the following disclaimer in the
|        documentation and/or other materials provided with the distribution.
|    3.  The name of the author may not be used to endorse or promote
|        products derived from this software without specific prior written
|        permission.
|    
|    THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR
|    IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
|    WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
|    DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT,
|    INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
|    (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
|    SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
|    HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
|    STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
|    ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
|    POSSIBILITY OF SUCH DAMAGE.
|
*/

class EvalMathDriver implements Engine {

	/**
	 * Determines if the driver will suppress errors.
	 *
	 * @var bool
	 */
	protected $suppressErrors = false;

	/**
	 * The ExecutionEngineInterface implementation
	 *
	 * @var \Flare\Math\ExecutionEngineInterface
	 */
	protected $executionEngine;

	/**
	 * Holds the last error encountered by the driver.
	 *
	 * @var mixed
	 */
	protected $lastError = null;

	/**
	 * Holds the default constants used by the solution engine.
	 *
	 * @var array
	 */
	protected $constants = array(
		'e'  => M_E,
		'pi' => M_PI,
	);

	/**
	 * Holds the functions that are allowed.
	 *
	 * @var array
	 */
	protected $functions = array(
		'sin', 'sinh', 'arcsin', 'asin', 'arcsinh',
		'asinh', 'cos', 'cosh', 'arccos', 'acos', 'arccosh',
		'acosh', 'tan', 'tanh', 'arctan', 'atan', 'arctanh',
		'atanh', 'sqrt', 'abs', 'ln', 'log'
	);

	/**
	 * Holds the user-defined functions.
	 *
	 * @var array
	 */
	protected $userFunctions = array();

	/**
	 * Returns an instance of EvalMathDriver
	 *
	 * @param \Flare\Math\ExecutionEngineInterface
	 */
	public function __construct(\Flare\Math\ExecutionEngineInterface $executionEngine)
	{
		$this->executionEngine = $executionEngine;
	}


	/**
	 * Sets the ExecutionEngineInterface implementation.
	 *
	 * @param \Flare\Math\ExecutionEngineInterface
	 */
	public function setExecutionEngine(\Flare\Math\ExecutionEngineInterface $executionEngine)
	{
		$this->executionEngine = $executionEngine;
	}

	/**
	 * Gets the ExecutionEngineInterface implementation.
	 *
	 */
	public function getExecutionEngine()
	{
		return $this->executionEngine;
	}

	/**
	 * Solves the given equation. 
	 *
	 * @param  string $equation
	 * @return number
	 */
	public function solve($equation)
	{
		$this->lastError = null;

		$expression = trim($equation);

		if (substr($expression, -1, 1) == ';')
		{
			// This is to remove the semicolons at the end, if any.
			$expression = substr($expression, 0, strlen($expression) - 1);
		}

		if (preg_match('/^\s*([a-z]\w*)\s*=\s*(.+)$/', $expression, $matches)) {

			// Variable Assignment.

			if (in_array($matches[1], $this->constants))
			{
				// This catches the cases where users are trying to
				// overwrite the value of a constant.
				return $this->raiseError('Cannot redefine constant \''.$matches[1].'\'');
			}

			$temp  = $this->evaluatePostfixNotation($this->convertInfixToPostfix($matches[2]));

			if (($temp = false) == false)
			{
				return false;
			}

			$this->constants[$matches[1]] = $temp;
			return $this->constants[$matches[1]];
		}
		elseif (preg_match('/^\s*([a-z]\w*)\s*\(\s*([a-z]\w*(?:\s*,\s*[a-z]\w*)*)\s*\)\s*=\s*(.+)$/', $expression, $matches))
		{
			// Function assignment.

			// Get the function name.
			$functionName = $matches[1];

			if (in_array($matches[1], $this->functions))
			{
				return $this->raiseError('Cannot redefine function \''.$matches[1].'\'');
			}

			// Get the function's arguments.
			$arguments = explode(",", preg_replace("/\s+/", "", $matches[2]));

			$stack = $this->convertInfixToPostfix($matches[3]);

			if ($stack == false)
			{
				return false;
			}

			// Freeze the state of the non-argument variables.
			for ($i = 0; $i < count($stack); $i++)
			{
				$token = $stack[$i];
				if (preg_match('/^[a-z]\w*$/', $token) and !in_array($token, $arguments))
				{
					if (array_key_exists($toke, $this->constants))
					{
						$stack[$i] = $this->constants[$token];
					}
					else
					{
						return $this->raiseError('Undefined variable \''.$token.'\' in function definition.');
					}
				}
			}

			$this->userFunctions[$functionName] = array(
				'args' => $arguments,
				'func' => $stack,
			);

			return true;
		}
		else
		{
			return $this->evaluatePostfixNotation($this->convertInfixToPostfix($expression));
		}

	}

	private function convertInfixToPostfix($expression)
	{
		$position = 0;
		$stack = new Stack;

		// The postfix form of an expression.
		$output = array();
		$expression = trim(strtolower($expression));

		$operators = array(
			'+', '-', '*', '/', '^', '_',
		);

		// Right-Associative operator
		$operatorsRight = array(
			'+' => 0, '-' => 0, '*' => 0,
			'/' => 0, '^' => 1,
		);

		// Operator Precedence
		$operatorPrecedence = array(
			'+' => 0, '-' => 0, '*' => 1,
			'/' => 1, '_' => 1, '^' => 2
		);

		// Used for syntax-checking and verifying negation
		// operators.
		$expectingOperator = false;

		if (preg_match("/[^\w\s+*^\/()\.,-]/", $expression, $matches))
		{
			return $this->raiseError('Illegal character '.$matches[0]);
		}

		while(1)
		{
			// Get the first character at the current position.
			$character = substr($expression, $position, 1);

			// Determine if we're currently at the beginning of a number,
			// variable, function, parenthesis or operand
			$ex = preg_match('/^([a-z]\w*\(?|\d+(?:\.\d*)?|\.\d+|\()/', substr($expression, $position), $match);

			// Determine if the current character is implying a negation
			// operator or a subtraction operator.
			if ($character == '-' and ! $expectingOperator)
			{
				// The character was implying a negation operator.
				$stack->push('_');
				$position++;
			}
			elseif ($character == '_')
			{
				// The underscore is not a valid character in an expression
				// because the stack is interpreting it as a negation operator.
				$this->raiseError('Invalid character \'_\'');
			}
			elseif ((in_array($character, $operators) or $ex) and $expectingOperator)
			{
				// At this point, we are expecting to put an operator
				// onto the stack.

				// This check handles the use-case of implicit
				// multiplication.
				if ($ex)
				{
					$character = '*';
					$position--;
				}

				while($stack->getCount() > 0 and ($lastOperator = $stack->last())
					  and in_array($lastOperator, $operators)
					  and ($operatorsRight[$character] ? $operatorPrecedence[$character] < $operatorPrecedence[$lastOperator] : $operatorPrecedence[$character] <= $operatorPrecedence[$lastOperator])
					 )
				{
					// Pop stuff off the stack into the output.
					$output[] = $stack->pop();
				}

				$stack->push($character);
				$position++;
				$expectingOperator = false;
			}
			elseif ($character == ')' and $expectingOperator)
			{
				// Closing parenthesis
				while (($lastOperator = $stack->pop()) != '(')
				{
					if (is_null($lastOperator))
					{
						return $this->raiseError('Unexpected \')\'');
					}
					else
					{
						$output[] = $lastOperator;
					}
				}

				// Check to see if the last ')' was actually
				// closing a function call.
				if (preg_match("/^([a-z]\w*)\($/", $stack->last(2), $matches))
				{
					// Get the name of the function.
					$functionName = $matches[1];
					// Get the number of function arguments.
					$argumentCount = $stack->pop();
					// Pop the function and push onto the output.
					$output[] = $stack->pop();


					if (in_array($functionName, $this->functions))
					{
						// Check the argument count.
						if ($argumentCount > 1)
						{
							return $this->raiseError('Invalid argument count. Expecting 1 argument, \''.$argumentCount.'\' given.');
						}
					}
					elseif (array_key_exists($functionName, $this->userFunctions))
					{
						if ($argumentCount != count($this->userFunctions[$functionName]['args']))
						{
							return $this->raiseError('Invalid argument count. Expecting \''.count($this->userFunctions[$functionName]['args']).'\' argument, \''.$argumentCount.'\' given.');
						}
					}
					else
					{
						return $this->raiseError('Unexpected error.');
					}


				}

				$position++;
			}
			elseif ($character == ',' and $expectingOperator)
			{
				// Checking if we just finished a function argument.
				while (($lastOperator = $stack->pop()) != '(')
				{
					if (is_null($lastOperator))
					{
						// There was no starting '(' found, so bail.
						return $this->raiseError('Unexpected \',\'');
					}
					else
					{
						$output[] = $lastOperator;
					}
				}

				if (! preg_match("/^([a-z]\w*)\($/", $stack->last(2), $matches))
				{
					return $this->raiseError('Unexpected \',\'');
				}

				// Increment the argument count.
				$stack->push($stack->pop() + 1);
				// Put the '(' back on the stack, we'll need it later.
				$position++;
				$expectingOperator = false;
			}
			elseif ($character == '(' and ! $expectingOperator)
			{
				$stack->push('(');
				$position++;	
			}
			elseif ($ex and ! $expectingOperator)
			{
				// Check if we are now processing a function, variable
				// or number.
				$expectingOperator = true;
				$value = $match[1];

				if (preg_match("/^([a-z]\w*)\($/", $value, $matches))
				{
					// May be a function or variable with implicit
					// multiplication against parenthesis.
					if (in_array($matches[1], $this->functions)
						or array_key_exists($matches[1], $this->userFunctions))
					{
						// It's a function.
						$stack->push($value);
						$stack->push(1);
						$stack->push('(');
						$expectingOperator = false;
					}
					else
					{
						$value = $matches[1];
						$output[] = $value;
					}
				}
				else
				{
					// It's a variable or number.
					$output[] = $value;
				}

				$position += strlen($value);
			}
			elseif ($character == ')')
			{
				return $this->raiseError('Unexpected \')\'');
			}
			elseif (in_array($character, $this->operators) and ! $expectingOperator)
			{
				return $this->raiseError('Unexpected operator \''.$character.'\'');
			}
			else
			{
				return $this->raiseError('Unexpected error');
			}

			if ($position == strlen($expression))
			{
				if (in_array($character, $operators))
				{
					// The expression ended with an operator. This is
					// not good.
					return $this->raiseError('Operator \''.$character.'\' lacks operand.');
				}
				else
				{
					break;
				}
			}

			while (substr($expression, $position, 1) == ' ')
			{
				// Advance the position past the whitespace.
				$position++;
			}

		}

		while (! is_null($character = $stack->pop()))
		{
			// Pop everything off the stack and push onto output.
			if ($character == '(')
			{
				// If there are '('`s on the stack, we have unbalanced
				// parenthesis.
				return $this->raiseError('Expecting \')\'');
			}

			$output[] = $character;
		}

		return $output;

	}

	private function evaluatePostfixNotation($tokens, $variables = array())
	{
		if ($tokens == false)
		{
			return false;
		}

		$stack = new Stack;

		foreach ($tokens as $token)
		{
			if (in_array($token, array('+', '-', '*', '/', '^')))
			{

				$lastOperatorTwo = $stack->pop();
				$lastOperatorOne = $stack->pop();

				if (is_null($lastOperatorOne))
				{
					return $this->raiseError('Internal error');
				}

				if (is_null($lastOperatorTwo))
				{
					return $this->raiseError('Internal error'); 
				}

				switch ($token)
				{
					case '+':
						$stack->push($this->executionEngine->add($lastOperatorOne, $lastOperatorTwo));
						break;
					case '-':
						$stack->push($this->executionEngine->subtract($lastOperatorOne, $lastOperatorTwo));
						break;
					case '*':
						$stack->push($this->executionEngine->multiply($lastOperatorOne, $lastOperatorTwo));
						break;
					case '/':
						if ($lastOperatorTwo == 0)
						{
							return $this->raiseError('Divide by zero error.');
						}
						$stack->push($this->executionEngine->divide($lastOperatorOne, $lastOperatorTwo));
						break;
					case '^':
						$stack->push($this->executionEngine->pow($lastOperatorOne, $lastOperatorTwo));
						break;
				}

			}
			elseif ($token == '_')
			{
				// If the token is a unary operator, pop one value off the stack and
				// then do the operation, then push it back on.
				$stack->push(-1 * $stack->pop());
			}
			elseif (preg_match("/^([a-z]\w*)\($/", $token, $matches))
			{
				// If the token is a function, pop arguments off the stack, hand them to
				// the function and push the result back on.
				$functionName = $matches[1];

				if (in_array($functionName, $this->functions))
				{
					// The function name is one of the default functions.
					$lastOperatorOne = $stack->pop();
					if (is_null($lastOperatorTwo))
					{
						return $this->raiseError('Internal error.');
					}

					// Handles the 'arc' trig synonyms.
					$functionName = preg_replace("/^arc/", "a", $functionName);

					// Converts 'ln' into the 'log' function name.
					if ($functionName == 'ln')
					{
						$functionName = 'log';
					}

					// Here the original code had an eval statement. We are going to try and do
					// away with that and handle the function execution ourself. We will also do
					// this so that this driver can use the MathExecutionEngine implementation.

					switch ($functionName)
					{
						case 'sin':
							$stack->push($this->executionEngine->sin($lastOperatorOne));
							break;
						case 'sinh':
							$stack->push($this->executionEngine->sinh($lastOperatorOne));
							break;
						case 'arcsin':
							$stack->push($this->executionEngine->arcsin($lastOperatorOne));
							break;
						case 'asin':
							$stack->push($this->executionEngine->asin($lastOperatorOne));
							break;
						case 'arcsinh':
							$stack->push($this->executionEngine->arcsinh($lastOperatorOne));
							break;
						case 'asinh':
							$stack->push($this->executionEngine->asinh($lastOperatorOne));
							break;
						case 'cos':
							$stack->push($this->executionEngine->cos($lastOperatorOne));
							break;
						case 'cosh':
							$stack->push($this->executionEngine->cosh($lastOperatorOne));
							break;
						case 'arccos':
							$stack->push($this->executionEngine->arccos($lastOperatorOne));
							break;
						case 'acos':
							$stack->push($this->executionEngine->acos($lastOperatorOne));
							break;
						case 'arccosh':
							$stack->push($this->executionEngine->arccosh($lastOperatorOne));
							break;
						case 'acosh':
							$stack->push($this->executionEngine->acosh($lastOperatorOne));
							break;
						case 'tan':
							$stack->push($this->executionEngine->tan($lastOperatorOne));
							break;
						case 'tanh':
							$stack->push($this->executionEngine->tanh($lastOperatorOne));
							break;
						case 'arctan':
							$stack->push($this->executionEngine->arctan($lastOperatorOne));
							break;
						case 'atan':
							$stack->push($this->executionEngine->atan($lastOperatorOne));
							break;
						case 'arctanh':
							$stack->push($this->executionEngine->arctanh($lastOperatorOne));
							break;
						case 'atanh':
							$stack->push($this->executionEngine->atanh($lastOperatorOne));
							break;
						case 'sqrt':
							$stack->push($this->executionEngine->sqrt($lastOperatorOne));
							break;
						case 'abs':
							$stack->push($this->executionEngine->abs($lastOperatorOne));
							break;
						case 'log':
							$stack->push($this->executionEngine->log($lastOperatorOne));
							break;
					}


				}
				elseif (array_key_exists($functionName, $this->userFunctions))
				{
					// This is a user defined function.
					$arguments = array();

					for ($i = count($this->userFunctions[$functionName]['args']) - 1; $i >= 0; $i--)
					{
						if (is_null($arguments[$this->userFunctions[$functionName]['args'][$i]] = $stack->pop()))
						{
							return $this->raiseError('Internal error.');
						}
					}

					$stack->push($this->evaluatePostfixNotation($this->userFunctions[$functionName]['func'], $arguments));
				}
			}
			else
			{
				if (is_numeric($token))
				{
					$stack->push($token);
				}
				elseif (array_key_exists($token, $this->constants))
				{
					$stack->push($this->constants[$token]);
				}
				elseif (array_key_exists($token, $variables))
				{
					$stack->push($variables[$token]);
				}
				else
				{
					return $this->raiseError('Undefined variable \''.$token.'\'');
				}
			}
		}

		// After there are no more tokens, the stack should have the final result.
		if ($stack->getCount() != 1)
		{
			return $this->raiseError('Internal error');
		}

		// Return the result.
		return $stack->pop();
	}

	private function raiseError($errorMessage)
	{
		$this->lastError = $errorMessage;

		if (! $this->suppressErrors)
		{
			throw new \Exception($errorMessage);
		}

		return false;
	}

}