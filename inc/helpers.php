<?php

/**
 * Helpers
 */

function dump($data)
{
	print "<pre style=' background: rgba(0, 0, 0, 0.1); margin-bottom: 1.618em; padding: 1.618em; overflow: auto; max-width: 100%; '>==========================\n";
	if (is_array($data)) {
		print_r($data);
	} elseif (is_object($data)) {
		var_dump($data);
	} else {
		var_dump($data);
	}
	print "===========================</pre>";
}


if (!function_exists('nakatani_svg_icon')) {

	/**
	 * @param $icon
	 *
	 * @return mixed|string
	 */
	function nakatani_svg_icon($icon)
	{
		$icons = require(__DIR__ . '/svg.php');
		return isset($icons[$icon]) ? $icons[$icon] : '';
	}
}

if (!function_exists('nakatani_the_posts_navigation')) {
	function nakatani_the_posts_navigation($args = array(), $base = false, $query = false)
	{
		$args = wp_parse_args($args, array(
			'prev_text' => __('Older posts'),
			'next_text' => __('Newer posts'),
			'screen_reader_text' => __('Posts navigation'),
			'aria_label' => __('Posts'),
			'class' => 'posts-navigation',
		));

		$wp_query = $query ? $query : $GLOBALS['wp_query'];

		// Don't print empty markup if there's only one page.
		if ($wp_query->max_num_pages < 2) {
			return;
		}
		$paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
		$pagenum_link = html_entity_decode(get_pagenum_link());
		if ($base) {
			$orig_req_uri = $_SERVER['REQUEST_URI'];
			$_SERVER['REQUEST_URI'] = $base;
			$pagenum_link = get_pagenum_link($paged - 1);
			$_SERVER['REQUEST_URI'] = $orig_req_uri;
		}

		$query_args = array();
		$url_parts = explode('?', $pagenum_link);
		if (isset($url_parts[1])) {
			wp_parse_str($url_parts[1], $query_args);
		}

		$pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
		$pagenum_link = trailingslashit($pagenum_link) . '%_%';
		$format = $GLOBALS['wp_rewrite']->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links(array(
			'base' => $pagenum_link,
			'format' => $format,
			'total' => $wp_query->max_num_pages,
			'current' => $paged,
			'mid_size' => 1,
			// 'add_args'  => array_map('urlencode', $query_args),
			'prev_text' => $args['prev_text'],
			'next_text' => $args['next_text'],
		));

		if ($links): ?>
			<nav class="navigation paging-navigation">
				<span class="screen-reader-text"><?= $args['screen_reader_text']; ?></span>
				<?php echo '<div class="pagination loop-pagination">' . $links . '</div><!-- .pagination -->' ?>
			</nav><!-- .navigation -->
			<?php
		endif;
	}
}


function nkt_translate($key, $path) {
    $locale = get_locale(); 
    $shortLocale = substr($locale, 0, 2); 
    
    $file = get_template_directory() . "/languages/{$shortLocale}/{$path}.php";
    
    if (file_exists($file)) {
        $langData = include $file;
        return $langData[$key] ?? $key;
    }
    
    $fallbackFile = get_template_directory() . "/languages/en/{$path}.php";
    if (file_exists($fallbackFile)) {
        $langData = include $fallbackFile;
        return $langData[$key] ?? $key;
    }
    
    return $key; 
}

function nkt_translate_shortcode($atts) {
    $atts = shortcode_atts([
        'text' => ''
    ], $atts);
    
    return nkt_translate($atts['text']);
}
add_shortcode('t', 'nkt_translate_shortcode');


function handle_language_switch() {
    if (isset($_GET['lang'])) {
        $lang = sanitize_text_field($_GET['lang']);
        $allowed_langs = ['en', 'jp', 'fr'];
        
        if (in_array($lang, $allowed_langs)) {
            // SET COOKIE 
            setcookie('site_language', $lang, time() + (365 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN, false, true);
            $_COOKIE['site_language'] = $lang;
        }
        
        // Redirect về URL không có parameter lang
        $redirect_url = remove_query_arg('lang');
        wp_redirect($redirect_url);
        exit;
    }
}
add_action('init', 'handle_language_switch');


function custom_site_language($locale) {
    // important cookie
    if (isset($_COOKIE['site_language'])) {
        $lang = $_COOKIE['site_language'];
        switch ($lang) {
            case 'en':
                return 'en_US';
            case 'fr':
                return 'fr';
            case 'jp':
                return 'jp';
        }
    }
    
    // Fallback to default settings of WordPress
    return $locale;
}
add_filter('locale', 'custom_site_language');


function get_language_url($lang) {
    global $wp;
    $current_url = home_url($wp->request);
    
    if (!str_ends_with($current_url, '/')) {
        $current_url .= '/';
    }
    
    return add_query_arg('lang', $lang, $current_url);
}

function nkt_language_switcher() {
    $languages = [
        'en' => 'EN',
        'jp' => 'JP',
		'fr' => 'FR'
    ];
    
    $current_lang = isset($_COOKIE['site_language']) ? $_COOKIE['site_language'] : 'en';
    $current_language_name = $languages[$current_lang];
    
    $output = '<div class="language-switcher d-flex flex-wrap">';
    
    
    $output .= '<div class="current-language-item w-100 d-sm-flex d-none">';
    $output .= '<span class="current-language">' . $current_language_name . '</span>';
    $output .= '<span class="dropdown-arrow"></span>';
    $output .= '</div>';
    
    $output .= '<div class="language-dropdown">';
    $output .= '<div class="dropdown-content">';
    
    foreach ($languages as $code => $name) {
        if ($code === $current_lang) continue;
        
        $language_url = get_language_url($code);
        $output .= '<a href="' . esc_url($language_url) . '" class="language-item" data-lang="' . $code . '">';
        $output .= $name;
        $output .= '</a>';
    }
    
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    return $output;
}

function nkt_language_switcher_mobile() {
    $languages = [
        'en' => 'EN',
        'jp' => 'JP',
        'fr' => 'FR'
    ];
    
    $current_lang = isset($_COOKIE['site_language']) ? $_COOKIE['site_language'] : 'en';
    
    $output = '<div class="language-switcher-mobile d-block d-sm-none">';
    $output .= '<div class="mobile-language-list">';
    
    foreach ($languages as $code => $name) {
        $active_class = ($code === $current_lang) ? 'active' : '';
        $language_url = get_language_url($code);
        
        $output .= '<a href="' . esc_url($language_url) . '" class="mobile-language-item ' . $active_class . '" data-lang="' . $code . '">';
        $output .= $name;
        // if ($code === $current_lang) {
        //     $output .= ' <span class="current-indicator">✓</span>';
        // }
        $output .= '</a>';
    }
    
    $output .= '</div>';
    $output .= '</div>';
    
    return $output;
}