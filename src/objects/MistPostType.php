<?php
declare(strict_types=1);
/**
 * Mist
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
namespace mist\objects;

/**
 * MistPostType - Post Type as object
 * this will allow for later customization like removing
 * extended-cpts and roll your own if you want to.
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistPostType
{
	/**
	 * Post type name
	 */
	public $name = '';

	/**
	 * Label singular
	 */
	public $singular = '';
	
	/**
	 * Label plural
	 */
	public $plural = '';

	public function __construct(){}
	
	/**
	 * Setup the post type
	 * 
	 * @param array $args - parameters for the post type
	 * 
	 * @return void
	 */
	public function setup(array $args): void
	{
		array_map(
			function($ptParams, $ptName){
				// set name
				$this->name = $ptName;

				// no params
				if (count($ptParams) < 1) {
					return;
				}

				// extract params
				$this->extractParams($ptParams);
			},
			$args,
			array_keys($args)
		);
	}

	/**
	 * extract parameters and set them on the object
	 * 
	 * @param array $params - parameters for the post type
	 * 
	 * @return void
	 */
	private function extractParams(array $params): void
	{
		$this->singular = isset($params['singular']) ? $params['singular'] : '';
		$this->plural = isset($params['plural']) ? $params['plural'] : '';
	}

	/**
	 * Register the post type
	 * TODO: make extended-cpts optional
	 * 
	 * @return void
	 */
	public function register(): void
	{
		$labels = $this->labels();
		$params = [];
		
		if (count($labels) < 1) {
			register_extended_post_type($this->name, $params);
		}

		if (count($labels) > 0) {
			register_extended_post_type($this->name, $params, $labels);
		}
	}

	/**
	 * Return the labels for the post type
	 * 
	 * @return array - the post types labels
	 */
	private function labels(): array
	{
		$labels = [];
		if ('' !== $this->singular && '' !== $this->plural) {
			$labels['singular'] = $this->singular;
			$labels['plural'] = $this->plural;
		}

		return $labels;
	}
}
