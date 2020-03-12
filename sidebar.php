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
			leading-normal
			sidebar
			widget-area
			w-full
			pb-42
			lg:py-42
			lg:pl-42
			lg:float-right
			lg:w-1/3
			xl:w-2/5
		"
		role="complementary">
		<?php dynamic_sidebar('mainside'); ?>
	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>
