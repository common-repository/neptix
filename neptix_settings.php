<?php

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

$notification = "";

function neptix_update_option($option, $value)
{
	if (get_option($option) !== false) update_option($option, $value);
	else add_option($option, $value);

	return $value;
}

if (isset($_POST["apikey"]))
{
	if (trim($_POST["apikey"]) != "")
	{
		neptix_update_option("neptix_apikey", trim($_POST["apikey"]));
		$notification .= '<div class="neptix_notification neptix_notification_success">API key updated successfully.</div>';
	} else {
		$notification .= '<div class="neptix_notification neptix_notification_error">API key can\'t be blank.</div>';
	}
}

if (isset($_POST["event_style"]))
{
	$event_title_color	= isset($_POST["event_title_color"]) ? trim($_POST["event_title_color"]) : "";
	$event_date_color	= isset($_POST["event_date_color"]) ? trim($_POST["event_date_color"]) : "";
	$event_font_color	= isset($_POST["event_font_color"]) ? trim($_POST["event_font_color"]) : "";
	$event_link_color	= isset($_POST["event_link_color"]) ? trim($_POST["event_link_color"]) : "";
	$event_countdown_color	= isset($_POST["event_countdown_color"]) ? trim($_POST["event_countdown_color"]) : "";
	$buytix_button	= isset($_POST["buytix_button"]) ? trim($_POST["buytix_button"]) : "";
	neptix_update_option("event_title_color", $event_title_color);
	neptix_update_option("event_date_color", $event_date_color);
	neptix_update_option("event_font_color", $event_font_color);
	neptix_update_option("event_link_color", $event_link_color);
	neptix_update_option("event_countdown_color", $event_countdown_color);
	neptix_update_option("buytix_button", $buytix_button);
	$notification .= '<div class="neptix_notification neptix_notification_success">Event style updated successfully.</div>';
}

if (isset($_POST["multiple_events_settings"]))
{
	$events_display_columns	= isset($_POST["events_display_columns"]) ? trim($_POST["events_display_columns"]) : "";
	$event_thumbnail_width	= isset($_POST["event_thumbnail_width"]) ? trim($_POST["event_thumbnail_width"]) : "";
	$event_disable_images	= isset($_POST["event_disable_images"]) ? trim($_POST["event_disable_images"]) : "";
	$event_display_view	= isset($_POST["event_display_view"]) ? trim($_POST["event_display_view"]) : "";
	$events_total	= isset($_POST["events_total"]) ? trim($_POST["events_total"]) : "";
	$show_neptix_signature	= isset($_POST["show_neptix_signature"]) ? trim($_POST["show_neptix_signature"]) : "no";
	$show_private_events	= isset($_POST["show_private_events"]) ? trim($_POST["show_private_events"]) : "no";
	neptix_update_option("events_display_columns", $events_display_columns);
	neptix_update_option("event_thumbnail_width", $event_thumbnail_width);
	neptix_update_option("event_disable_images", $event_disable_images);
	neptix_update_option("event_display_view", $event_display_view);
	neptix_update_option("events_total", $events_total);
	neptix_update_option("show_neptix_signature", $show_neptix_signature);
	neptix_update_option("show_private_events", $show_private_events);
	$notification .= '<div class="neptix_notification neptix_notification_success">Multiple events settings updated successfully.</div>';
}

