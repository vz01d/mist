<?php
declare(strict_types=1);
/**
 * The theme's 404 template
 *
 * @category   Theme Framework
 * @package    Mist
 * @subpackage Templates
 * @since      1.0
 */
use mist\wrapper\MistIcon;
?>
<h1 class="font-skeeg text-size-84 text-skeeg-400">
	40<span class="m-rot90 ml-16">4</span>
	<span class="float-right hidden md:block">
		<?php new MistIcon(
			'258-crying',
			[
				'fill' => '#336699',
				'width' => '150px',
				'height' => '150px'
			]);
		?>
	</span>
	<span class="float-right md:hidden">
		<?php new MistIcon(
			'258-crying',
			[
				'fill' => '#336699',
				'width' => '84px',
				'height' => '84px'
			]);
		?>
	</span>
</h1>
<span class="text-size-24 text-skeeg-500 font-skeeg">
	<?php if (isset(($_GET['s']))): ?>
		Deine Suche: <span class="italic"><?php echo esc_html(strip_tags($_GET['s'])); ?></span>
	<?php else: ?>
		Die Seite wurde nicht gefunden.
	<?php endif; ?>
</span>
<p class="mt-10">Was Du gesucht hast ist nicht hier.</p>
<p class="mt-10">Möchtest Du erneut suchen oder den Geenie befragen?</p>
<div class="w-full mt-42 shadow-md hover:shadow-xl cursor-pointer h-40">
	<div class="w-10 mx-auto pt-6">
		<?php new MistIcon(
			'135-search',
			[
				'fill' => '#336699',
				'width' => '36px',
				'height' => '36px'
			]);
		?>
	</div>
	<h2 class="text-size-30 font-skeeg text-skeeg-400 text-center">Erneut suchen</h2>
	<form
		role="search"
		method="get"
		class=""
		action="<?php esc_url( home_url( '/' ) ); ?>'"
	>
		<span class="screen-reader-text"><?php _x( 'Search for:', 'label' ); ?></span>
		<input
			class="
				block
				mx-auto
				w-8/12
				pl-2
				focus:pl-8
				text-size-22
				duration-300
				placeholder-skeeg-400
				text-skeeg-400
				font-skeeg
				text-center
				border-l-8
				border-b
				border-skeeg-400
			"
			name="s"
			type="search"
			placeholder="Erneut suchen"
		/>
	</form>
</div>
<div class="w-full mt-42 shadow-md hover:shadow-sm cursor-not-allowed h-40">
	<div class="w-10 mx-auto pt-6">
		<?php new MistIcon(
			'152-magic-wand',
			[
				'fill' => '#336699',
				'width' => '36px',
				'height' => '36px'
			]);
		?>
	</div>
	<h2 class="text-size-30 font-skeeg text-skeeg-400 text-center">
		Geenie befragen
	</h2>
	<span class="text-gray-400 text-center block font-skeeg">coming soon ...</span>
</div>