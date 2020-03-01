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
	 */
	public function __construct(string $iconName, array $props = [])
	{
		$this->iconName = $iconName;
		$diff = array_diff($props, $this->props);
		$this->props = count($diff) < 1 ? $this->props : $diff;

		return $this->render();
	}

	/**
	 * Render icon if exists
	 * else return icon name as alt string
	 * 
	 * @return string - the icon svg or name
	 */
	private function render()
	{
		$iconPath = $this->theme()->assetPath() . '/icons/' . $this->iconName . '.svg';
		if (true === file_exists($iconPath)) {
			$svg = file_get_contents($iconPath);
			$img = SVG::fromString($svg);
			$doc = $img->getDocument();
			$doc->setWidth($this->props['width']);
			$doc->setHeight($this->props['height']);
			$rect = $doc->getChild(0);
			$rect->setStyle('fill', $this->props['fill']);

			header('Content-Type: image/svg+xml');
			echo $img;
		}
	}
}
