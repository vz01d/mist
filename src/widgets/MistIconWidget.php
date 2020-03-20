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
namespace mist\widgets;

use mist\wrapper\MistIcon;

/**
 * MistIconWidget - a widget representing an svg icon to select from
 * which is optionally linkable
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistIconWidget extends \WP_Widget
{
	/**
	 * Theme DI
	 */
	private static $theme = null;

	/**
	 * Setup widget object
	 * 
	 * @param \mist\wrapper\MistTheme $theme - the theme object
	 */
	public function __construct(\mist\wrapper\MistTheme $theme)
	{
		self::$theme = $theme;

		$opts = [
			'classname' => 'MistIconWidget',
			'description' => 'SVG based icon widget (ssr)',
		];
		parent::__construct('MistIconWidget', 'Mist Icon', $opts);
	}
	
	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance) {
		
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form($instance) {
		$icon = ! empty($instance['icon']) ? $instance['icon'] : esc_html__('Select icon', self::$theme->textDomain);
		$out = '';
		$out .= '<p>';
		$out .= '<label
			for="'. esc_attr($this->get_field_id('icon')) . '">' .
			esc_attr_e('Select Icon:', self::$theme->textDomain). '</label>';
		
		$icons = self::$theme->themeIcons();

		// TODO: abstraction layer -> form -> generators
		/*
		$out .= '<select class="mist-select">';
			foreach($icons as $icon) {
				// add options
				if (false != file_exists($icon['path'])) {
					$i = new MistIcon(
						$icon['name'],
						[
							'fill' => '#336699',
							'width' => '36px',
							'height' => '36px'
						],
						false
					);

					$out .= '<option value="' . $icon['name'] . '">';
						ob_start();
						$i->render(false);
						$out .= ob_get_contents();
					$out .= '</option>';
				}
			}
		$out .= '</select>';
*/
		$out .= '</p>';

		echo $out;
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update($new_instance, $old_instance) {
		// processes widget options to be saved
	}
}
