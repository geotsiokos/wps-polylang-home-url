<?php
/**
 * Plugin Name: WPS Polylang Home URL
 * Plugin URI: https://www.netpad.gr
 * Description: Adjust WPS home url to include current language.
 * Version: 1.0.0
 * Author: eugen
 * Author URI: https://www.netpad.gr
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


add_filter( 'request', 'init_wps_change_home_url' );
function init_wps_change_home_url( $request ) {
    if ( isset( $_REQUEST['ixwps'] ) ) {
        if ( $_REQUEST['ixwps'] === 1 ) {
            add_filter( 'home_url', 'wps_home_url_filter', 10, 4 );
        }
    }
    
    return $request;
}

/**
 * Function for `home_url` filter-hook.
 *
 * @param string      $url         The complete home URL including scheme and path.
 * @param string      $path        Path relative to the home URL. Blank string if no path is specified.
 * @param string|null $orig_scheme Scheme to give the home URL context. Accepts 'http', 'https', 'relative', 'rest', or null.
 * @param int|null    $blog_id     Site ID, or null for the current site.
 *
 * @return string
 */
function wps_home_url_filter( $url, $path, $orig_scheme, $blog_id ){
    
    if( !is_admin() ){
        if ( defined( 'POLYLANG_VERSION' ) ) {
            if ( !function_exists( 'pll_home_url' ) ) {
                // Free API
                require_once ABSPATH . '/wp-content/plugins/polylang/include/api.php';
                
                // Pro API
                // require_once ABSPATH . '/wp-content/plugins/polylang-pro/vendor/wpsyntex/polylang/include/api.php';
            }
            
            $log = $url . "  |  " . ": Start value of URL\n";
            
            error_log( $log, 3 );
            
            $url = pll_home_url();
            
            $log = $url . "  |  " . ": End value of URL\n";
            
            error_log( $log, 3 );
            
        }
    }
    return $url;
}
