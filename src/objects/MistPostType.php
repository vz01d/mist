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
	private $excerptLength = 231;
	
	/**
	 * Excerpt text
	 */
	private $excerptText = 'read more ...';

	/**
	 * $showCopyright
	 */
	protected $showCopyright = false;

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

		if (true === isset($args['show_copyright'])) {
			$this->showCopyright = $args['show_copyright'];
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
		
		add_filter('get_the_excerpt', [$this, 'excerptLength']);
		add_filter('excerpt_more', [$this, 'excerptMoreText']);

		// show copyright meta if desired
		// TODO: move this (!)
		if (true === $this->showCopyright) {
			$this->addAttachmentMeta();
		}
	}

	/**
	 * Add custom meta fields to attachments
	 *
	 * @return void
	 */
	private function addAttachmentMeta(): void
	{
		// TODO: abstract to MistPostTypeAttachment
		// add filters and actions
		add_filter('attachment_fields_to_edit', [$this, 'loadAttachmentMeta'], 10, 2);
		add_action('wp_ajax_save-attachment-compat', [$this, 'ajaxSaveCompat'], 0, 1);
		add_filter('attachment_fields_to_edit', [$this, 'saveAttachment'], 1);
	}

	/**
	 * Load WPs attachment meta
	 * 
	 * @param array $fields - the current fields array
	 * @param \WP_Post $post - the post we're working on
	 * 
	 * @return array - the modified fields
	 */
	public function loadAttachmentMeta($fields, \WP_Post $post): array
	{
		// TODO: abstract this
		$copyrightUrl = get_post_meta($post->ID, 'mist_copyright_url', true);
		$fields['mist_copyright_url'] = [
				'label' =>  __('Copyright Url', $this->theme()->textDomain),
				'input' => 'text',
				'value' => $copyrightUrl,
				'show_in_edit' => true,
		];
		
		$copyrightText = get_post_meta($post->ID, 'mist_copyright_text', true);
		$fields['mist_copyright_text'] = [
				'label' =>  __('Copyright Info Text', $this->theme()->textDomain),
				'input' => 'text',
				'value' => $copyrightText,
				'show_in_edit' => true,
		];

		return $fields;  
	}

	/**
	 * Load WPs attachment meta
	 * 
	 * @return void
	 */
	public function ajaxSaveCompat(): void
	{
		$post_id = intval($_POST['id']);
		$copyrightUrl = sanitize_text_field($_POST['attachments'][$post_id]['mist_copyright_url']);
		update_post_meta($post_id , 'mist_copyright_url', $copyrightUrl);
		
		$copyrightText = sanitize_text_field($_POST['attachments'][$post_id]['mist_copyright_text']);
		update_post_meta($post_id , 'mist_copyright_text', $copyrightText);

		clean_post_cache($post_id);
	}

	/**
	 * Load WPs attachment meta
	 * 
	 * @return bool
	 */
	public function saveAttachment($post_id): bool
	{
		$copyrightUrl = isset($_POST['attachments'][$post_id]['mist_copyright_url']) ?? false;
		$result = update_post_meta($post_id, 'mist_copyright_url', sanitize_text_field($copyrightUrl));

		$copyrightText = isset($_POST['attachments'][$post_id]['mist_copyright_text']) ?? false;
		$result = $result && update_post_meta($post_id, 'mist_copyright_text', sanitize_text_field($copyrightText));

		return $result;
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
     * @param string $more - the current more tag
     *
     * @return string - the new more tag
     */
    public function excerptMoreText(string $more): string
    {
        $postId = get_the_ID();
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
		// TODO: create custom loop for functions like get_post_type to be covered by framework
		// TODO: if ! if ?
		$post_type = get_post_type();
		if ('' === $excerpt || $this->name !== $post_type) {
			return $excerpt;
		}
		return substr($excerpt, 0, $this->excerptLength) . ' ' . $this->excerptMoreText('');
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
