<?php
/*
Plugin Name: WPME Google Maps
Plugin URI: http://wordpress.org/plugins/wpme-google-maps
Description: Plot your address on a Google Map, with easy to use interface and simple short code.
Version: 1.1
Author: WPMadeasy
Author URI: http://wpmadeasy.com
Text Domain: wpme-google-maps
License URI: https://www.gnu.org/licenses/gpl-2.0.html
License: GPLv2
*/

if(defined('WPME_GMAPS_VERSION')) return;	// Looks like another instance is active.

define('WPME_GMAPS_VERSION', '1.1');
define('WPME_GMAPS_FULLNAME', 'WPME Google Maps');
define('WPME_GMAPS_SHORTNAME', 'wpmegmaps');
define('WPME_GMAPS_INITIALS', 'wpmegm_');
define('WPME_GMAPS_TEXTDOMAIN', 'wpme-google-maps');
define('WPME_GMAPS_DESCRIPTION', 'Plot your address on a Google Map, with easy to use interface and simple short code.');

// Paths
define('WPME_GMAPS_PATH', dirname(__FILE__));
define('WPME_GMAPS_FOLDER', basename(WPME_GMAPS_PATH));

// URLs
define('WPME_GMAPS_URL', plugin_dir_url( __FILE__ ));
define('WPME_GMAPS_IMGURL', WPME_GMAPS_URL."images");

// Activate
function wpme_gmaps_activate() {}
register_activation_hook( __FILE__, 'wpme_gmaps_activate' );

// Deactivate
function wpme_gmaps_deactivate() {}
register_deactivation_hook( __FILE__, 'wpme_gmaps_deactivate' );

function wpme_gmaps_enqueue_scripts() {
	wp_enqueue_style(WPME_GMAPS_SHORTNAME.'-colorbox', WPME_GMAPS_URL.'colorbox.css');
	wp_enqueue_style(WPME_GMAPS_SHORTNAME.'-jqueryui', WPME_GMAPS_URL.'/jquery-ui.min.css');
	wp_enqueue_style(WPME_GMAPS_SHORTNAME.'-core', WPME_GMAPS_URL.'wpme-google-maps.css');

	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');

	wp_enqueue_script(WPME_GMAPS_SHORTNAME.'-colorbox', WPME_GMAPS_URL . 'jquery.colorbox-min.js', array('jquery'), null, true);
	wp_enqueue_script(WPME_GMAPS_SHORTNAME.'-core', WPME_GMAPS_URL . 'wpme-google-maps.js', array('jquery'), '1.0.0', true);

	$img = WPME_GMAPS_URL . 'wpme-google-maps.png';

	wp_localize_script(
		WPME_GMAPS_SHORTNAME.'-core',
		WPME_GMAPS_INITIALS.'ajax',
		array(
			'url' => admin_url('admin-ajax.php' ),
			'tag' => WPME_GMAPS_FULLNAME,
			'i' => WPME_GMAPS_INITIALS,
			'help' => ' - <a href="http://wpmadeasy.com/google-maps/" target="_blank">User Guide</a>',
			'icon' => "<img src='{$img}' style='width: 20px; vertical-align: bottom; margin-right: 5px;' />"
		)
	);
}
add_action('admin_init', 'wpme_gmaps_enqueue_scripts');

/*
 * Register custom button(s) for WP Editor
 */
function wpme_gmaps_custom_buttons($context) {
	$options = get_option('wpmegm_options');
	$button_appearance = esc_attr($options["general"]["button_appearance"]);

	$img = WPME_GMAPS_URL . 'wpme-google-maps.png';
	$title = WPME_GMAPS_FULLNAME;
	$context .= "<a title='{$title}' class='button' id='".WPME_GMAPS_INITIALS."InsertShortcode' href='#'>";

	$icon = "<img src='{$img}' /> ";
	$text = "$title";

	switch($button_appearance) {
		case "icon":
			$context .= $icon;
			break;

		case "text":
			$context .= $text;
			break;

		default:
			$context .= $icon.$text;
			break;
	}

	$context .= "</a>";

	return $context;
}
add_action('media_buttons_context',  'wpme_gmaps_custom_buttons');

/*
 * Loads UI for short code
 */
function wpme_gmaps_load_ui() {
	include(WPME_GMAPS_PATH."/wpme-google-maps-ui.php");
	wp_die();
}
add_action( 'wp_ajax_wpme_gmaps_load_ui', 'wpme_gmaps_load_ui' );

/*
 * Short code
 *
 * Attributes:
 * 	Full Street Address (address)
 * 	Width of Map, %age or px (width)
 * 	Height of Map, %age or px (height)
 * 	Marker Image (marker)
 * 	Zoom Level (zoom)
 * 	Map Type, ROADMAP, SATELLITE, HYBRID or TERRAIN (type)
 * 	Scroll Wheel Support, enable/disable (swheel)
 * 	Map Controls, show/hide (controls)
 * 	Cache Control, enable/disable (cache)
 * 	Map CSS Class (class)
 * 	Map ID (id)
 */
