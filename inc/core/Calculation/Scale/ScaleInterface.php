<?php
/**
 * This file contains class::ScaleInterface
 * @package Runalyze\Calculation\Scale
 */

namespace Runalyze\Calculation\Scale;

/**
 * Scale
 * 
 * @author Hannes Christiansen
 * @package Runalyze\Calculation\Scale
 */
interface ScaleInterface {
	/**
	 * Transform value
	 * @param float $input
	 * @return float
	 */
	public function transform($input);
}
