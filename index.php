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
<div class="container">
	<main
		class="
			py-42
			lg:p-42
			w-full
			lg:float-left
			lg:w-2/3
			xl:w-3/5
			text-size-18
		"
	>
	<?php
	if (have_posts()) {
		while (have_posts()) {
			the_post();
			the_content();
		}
	}
	?>
	</main>
	<?php get_sidebar(); ?>	
</div>
<?php get_footer();
