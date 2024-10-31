<?php

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

$neptix_version = get_option("neptix_version");
$events_display_columns = get_option("events_display_columns");
$events_display_rows = get_option("events_display_rows");
$event_disable_images = get_option("event_disable_images");
$event_display_view = get_option("event_display_view");
$show_private_events = get_option("show_private_events");
$buytix_button = get_option("buytix_button");
if ($buytix_button == "") $buytix_button = "Buy Tix";
if (get_option("show_neptix_signature") == "yes") $show_neptix_signature = true;
else $show_neptix_signature = false;


if ($is_widget == true) {
	$events_display_rows = $events_display_rows * $events_display_columns;
	$events_display_columns = 1;
	$event_display_view = "grid";
	$show_neptix_signature = false;
	$show_private_events = ($private_events == true) ? "yes" : "no";
} else {
	$total_events = get_option("events_total");
}

// if display mode is list
if ($event_display_view == "list")
{
	$events_display_rows = $events_display_rows * $events_display_columns;
	$events_display_columns = 1;
}

// single event
if ($type == 1)
{
	$events_display_rows = 1;
	$events_display_columns = 1;
	$api = "http://www.neptix.com/single-event/".$id;
	$event_prefix = "http://www.neptix.com/events/";
}

// seller events
if ($type == 2) {
	$api = "http://www.neptix.com/user-events/".$id."/0";
	$event_prefix = "http://www.neptix.com/events/";
}

// venue events
if ($type == 3) {
	$api = "http://www.neptix.com/venue-events/".$id."/0";
	$event_prefix = "http://www.neptix.com/events/";
}

// private api link
$private_api = "http://www.neptix.com/private-events/".$id."/0";


if ($show_thumb == "on") $event_disable_images = "no";
else $event_disable_images = "yes";


$countdown_data = explode(",", $countdown);
$countdown_events_id = array();
for($i=0; $i<count($countdown_data); $i++)
{
	if (is_numeric($countdown_data[$i]))
	{
		$countdown_events_id[] = $countdown_data[$i];
	} else {
		preg_match("~events/(\d+)~", $countdown_data[$i], $id);
		if (isset($id[1])) $countdown_events_id[] = $id[1];
	}
}

$show_only_events = array();
$show_only_events_data = explode(",", $show_only);
for($i=0; $i<count($show_only_events_data); $i++)
{
	if (is_numeric($show_only_events_data[$i]))
	{
		$show_only_events[] = $show_only_events_data[$i];
	} else {
		preg_match("~events/(\d+)~", $show_only_events_data[$i], $id);
		if (isset($id[1])) $show_only_events[] = $id[1];
	}
}

$exclude_events = array();
$exclude_events_data = explode(",", $exclude);
for($i=0; $i<count($exclude_events_data); $i++)
{
	if (is_numeric($exclude_events_data[$i]))
	{
		$exclude_events[] = $exclude_events_data[$i];
	} else {
		preg_match("~events/(\d+)~", $exclude_events_data[$i], $id);
		if (isset($id[1])) $exclude_events[] = $id[1];
	}
}

