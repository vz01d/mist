<?php
declare(strict_types=1);
/**
 * Mist
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
namespace mist\objects;

use mist\MistConfig;

/**
 * MistBreadcrumb - display breadcrumbs in your theme
 * original source for breadcrumb via SO: https://gist.githubusercontent.com/techpulsetoday/c7f8fa1a5f170f4ecbb049b63d0cd140/raw/2dd52a19e786390fd6016478ff201b5e6c4ae818/breadcrumbs-code-without-plugin.php
 * this is a heavily modified OOP version of above gist
 * which incorporates some Mist related functions for config loading etc.
 *
 * @category Theme Framework
 * @package  Mist
 * @author   Sebo <sebo@42geeks.gg>
 * @license  GPLv3 https://opensource.org/licenses/gpl-3.0.php
 */
class MistBreadcrumb
{
	/**
	 * Default configuration for Breadcrumb
	 */
	private static $defaultConfig = [
		'showOnHome' => false,
		'delimiter' => '&#187;',
		'homelabel' => 'Home',
		'highlight' => true,
		'before' => '<span class="current">',
		'after' => '</span>',
	];
	
	/**
	 * Load object
	 * 
	 * @param array $config - the configuration array
	 */
	public function __construct(array $config)
	{
		self::$defaultConfig = wp_parse_args($config, $defaultConfig);
	}

	/**
	 * Render the breadcrumb
	 *
	 * @return string - the rendered breadcrumb html
	 */
	public static function render(): string
	{
		$c = self::$defaultConfig;
		$out = '';
		$homeLink = get_bloginfo('url');

		// TODO: this is a bit to much of a function
		// break up into smaller logical units
		if (is_home() || is_front_page()) {
			if (true === $c['showOnHome']) {
				$out .= '<div id="mist-breadcrumb"><a href="' . $homeLink . '">' . $c['homelabel'] . '</a></div>';
			}
		} else {
			$pt = get_post_type();
			$out .= '<div id="mist-breadcrumb"><a href="' . $homeLink . '">' . $c['homelabel'] . '</a> ' . $c['delimiter'] . ' ';
			if (is_category()) {
				$currentCat = get_category(get_query_var('cat'), false);
				if ($currentCat->parent != 0) {
					$out .=  get_category_parents($currentCat->parent, true, ' ' . $c['delimiter'] . ' ');
				}
				$out .=  $c['before'] . 'Archive by category "' . single_cat_title('', false) . '"' . $c['after'];
			} elseif (is_search()) {
				$out .=  $c['before'] . 'Search results for "' . get_search_query() . '"' . $c['after'];
			} elseif (is_day()) {
				$out .=  '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $c['delimiter'] . ' ';
				$out .=  '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $c['delimiter'] . ' ';
				$out .=  $c['before'] . get_the_time('d') . $c['after'];
			} elseif (is_month()) {
				$out .=  '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $c['delimiter'] . ' ';
				$out .=  $c['before'] . get_the_time('F') . $c['after'];
			} elseif (is_year()) {
				$out .=  $c['before'] . get_the_time('Y') . $c['after'];
			} elseif (is_single() && !is_attachment()) {
				if ('post' !== $pt) {
					$post_type = get_post_type_object($pt);
					$slug = $post_type->rewrite;
					$out .=  '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
					if (true === $c['highlight']) {
						$out .=  ' ' . $c['delimiter'] . ' ' . $c['before'] . get_the_title() . $c['after'];
					}
				} else {
					$cat = get_the_category();
					$cat = $cat[0];
					$cats = get_category_parents($cat, true, ' ' . $c['delimiter'] . ' ');
					if (false === $c['highlight']) {
						$cats = preg_replace("#^(.+)\s" . $c['delimiter'] . "\s$#", "$1", $cats);
					}
					$out .=  $cats;
					if (true === $c['highlight']) {
						$out .=  $c['before'] . get_the_title() . $c['after'];
					}
				}
			} elseif (!is_single() && !is_page() && $pt != 'post' && !is_404()) {
				$post_type = get_post_type_object($pt);
				$out .=  $c['before'] . $post_type->labels->singular_name . $c['after'];
			} elseif (is_attachment()) {
				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID);
				$cat = $cat[0];
				$out .=  get_category_parents($cat, true, ' ' . $c['delimiter'] . ' ');
				$out .=  '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
				if (true === $c['highlight']) {
					$out .=  ' ' . $c['delimiter'] . ' ' . $c['before'] . get_the_title() . $c['after'];
				}
			} elseif (is_page() && !$post->post_parent) {
				if (true === $c['highlight']) {
					$out .=  $c['before'] . get_the_title() . $c['after'];
				}
			} elseif (is_page() && $post->post_parent) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					$out .=  $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) {
						$out .=  ' ' . $c['delimiter'] . ' ';
					}
				}
				if (true === $c['highlight']) {
					$out .=  ' ' . $c['delimiter'] . ' ' . $c['before'] . get_the_title() . $c['after'];
				}
			} elseif (is_tag()) {
				$out .=  $c['before'] . 'Posts tagged "' . single_tag_title('', false) . '"' . $c['after'];
			} elseif (is_author()) {
				global $author;
				$userdata = get_userdata($author);
				$out .=  $c['before'] . 'Articles posted by ' . $userdata->display_name . $c['after'];
			} elseif (is_404()) {
				$out .=  $c['before'] . 'Error 404' . $c['after'];
			}

			if (get_query_var('paged')) {
				if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
					$out .=  ' (';
				}
				$out .=  __('Page') . ' ' . absint(get_query_var('paged'));
				if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
					$out .=  ')';
				}
			}
			$out .=  '</div>';
		}

		return $out;
	}
}
