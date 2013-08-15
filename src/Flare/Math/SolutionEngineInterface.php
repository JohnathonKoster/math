<?php namespace Flare\Math;

interface SolutionEngineInterface {
	
	/**
	 * Solves the given equation. 
	 *
	 * @param  string $equation
	 * @return number
	 */
	public function solve($equation);

}