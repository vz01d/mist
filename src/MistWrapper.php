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
use mist\wrapper;

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
	protected $app = null;

	/**
	 * MistTheme
	 */
	private static $theme = null;
	
	/**
	 * MistPost
	 */
	private static $post = null;

	/**
	 * Create a new Mist Wrapper
	 *
	 * @param \mist\MistBase $mb - the base app as dependency
	 */
	public function __construct(\mist\MistBase $mb)
	{
		self::$theme = new wrapper\MistTheme();
		$this->app = $mb;
	}

	/**
	 * Run the WP lifecycle functions
	 * init hook
	 *
	 * @return void
	 */
	public function initTheme(): void
	{
		self::$post = new wrapper\MistPost();
		self::$theme->init();
	}

	/**
	 * Access theme instance
	 *
	 * @return \mist\wrapper\MistTheme
	 */
	protected function theme(): \mist\wrapper\MistTheme
	{
		return self::$theme;
	}

	/**
	 * Access post instance
	 *
	 * @return \mist\wrapper\MistPost
	 */
	protected function post(): \mist\wrapper\MistPost
	{
		return self::$post;
	}
}
