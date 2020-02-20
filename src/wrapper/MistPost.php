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
namespace mist\wrapper;

use mist\MistWrapper;

/**
 * MistPost - Wrap wp post related functions and hooks
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistPost extends MistWrapper
{
	public function __construct(){}

	/**
	 * WP init hook run on this object
	 * 
	 * @return void
	 */
	public function init(array $postTypes): void
	{
		// TODO: figure this riddle out :>
		/*
		array(2) {
		[0]=>
		string(4) "team"
		[1]=>
		array(1) {
			["offer"]=>
			array(2) {
			["singular"]=>
			string(5) "offer"
			["plural"]=>
			string(6) "offers"
			}
		}
		}*/
		$count = count($postTypes);
		if ($count > 0) {
			if (isset($postTypes[0]) && is_array($postTypes[0]) || $count > 1) {
				foreach($postTypes[0] as $postType => $args) {
					register_extended_post_type($postType);
				}
			}

			if (isset($postTypes[0]) && is_string($postTypes[0])) {
				register_extended_post_type($postTypes[0]);
			}
		}
	}
}
