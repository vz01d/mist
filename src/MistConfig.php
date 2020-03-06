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
	 * Make sure we don't read wrong keys
	 * and load them
	 */
	private $configKeys = [
		'mistGlobal',
		'imageSizes',
		'postTypes',
		'themeSupport',
		'navMenus',
		'textDomain',
		'widgetAreas',
	];

	/**
	 * Widget Config Keys
	 */
	private $widgetProps = [
		'id'            => 'primary',
		'name'          => 'Primary Sidebar',
		'description'   => 'A short description of the sidebar.',
		'before_widget' => '<WTAG id="%1$s" class="%2$s %%MISTCLASSES%%">',
		'after_widget'  => '</WTAG>',
		'before_title'  => '<TTAG class="%%MISTCLASSES%%">',
		'after_title'   => '</TTAG>',
		'wrapper_classes' => ['widget'],
		'wrapper_tag' => 'div',
		'title_classes' => ['widget-title'],
		'title_tag' => 'span',
	];

	/**
	 * Global settings
	 */
	private $globalConfig;

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
	 * Load global config
	 * 
	 * @param array $values - global config
	 * 
	 * @return void
	 */
	private function mistGlobal(array $values): void
	{
		// cast back
		$this->globalConfig = (object)$values;
	}

	/**
	 * Read widget areas from config
	 * 
	 * @param array $values - parameters for the widget area (sidebar)
	 * 
	 * @return void
	 */
	private function widgetAreas(array $values): void
	{
		$this->widgetAreas = count($values) > 0 ? $values : []; 
	}
	
	/**
	 * Image Sizes from config
	 * 
	 * @param array $values
	 * 
	 * @return void
	 */
	private function imageSizes(array $values): void
	{
		$this->imageSizes = count($values) > 0 ? $values : []; 
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
			$pt = new MistPostType([
				'excerpt_length' => $this->globalConfig->excerpt_length,
				'excerpt_text' => $this->globalConfig->excerpt_text
			]);
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
		// TODO: sanitize this developer input make sure it's all right
		$navMenus = apply_filters('mist_nav_menus', $this->navMenus);
		register_nav_menus($navMenus);

		// load text domain
		load_theme_textdomain($this->textDomain, $this->theme()->rootPath() . '/languages');

		$this->addThemeSupport();
		$this->addImageSizes();
	}
	
	/**
	 * Run widgets_init hook
	 * 
	 * @return void
	 */
	public function initWidgets(): void
	{
		// TODO: sanitize this developer input make sure it's all right
		$widgetAreas = apply_filters('mist_widget_areas', $this->widgetAreas);
		array_map(function(array $item) {
			if (false === isset($item['name'])) {
				throw new \Exception('You must provide a name for the sidebar to register. Check mist.config.json for errors.');
			}

			$item = wp_parse_args($item, $this->widgetProps);
			$item = $this->builtSidebarArgs($item);

			// TODO: OOP -> check what happens with Gutenberg && sidebars
			register_sidebar([
				'name' => __($item['name'], $this->textDomain),
				'id' => $item['id'],
				'before_widget' => $item['before_widget'],
				'after_widget' => $item['after_widget'],
				'before_title' => $item['before_title'],
				'after_title' => $item['after_title'],
			]);
		}, $widgetAreas);
	}

	/**
	 * Create sidebar args from all possible input
	 * 
	 * @param array $args - the wp parsed args used to
	 * generate mist sidebar args
	 * 
	 * @return array - the new args
	 */
	private function builtSidebarArgs(array $args): array
	{
		// replace tags
		$wtags = str_replace(
			'WTAG',
			$args['wrapper_tag'],
			[
				$args['before_widget'],
				$args['after_widget'],
			]
		);

		$args['before_widget'] = $wtags[0];
		$args['after_widget'] = $wtags[1];
		
		$ttags = str_replace(
			'TTAG',
			$args['title_tag'],
			[
				$args['before_title'],
				$args['after_title'],
			]
		);

		$args['before_title'] = $ttags[0];
		$args['after_title'] = $ttags[1];

		// replace classes
		$args['before_widget'] = str_replace(
			'%%MISTCLASSES%%',
			implode(' ', $args['wrapper_classes']),
			$args['before_widget']
		);

		$args['before_title'] = str_replace(
			'%%MISTCLASSES%%',
			implode(' ', $args['title_classes']),
			$args['before_title']
		);

		return $args;
	}

	/**
	 * Add image sizes
	 * 
	 * @return void
	 */
	private function addImageSizes(): void
	{
		// TODO: sanitize this developer input make sure it's all right
		$imageSizes = apply_filters('mist_image_sizes', $this->imageSizes);
		if (count($imageSizes) > 0) {
			foreach($imageSizes as $name => $params) {
				$width = $params['width'] ?? 300;
				$height = $params['height'] ?? 300;
				add_image_size((string)$name, $width, $height);
			}
		}
		
		// remove default wp image sizes if desired
		if (isset($this->globalConfig->wp['image_sizes']['remove_defaults']) &&
			true === $this->globalConfig->wp['image_sizes']['remove_defaults'])
		{
			remove_image_size('1536x1536');
			remove_image_size('2048x2048');
		}
	}

	/**
	 * Add the theme support configuration
	 * 
	 * @return void
	 */
	private function addThemeSupport(): void
	{
		// TODO: sanitize this developer input make sure it's all right
		$themeSup = apply_filters('mist_theme_support', $this->themeSupport);
		if (count($themeSup) > 0) {
			foreach($themeSup as $themeSupport) {
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
