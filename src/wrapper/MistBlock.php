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

use mist\objects\MistImage;

/**
 * MistBlock - filter wp blocks, add custom ones or do some
 * magic here and there to make things more shiny. 
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistBlock
{
	/**
	 * Empty
	 */
	public function __construct(){}
	
	/**
	 * WP init hook
	 * 
	 * do some magic to blocks
	 * 
	 * @return void
	 */
	public function initBlocks(): void
	{
		register_block_type('core/image', [
			'render_callback' => [$this, 'extendImageBlock'],
		]);
	}

	/**
	 * Extend wp default image block
	 * adding mist copyright info if activated in theme config
	 * 
	 * @param $attributes - the attributes of the block
	 * @param $content - the content of the block
	 * 
	 * @return string - the image html rendered
	 */
	public function extendImageBlock($attributes, $content): string
	{
		$image = new MistImage(['showCopyright' => true, 'id' => $attributes['id']]);
		return $image->render();
	}
}
