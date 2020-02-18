<?php
declare(strict_types=1);
/**
 * The theme's functions.php file as application bootstrap
 * 
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv2 https://opensource.org/licenses/gpl-2.0.php
 * @link     https://42geeks.gg/
 */

// no direct file access
if (! defined('WPINC')) {
	die('You do not take that candle!');
}

// composer psr-4 autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
	include_once dirname(__FILE__) . '/vendor/autoload.php';
}

if (class_exists('Mist\\MistBase')) {
	// TODO: figure out a better way to keep compliant
	// PSR1.Files.SideEffects.FoundWithSymbols
	define('MIST_VERSION', '0.1');
	define('MIST_DEV', true);

	// run theme
	$app = mist\MistBase::app();
}