?>
<div class="neptix_events">
	<div class="row <?php echo "event_type_".$type; ?>">
	<?php

		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $api);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Neptix Wordpress Plugin ".$neptix_version, 'apikey:'.get_option("neptix_apikey")) ); 
		curl_setopt($ch, CURLOPT_NOBODY, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
	    $json = curl_exec($ch);
	    $events = json_decode($json);

	    if ($show_private_events == "yes")
	    {
			$ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $private_api);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_HEADER, 0);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Neptix Wordpress Plugin ".$neptix_version, 'apikey:'.get_option("neptix_apikey")) ); 
			curl_setopt($ch, CURLOPT_NOBODY, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
		    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
		    $json = curl_exec($ch);
		    $json = json_decode($json);
		    if (count($json) > 0)
		    {
			    if (count($events) > 0) $_events = array_merge($events, $json);
			    else $_events = $json;
			    unset($json);
			    $__events = array();
			    if (count($_events) > 0)
			    {
				    foreach ($_events as $key => $event) {
						$date = $event->event_startdate;
						$time = strtotime(str_replace(",", "", $date));
						$__events[] = array("timestamp" => $time, "event" => $event);
					}
				}
				$__events = neptix_array_sort($__events, 'timestamp', SORT_DESC);
			    $events = array();
			    foreach ($__events as $key => $value) {
			    	$events[] = $value["event"];
			    }
			    unset($_events);
			    unset($__events);
			}
	    }

	    if (count($events) > 0)
	    {
		    $events = array_reverse($events);

		    foreach($events as $key => $event)
		    {
				// exclude events
		    	if (count($exclude_events) > 0 && in_array($event->id, $exclude_events))
		    	{
		    		unset($events[$key]);
		    	}
				// show only events
		    	else if (count($show_only_events) > 0 && !in_array($event->id, $show_only_events))
		    	{
		    		unset($events[$key]);
		    	}
		    	// show countdown events first
		    	else if (in_array($event->id, $countdown_events_id))
		    	{
		    		unset($events[$key]);
		    		array_unshift($events, $event);
		    	}
		    }

		    $event_i = $x = $y = 0;
		    foreach($events as $key => $event)
		    {
		    	$col = 0;
		    	if ($events_display_columns == 12) $col = 1;
		    	if ($events_display_columns == 6) $col = 2;
		    	if ($events_display_columns == 4) $col = 3;
		    	if ($events_display_columns == 3) $col = 4;
		    	if ($events_display_columns == 2) $col = 6;
		    	if ($events_display_columns == 1) $col = 12;
		    	
		    	if ($total_events != 0 && $event_i == $total_events) break;

		    	if ($x == $events_display_columns) {
		    		$x = 0;
		    		$y++;
		    		echo '</div><div class="row">';
		    	}

		    	$image = "";
		    	if ($event_disable_images != "yes")
		    	{
		    		$event_image = "http://www.neptix.com/userfiles/".$event->userid."/".$event->event_image;
		    		$image = '<p><a href="'.$event_prefix.$event->id.'" target="_blank"><img alt="" src="'.$event_image.'" class="thumb_event"></a></p>';
		    	}

		    	preg_match("~(\w+), (\d+) (\d+)~", $event->event_startdate, $date);
		    	$date = $date[1].", ".$date[2]." ".$date[3];

		    	preg_match("~(\d+)\:(\d+)\:(\d+)~", $event->event_dooropen, $time);
		    	$time = $time[1].":".$time[2].":".$time[3];

		    	if ($countdown == "all" || in_array($event->id, $countdown_events_id))
		    		$_countdown = '<span class="event_countdown" data-date="'.$date." ".$time.'"></span>';
		    	else
		    		$_countdown = "";

		    	if ($type == 1)
		    	{
		    		echo '
			    	<div class="thumb">
			    		'.$image.'
			    	</div>
			    	<div>
			    		'.$_countdown.'
						<p class="event_details" align="center">
							<a href="'.$event_prefix.$event->id.'" target="_blank">
								<strong class="event_title">'.$event->event_name.'</strong><br/>
								<span class="event_date">'.$date.'</span><br/>
							</a>
						</p>
						<a href="'.$event_prefix.$event->id.'" target="_blank" class="buytix">
							'.$buytix_button.'
						</a>
					</div>';
		    	} else if ($event_display_view == "list") {
		    		echo '
			    	<div class="thumb">
			    		'.$image.'
			    	</div>
			    	<div>
						<p class="event_details" align="left">
							<a href="'.$event_prefix.$event->id.'" target="_blank">
								<strong class="event_title">'.$event->event_name.'</strong><br/>
								<span class="event_date">'.$date.'</span><br/>
							</a>
							'.$_countdown.'
						</p>
					</div>';
		    	} else {
			    	echo '<div id="event_'.$event_i.'" class="col-'.$col.'">';
			    	$event_content = '<p class="event_details">
											<a href="'.$event_prefix.$event->id.'" target="_blank">
												<strong class="event_title">'.$event->event_name.'</strong><br/>
												<span class="event_date">'.$date.'</span><br/>
											</a>
											'.$_countdown.'
										</p>';
			    	if ($alignment == 1) echo $image.$event_content;
					if ($alignment == 3) echo $event_content.$image;
					if ($alignment == 2)
					{
						echo '<div class="row">
								<div class="thumb">'.$image.'</div>
								<div align="left">'.$event_content.'</div>
							</div>';
					}
					if ($alignment == 4)
					{
						echo '<div class="row">
								<div align="left">'.$event_content.'</div>
								<div class="thumb">'.$image.'</div>
							</div>';
					}
					echo '</div>';
				}

				if ($type == 1) break;

				$event_i++;
				$x++;
		    }
		    if ($x < $events_display_columns)
		    {
		    	for($i=0; $i < $events_display_columns - $x; $i++)
		    	{
		    		echo '<div class="col-'.$col.'"></div>';
		    	}
		    }
		} else {
			echo 'Nothing Found !';
		}

	?>
	</div>
	<?php if ($show_neptix_signature) : ?>
	<div class="neptix_signature row">
		<div class="col-12">
			Tickets On 
			<a href="http://www.neptix.com" target="_blank">
				<img src="<?php echo neptix_plugin_url; ?>images/logo_small.png" alt="Neptix.com" />
			</a>
		</div>
	</div>
	<?php endif; ?>
</div>