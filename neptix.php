<?php
/*
Plugin Name: Neptix
Plugin URI: http://www.neptix.com
Description: Neptix Wordpress Plugin
Author: BMG MEDIA
Version: 1.0
Author URI: http://www.bmgmediaco.com
*/
/*  Copyright 2014  Neptix  (email : contact@neptix.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define("neptix_plugin_url", plugin_dir_url(__FILE__));

if (get_option("neptix_version") === false)
{
	$options = array(
			"neptix_version" => "1.0",
			"event_title_color" => "EB7944",
			"event_date_color" => "CCCCCC",
			"event_font_color" => "000000",
			"event_link_color" => "000000",
			"event_countdown_color" => "1F1F1F",
			"buytix_button" => "Buy Tix",
			"events_display_columns" => "3",
			"event_thumbnail_width" => "200",
			"events_total" => "9",
			"show_neptix_signature" => "yes",
			"event_display_view" => "grid"
		);

	foreach ($options as $option => $value) {
		add_option($option, $value);
	}
}

function neptix_array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();
    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }
        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }
        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }
    return $new_array;
}

function neptix_admin() {
	wp_enqueue_style( 'wp-color-picker' );        
	wp_enqueue_script( 'wp-color-picker' );
	echo "<link rel='stylesheet' media='screen' type='text/css' href='".neptix_plugin_url."css/jquery.selectBox.css' />\n";
	echo "<link rel='stylesheet' media='screen' type='text/css' href='".neptix_plugin_url."css/colpick.css' />\n";
    echo "<link rel='stylesheet' type='text/css' href='".neptix_plugin_url."admin.css' />\n";
    echo "<script src='".neptix_plugin_url."js/colpick.js'></script>\n";
    echo "<script src='".neptix_plugin_url."js/jquery.selectBox.js'></script>\n";
    ?>
	<script type="text/javascript">
    jQuery(document).ready(function($) {
    	$(".neptix_color_picker").each(function(){
    		$(this).colpick({
				layout:'hex',
				submit:0,
				colorScheme:'dark',
				color: $(this).val(),
				onChange:function(hsb,hex,rgb,el,bySetColor) {
					if(!bySetColor) $(el).val(hex);
				}
			}).keyup(function(){
				$(this).colpickSetColor(this.value);
			});
    	});
		$('.neptix_wrap select').selectBox();
		$(".neptix_wrap .input_group .ico").click(function(ev){
			$(this).parent().find("input").focus().click();
		});
    });             
    </script>
    <?php
}
add_action('admin_head', 'neptix_admin');


function neptix_widget_style()
{
	echo '<script type="text/javascript">var neptix_plugin_url = "'.neptix_plugin_url.'";</script>';
    wp_enqueue_style('flipclock_style', neptix_plugin_url . '/css/flipclock.css', false );
    wp_enqueue_style('neptix_widget_style', home_url() . '/?neptix_style', false );
    wp_enqueue_script('flipclock_js', neptix_plugin_url . '/js/flipclock.min.js', array('jquery-core') );
    wp_enqueue_script('neptix_js', neptix_plugin_url . '/js/neptix.js', array('jquery-core') );
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery.ui.theme', plugins_url( '/css/ui/jquery-ui.min.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'neptix_widget_style' );


add_action('admin_menu', 'neptix_admin_menu');
function neptix_admin_menu()
{
	add_menu_page('Neptix', 'Neptix', 'manage_options', 'neptix', 'neptix', neptix_plugin_url.'images/icon.png', 81);
	add_submenu_page('neptix', 'Shortcodes', 'Shortcodes', 'manage_options', 'neptix_shortcodes', 'neptix_shortcodes');
}

function neptix()
{
	include_once("neptix_settings.php");
}

function neptix_shortcodes(){
	include_once("neptix_shortcodes.php");
}

function neptix_shortcodes_func( $atts ) {
	$atts = shortcode_atts(array(
		'eventid' => '0',
		'eventlist' => '0',
		'venueid' => '0',
		'countdown' => '',
		'show_only' => '',
		'exclude' => ''
	), $atts);
	if ($atts["eventid"] != "0") { $type = 1; $id = $atts["eventid"]; }
	if ($atts["eventlist"] != "0") { $type = 2; $id = $atts["eventlist"]; }
	if ($atts["venueid"] != "0") { $type = 3; $id = $atts["venueid"]; }
	return neptix_get_events($type, $id, false, 0, "on", $atts["countdown"], $atts["show_only"], $atts["exclude"]);
}
add_shortcode('neptix', 'neptix_shortcodes_func' );


add_action('media_buttons_context', 'neptix_editor_button');
add_action('admin_footer', 'neptix_popup_content');
function neptix_editor_button($context) {
	$img = plugins_url( 'images/icon2.png' , __FILE__ );
	$container_id = 'neptix_popup_container';
	$context .= "<a class='button neptix_button_popup'href='#'>
	<img src='{$img}' /> Neptix</a>";
	return $context;
}

function neptix_popup_content() {
?>
<div id="neptix_popup_container" style="display:none;">
	<div class="neptix_popup_overlay"></div>
	<div id="neptix_popup">
		<p id="neptix_logo">
			<img src="<?php echo neptix_plugin_url; ?>images/logo.png" alt="" />
		</p>
		<p>
			<select class="widefat neptix_select" id="neptix_event_type" name="neptix_event_type">
				<option value="1">Single Event</option>
				<option value="2">Seller Specific Events</option>
				<option value="3">Venue Specific Events</option>
			</select>
		</p>
		<p>
			<input type="text" id="neptix_event_id" name="neptix_event_id" value="" placeholder="Event ID / Seller ID / Venue ID" />
		</p>
		<p align="left">
			<label for="neptix_event_countdown">Show Countdown on :</label><br/>
			<input type="text" id="neptix_event_countdown" name="neptix_event_countdown" value="" /><br/>
			<small>IDs or events url (separated by ",")</small>
		</p>
		<div id="neptix_popup_advanced_settings" style="display: none">
			<p align="left">
	            <label for="neptix_show_only_events">Show only events :</label>
	            <input class="widefat" id="neptix_show_only_events" name="neptix_show_only_events" type="text" value="" />             
	            <small>Separate each event ID or URL with a comma ","</small>
	        </p> 
	        <p align="left">
	            <label for="neptix_exclude_events">Exclude events :</label>
	            <input class="widefat" id="neptix_exclude_events" name="neptix_exclude_events" type="text" value="" />             
	            <small>Separate each event ID or URL with a comma ","</small>
	        </p>
	    </div>
	    <p align="left">
			<a href="#" class="neptix_popup_advanced_settings">Advanced settings &raquo;</a>
		</p>
		<p align="right">
			<a href="#" class="button button-primary neptix-add-shortcode">Insert</a>
		</p>
	</div>
</div>
<style type="text/css">
	#neptix_popup_container .neptix_popup_overlay {
		background: rgba(0,0,0,.8);
		position: fixed;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		z-index: 999998;
	}
	#neptix_popup {
		width: 486px;
		border-radius: 20px;
		background: #ececec;
		position: fixed;
		top: 50%;
		left: 50%;
		padding: 20px;
		text-align: center;
		z-index: 999999;
		-moz-transform: translate(-50%, -50%);
		-webkit-transform: translate(-50%, -50%);
		-o-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
	}
	.ie8 #neptix_popup {
		margin-left: -243px;
		margin-top: -119px;
		height: 298px;
		overflow: auto;
	}
	#neptix_popup input[type=text],
	#neptix_popup select {
		width: 100%;
	}
	#neptix_popup .button {
		height: 28px;
	    line-height: 24px;
	    padding: 0 30px 1px;
	}
</style>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".neptix_button_popup").click(function(){
			jQuery("#neptix_popup_container").show();
			return false;
		});
		jQuery("#neptix_popup_container .neptix_popup_overlay").click(function(){
			jQuery("#neptix_popup_container").hide();
		});
		jQuery(".neptix-add-shortcode").click(function(){
			var countdown = "",
				show_only = "",
				exclude = "";

			if (jQuery("#neptix_event_countdown").val() != "") {
				countdown = ' countdown="'+jQuery("#neptix_event_countdown").val()+'"';
			}
			if (jQuery("#neptix_show_only_events").val() != "") {
				show_only = ' show_only="'+jQuery("#neptix_show_only_events").val()+'"';
			}	
			if (jQuery("#neptix_exclude_events").val() != "") {
				exclude = ' exclude="'+jQuery("#neptix_exclude_events").val()+'"';
			}

			if (jQuery("#neptix_event_type").val() == 1) {
				send_to_editor('[neptix eventid="'+jQuery("#neptix_event_id").val()+'"'+countdown+show_only+exclude+']');	
			}
			if (jQuery("#neptix_event_type").val() == 2) {
				send_to_editor('[neptix eventlist="'+jQuery("#neptix_event_id").val()+'"'+countdown+show_only+exclude+']');	
			}
			if (jQuery("#neptix_event_type").val() == 3) {
				send_to_editor('[neptix venueid="'+jQuery("#neptix_event_id").val()+'"'+countdown+show_only+exclude+']');	
			}
			jQuery("#neptix_popup_container").hide();
			return false;
		});
		jQuery("a.neptix_popup_advanced_settings").click(function(){
			jQuery("#neptix_popup_advanced_settings").slideDown("fast");
			jQuery(this).parent().hide();
			return false;
		});
	});
</script>
<?php
}

function neptix_get_events($type, $id, $is_widget = false, $total_events = 0, $show_thumb = "on", $countdown = "", $show_only = "", $exclude = "", $private_events = false, $alignment = "1")
{
	ob_start();
	include("neptix_get_events.php");
	$output = ob_get_clean( );
    return $output;
}

include("neptix_widget.php");
include("neptix_widget_calendar.php");
include("neptix_widget_countdown.php");

if (isset($_GET["neptix_style"])) include("style.php");
if (isset($_GET["neptix_ajax_calendar"])) include("neptix_json.php");

?>