<?php
declare(strict_types=1);
/**
 * The theme's footer template
 *
 * @category   Theme Framework
 * @package    Mist
 * @subpackage Templates
 * @since      1.0
 */
?>
<footer
	class="bg-skeeg-400 static bottom-0 clear-both text-white leading-normal">
	<div class="container md:flex p-42">
		<div class="w-full md:flex-1 text-center">
			<?php if (is_active_sidebar('footer1')) : ?>
				<?php dynamic_sidebar('footer1'); ?>
			<?php endif; ?>
		</div>
		<div class="w-full md:flex-1 text-center">
			<?php if (is_active_sidebar('footer2')) : ?>
				<?php dynamic_sidebar('footer2'); ?>
			<?php endif; ?>
		</div>
		<div class="w-full md:flex-1 text-center">
			<?php if (is_active_sidebar('footer3')) : ?>
				<?php dynamic_sidebar('footer3'); ?>
			<?php endif; ?>
		</div>
		<div class="w-full md:flex-1 text-center">
			<?php if (is_active_sidebar('footer4')) : ?>
				<?php dynamic_sidebar('footer4'); ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="border-t-2 border-solid border-skeeg-500 py-4">
		<div class="container">
			<div class="flex">
				<div class="flex-1 align-center self-center">
					&copy; 2020 - 42GEEKS.GG
				</div>
				<div class="flex-1 text-right">
					<?php 
						// TODO: custom walker
						echo wp_nav_menu(
							[
								'menu' => 'footer',
								'menu_class' => 'list-none mist-inline-nav',
							]
						);
					?>
				</div>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
<!-- GG -->
