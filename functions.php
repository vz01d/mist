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

// psr-4
try {
	include_once dirname(__FILE__) . '/vendor/autoload.php';

	// run theme
	$mist = mist\MistBase::app();
	$mist->run();	
} catch (\Exception $e) {
	throw new \Exception($e->getMessage());
}