<?php namespace Flare\Math;

interface SolutionEngineInterface {
	
	/**
	 * Solves the given equation. 
	 *
	 * @param  string $equation
	 * @return number
	 */
	public function solve($equation);

	/**
	 * Sets the ExecutionEngineInterface implementation.
	 *
	 * @param \Flare\Math\ExecutionEngineInterface
	 */
	public function setExecutionEngine(\Flare\Math\ExecutionEngineInterface $executionEngine);

	/**
	 * Gets the ExecutionEngineInterface implementation.
	 *
	 */
	public function getExecutionEngine();

}