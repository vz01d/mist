<?php
declare(strict_types=1);
/**
 * The theme's sidebar.php file.
 *
 * @category   Theme Framework
 * @package    Mist
 * @subpackage Templates
 * @since      1.0
 */
if (!defined('ABSPATH')) {
	exit('direct access not allowed.');
}

if (is_active_sidebar('mainside')) : ?>
	<aside 
		id="secondary"
		class="
			py-42
			pl-42
			sidebar
			widget-area
			w-full
			lg:float-right
			lg:w-1/3
			xl:w-2/5
		"
		role="complementary">
		<?php dynamic_sidebar('mainside'); ?>
	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>