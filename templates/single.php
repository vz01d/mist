<?php
declare(strict_types=1);
/**
 * The theme's single.php file.
 *
 * @category   Theme Framework
 * @package    Mist
 * @subpackage Templates
 * @since      1.0
 */
if (!defined('ABSPATH')) {
	exit('direct access not allowed.');
}

use mist\objects\MistImage;

?>
<article class="border-b border-gray-300 py-42 first:pt-0 last:border-0">
	<h2 class="
		text-size-36
		font-skeeg
		text-skeeg-400"
	>
		<?php the_title(); ?>
	</h2>
	<span class="block text-skeeg-500 italic h-42 mb-2">
		<?php echo get_the_date() . ' von ' . get_the_author(); ?>
	</span>
	<?php echo new MistImage(['showCopyright' => true]); ?>
	<p class="mt-10">
		<?php the_content(); ?>
	</p>
</article>