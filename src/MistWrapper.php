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
namespace mist;

use MistBase;

/**
 * MistWrapper - initialize Wrapper classes
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistWrapper
{
	/**
	 * App reference
	 */
	private $app = null;

	/**
	 * Create a new Mist Wrapper
	 * 
	 * @param MistBase $mb - the base app as dependency
	 */
	public function __construct(MistBase $mb)
	{
		$this->app = $mb;
	}
}