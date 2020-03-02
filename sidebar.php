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
			p-42
			sidebar
			widget-area
			w-full
			md:w-1/4
			md:float-right
			lg:w-1/3
			xl:w-2/5
		"
		role="complementary">
		<?php dynamic_sidebar('mainside'); ?>
	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>