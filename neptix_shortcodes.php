<div class="wrap neptix_wrap">
	<div id="neptix_logo">
		<a href="http://www.neptix.com" target="_blank"><img src="<?php echo neptix_plugin_url; ?>images/logo.png" alt="" /></a>
	</div>

	<h1>Shortcodes</h1>

	<p><img src="<?php echo neptix_plugin_url; ?>images/shortcode1.jpg" alt="" /></p>

	<h2>Parameters :</h2>
	<p><code>eventid</code> : Single event ID.</p>
	<p><code>eventlist</code> : User ID.</p>
	<p><code>venueid</code> : Venue ID.</p>
	<p><code>countdown</code> (optional) : ID or URLs of events where to display the countdown.</p>
	<p><code>show_only</code> (optional) : ID or URLs of events to show.</p>
	<p><code>exclude</code> (optional) : ID or URLs of events to exclude.</p>

	<h2>Examples :</h2>
	<p><code>[neptix eventid="xxx"]</code> : Return a specific event.</p>
	<p><code>[neptix eventlist="xxx"]</code> : Returns all events for a specific user.</p>
	<p><code>[neptix venueid="xxx"]</code> : Returns all events for a specific venue.</p>
</div>