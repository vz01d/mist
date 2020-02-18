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

/**
 * MistTheme - Wrap wp theme related functions and hooks like
 * after_setup_theme or upload_mimes
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistTheme
{
	/**
	 * 
	 */
	public function __construct()
	{
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