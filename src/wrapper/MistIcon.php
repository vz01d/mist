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
	private $props = [];

	/**
	 * Initialize object
	 * 
	 * @param string $iconName - the icon name
	 * @param string $props - the icon properties
	 */
	public function __construct(string $iconName, array $props = [])
	{
		$this->iconName = $iconName;
		$this->props = $props;

		$this->validateProps();
	}

	/**
	 * Validate set properties and only
	 * overwrite defaults if valid
	 */
	private function validateProps(): void
	{
		// TODO: this needs more thought
		/**
		 * not always 7, maybe 6, 3 or 4
		 * wether # or not also consider rgba hsl support
		 */
		if (
			false === isset($this->props['fill']) ||
			false === is_string($this->props['fill']) ||
			7 !== strlen($this->props['fill'])
		) {
			$this->props['fill'] = '#000';
		}

		if (false === isset($this->props['width'])) {
			$this->props['width'] = '14px';
		}

		if (false === isset($this->props['height'])) {
			$this->props['height'] = '14px';
		}
	}

	/**
	 * Render icon if exists
	 * else return icon name as alt string
	 * 
	 * @return string - the icon svg or name
	 */
	public function __toString()
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

		return $this->iconName;
	}
}
