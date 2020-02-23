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
	 * @param array $postTypes - the postTypes to register
	 * 
	 * @return void
	 */
	public function init(array $postTypes): void
	{
		$count = count($postTypes);
		if ($count > 1) {
			foreach($postTypes as $postType) {
				$postType->register();
			}
		}
	}
}
