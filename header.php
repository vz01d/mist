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

use mist\wrapper\MistIcon;
use mist\objects\MistBreadcrumb;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<!-- SKEEG@202042 674659874275784244531350568116333665037981361 -->
</head>
<body itemtype="https://schema.org/WebPage" itemscope="itemscope" <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header
	class="p-42 py-4 md:py-42 bg-skeeg-400 md:flex"
	id="masthead"
	itemtype="https://schema.org/WPHeader"
	itemscope="itemscope"
>
	<div class="
		container
		inline-block
		w-full
		md:flex-1
		md:flex-shrink
		lg:w-1/3
	">
		<!-- TODO: h1 only if is_home() -->
		<h1 class="my-0 font-skeeg uppercase text-logo text-white leading-none text-left">
			<?php 
				$siteName = get_bloginfo('name');
				$out = $siteName;
				// set link to home
				if (false === is_home()) {
					$out = '<a href="'. get_home_url() . '" title="Zur Startseite">' . $siteName . '</a>';
				}

				echo $out;
			?>
			<div class="hidden md:block float-left p-4">
				<div id="mwand">
					<?php new MistIcon(
						'152-magic-wand',
						[
							'fill' => '#ffffff',
							'width' => '36px',
							'height' => '36px'
						]);
					?>
				</div>
			</div>
				<form
					id="mist-search-form" role="search" method="get" class="search-form -mt-3 w-full float-right lg:w-4/5 xl:w-1/3 md:ml-4" action="<?php esc_url( home_url( '/' ) ); ?>'">
					<span class="screen-reader-text"><?php _x( 'Search for:', 'label' ); ?></span>
					<input
						id="mist-search"
						class="
							w-full
							pl-2
							focus:pl-4
							h-16
							text-size-22
							duration-300
							placeholder-skeeg-400
							text-skeeg-400
						"
						name="s"
						type="search"
						placeholder="42?"
					/>
				</form>
		</h1>
		<hr class="w-full h-1 bg-white" />
		<div class="uppercase font-bold text-white text-size-18 text-center md:text-left">
			<?php echo get_bloginfo('description'); ?>
		</div>
	</div>
</header>
<div class="container">
	<?php echo MistBreadcrumb::render(); ?>
</div>