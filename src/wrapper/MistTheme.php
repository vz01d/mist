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
 * MistTheme - Wrap wp theme related functions and hooks like
 * after_setup_theme or upload_mimes
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistTheme extends MistWrapper
{
	/**
	 * Is child theme
	 */
	private static $isChildTheme = false;

	/**
	 * Theme URI
	 */
	private static $themeUri = '';

	/**
	 * Theme Path
	 */
	private static $themePath = '';

	/**
	 * Theme configuration
	 */
	private static $config = null;

	/**
	 * Holds all relevant theme data
	 */
	public function __construct()
	{
		self::$isChildTheme = is_child_theme();

		// load theme paths only once
		if (true === self::$isChildTheme) {
			self::$themeUri = get_stylesheet_directory_uri();
			self::$themePath = get_stylesheet_directory();
		} else {
			self::$themeUri = get_template_directory_uri();
			self::$themePath = get_template_directory();
		}
	}

	/**
	 * Set the theme configuration
	 * 
	 * @param object $config - the configuration object
	 * 
	 * @return void
	 */
	public function setConfig(object $config): void
	{
		// check if config is empty at this point
		$isEmpty = 1 > count(get_object_vars($config));
		if (true === $isEmpty) {
			// load default config instead
			$this->setDefaultConfig();	
		}

		self::$config = $config;
	}

	/**
	 * Set the default mist theme config
	 * 
	 * @return void
	 */
	private function setDefaultConfig(): void
	{
		$file = dirname(__FILE__) . '/../mist.config.default.json';
		if (true !== file_exists($file)) {
			throw new \Exception('mist default config file missing. Run composer update to get the latest version.');
		}

		$conf = file_get_contents($file);
		$conf = (object)json_decode($conf, true);
		$this->setConfig($conf);
	}

	/**
	 * Theme root path
	 * 
	 * @return string - the theme root path
	 */
	public function rootPath(): string
	{
		return self::$themePath;
	}

	/**
	 * Theme root uri
	 * 
	 * @return string - the theme root uri
	 */
	public function rootUri(): string
	{
		return self::$themeUri;
	}

	/**
	 * Is a child theme?
	 * 
	 * @return bool - wether is a child theme or not
	 */
	public function isChildTheme(): bool
	{
		return self::$isChildTheme;
	}
}
