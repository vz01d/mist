<?php
declare(strict_types=1);
/**
 * The theme's 404.php file.
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
			leading-normal
			py-42
			pr-42
			w-full
			lg:float-left
			lg:w-2/3
			xl:w-3/5
			text-size-18
		"
	>
	<?php
		get_template_part( 'templates/404' );
	?>
	</main>
	<?php get_sidebar(); ?>	
</div>
<?php get_footer();
