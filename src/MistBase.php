<?php
declare(strict_types=1);
/**
 * Mist
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 *
 * Mist is a Framework for building WordPress Themes - it's to be used by developers
 * who want to built custom Themes for WordPress with ease using an OOP API in both
 * frontend and backend.
 */
namespace mist;

/**
 * final class MistBase - the Framework base class
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
final class MistBase
{
	/**
	 * Singleton
	 */
	private static $instance = null;

	/**
	 * Get Base
	 *
	 * @return MistBase
	 */
	public static function app(): MistBase
	{
		if (null === self::$instance) {
			self::$instance = new MistBase();
		}
		
		return self::$instance;
	}

	/**
	 * Run Mist
	 * 
	 * @return void
	 */
	public function run(): void
	{	
		// load Mist
		new MistWrapper(self::$instance);
		
		// load Mist config (theme data required hence wrapper first)

	}

	/**
	 * You do not take that candle!
	 */
	private function __construct() {}
}