add_shortcode('wpme-gmap', 'wpme_shortcode_gmap');
function wpme_shortcode_gmap( $atts ) {

	extract(
		shortcode_atts(
			array(
				"address" => "",
				"width" => "100%",
				"height" => "400px",
				"marker" => "",
				"zoom" => "15",
				"type" => "ROADMAP",
				"swheel" => "disable",
				"controls" => "show",
				"cache" => "enable",
				"class" => "wpme-gmap",
				"id" => "wpme-gmap",
			),
			$atts, "wpme-gmap"
		)
	);

	// Some book keeping
	$swheel = strtolower($swheel);
	$swheel = ($swheel=="disable")?"0":"1";

	$controls = strtolower($controls);
	$controls = ($controls=="show")?"0":"1";	//disabled=1, enabled=0

	$cache = strtolower($cache);
	$cache = ($cache=="enable")?true:false;

	$type = strtoupper($type);

	if(!empty($address) && wp_script_is('google-maps-api', 'registered')) {
		wp_print_scripts( 'google-maps-api' );

		$coordinates = wpme_get_coordinates($address, $cache);

		if(!is_array($coordinates)) {
			return;
		}

		$map_id = wpme_sanitize_id($id);

		if(empty($map_id) || $map_id == "wpme_gmap") {
			$map_id = uniqid('wpme_gmap_');
		}

		ob_start(); ?>
		<div class="<?=$class?>" id="<?=$id?>" style="width: <?=$width?>; height: <?=$height?>"></div>
		<script type="text/javascript">
			var <?=$map_id?>;
			function func_<?=$map_id?>() {
				var location = new google.maps.LatLng("<?=$coordinates['lat']?>", "<?=$coordinates['lng']?>");
				var map_options = {
					zoom: <?=$zoom?>,
					center: location,
					scrollwheel: <?=$swheel?>,
					disableDefaultUI: <?=$controls?>,
					mapTypeId: google.maps.MapTypeId.<?=$type?>
				}

				<?=$map_id?> = new google.maps.Map(document.getElementById("<?=$id?>"), map_options);

				var marker = new google.maps.Marker({
					position: location,
					map: <?=$map_id?>,
					<?php if(!empty($marker)) { ?>
					icon: "<?=$marker?>"
					<?php } ?>
				});
			}

			func_<?=$map_id?>();
		</script>
		<style type="text/css">
			#<?=$id?> img {max-width: none;}
		</style>
		<?php
		return ob_get_clean();
	} else {
		return __('Google Maps API does not appear to be loaded, or address is not available.', 'wpme-google-maps');
	}
}

/*
 * Load and Register Google Maps API
 */
function wpme_gmap_load_scripts() {
	wp_register_script( 'google-maps-api', 'http://maps.google.com/maps/api/js?sensor=false' );
}
add_action('wp_enqueue_scripts', 'wpme_gmap_load_scripts');



/*
 * Retrieve address coordinates.
 */
function wpme_get_coordinates($address, $cache=true) {
	if($cache) {
		$hash = md5($address);
		$coordinates = get_transient($hash);
	}

    if ($coordinates === false || $cache == false) {
    	$args = array(
			'address' => urlencode($address),
			'sensor' => 'false'
		);
    	$url = esc_url_raw(add_query_arg($args, 'http://maps.googleapis.com/maps/api/geocode/json'));
     	$response = wp_remote_get($url);

     	if(is_wp_error($response)) {
			return;
		}

     	$data = wp_remote_retrieve_body($response);

     	if(is_wp_error($data)) {
     		return;
		}

		if ($response['response']['code'] == 200) {
			$data = json_decode($data);

			if ($data->status === 'OK') {
			  	$coordinates = $data->results[0]->geometry->location;
			  	$cache_data['lat'] = $coordinates->lat;
				$cache_data['lng'] = $coordinates->lng;
				$cache_data['address'] = (string) $data->results[0]->formatted_address;
				$data = $cache_data;

			  	if($cache) {
					set_transient($hash, $data, 3600*24*30);	// Cached for 30 days
				}
			} elseif ($data->status === 'ZERO_RESULTS') {
			  	return __('Address does not seem to exist, unable to retrieve coordinates.', 'wpme-google-maps');
			} elseif($data->status === 'INVALID_REQUEST') {
			   	return __('Please enter a valid address.', 'wpme-google-maps');
			} else {
				return __('Unknown error, please contact plugin author.', 'wpme-google-maps');
			}

		} else {
		 	return __('Unable to connect to Google APIs.', 'wpme-google-maps');
		}

    } else {
       // return cached results
       $data = $coordinates;
    }

    return $data;
}

function wpme_sanitize_id($id) {
	return str_replace("-", "_", $id);
}

// create custom plugin settings menu
add_action('admin_menu', 'wpmegm_create_menu');

function wpmegm_create_menu() {

	//create new top-level menu
	add_menu_page('WPME Google Maps Settings', 'WPME Google Maps', 'manage_options', __FILE__, 'wpmegm_settings_page', WPME_GMAPS_IMGURL.'/icon-wpmegm24x24.png');

	//call register settings function
	add_action( 'admin_init', 'wpmegm_register_settings' );
}


function wpmegm_register_settings() {
	//register our settings
	register_setting('wpmegm-settings', 'wpmegm_options');
}

function wpmegm_settings_page() {
	include(WPME_GMAPS_PATH."/options/default.php");
}