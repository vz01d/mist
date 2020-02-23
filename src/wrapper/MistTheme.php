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
use mist\MistConfig;

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
	 * Init the theme
	 *
	 * @return void
	 */
	public function init(): void
	{
		// developers need to use MistPostType to add their post types using code/filter
		$postTypes = apply_filters('mist_post_types', self::$config->registeredPosttypes());
		$this->post()->init($postTypes);
	}

	/**
	 * Initialize the theme configuration
	 *
	 * @return void
	 */
	public function initConfig(): void
	{
		self::$config = new MistConfig();
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
