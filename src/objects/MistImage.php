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
namespace mist\objects;

/**
 * MistImage - Image object
 * render an image using wp src set
 * registers meta field for media "copyright" which should
 * be filled with an url output will contain a small info icon with
 * a nofollow ahref to the source of the image
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistImage
{
	/**
	 * Show image caption or not
	 */
	private $showCaption = true;
	
	/**
	 * Show image caption or not
	 */
	private $size = '';

	/**
	 * Create new image - image must be echo'd so magic will happen
	 * 
	 * @param bool $showCaption - show the image caption - default true
	 * @param string $size - the image size name - default empty string
	 * will fallback to largest (!) size
	 */
	public function __construct(bool $showCaption = true, string $size = '')
	{
		$this->showCaption = $showCaption;

		$sizes = get_intermediate_image_sizes();
		if ('' === $size || false === in_array($size, $sizes)) {
			$size = $sizes[count($sizes) - 1] ?? 'thumbnail';
		}

		$this->size = $size;
	}

	/**
	 * Magic __toString
	 * 
	 * outputs the image loaded :)
	 */
	public function __toString(): string
	{
		$imageId = get_post_thumbnail_id();
		$src = wp_get_attachment_image_src($imageId, $this->size);
		$srcSet = wp_get_attachment_image_srcset($imageId, $this->size);
		$srcSetSizes = wp_get_attachment_image_sizes($imageId, $this->size);
		$alt = get_post_meta($imageId, '_wp_attachment_image_alt', true);
		$meta = wp_get_attachment_metadata($imageId);
		$title = get_the_title($imageId);

		if ($this->showCaption) {
			$caption = wp_get_attachment_caption($imageId);
		}

		$out = "";

		if (false !== $this->showCaption && '' !== $caption) {
			$out .= "<figure class='wp-caption'>";
		}

		$out .= "<img
			class='mist-img'
			src='{$src[0]}'
			title='{$title}'
			srcset='{$srcSet}'
			sizes='{$srcSetSizes}'
			alt='{$alt}'
		/>";

		if (false !== $this->showCaption && '' !== $caption) {
			$out .= "<figcaption class='wp-caption-text'>{$caption}</figcaption>";
			$out .= "</figure>";
		}

		return $out;
	}
}
