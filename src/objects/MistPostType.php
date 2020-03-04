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

use mist\wrapper\MistPost;

/**
 * MistPostType - Post Type as object
 * this will allow for later customization like removing
 * extended-cpts and roll your own if you want to.
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistPostType extends MistPost
{
	/**
	 * Post type name
	 */
	public $name = '';

	/**
	 * Label singular
	 */
	public $singular = '';
	
	/**
	 * Label plural
	 */
	public $plural = '';

	/**
	 * Excerpt length
	 */
	public $excerptLength = 231;
	
	/**
	 * Excerpt text
	 */
	public $excerptText = 'read more ...';

	/**
	 * Create new Posttype object
	 * 
	 * @param array $args - the parameters for the post type
	 */
	public function __construct(array $args)
	{
		if (true === isset($args['excerpt_length'])) {
			$this->excerptLength = $args['excerpt_length'];
		}

		if (true === isset($args['excerpt_text'])) {
			$this->excerptText = $args['excerpt_text'];
		}
	}
	
	/**
	 * Setup the post type
	 * 
	 * @param array $args - parameters for the post type
	 * 
	 * @return void
	 */
	public function setup(array $args): void
	{
		array_map(
			function($ptParams, $ptName){
				// set name
				$this->name = $ptName;

				// no params
				if (count($ptParams) < 1) {
					return;
				}

				// extract params
				$this->extractParams($ptParams);
			},
			$args,
			array_keys($args)
		);

        add_filter('get_the_excerpt', [$this, 'excerptLength'], 999);
        add_filter('excerpt_more', [$this, 'excerptMoreText']);
	}

	/**
	 * extract parameters and set them on the object
	 * 
	 * @param array $params - parameters for the post type
	 * 
	 * @return void
	 */
	private function extractParams(array $params): void
	{
		$this->singular = isset($params['singular']) ? $params['singular'] : '';
		$this->plural = isset($params['plural']) ? $params['plural'] : '';
		$this->excerptLength = isset($params['excerpt_length']) ? $params['excerpt_length'] : $this->excerptLength;
		$this->excerptText = isset($params['excerpt_text']) ? $params['excerpt_text'] : $this->excerptText;
	}

	/**
     * Change excerpt read more text
     *
     * @param string $more - the 6current more tag
     *
     * @return string - the new more tag
     */
    public function excerptMoreText(string $more): string
    {
        $postId = get_queried_object_id();
        return '<a class="moretag inline-block" href="' .
               get_permalink($postId) .
               '">' .
               $this->excerptText .
        '</a>';
    }

	/**
     * Change excerpt default length
     *
     * @param string $excerpt - the excerpt input
     *
     * @return string - the new excerpt
     *
     */
    public function excerptLength(string $excerpt): string
    {
		if ('' === $excerpt || $this->name !== get_post_type()) {
			return $excerpt;
		}
		return substr($excerpt, 0, $this->excerptLength) . $this->excerptMoreText('');
	}

	/**9
	 * Register the post type
	 * TODO: make extended-cpts optional
	 * 
	 * @return void
	 */
	public function register(): void
	{
		$labels = $this->labels();
		$params = [];
		
		if (count($labels) < 1) {
			register_extended_post_type($this->name, $params);
		}

		if (count($labels) > 0) {
			register_extended_post_type($this->name, $params, $labels);
		}
	}

	/**
	 * Return the labels for the post type
	 * 
	 * @return array - the post types labels
	 */
	private function labels(): array
	{
		$labels = [];
		if ('' !== $this->singular && '' !== $this->plural) {
			$labels['singular'] = $this->singular;
			$labels['plural'] = $this->plural;
		}

		return $labels;
	}
}