?>
<div class="wrap neptix_wrap">

	<div id="neptix_logo">
		<a href="http://www.neptix.com" target="_blank"><img src="<?php echo neptix_plugin_url; ?>images/logo.png" alt="" /></a>
	</div>

	<?php
		if ($notification != "") echo $notification;
	?>

	<div class="n_box">
		<div class="n_title">Settings</div>
		<div class="n_content">
			<h2 align="center">Please Insert Your API Key</h2>
			<p align="center">
				You can find this by logging into you Neptix.com <a href="http://www.neptix.com/login/" target="_blank">account</a>, 
				and selecting Developer API under "Event Tools"
			</p>
			<form action="" method="post">
				<div class="row">
					<div class="col-12">
						<input type="text" name="apikey" value="<?php echo get_option("neptix_apikey"); ?>" class="field apikey_input">
					</div>
				</div>
				<div class="row">
					<div class="col-12 ta_right">
						<input type="submit" name="submit" class="button button-primary" value="Save">
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="n_box">
		<div class="n_title">Event Style</div>
		<div class="n_content">
			<form action="" method="post">
				<div class="row">
					<div class="col-6">
						<div class="input_group">
							<input type="text" value="<?php echo get_option("event_title_color"); ?>" id="event_title_color" name="event_title_color" class="neptix_color_picker">
							<span class="ico ico_picker"></span>
						</div>
						<label for="event_title_color">Event Title</label>
					</div>
					<div class="col-6">
						<div class="input_group">
							<input type="text" value="<?php echo get_option("event_date_color"); ?>" id="event_date_color" name="event_date_color" class="neptix_color_picker">
							<span class="ico ico_picker"></span>
						</div>
						<label for="event_date_color">Event Date</label>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="input_group">
							<input type="text" value="<?php echo get_option("event_font_color"); ?>" id="event_font_color" name="event_font_color" class="neptix_color_picker">
							<span class="ico ico_picker"></span>
						</div>
						<label for="event_font_color">Font Color</label>
					</div>
					<div class="col-6">
						<div class="input_group">
							<input type="text" value="<?php echo get_option("event_link_color"); ?>" id="event_link_color" name="event_link_color" class="neptix_color_picker">
							<span class="ico ico_picker"></span>
						</div>
						<label for="event_link_color">Link Color</label>
					</div>
				</div>	
				<div class="row">
					<div class="col-6">
						<div class="input_group">
							<input type="text" value="<?php echo get_option("event_countdown_color"); ?>" id="event_countdown_color" name="event_countdown_color" class="neptix_color_picker">
							<span class="ico ico_picker"></span>
						</div>
						<label for="event_countdown_color">Countdown Color</label>
					</div>
					<div class="col-6">
						<div class="input_group">
							<input type="text" value="<?php echo get_option("buytix_button"); ?>" id="buytix_button" name="buytix_button" class="">
						</div>
						<label for="buytix_button">Buytix button</label>
					</div>
				</div>
				<div class="row">
					<div class="col-12 ta_right">
						<input type="submit" name="event_style" class="button button-primary" value="Save">
					</div>
				</div>		
			</form>
		</div>
	</div>

	<div class="n_box">
		<div class="n_title">Multiple Events Settings</div>
		<div class="n_content">
			<form action="" method="post">
				<div class="row">
					<div class="col-6">
						<label>How Do You Want To Display The Events?</label>
						<div class="row">
							<div class="col-12">
								<select name="events_display_columns">
									<?php
										$events_display_columns = get_option("events_display_columns");
										$columns = array(1, 2, 3, 4, 6);
										for($i=0; $i<count($columns); $i++)
										{
											if ($events_display_columns == $columns[$i])
												echo '<option value="'.$columns[$i].'" selected>'.$columns[$i].'</option>';
											else
												echo '<option value="'.$columns[$i].'">'.$columns[$i].'</option>';
										}
									?>
								</select><br/>
								Columns
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="input_group">
									<input type="text" value="<?php echo get_option("event_thumbnail_width"); ?>" id="event_thumbnail_width" name="event_thumbnail_width" class="neptix_number_only">
									<span class="ico ico_text">px</span>
								</div>
								Thumbnail Width
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<input type="checkbox" name="show_neptix_signature" value="yes" id="show_neptix_signature" <?php
									if (get_option("show_neptix_signature") == "yes") echo "checked";
								?> />
								<label for="show_neptix_signature">Show Neptix Signature</label>
							</div>
							<div class="col-6" align="right">
								<input type="checkbox" name="show_private_events" value="yes" id="show_private_events" <?php
									if (get_option("show_private_events") == "yes") echo "checked";
								?> />
								<label for="show_private_events">Show private events</label>
							</div>
						</div>
					</div>
					<div class="col-6">
						Display How Many Events ?
						<div class="row">
							<div class="col-12">
								<select name="events_total">
									<?php
										$events_total = get_option("events_total");
										for($i=0; $i<36; $i++)
										{
											if ($events_total == $i)
												echo '<option value="'.$i.'" selected>'.$i.'</option>';
											else
												echo '<option value="'.$i.'">'.$i.'</option>';
										}
									?>
								</select><br/>
								(Leave 0 to display all)
							</div>
						</div>

						<div class="row">
							<div class="col-6">
								<?php $event_display_view = get_option("event_display_view"); ?>
								<input type="radio" name="event_display_view" value="grid" id="event_display_grid_view" <?php
											if ($event_display_view == "grid") echo "checked";
										?> />
								<label for="event_display_grid_view">Grid View</label>
								&nbsp;&nbsp;
								<input type="radio" name="event_display_view" value="list" id="event_display_list_view" <?php
											if ($event_display_view == "list") echo "checked";
										?> />
								<label for="event_display_list_view">List View</label>
							</div>

							<div class="col-6">
								<?php $event_disable_images = get_option("event_disable_images"); ?>
								Disable Images ?
								&nbsp;&nbsp;
								<input type="radio" name="event_disable_images" value="yes" id="event_disable_images_yes" <?php
									if ($event_disable_images == "yes") echo "checked";
								?> />
								<label for="event_disable_images_yes">Yes</label>
								&nbsp;&nbsp;
								<input type="radio" name="event_disable_images" value="no" id="event_disable_images_no" <?php
									if ($event_disable_images == "no") echo "checked";
								?> />
								<label for="event_disable_images_no">No</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 ta_right">
						<input type="submit" name="multiple_events_settings" class="button button-primary" value="Save">
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="neptix_footer">
		<p>Copyright 2014 Neptix, LLC. | Plugin Developed By <a href="http://www.bmgmediaco.com" target="_blank">BMG Media</a></p>
	</div>
</div>