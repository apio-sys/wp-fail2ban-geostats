=== WP fail2ban GeoStats ===
Contributors: Joris Le Blansch
Author URI: https://apio.systems
Plugin URI: https://apio.systems
Tags: fail2ban, login, security, syslog, geoip
Requires at least: 4.7.0
Tested up to: 4.6.3
Stable tag: 0.8.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Write selected fail2ban filters to a top N file and display a page showing geolocation of concerned IPs on a Google world map.

== Other Features ==


== Installation ==
1. Upload the plugin to your plugins directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make sure you have the plugin wp-fail2ban and fail2ban setup and working
4. Edit /etc/fail2ban/action.d/iptables-multiport.conf to include something like:
~~~
actionban = iptables -I fail2ban-<name> 1 -s <ip> -j <blocktype>
            # Remove from line 99 to end of file to get a top 100
            sed -i -e '100,$d' /var/www/wordpress/wp-content/plugins/wp-fail2ban-geostats/block-list
            # Add newly banned IP to top of the list
            sed -i '1i<ip>' /var/www/wordpress/wp-content/plugins/wp-fail2ban-geostats/block-list
            # Set file permissions so that Apache can read the file
            chown www-data:www-data /var/www/wordpress/wp-content/plugins/wp-fail2ban-geostats/block-list
~~~

== Frequently Asked Questions ==

== Changelog ==


= 0.8.5 =
* Initial release.

== Upgrade Notice ==
