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

if (class_exists('mist\\MistBase')) {
	// run theme
	$mist = mist\MistBase::app();
	$mist->run();
}
