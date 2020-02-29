<?php
declare(strict_types=1);
/**
 * The theme's header template
 *
 * @category   Theme Framework
 * @package    Mist
 * @subpackage Templates
 * @since      1.0
 */
if (!defined('ABSPATH')) {
	exit('direct access not allowed.');
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body itemtype="https://schema.org/WebPage" itemscope="itemscope" <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header
	class="p-42 py-4 bg-skeeg-400"
	id="masthead"
	itemtype="https://schema.org/WPHeader"
	itemscope="itemscope"
>
	<div class="flex">
		<div class="inline-block flex-1">
			<!-- TODO: h1 only if is_home() -->
			<h1 class="my-0 font-skeeg uppercase text-logo text-white leading-none border-b text-center">
				<?php echo get_bloginfo('name'); ?>
			</h1>
			<div class="uppercase font-bold text-white text-size-18 text-center">
				<?php echo get_bloginfo('description'); ?>
			</div>
		</div>
		<div class="flex-grow flex-shrink">
			<input
				id="mist-search"
				class="py-4 pl-2 focus:pl-12 w-full my-auto h-12 text-size-22 mt-42 rounded duration-300"
				type="text"
				placeholder="42?"
			/>
		</div>
	</div>
</header>