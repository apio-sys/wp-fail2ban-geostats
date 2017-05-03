<?php
/*
Plugin Name: WP fail2ban GeoStats
Plugin URI:  https://apio.systems
Description: Write selected fail2ban filters to a top N file and display a page showing geolocation of concerned IPs on a Google world map.
Version:     0.8.5
Author:      Joris Le Blansch
Author URI:  https://apio.systems
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: apio.systems

WP fail2ban GeoStats is free software: you can redistribute it and/or 
modify it under the terms of the GNU General Public License as 
published by the Free Software Foundation, either version 2 of the 
License, or any later version.

WP fail2ban GeoStats is distributed in the hope that it will be 
useful, but WITHOUT ANY WARRANTY; without even the implied warranty 
of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU 
General Public License for more details.

You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

/*defined( 'ABSPATH' ) or die( 'No script kiddies please!' );*/

/* TODO
register_activation_hook()
register_deactivation_hook()
register_uninstall_hook()
*/

/** Register admin menu */
add_action( 'admin_menu', 'wpf2bgs_menu' );

/** Build the menu entry */
function wpf2bgs_menu() {
	add_options_page( 'WP fail2ban GeoStats Options', 'WP fail2ban GeoStats', 'manage_options', 'wpf2bgs', 'wpf2bgs_options' );
}

/** HTML output for admin page */

/**function wpf2bgs_scripts()
{
	// Google Maps API, use your own API key
	wp_register_script( 'custom-script1','external://maps.google.com/maps/api/js?key=AIzaSyDAXzLOy5aLgj25ti_FeCpHcna5JfJvlkM');
	// IPMapper JS
	wp_register_script( 'ipmapper', plugins_url( '/js/ipmapper-2016.js', __FILE__ ) )
	// Enqueue the scripts
	wp_enqueue_script( 'custom-script1');
	wp_enqueue_script( 'ipmapper');
}
add_action( 'admin_enqueue_scripts', 'wpf2bgs_scripts' );**/

function load_custom_wp_admin_js($hook) {
        // Load only on ?page=mypluginname
        if($hook != 'settings_page_wpf2bgs') {
                return;
        }
        wp_enqueue_script( 'ipmapper-2016-js', plugins_url('js/ipmapper-2016.js', __FILE__) );
        wp_enqueue_script( 'google-ajax-api', 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' );
        wp_enqueue_script( 'google-maps-api', 'https://maps.google.com/maps/api/js?key=AIzaSyDAXzLOy5aLgj25ti_FeCpHcna5JfJvlkM' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_js' );

function wpf2bgs_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<script>';
	echo '$(function(){';
	echo 'try{';
	echo 'IPMapper.initializeMap("map");';
	echo 'var file = "block-list";';
	echo 'var ipArray = new Array();';
	echo '$.get(file, function(data){';
	echo 'ipArray = data.split(\'\n\');';
	echo 'IPMapper.addIPArray(ipArray);';
	echo '});';
	echo '} catch(e){';
	echo 'Error; ';
	echo '}';
	echo '});';
	echo '</script>';

	echo '<div class="wrap" id="map">';

	echo '<p>wpf2bgs-plugin.</p>';

/**	echo '<style>';
	echo 'html, body, #map {';
	echo 'height: 100%;';
	echo 'margin: 0px;';
	echo 'padding: 0px;';
	echo '}';
	echo '</style>';**/

/**	echo '<div id="map"></div>';**/

	echo '<iframe src="' . plugins_url('test.html', __FILE__) . '" width="800" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>';

	echo '</div>';

}

/**
 * Register the settings
 */
function wpf2bgs_register_settings() {
     register_setting( 'wpf2bgs_options', 'wpf2bgs_options' );
}

?>
