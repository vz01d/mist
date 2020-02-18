<?php
declare(strict_types=1);
/**
 * The theme's index.php file.
 *
 * @category   Theme Framework
 * @package    Mist
 * @subpackage Templates
 * @since      1.0
 */

get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post(); ?>
	<?php }
}

get_footer();
