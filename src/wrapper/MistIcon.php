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
use SVG\SVG;

/**
 * MistIcon - a wrapper around svg icons
 * TODO: move svg's somewhere to framework (???)
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistIcon extends MistWrapper
{
	/**
	 * Icon name
	 */
	private $iconName = '';

	/**
	 * Icon properties
	 */
	private $props = [
		'fill' => '#000000',
		'width' => '14px',
		'height' => '14px',
	];

	/**
	 * Initialize object
	 * 
	 * @param string $iconName - the icon name
	 * @param string $props - the icon properties
	 * @param string $render - render the icon or not
	 */
	public function __construct(string $iconName, array $props = [], bool $render = true)
	{
		$this->iconName = $iconName;
		$this->props = wp_parse_args($props, $this->props);

		if (true === $render){
			return $this->render();
		}
	}

	/**
	 * Render icon if exists
	 * else return icon name as alt string
	 * 
	 * @param bool $echo - wether to echo the icon or not
	 * 
	 * TODO: naming is somewhat crap
	 * 
	 * @return string - the icon svg or name
	 */
	public function render()
	{
		$img = '';
		$iconPath = $this->theme()->assetPath() . '/icons/' . $this->iconName . '.svg';
		if (true === file_exists($iconPath)) {
			$svg = file_get_contents($iconPath);
			$img = SVG::fromString($svg);
			$doc = $img->getDocument();
			$doc->setWidth($this->props['width']);
			$doc->setHeight($this->props['height']);
			$rect = $doc->getChild(0);
			$rect->setStyle('fill', $this->props['fill']);

		}
		
		echo $img;
	}
}
