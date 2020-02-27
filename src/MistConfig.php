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

use mist\objects\MistPostType;

/**
 * MistConfig - Configuration object for mist
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistConfig extends \mist\wrapper\MistTheme
{
	/**
	 * Post type object container
	 */
	private $postTypes = [];
	
	/**
	 * Nav menu object container
	 */
	private $navMenus = [
		'main'
	];

	/**
	 * Theme text domain
	 */
	private $textDomain = 'mist';
	
	/**
	 * Theme support
	 */
	private $themeSupport = [];

	/**
	 * Make sure we don't read wrong keys
	 * and load them
	 */
	private $configKeys = [
		'postTypes',
		'themeSupport',
		'navMenus',
		'textDomain',
	];

	/**
	 * Initialize the configiguration object
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 * Initialize mist configuration object
	 *
	 * @return void
	 */
	public function init(): void
	{
		$config = dirname(__FILE__) . '/mist.config.default.json';
		$customConf = $this->theme()->rootPath() . '/mist.config.json';

		if (true === file_exists($customConf)) {
			$config = $customConf;
		}

		$config = file_get_contents($config);
		$config = json_decode($config, true);

		$this->loadConfigProperties($config);
	}

	/**
	 * Load properties of mist config object
	 * the config part of the framework can be omitted
	 * by providing an empty config json {}
	 * 
	 * @param array $config - the configuration file read from json
	 * 
	 * @return void - props are set on the object instead
	 */
	private function loadConfigProperties(array $config): void
	{
		// config should be used at all
		if (count($config) > 0) {
			foreach($config as $prop => $values) {
				// rather ignore non existant keys
				if (false !== in_array($prop, $this->configKeys)) {
					if (method_exists($this, $prop)) {
						$this->$prop((array)$values);
					}
				}
			}
		}
	}

	/**
	 * Set the text domain
	 * 
	 * @param array $values - the text domain value
	 * 
	 * @return void
	 */
	private function textDomain(array $values): void
	{
		$this->textDomain = isset($values[0]) ? $values[0] : $this->textDomain;
	}
	
	/**
	 * Theme support
	 * 
	 * @param array $values - the theme support array
	 * 
	 * @return void
	 */
	private function themeSupport(array $values): void
	{
		$this->themeSupport = isset($values[0]) ? $values : [];
	}

	/**
	 * Set post types registered
	 * 
	 * @param array $objects - the post types in config
	 * 
	 * @return void 
	 */
	private function postTypes(array $objects = []): void
	{
		if (count($objects) < 1) {
			return;
		}

		// mini factory
		foreach($objects as $object) {
			$pt = new MistPostType();
			$pt->setup($object);
			$this->postTypes[] = $pt;
		}
	}
	
	/**
	 * Set nav Menus registered
	 * 
	 * @param array $objects - the post types in config
	 * 
	 * @return void 
	 */
	private function navMenus(array $objects = []): void
	{
		$this->navMenus = $objects;
	}

	/**
	 * Run after theme setup wp hook
	 * 
	 * @return void
	 */
	public function afterSetup(): void
	{
		// apply navigation menus
		$navMenus = apply_filters('mist_nav_menus', $this->navMenus);
		register_nav_menus($navMenus);

		// load text domain
		load_theme_textdomain($this->textDomain, $this->theme()->rootPath() . '/languages');

		$this->addThemeSupport();
	}

	/**
	 * Add the theme support configuration
	 * 
	 * @return void
	 */
	private function addThemeSupport(): void
	{
		if (count($this->themeSupport) > 0) {
			foreach($this->themeSupport as $themeSupport) {
				if (is_array($themeSupport)) {
					$key = array_key_first($themeSupport);
					add_theme_support($key,
						array_values($themeSupport)
					);
				}

				if (is_string($themeSupport)) {
					add_theme_support($themeSupport);
				}
			}
		}
	}

	/**
	 * Access posttype - TDA does not work well in this case
	 * as we have 2 possible inputs for the same output
	 * 
	 * @return array - the post types configured in this theme
	 */
	protected function registeredPosttypes(): array
	{
		return $this->postTypes;
	}
}
