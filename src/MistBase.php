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
		$wrapper = new MistWrapper(self::$instance);
		
		// load Mist config (theme data required hence wrapper first)
		self::config($wrapper);
	}

	/**
	 * Load mist configuration file from theme
	 * root. If no file exists the default
	 * will be loaded
	 * 
	 * @param MistWrapper $wrapper - the wrapper instance to access
	 * theme data
	 * 
	 * @return void
	 */
	private static function config(MistWrapper $wrapper): void
	{
		$file = $wrapper->theme()->rootPath() . '/mist.config.json';

		// empty object
		$conf = (object)null;

		// check if config file has been created by fellow dev
		if (true === file_exists($file)) {
			$conf = file_get_contents($file);
			$conf = (object)json_decode($conf, true);
		}

		// set the config
		$wrapper->theme()->setConfig($conf);
	}

	/**
	 * You do not take that candle!
	 */
	private function __construct() {}
}