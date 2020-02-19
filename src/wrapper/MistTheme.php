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

		// TODO: 
		// add hooks
		// add filter
		/**
		 * How it should work:
		 * the developer is using the class can simply call
		 * MistTheme::setSupport([
		 * 	'align-wide',
		 * 	'title-tag',
		 * 	'custom-logo' => [
		 * 		'flex-width' => true,
		 * 		'flex-height' => true,
		 *  ]
		 * ]);
		 * MistTheme::setThumbnailSize($w, $h)
		 */
	}
}