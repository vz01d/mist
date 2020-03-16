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
	 * Image parameters
	 */
	private $params = [
		'id' => null,
		'showCaption' => true,
		'size' => 'thumbnail',
		'showCopyright' => false
	];

	/**
	 * Create new image - image must be echo'd so magic will happen
	 * 
	 * @param array $params - array of image params as below
	 *  bool $showCaption - show the image caption - default true
	 *  string $size - the image size name - default 'thumbnail'
	 *  will fallback to largest (!) size
	 *  bool showCopyright - wether to show the copyright info link and
	 *  tooltip or not
	 */
	public function __construct(array $params = [])
	{
		// use biggest registered size of theme as default (!)
		$sizes = get_intermediate_image_sizes();
		$this->params['size'] = $sizes[count($sizes) - 1];

		// set params
		$this->params = wp_parse_args($params, $this->params);
	}

	/**
	 * Render the image
	 * 
	 * @return string - the image string
	 */
	public function render(): string
	{
		$imageId = $this->params['id'] ?? get_post_thumbnail_id();
		$src = wp_get_attachment_image_src($imageId, $this->params['size']);
		$srcSet = wp_get_attachment_image_srcset($imageId, $this->params['size']);
		$srcSetSizes = wp_get_attachment_image_sizes($imageId, $this->params['size']);
		$alt = get_post_meta($imageId, '_wp_attachment_image_alt', true);
		$meta = wp_get_attachment_metadata($imageId);
		$title = get_the_title($imageId);

		if ($this->params['showCaption']) {
			$caption = wp_get_attachment_caption($imageId);
		}

		$out = "";

		if (false !== $this->params['showCaption'] && '' !== $caption) {
			$out .= "<figure class='wp-block-image size-full'>";
		}

		$out .= "<img
			class='mist-img'
			src='{$src[0]}'
			title='{$title}'
			srcset='{$srcSet}'
			sizes='{$srcSetSizes}'
			alt='{$alt}'
		/>";

		if (false !== $this->params['showCaption'] && '' !== $caption) {
			// copyright
			// ??? -> @giggles: can we please safe these permanent postmeta hits somehow?
			$copyrightText = esc_html(get_post_meta($imageId, 'mist_copyright_text', true));
			$copyrightUrl = esc_html(get_post_meta($imageId, 'mist_copyright_url', true));
			$out .= "<figcaption class='wp-caption-text' data-cptext='{$copyrightText}' data-cpurl='{$copyrightUrl}'>";
			$out .= $caption;
			
			if (true === $this->params['showCopyright']) {
				$out .= "<a href='#mistmodal' class='mist-copyright-info'>©️</a>";

				// pass data to client if required
				// wp_localize_script('mist-overlay', 'MISTIMG', []);
				wp_enqueue_script('mist-overlay');
			}

			$out .= "</figcaption>";
			$out .= "</figure>";
		}

		return $out;
	}

	/**
	 * Magic __toString
	 * 
	 * outputs the image loaded :)
	 */
	public function __toString(): string
	{
		return $this->render();
	}
}
