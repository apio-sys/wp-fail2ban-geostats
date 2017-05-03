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

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* TODO
register_activation_hook()
register_deactivation_hook()
register_uninstall_hook()
*/

add_action( 'admin_menu', 'wpf2bgs_page' );

function wpf2bgs_page() {

	$wpf2bgs_page = add_submenu('options-general.php','WP fail2ban GeoStats', 'WP fail2ban GeoStats', 'manage_options', 'wpf2bgs_options', 'wpf2bgs_page');

	add_action( "admin_head-{$wpf2bgs_page}", 'wpf2bgs_admin_head_script' );
}

function wpf2bgs_admin_head_script() { ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyDAXzLOy5aLgj25ti_FeCpHcna5JfJvlkM"></script>
<script src="js/ipmapper-2016.js"></script>

<div class="wrap">
Page.
</div>

<?php }


/**
 * Register the settings
 */
function wpf2bgs_register_settings() {
     register_setting( 'wpf2bgs_options', 'wpf2bgs_options' );
}

?>
