<?php
add_action('after_setup_theme', function () {
	register_nav_menus([
		'primary-menu'     => esc_html__('Primary Menu', 'nakatani'),
	]);
});

/**
 * @param $classes
 * @param $item
 * @param $args
 *
 * @return mixed
 */
add_filter('nav_menu_css_class', 'filter_bootstrap_nav_menu_css_class', 10, 3);
function filter_bootstrap_nav_menu_css_class($classes, $item, $args)
{
	if (isset($args->bootstrap)) {

		$classes[] = ($item->object_id == get_the_ID()) ? 'nav-item current' : 'nav-item';

		if (in_array('menu-item-has-children', $classes)) {
			$classes[] = 'dropdown';
		}

		if (in_array('dropdown-header', $classes)) {
			unset($classes[array_search('dropdown-header', $classes)]);
		}
	}


	return $classes;
}

/**
 * Add bootstrap attributes to individual link elements.
 *
 * @param $atts
 * @param $item
 * @param $args
 * @param $depth
 *
 * @return mixed
 */

add_filter('nav_menu_link_attributes', 'filter_bootstrap_nav_menu_link_attributes', 10, 4);
function filter_bootstrap_nav_menu_link_attributes($atts, $item, $args, $depth)
{

	if (isset($args->bootstrap)) {
		if (!isset($atts['class'])) {
			$atts['class'] = '';
		}

		if ($depth > 0) {
			if (in_array('dropdown-header', $item->classes)) {
				$atts['class'] = 'dropdown-header';
			} else {
				$atts['class'] .= 'dropdown-item';
			}

			if ($item->description) {
				$atts['class'] .= ' has-description';
			}
		} else {
			$atts['class'] .= 'nav-link';
			if (in_array('menu-item-has-children', $item->classes)) {
				$atts['class'] .= ' dropdown-toggle';
				$atts['role'] = 'button';
				$atts['data-toggle'] = 'dropdown';
				$atts['aria-haspopup'] = 'true';
				$atts['aria-expanded'] = 'false';
			}
		}
	}

	return $atts;
}

/**
 * Add bootstrap classes to dropdown menus.
 *
 * @param $classes
 * @param $args
 * @param $depth
 *
 * @return mixed
 */

add_filter('nav_menu_submenu_css_class', 'filter_bootstrap_nav_menu_submenu_css_class', 10, 3);
function filter_bootstrap_nav_menu_submenu_css_class($classes, $args, $depth)
{
	if (isset($args->bootstrap)) {
		$classes[] = 'dropdown-menu';
	}

	return $classes;
}


function nkt_menu_translate($key) {
    static $menuData = null;
    $current_lang = isset($_COOKIE['site_language']) ? $_COOKIE['site_language'] : 'en';

    if ($menuData === null) {
        $file = get_template_directory() . "/languages/{$current_lang}/menu.php";
        if (file_exists($file)) {
            $menuData = include $file;
        } else {
            $fallbackFile = get_template_directory() . "/languages/en/menu.php";
            $menuData = file_exists($fallbackFile) ? include $fallbackFile : [];
        }
    }

    return $menuData[$key] ?? [$key, '#'];
}

function nkt_menu_item($key) {
    $menu_item = nkt_menu_translate($key);
    $label = $menu_item[0] ?? $key;
    $path  = $menu_item[1] ?? '#';
    $href = preg_match('#^https?://#i', $path) ? $path : home_url($path);

    // get current url
    global $wp;
    $current_url = home_url($_SERVER['REQUEST_URI']);

    $normalize = static function ($url) {
        $url = strtok($url, '?'); // Only remove the query string (?), KEEP the hash (#)
        return strtolower( rtrim($url, '/') );
    };

    // Only check active for non-hash links
    $is_active = false;
    
    // If the href does NOT contain a hash (#), then check.
    if (strpos($href, '#') === false) {
        $is_active = ($normalize($href) === $normalize($current_url));
        
        // check home
        if (!$is_active && is_front_page()) {
            $is_active = ($normalize($href) === $normalize(home_url('/')));
        }
    }

    $class = $is_active ? ' current_page_item current' : '';

    return '<li class="menu-item nav-item' . esc_attr($class) . '"><a href="' . esc_url($href) . '">' . esc_html($label) . '</a></li>';
}