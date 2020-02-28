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
	class="p-42 py-0 bg-skeeg-400"
	id="masthead"
	itemtype="https://schema.org/WPHeader"
	itemscope="itemscope"
>
	<!-- TODO: h1 only if is_home() -->
	<h1 class="my-0 font-skeeg uppercase text-s42 text-white">
		<?php echo get_bloginfo('name'); ?>
	</h1>
	<div class="uppercase text-base font-bold text-white">
		<?php echo get_bloginfo('description'); ?>
	</div>
</header>