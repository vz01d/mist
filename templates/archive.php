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
	<?php the_post_thumbnail(); ?>
	<p class="mt-10">
		<?php the_excerpt(); ?>
	</p>
</article>