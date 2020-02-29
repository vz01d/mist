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
	 * Initialize object
	 */
	public function __construct(string $iconName)
	{
		$this->iconName = $iconName;
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
			$rect = $doc->getChild(0);
			$rect->setStyle('fill', '#ffffff');

			header('Content-Type: image/svg+xml');
			echo $img;
		}

		return $this->iconName;
	}
}
