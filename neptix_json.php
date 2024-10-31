<?php
	
	if (!isset($_GET["type"]) || !isset($_GET["id"])) die("Error !");

	$neptix_apikey = get_option("neptix_apikey");
	$neptix_version = get_option("neptix_version");
	$type = strip_tags($_GET["type"]);
	$id = strip_tags($_GET["id"]);
	$exclude = isset($_GET["exclude"]) ? strip_tags($_GET["exclude"]) : "";
	$private_events = isset($_GET["private_events"]) ? strip_tags($_GET["private_events"]) : "no";

	if ($type == 1) $api = "http://www.neptix.com/single-event/".$id;
	if ($type == 2) $api = "http://www.neptix.com/user-events/".$id."/0";
	if ($type == 3) $api = "http://www.neptix.com/venue-events/".$id."/0";
	// private api link
	$private_api = "http://www.neptix.com/private-events/".$id."/0";

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

	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Neptix Wordpress Plugin ".$neptix_version, 'apikey:'.$neptix_apikey)); 
	curl_setopt($ch, CURLOPT_NOBODY, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
    $json = curl_exec($ch);

	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');

	$array = array();
	$events = json_decode($json);

    if ($private_events == "on")
    {
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $private_api);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Neptix Wordpress Plugin ".$neptix_version, 'apikey:'.$neptix_apikey));
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
		foreach ($events as $key => $event)
		{
			if (!in_array($event->id, $exclude_events))
	    	{
	    		$array[] = $event;
	    	}	
		}
	}

	echo json_encode($array);
	die();

?>