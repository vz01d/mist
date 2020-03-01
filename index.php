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
if (!defined('ABSPATH')) {
	exit('direct access not allowed.');
}

get_header();
?>
<main class="p-42">
<?php
if (have_posts()) {
	while (have_posts()) {
		the_post();
		the_content();
	}
}
?>
</main>
<?php
get_footer();
